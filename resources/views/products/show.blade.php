{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @if($product->images && count($product->images) > 0)
                        @foreach($product->images as $index => $image)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     class="d-block w-100 rounded" 
                                     style="height: 400px; object-fit: cover;" 
                                     alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    @else
                        <div class="carousel-item active">
                            <div class="bg-light d-flex align-items-center justify-content-center rounded" 
                                 style="height: 400px;">
                                <i class="fas fa-fish fa-5x text-muted"></i>
                            </div>
                        </div>
                    @endif
                </div>
                @if($product->images && count($product->images) > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                @endif
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h2>{{ $product->name }}</h2>
                    <p class="text-muted mb-2">{{ $product->shop->name }}</p>
                    
                    <div class="mb-3">
                        <span class="badge bg-info">{{ $product->fish_type_text }}</span>
                        <span class="badge bg-secondary">{{ $product->species }}</span>
                        @if($product->is_featured)
                            <span class="badge bg-warning text-dark">Unggulan</span>
                        @endif
                    </div>
                    
                    <h3 class="text-primary mb-3">{{ $product->formatted_price }}/{{ $product->unit }}</h3>
                    
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <strong>Stok:</strong> {{ $product->stock }} {{ $product->unit }}
                        </div>
                        <div class="col-sm-6">
                            <strong>Status:</strong> 
                            <span class="badge bg-{{ $product->status == 'available' ? 'success' : 'danger' }}">
                                {{ $product->status == 'available' ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                    </div>
                    
                    @if($product->size)
                        <p><strong>Ukuran:</strong> {{ $product->size }}</p>
                    @endif
                    
                    @if($product->origin)
                        <p><strong>Asal:</strong> {{ $product->origin }}</p>
                    @endif
                    
                    <div class="mb-4">
                        <h5>Deskripsi</h5>
                        <p>{{ $product->description }}</p>
                    </div>
                    
                    @if($product->status == 'available' && $product->stock > 0)
                        @auth
                            @if(Auth::user()->role === 'buyer')
                                <form action="{{ route('cart.store') }}" method="POST" id="addToCartForm">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="quantity" class="form-label">Jumlah</label>
                                            <div class="input-group">
                                                <button type="button" class="btn btn-outline-secondary" id="decreaseQty">-</button>
                                                <input type="number" class="form-control text-center" 
                                                       id="quantity" name="quantity" value="1" 
                                                       min="0.1" max="{{ $product->stock }}" step="0.1">
                                                <button type="button" class="btn btn-outline-secondary" id="increaseQty">+</button>
                                            </div>
                                            <small class="text-muted">{{ $product->unit }}</small>
                                        </div>
                                    </div>
                                    
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                        <a href="{{ route('checkout.direct', $product) }}" class="btn btn-success btn-lg">
                                            <i class="fas fa-shopping-bag"></i> Beli Langsung
                                        </a>
                                    </div>
                                </form>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Anda harus login sebagai pembeli untuk membeli produk ini.
                                </div>
                            @endif
                        @else
                            <div class="alert alert-warning">
                                <p>Silakan <a href="{{ route('login') }}">login</a> terlebih dahulu untuk membeli produk ini.</p>
                            </div>
                        @endauth
                    @else
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i> Produk ini sedang tidak tersedia.
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Shop Info -->
            <div class="card mt-3">
                <div class="card-body">
                    <h5><i class="fas fa-store"></i> Informasi Lapak</h5>
                    <div class="d-flex align-items-center">
                        @if($product->shop->logo)
                            <img src="{{ asset('storage/' . $product->shop->logo) }}" 
                                 class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;" 
                                 alt="Logo">
                        @endif
                        <div>
                            <h6 class="mb-1">{{ $product->shop->name }}</h6>
                            <p class="mb-1 text-muted">{{ $product->shop->address }}</p>
                            <p class="mb-0"><i class="fas fa-phone"></i> {{ $product->shop->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityInput = document.getElementById('quantity');
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');
    const maxStock = {{ $product->stock }};
    
    if (decreaseBtn && increaseBtn && quantityInput) {
        decreaseBtn.addEventListener('click', function() {
            let value = parseFloat(quantityInput.value) || 0;
            if (value > 0.1) {
                quantityInput.value = (value - 0.1).toFixed(1);
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            let value = parseFloat(quantityInput.value) || 0;
            if (value < maxStock) {
                quantityInput.value = (value + 0.1).toFixed(1);
            }
        });
        
        quantityInput.addEventListener('input', function() {
            let value = parseFloat(this.value) || 0;
            if (value > maxStock) {
                this.value = maxStock;
            } else if (value < 0.1) {
                this.value = 0.1;
            }
        });
    }
});
</script>
@endpush