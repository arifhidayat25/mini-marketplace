<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang digunakan oleh model ini.
     * @var string
     */
    protected $table = 'orders'; // <-- PENTING: Tetap menunjuk ke tabel 'orders'

    protected $fillable = [
        'user_id', 'name', 'email', 'phone', 'address', 'total_price', 'status'
    ];

    /**
     * Get all of the items for the Pesanan
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    /**
     * Get the user that owns the Pesanan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
