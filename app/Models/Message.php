<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'user_id', // ID pengirim, null jika admin
        'body',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    // Relasi ke pengirim (bisa jadi user, bisa jadi null)
    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}