<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    
        protected $fillable = ['title', 'description', 'image', 'price', 'discount_price', 'category', 'quantity', 'status'];
    
        // Lắng nghe sự kiện cập nhật
        protected static function boot()
        {
            parent::boot();
    
            static::saving(function ($product) {
                // Cập nhật status dựa trên quantity
                $product->status = $product->quantity == 0 ? 'out of stock' : 'available';
            });
        }

        
}
