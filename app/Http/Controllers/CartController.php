<?php

namespace App\Http\Controllers;

use App\Models\FishProduct as Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        // ambil keranjang dari session (default: array kosong)
        $cartItems = session()->get('cart', []);

        // hitung total harga
        $totalPrice = 0;
        foreach ($cartItems as $id => $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cartItems', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        $product = Product::findOrFail($request->product_id);

        // kalau produk sudah ada di cart, tambahkan jumlah
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $request->quantity,
                'unit'     => $product->unit,
                'images'   => $product->images,
                'stock'    => $product->stock, // ✅ tambahin ini

            ];

        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang.');
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }
}
