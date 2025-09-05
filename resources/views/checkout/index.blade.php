{{-- resources/views/checkout/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-credit-card"></i> Checkout</h2>
        </div>
    </div>
    
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-lg-8">
                <!-- Shipping Address -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-map-marker-alt"></i> Alamat Pengiriman</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="recipient_name" class="form-label">Nama Penerima</label>
                            <input type="text" class="form-control @error('recipient_name') is-invalid @enderror" 
                                   id="recipient_name" name="recipient_name" 
                                   value="{{ old('recipient_name', Auth::user()->name) }}" required>
                            @error('recipient_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="recipient_phone" class="form-label">Nomor Telepon</label>
                            <input type="text" class="form-control @error('recipient_phone') is-invalid @enderror" 
                                   id="recipient_phone" name="recipient_phone" 
                                   value="{{ old('recipient_phone', Auth::user()->phone) }}" required>
                            @error('recipient_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control @error('shipping_address') is-invalid @enderror" 
                                      id="shipping_address" name="shipping_address" rows="4" required>{{ old('shipping_address', Auth::user()->address) }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Payment Method -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-credit-card"></i> Metode Pembayaran</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" 
                                   id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">
                                <i class="fas fa-hand-holding-usd text-success"></i>
                                <strong>COD (Cash on Delivery)</strong>
                                <br>
                                <small class="text-muted">Bayar tunai saat barang diterima</small>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Notes -->
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-sticky-note"></i> Catatan Pesanan (Opsional)</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" name="notes" rows="3" 
                                  placeholder="Tambahkan catatan untuk penjual...">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Order Summary -->
                <div class="card">
                    <div class="card-header">
                        <h5>Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <h6 class="mb-0">{{ $item['name'] }}</h6>
                                    <small class="text-muted">{{ $item['quantity'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</small>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkos Kirim:</span>
                            <span class="text-success">GRATIS</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong>Rp {{ number_format($totalPrice, 0, ',', '.') }}</strong>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i> Buat Pesanan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection