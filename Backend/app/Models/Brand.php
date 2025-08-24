<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Inventory;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status',
        'image'
    ];
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
