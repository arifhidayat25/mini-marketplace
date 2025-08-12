<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'address', 'total_price', 'status'
    ];

    /**
     * Get all of the items for the Order
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the user that owns the Order
     */
   // public function user()
 //   {
  //      return $this->belongsTo(User::class);
  //  }
}
