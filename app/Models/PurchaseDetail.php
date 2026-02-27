<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $fillable = ['purchase_id', 'product_id', 'quantity', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    protected static function booted()
    {
        static::created(function ($detail) {
            $product = $detail->product;
            if ($product) {
                $product->increment('stock', $detail->quantity);
                $product->buy_price = $detail->price;
                $product->save();
            }
        });

        static::deleted(function ($detail) {
            $product = $detail->product;
            if ($product) {
                $product->decrement('stock', $detail->quantity);
            }
        });
    }
}
