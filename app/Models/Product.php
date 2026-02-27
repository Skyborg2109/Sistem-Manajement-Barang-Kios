<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'category_id', 'buy_price', 'sell_price', 'stock', 'min_stock', 'unit'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
