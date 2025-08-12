<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory; // Pastikan ini ada
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory; // Pastikan ini ada

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function booted(): void
    {
        static::saving(function ($category) {
            $category->slug = Str::slug($category->name);
        });
    }
}