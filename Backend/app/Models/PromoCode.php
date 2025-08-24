<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'discount_percentage',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'discount_percentage' => 'integer',
    ];

    // Relationships
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Check if promo code is active
    public function isActive()
    {
        $now = Carbon::now();
        return $this->status === 'active' &&
               $this->start_date <= $now &&
               $this->end_date >= $now;
    }

    // Check if promo code is expired
    public function isExpired()
    {
        return Carbon::now()->isAfter($this->end_date);
    }

    // Check if promo code is not yet started
    public function isNotStarted()
    {
        return Carbon::now()->isBefore($this->start_date);
    }

    // Get status badge class
    public function getStatusBadgeClass()
    {
        if ($this->isExpired()) {
            return 'badge-danger';
        }

        if ($this->isNotStarted()) {
            return 'badge-warning';
        }

        return match($this->status) {
            'active' => 'badge-success',
            'inactive' => 'badge-secondary',
            default => 'badge-secondary'
        };
    }

    // Get status text
    public function getStatusText()
    {
        if ($this->isExpired()) {
            return 'Expired';
        }

        if ($this->isNotStarted()) {
            return 'Not Started';
        }

        return ucfirst($this->status);
    }

    // Scope for active promo codes
    public function scopeActive($query)
    {
        $now = Carbon::now();
        return $query->where('status', 'active')
                    ->where('start_date', '<=', $now)
                    ->where('end_date', '>=', $now);
    }
}
