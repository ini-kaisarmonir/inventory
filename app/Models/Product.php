<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'purchase_price',
        'sell_price',
        'active_status',
    ];

    public function stock()
    {
        return $this->hasOne(Stock::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function reduceStock($qty)
    {
        $this->stock->decrement('quantity', $qty);
    }

    public function increaseStock($qty)
    {
        $this->stock->increment('quantity', $qty);
    }
}
