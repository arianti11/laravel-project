<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'model',
        'model_id',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Static method untuk create log dengan mudah
     */
    public static function record($type, $description, $model = null, $modelId = null, $oldValues = null, $newValues = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'type' => $type,
            'model' => $model,
            'model_id' => $modelId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent()
        ]);
    }

    /**
     * Scope: Filter by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Filter by model
     */
    public function scopeOfModel($query, $model)
    {
        return $query->where('model', $model);
    }

    /**
     * Scope: Recent activities
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Get badge color based on type
     */
    public function getTypeBadgeAttribute()
    {
        return match($this->type) {
            'create' => 'success',
            'update' => 'info',
            'delete' => 'danger',
            'login' => 'primary',
            'logout' => 'secondary',
            'view' => 'light',
            default => 'secondary'
        };
    }

    /**
     * Get icon based on type
     */
    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'create' => 'fa-plus-circle',
            'update' => 'fa-edit',
            'delete' => 'fa-trash',
            'login' => 'fa-sign-in-alt',
            'logout' => 'fa-sign-out-alt',
            'view' => 'fa-eye',
            default => 'fa-info-circle'
        };
    }
}