<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'message',
        'type',
        'icon',
        'user_id',
        'is_read',
        'data',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'data' => 'array',
        'read_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public function getIconClass()
    {
        $icons = [
            'info' => 'fa fa-info-circle',
            'warning' => 'fa fa-exclamation-triangle',
            'success' => 'fa fa-check-circle',
            'error' => 'fa fa-times-circle'
        ];

        return $icons[$this->type] ?? $this->icon ?? 'fa fa-bell';
    }

    public function getTypeColor()
    {
        $colors = [
            'info' => 'text-info',
            'warning' => 'text-warning',
            'success' => 'text-success',
            'error' => 'text-danger'
        ];

        return $colors[$this->type] ?? 'text-info';
    }
}
