<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'country',
        'zip',
        'alternative_phone',
        'date_of_birth',
        'gender',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
