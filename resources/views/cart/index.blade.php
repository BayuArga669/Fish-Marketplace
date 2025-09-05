{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-shopping-cart"></i> Keranjang Belanja</h2>
        </div>
    </div>
    
    @if(count($cartItems) > 0)
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cartItems as $id => $item)
                            <div class="row align-items-center border-bottom py-3">
                                <div class="col-md-2">
                                    @if(isset($item['images']) && count($item['images']) > 0)
                                        <img src="{{ asset('storage/' . $item['images'][0]) }}" 
                                             class="img-fluid rounded" style="height: 80px; width: 80px; object-fit: cover;" 
                                             alt="{{ $item['name'] }}">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                             style="height: 80px; width: 80px;">
                                            <i class="fas fa-fish text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <h6>{{ $item['name'] }}</h6>
                                    <small class="text-muted">{{ $item['shop'] ?? '' }}</small>
                                    <br>
                                    <span class="text-primary">Rp {{ number_format($item['price'], 0, ',', '.') }}/{{ $item['unit'] }}</span>
                                </div>
                                <div class="col-md-3">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control text-center"
                                                name="quantity"
                                                value="{{ $item['quantity'] }}"
                                                min="0.1"
                                                max="{{ $item['stock'] ?? 9999 }}"  {{-- kasih default kalau stock tidak ada --}}
                                                step="0.1"
                                                onchange="this.form.submit()">
                                            <span class="input-group-text">{{ $item['unit'] }}</span>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-2">
                                    <strong>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</strong>
                                </div>
                                <div class="col-md-1">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5>Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Item:</span>
                            <span>{{ array_sum(array_column($cartItems, 'quantity')) }} item</span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Total Harga:</span>
                            <strong>Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong>
                        </div>
                        <hr>
                        <div class="d-grid gap-2">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-credit-card"></i> Checkout
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left"></i> Lanjut Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-5x text-muted mb-3"></i>
                    <h4>Keranjang Kosong</h4>
                    <p class="text-muted">Belum ada produk di keranjang Anda.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-fish"></i> Mulai Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
