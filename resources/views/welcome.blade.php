{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="row align-items-center mb-5">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold">Pasar Ikan Online</h1>
            <p class="lead">Platform jual beli ikan segar terpercaya. Temukan ikan berkualitas dari penjual terbaik di seluruh Indonesia.</p>
            <div class="d-flex gap-3">
                <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-search"></i> Cari Ikan
                </a>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-store"></i> Mulai Jualan
                    </a>
                @endguest
            </div>
        </div>
        <div class="col-lg-6">
            <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=600&h=400&fit=crop" 
                 class="img-fluid rounded shadow" alt="Fresh Fish">
        </div>
    </div>

    <!-- Features -->
    <div class="row text-center mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-fish fa-3x text-primary mb-3"></i>
                    <h5>Ikan Segar</h5>
                    <p>Ikan segar langsung dari nelayan dan peternak terpercaya</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-store fa-3x text-primary mb-3"></i>
                    <h5>Lapak Online</h5>
                    <p>Buat lapak online Anda sendiri dan jangkau lebih banyak pembeli</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body">
                    <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                    <h5>Pengiriman Cepat</h5>
                    <p>Sistem pengiriman yang memastikan ikan tetap segar sampai tujuan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection