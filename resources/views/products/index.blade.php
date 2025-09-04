{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-fish"></i> Semua Produk Ikan</h2>
            <p class="lead">Temukan ikan segar dari berbagai penjual terpercaya</p>
        </div>
    </div>

    <div class="row">
        @forelse($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    @if($product->images && count($product->images) > 0)
                        <img src="{{ asset('storage/' . $product->images[0]) }}" 
                             class="card-img-top" style="height: 250px; object-fit: cover;" 
                             alt="{{ $product->name }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                             style="height: 250px;">
                            <i class="fas fa-fish fa-3x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text flex-grow-1">{{ Str::limit($product->description, 100) }}</p>
                        <div class="mb-2">
                            <span class="badge bg-info">{{ $product->fish_type_text }}</span>
                            <span class="badge bg-success">{{ $product->stock }} {{ $product->unit }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-primary mb-0">{{ $product->formatted_price }}/{{ $product->unit }}</h6>
                                <small class="text-muted">{{ $product->shop->name }}</small>
                            </div>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-fish fa-3x text-muted mb-3"></i>
                    <h4>Belum Ada Produk</h4>
                    <p class="text-muted">Belum ada produk ikan yang tersedia saat ini.</p>
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