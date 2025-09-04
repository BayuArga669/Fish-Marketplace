<?php

namespace App\Http\Controllers;

use App\Models\FishProduct;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isSeller()) {
            $shop = $user->shop;
            $productsCount = $shop ? $shop->fishProducts()->count() : 0;
            
            return view('dashboard.seller', compact('shop', 'productsCount'));
        }
        
        $recentProducts = FishProduct::with('shop')
            ->where('status', 'available')
            ->latest()
            ->take(6)
            ->get();
            
        return view('dashboard.buyer', compact('recentProducts'));
    }
}