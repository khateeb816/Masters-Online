<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'promo_code_id',
        'status',
        'payment_status',
        'shipping_address',
        'city',
        'state',
        'country',
        'zip',
        'sub_total',
        'total',
        'shipping_cost',
        'rejection_reason',
    ];

    protected $casts = [
        'sub_total' => 'integer',
        'total' => 'integer',
        'shipping_cost' => 'integer',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function promoCode()
    {
        return $this->belongsTo(PromoCode::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    // Generate unique order number
    public static function generateOrderNumber()
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $lastOrder = self::whereDate('created_at', today())->latest()->first();

        if ($lastOrder) {
            $lastNumber = (int) substr($lastOrder->order_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . $date . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    // Get status badge class
    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'pending' => 'badge-warning',
            'processing' => 'badge-info',
            'approved' => 'badge-success',
            'shipped' => 'badge-primary',
            'delivered' => 'badge-success',
            'rejected' => 'badge-danger',
            'cancelled' => 'badge-danger',
            default => 'badge-secondary'
        };
    }

    // Get payment status badge class
    public function getPaymentStatusBadgeClass()
    {
        return match($this->payment_status) {
            'pending' => 'badge-warning',
            'paid' => 'badge-success',
            'failed' => 'badge-danger',
            'refunded' => 'badge-info',
            default => 'badge-secondary'
        };
    }
}
