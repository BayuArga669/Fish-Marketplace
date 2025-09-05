<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class SellerOrderController extends Controller
{
    public function index()
    {
        $shop = auth()->user()->shop;

        $allCount = $shop->orders()->count();
        $pendingCount = $shop->orders()->where('orders.status', 'pending')->count();
        $confirmedCount = $shop->orders()->where('orders.status', 'confirmed')->count();
        $processingCount = $shop->orders()->where('orders.status', 'processing')->count();
        $shippedCount = $shop->orders()->where('orders.status', 'shipped')->count();

        // Ambil data order sesuai filter
        $query = $shop->orders()->with(['user', 'items.product']);
        if (request('status')) {
            $query->where('orders.status', request('status'));
        }
        $orders = $query->latest()->paginate(10);

        return view('seller.orders', compact(
            'orders',
            'allCount',
            'pendingCount',
            'confirmedCount',
            'processingCount',
            'shippedCount'
        ));
    }

}
