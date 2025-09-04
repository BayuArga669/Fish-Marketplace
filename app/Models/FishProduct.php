<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FishProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'unit',
        'fish_type',
        'images',
        'status',
    ];

    protected $casts = [
        'images' => 'array',
        'price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            $product->slug = Str::slug($product->name);
        });
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFishTypeTextAttribute()
    {
        $types = [
            'air_tawar' => 'Air Tawar',
            'air_laut' => 'Air Laut',
            'air_payau' => 'Air Payau',
        ];

        return $types[$this->fish_type] ?? $this->fish_type;
    }
}