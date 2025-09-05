<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        // Ambil semua pesanan milik user yang sedang login
        $orders = Order::where('user_id', auth()->id())
               ->latest()
               ->paginate(10);


        return view('orders.index', compact('orders'));
    }

    public function directCheckout(Product $product, Request $request)
    {
        // Ambil jumlah (default = 1 kalau belum dikirim)
        $quantity = $request->input('quantity', 1);

        // Hitung total harga
        $total = $product->price * $quantity;

        // Lempar ke view checkout
        return view('checkout.direct', compact('product', 'quantity', 'total'));
        
        
    }

    public function checkout()
    {
        $cartItems = session()->get('cart', []);
        $totalPrice = 0;

        foreach ($cartItems as $id => $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return view('checkout.index', compact('cartItems', 'totalPrice'));
    }
    
    public function store(Request $request)
{
    $cartItems = session()->get('cart', []);
    $totalPrice = 0;

    foreach ($cartItems as $id => $item) {
        $totalPrice += $item['price'] * $item['quantity'];
    }

    // Simpan order ke database
    $order = \App\Models\Order::create([
        'user_id' => auth()->id(),
        'total_price' => $totalPrice,
        'status' => 'pending',
    ]);

    // Simpan detail item
    foreach ($cartItems as $id => $item) {
        $order->items()->create([
            'product_id' => $id,
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    }

    // Kosongkan keranjang
    session()->forget('cart');

    return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat!');
}
    public function cancel(Order $order)
{
    // pastikan hanya pemilik order yang bisa cancel
    if ($order->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    if ($order->status === 'pending') {
        $order->update(['status' => 'cancelled']);
    }

    return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibatalkan.');
}


}
