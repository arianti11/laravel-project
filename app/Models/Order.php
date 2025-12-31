<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'city',
        'province',
        'postal_code',
        'subtotal',
        'shipping_cost',
        'total',
        'payment_method',
        'payment_status',
        'paid_at',
        'status',
        'notes',
        'admin_notes'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'paid_at' => 'datetime'
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Order Items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate order number unik
     */
    public static function generateOrderNumber()
    {
        do {
            $prefix = 'ORD';
            $date = date('Ymd');
            $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $orderNumber = $prefix . $date . $random;
            
            // Check if order number already exists
            $exists = self::where('order_number', $orderNumber)->exists();
        } while ($exists);
        
        return $orderNumber;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'processing' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get payment status badge color
     */
    public function getPaymentBadgeAttribute()
    {
        return match($this->payment_status) {
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'info',
            default => 'secondary'
        };
    }
}