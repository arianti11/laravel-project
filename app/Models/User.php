<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'avatar',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // ============================================
    // SCOPES
    // ============================================

    /**
     * SCOPE: Hanya user yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * SCOPE: Hanya admin
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * SCOPE: Hanya staff
     */
    public function scopeStaff($query)
    {
        return $query->where('role', 'staff');
    }

    /**
     * SCOPE: Hanya user biasa (customer)
     */
    public function scopeCustomer($query)
    {
        return $query->where('role', 'user');
    }

    /**
     * SCOPE: Admin dan Staff (untuk permission yang sama)
     */
    public function scopeAdminOrStaff($query)
    {
        return $query->whereIn('role', ['admin', 'staff']);
    }

    /**
     * SCOPE: Search user berdasarkan nama atau email
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%")
              ->orWhere('phone', 'like', "%{$keyword}%");
        });
    }

    // ============================================
    // ACCESSORS
    // ============================================

    /**
     * ACCESSOR: Mendapatkan URL avatar
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return asset('images/default-avatar.png');
    }

    /**
     * ACCESSOR: Mendapatkan inisial nama (2 huruf pertama)
     */
    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    /**
     * ACCESSOR: Role badge color untuk UI
     */
    public function getRoleBadgeAttribute()
    {
        return [
            'admin' => 'danger',    // Red
            'staff' => 'warning',   // Yellow
            'user' => 'primary',    // Blue
        ][$this->role] ?? 'secondary';
    }

    /**
     * ACCESSOR: Role label untuk display
     */
    public function getRoleLabelAttribute()
    {
        return [
            'admin' => 'Administrator',
            'staff' => 'Staff',
            'user' => 'Customer',
        ][$this->role] ?? 'Unknown';
    }

    // ============================================
    // METHODS - Role Checking
    // ============================================

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah staff
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Cek apakah user adalah customer biasa
     */
    public function isCustomer()
    {
        return $this->role === 'user';
    }

    /**
     * Cek apakah user adalah admin atau staff
     * (untuk permission yang sama antara admin & staff)
     */
    public function isAdminOrStaff()
    {
        return in_array($this->role, ['admin', 'staff']);
    }

    /**
     * Cek apakah user punya permission tertentu
     * 
     * @param string $permission (create, edit, delete, view)
     * @param string $module (users, categories, products, orders, reports, settings)
     * @return bool
     */
    public function can($permission, $module = null)
    {
        // Admin bisa semua
        if ($this->isAdmin()) {
            return true;
        }

        // Staff permissions (customize sesuai kebutuhan)
        if ($this->isStaff()) {
            // Staff TIDAK BISA manage users, categories, settings
            $restrictedModules = ['users', 'categories', 'settings'];
            
            if (in_array($module, $restrictedModules)) {
                return false;
            }

            // Staff bisa manage products & orders
            if (in_array($module, ['products', 'orders'])) {
                return in_array($permission, ['create', 'edit', 'view']);
            }

            // Staff bisa view reports (tidak edit/delete)
            if ($module === 'reports') {
                return $permission === 'view';
            }

            return false;
        }

        // Customer default permission
        return false;
    }

    // ============================================
    // METHODS - User Management
    // ============================================

    /**
     * Aktivasi user
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    /**
     * Nonaktifkan user
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    /**
     * Toggle status aktif
     */
    public function toggleStatus()
    {
        $this->update(['is_active' => !$this->is_active]);
    }
}