<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = ['name', 'details', 'price', 'stock', 'image_url', 'sku'];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer'
    ];

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
