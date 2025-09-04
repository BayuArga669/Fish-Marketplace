<?php
// app/Http/Middleware/CheckSeller.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSeller
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        
        // Check if user is seller
        if (!$user || !$user->isSeller()) {
            return redirect()->route('dashboard')->with('error', 'Anda harus menjadi penjual untuk mengakses halaman ini.');
        }
        
        // Check if seller has a shop
        if (!$user->shop) {
            return redirect()->route('shop.create')->with('error', 'Anda harus membuat lapak terlebih dahulu sebelum menambah produk.');
        }
        
        return $next($request);
    }
}