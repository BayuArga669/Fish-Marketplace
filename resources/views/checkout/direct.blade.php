{{-- resources/views/checkout/direct.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-shopping-bag"></i> Beli Langsung</h2>
        </div>
    </div>
    
    <form action="{{ route('orders.store-direct') }}" method="POST">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        
        <div class="row">
            <div class="col-lg-8">
                <!-- Product Info -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5><i class="fas fa-fish"></i> Produk</h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}" 
                                         class="img-fluid rounded" alt="{{ $product->name }}">
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h5>{{ $product->name }}</h5>
                                <p class="text-muted">{{ $product->shop->name }}</p>
                                <p class="text-primary">{{ $product->formatted_price }}/{{ $product->unit }}</p>
                            </div>
                            <div class="col-md-3">
                                <label for="quantity" class="form-label">Jumlah</label>
                                <div class="input-group">
                                    <input type="number" class="form-control text-center" 
                                           id="quantity" name="quantity" value="1" 
                                           min="0.1" max="{{ $product->stock }}" step="0.1" required>
                                    <span class="input-group-text">{{ $product->unit }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
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
                        <div class="d-flex justify-content-between mb-2">
                            <span>Harga:</span>
                            <span id="price">{{ $product->formatted_price }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Jumlah:</span>
                            <span id="qty-display">1 {{ $product->unit }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span id="subtotal">{{ $product->formatted_price }}</span>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ongkos Kirim:</span>
                            <span class="text-success">GRATIS</span>
                        </div>
                        
                        <hr>
                        
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong id="total">{{ $product->formatted_price }}</strong>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-check"></i> Buat Pesanan
                            </button>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const pricePerUnit = {{ $product->price }};
    const unit = '{{ $product->unit }}';
    
    function updateTotal() {
        const quantity = parseFloat(quantityInput.value) || 0;
        const subtotal = pricePerUnit * quantity;
        
        document.getElementById('qty-display').textContent = quantity + ' ' + unit;
        document.getElementById('subtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        document.getElementById('total').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
    }
    
    quantityInput.addEventListener('input', updateTotal);
});
</script>
@endpush