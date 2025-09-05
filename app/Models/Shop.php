<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Order; // 🔹 tambahin import Order biar dikenali

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

    // 🔹 Relasi ke orders (lewat fish_products)
    public function orders()
    {
        return $this->hasManyThrough(
            Order::class,
            FishProduct::class,
            'shop_id',    // FK di fish_products ke shops
            'id',         // PK di orders
            'id',         // PK di shops
            'id'          // PK di fish_products
        )->with('items'); // biar eager load order_items
    }


    // 🔹 Hitung pesanan dengan status pending
    public function pendingOrdersCount()
    {
        return $this->orders()
            ->where('orders.status', 'pending') // ✅ kasih prefix tabel biar ga ambigu
            ->count();
    }
}
