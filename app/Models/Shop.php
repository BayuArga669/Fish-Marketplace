<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'logo',
        'address',
        'phone',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($shop) {
            $shop->slug = Str::slug($shop->name);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fishProducts()
    {
        return $this->hasMany(FishProduct::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}