<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    //
    protected $fillable = [
        'user_id', 'label', 'recipient_name', 'phone', 'full_address', 'is_primary'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
