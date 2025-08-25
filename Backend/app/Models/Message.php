<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'message',
        'is_read',
        'read_at',
        'is_deleted_by_sender',
        'is_deleted_by_receiver'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_deleted_by_sender' => 'boolean',
        'is_deleted_by_receiver' => 'boolean'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
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
        return $query->where('receiver_id', $userId)
                    ->where('is_deleted_by_receiver', false);
    }

    public function scopeSentByUser($query, $userId)
    {
        return $query->where('sender_id', $userId)
                    ->where('is_deleted_by_sender', false);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }

    public function deleteForUser($userId)
    {
        if ($this->sender_id == $userId) {
            $this->update(['is_deleted_by_sender' => true]);
        } elseif ($this->receiver_id == $userId) {
            $this->update(['is_deleted_by_receiver' => true]);
        }
    }

    public function isDeletedForUser($userId)
    {
        if ($this->sender_id == $userId) {
            return $this->is_deleted_by_sender;
        } elseif ($this->receiver_id == $userId) {
            return $this->is_deleted_by_receiver;
        }
        return false;
    }
}
