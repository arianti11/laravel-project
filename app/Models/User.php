<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     * Kolom yang boleh diisi massal
     *
     * @var array<int, string>
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
     * Kolom yang disembunyikan saat serialize (response API)
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * Casting tipe data
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * SCOPE: Hanya user yang aktif
     * 
     * Cara pakai:
     * User::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * SCOPE: Hanya admin
     * 
     * Cara pakai:
     * User::admin()->get();
     */
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * SCOPE: Hanya user biasa (bukan admin)
     * 
     * Cara pakai:
     * User::regularUser()->get();
     */
    public function scopeRegularUser($query)
    {
        return $query->where('role', 'user');
    }

    /**
     * SCOPE: Search user berdasarkan nama atau email
     * 
     * Cara pakai:
     * User::search('john')->get();
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function($q) use ($keyword) {
            $q->where('name', 'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%")
              ->orWhere('phone', 'like', "%{$keyword}%");
        });
    }

    /**
     * ACCESSOR: Mendapatkan URL avatar
     * 
     * Cara pakai:
     * $user->avatar_url
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        // Default avatar
        return asset('images/default-avatar.png');
    }

    /**
     * ACCESSOR: Mendapatkan inisial nama (2 huruf pertama)
     * 
     * Cara pakai:
     * $user->initials // JD (dari John Doe)
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
     * METHOD: Cek apakah user adalah admin
     * 
     * Cara pakai:
     * if ($user->isAdmin()) { ... }
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * METHOD: Cek apakah user adalah user biasa
     * 
     * Cara pakai:
     * if ($user->isUser()) { ... }
     */
    public function isUser()
    {
        return $this->role === 'user';
    }

    /**
     * METHOD: Aktivasi user
     * 
     * Cara pakai:
     * $user->activate();
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    /**
     * METHOD: Nonaktifkan user
     * 
     * Cara pakai:
     * $user->deactivate();
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }
}