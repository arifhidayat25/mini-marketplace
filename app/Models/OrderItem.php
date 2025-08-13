<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //
    protected $fillable = [
    'order_id', 'product_id', 'quantity', 'price'
];
public function product()
{
    return $this->belongsTo(Product::class);
}
public function pesanan()
{
    return $this->belongsTo(Pesanan::class, 'order_id');
}
public function review()
{
    return $this->hasOne(Review::class);
}
}