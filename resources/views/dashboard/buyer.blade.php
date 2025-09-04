{{-- resources/views/dashboard/buyer.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-tachometer-alt"></i> Dashboard Pembeli</h2>
            <p class="lead">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>Total Produk</h5>
                            <h3>{{ $recentProducts->count() }}</h3>
                        </div>
                        <div>
                            <i class="fas fa-fish fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4>Produk Terbaru</h4>
            <div class="row">
                @forelse($recentProducts as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" 
                                     class="card-img-top" style="height: 200px; object-fit: cover;" 
                                     alt="{{ $product->name }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p class="text-primary fw-bold">{{ $product->formatted_price }}/{{ $product->unit }}</p>
                                <small class="text-muted">{{ $product->shop->name }}</small>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada produk tersedia.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
