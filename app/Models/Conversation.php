<?php
// app/Models/Conversation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    // TAMBAHKAN 'product_id' DI SINI
    protected $fillable = ['user_id', 'product_id'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // TAMBAHKAN RELASI BARU INI
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}