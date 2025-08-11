<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'description',
        'price',
        'discounted_price',
        'stock_quantity',
        'status',
        'images',
    ];
}
