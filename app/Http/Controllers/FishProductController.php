<?php
// app/Http/Controllers/FishProductController.php

namespace App\Http\Controllers;

use App\Models\FishProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FishProductController extends Controller
{
    public function index()
    {
        $products = FishProduct::with('shop')
            ->where('status', 'available')
            ->latest()
            ->paginate(12);
            
        return view('products.index', compact('products'));
    }

    public function show(FishProduct $product)
    {
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $user = Auth::user();
        
        // Check if user is seller
        if (!$user->isSeller()) {
            return redirect()->route('dashboard')->with('error', 'Anda harus menjadi penjual untuk menambah produk.');
        }
        
        // Check if seller has shop
        $shop = $user->shop;
        if (!$shop) {
            return redirect()->route('shop.create')->with('error', 'Anda harus membuat lapak terlebih dahulu.');
        }
        
        return view('products.create', compact('shop'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $shop = $user->shop;
        
        if (!$shop) {
            return redirect()->route('shop.create')->with('error', 'Anda harus membuat lapak terlebih dahulu.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'fish_type' => 'required|in:air_tawar,air_laut,air_payau',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('fish-products', 'public');
                $images[] = $path;
            }
        }

        // Generate unique slug
        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $counter = 1;
        
        while (FishProduct::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        FishProduct::create([
            'shop_id' => $shop->id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'fish_type' => $request->fish_type,
            'images' => $images,
        ]);

        return redirect()->route('shop.manage')->with('success', 'Produk ikan berhasil ditambahkan!');
    }

    public function edit(FishProduct $product)
    {
        // Check if user owns this product
        if ($product->shop->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }
        
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, FishProduct $product)
    {
        // Check if user owns this product
        if ($product->shop->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'fish_type' => 'required|in:air_tawar,air_laut,air_payau',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $images = $product->images ?? [];
        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($images as $image) {
                Storage::disk('public')->delete($image);
            }
            
            // Upload new images
            $images = [];
            foreach ($request->file('images') as $image) {
                $path = $image->store('fish-products', 'public');
                $images[] = $path;
            }
        }

        // Generate new slug if name changed
        $slug = $product->slug;
        if ($product->name !== $request->name) {
            $newSlug = Str::slug($request->name);
            $originalSlug = $newSlug;
            $counter = 1;
            
            while (FishProduct::where('slug', $newSlug)->where('id', '!=', $product->id)->exists()) {
                $newSlug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $slug = $newSlug;
        }

        $product->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'unit' => $request->unit,
            'fish_type' => $request->fish_type,
            'images' => $images,
        ]);

        return redirect()->route('shop.manage')->with('success', 'Produk ikan berhasil diperbarui!');
    }

    public function destroy(FishProduct $product)
    {
        // Check if user owns this product
        if ($product->shop->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke produk ini.');
        }
        
        // Delete images
        if ($product->images) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $product->delete();
        
        return redirect()->route('shop.manage')->with('success', 'Produk ikan berhasil dihapus!');
    }
}