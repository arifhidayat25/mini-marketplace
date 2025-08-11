<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    //
    protected $fillable = [
    'image_url', 'title', 'link_url', 'is_active', 'order'
];
}
