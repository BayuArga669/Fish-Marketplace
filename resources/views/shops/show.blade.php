{{-- resources/views/shops/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Shop Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            @if($shop->logo)
                                <img src="{{ asset('storage/' . $shop->logo) }}" 
                                     class="img-fluid rounded" alt="Logo">
                            @else
                                <div class="bg-light rounded p-4 text-center">
                                    <i class="fas fa-store fa-4x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <h2>{{ $shop->name }}</h2>
                            <p class="lead">{{ $shop->description }}</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><i class="fas fa-user"></i> {{ $shop->user->name }}</p>
                                    <p><i class="fas fa-map-marker-alt"></i> {{ $shop->address }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><i class="fas fa-phone"></i> {{ $shop->phone }}</p>
                                    <p><i class="fas fa-fish"></i> {{ $shop->fishProducts->count() }} produk tersedia</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products -->
    <div class="row">
        <div class="col-12">
            <h4>Produk dari {{ $shop->name }}</h4>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    @if($product->images && count($product->images) > 0)
                        <img src="{{ asset('storage/' . $product->images[0]) }}" 
                             class="card-img-top" style="height: 200px; object-fit: cover;" 
                             alt="{{ $product->name }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                             style="height: 200px;">
                            <i class="fas fa-fish fa-2x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h6 class="card-title">{{ $product->name }}</h6>
                        <p class="card-text flex-grow-1">{{ Str::limit($product->description, 60) }}</p>
                        <div class="mb-2">
                            <span class="badge bg-info">{{ $product->fish_type_text }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-primary mb-0">{{ $product->formatted_price }}</h6>
                                <small class="text-muted">{{ $product->stock }} {{ $product->unit }}</small>
                            </div>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-fish fa-3x text-muted mb-3"></i>
                    <h5>Belum Ada Produk</h5>
                    <p class="text-muted">Lapak ini belum menambahkan produk.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="row">
            <div class="col-12">
                {{ $products->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
            