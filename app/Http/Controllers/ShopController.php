<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::with('user')
            ->where('status', 'active')
            ->paginate(12);
            
        return view('shops.index', compact('shops'));
    }

    public function show(Shop $shop)
    {
        $products = $shop->fishProducts()
            ->where('status', 'available')
            ->paginate(8);
            
        return view('shops.show', compact('shop', 'products'));
    }

    public function create()
    {
        if (Auth::user()->shop) {
            return redirect()->route('shop.manage');
        }
        
        return view('shops.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('shop-logos', 'public');
        }

        Shop::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'logo' => $logoPath,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->route('dashboard')->with('success', 'Lapak berhasil dibuat!');
    }

    public function manage()
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return redirect()->route('shop.create');
        }
        
        $products = $shop->fishProducts()->paginate(10);
        
        return view('shops.manage', compact('shop', 'products'));
    }

    public function edit()
    {
        $shop = Auth::user()->shop;
        
        if (!$shop) {
            return redirect()->route('shop.create');
        }
        
        return view('shops.edit', compact('shop'));
    }

    public function update(Request $request)
    {
        $shop = Auth::user()->shop;
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string|max:15',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $logoPath = $shop->logo;
        if ($request->hasFile('logo')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo')->store('shop-logos', 'public');
        }

        $shop->update([
            'name' => $request->name,
            'description' => $request->description,
            'logo' => $logoPath,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->route('shop.manage')->with('success', 'Lapak berhasil diperbarui!');
    }
}