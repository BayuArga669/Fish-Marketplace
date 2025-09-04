{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            @if($product->images && count($product->images) > 0)
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        @foreach($product->images as $index => $image)
                            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     class="d-block w-100 rounded" 
                                     style="height: 400px; object-fit: cover;"
                                     alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                    @if(count($product->images) > 1)
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    @endif
                </div>
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-fish fa-5x text-muted"></i>
                </div>
            @endif
        </div>
        <div class="col-md-6">
            <h1>{{ $product->name }}</h1>
            <div class="mb-3">
                <span class="badge bg-info me-2">{{ $product->fish_type_text }}</span>
                <span class="badge bg-{{ $product->status == 'available' ? 'success' : 'warning' }}">
                    {{ ucfirst($product->status) }}
                </span>
            </div>
            
            <h3 class="text-primary">{{ $product->formatted_price }}/{{ $product->unit }}</h3>
            <p class="text-muted">Stok: {{ $product->stock }} {{ $product->unit }}</p>
            
            <div class="mb-4">
                <h5>Deskripsi</h5>
                <p>{{ $product->description }}</p>
            </div>

            <!-- Shop Info -->
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-3">
                            @if($product->shop->logo)
                                <img src="{{ asset('storage/' . $product->shop->logo) }}" 
                                     class="img-fluid rounded" alt="Logo">
                            @else
                                <div class="bg-light rounded p-2 text-center">
                                    <i class="fas fa-store fa-2x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-9">
                            <h6>{{ $product->shop->name }}</h6>
                            <p class="mb-1"><i class="fas fa-map-marker-alt"></i> {{ Str::limit($product->shop->address, 50) }}</p>
                            <p class="mb-0"><i class="fas fa-phone"></i> {{ $product->shop->phone }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('shops.show', $product->shop) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-store"></i> Lihat Lapak
                        </a>
                    </div>
                </div>
            </div>

            @if($product->status == 'available')
                <div class="mt-4">
                    <button class="btn btn-success btn-lg w-100" disabled>
                        <i class="fas fa-shopping-cart"></i> Hubungi Penjual
                    </button>
                    <small class="text-muted d-block mt-2">
                        Fitur pembelian akan segera tersedia. Sementara hubungi penjual langsung.
                    </small>
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <h4>Produk Lainnya dari {{ $product->shop->name }}</h4>
            <div class="row">
                @forelse($product->shop->fishProducts()->where('id', '!=', $product->id)->take(3)->get() as $otherProduct)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            @if($otherProduct->images && count($otherProduct->images) > 0)
                                <img src="{{ asset('storage/' . $otherProduct->images[0]) }}" 
                                     class="card-img-top" style="height: 200px; object-fit: cover;" 
                                     alt="{{ $otherProduct->name }}">
                            @endif
                            <div class="card-body">
                                <h6 class="card-title">{{ $otherProduct->name }}</h6>
                                <p class="text-primary">{{ $otherProduct->formatted_price }}/{{ $otherProduct->unit }}</p>
                                <a href="{{ route('products.show', $otherProduct) }}" class="btn btn-primary btn-sm">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">Tidak ada produk lain dari lapak ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
