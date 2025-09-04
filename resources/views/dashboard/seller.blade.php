{{-- resources/views/dashboard/seller.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-store"></i> Dashboard Penjual</h2>
            <p class="lead">Selamat datang, {{ Auth::user()->name }}!</p>
        </div>
    </div>

    @if(!$shop)
        <div class="row">
            <div class="col-12">
                <div class="alert alert-warning">
                    <h5><i class="fas fa-exclamation-triangle"></i> Lapak Belum Dibuat</h5>
                    <p>Anda belum memiliki lapak. Silakan buat lapak terlebih dahulu untuk mulai berjualan.</p>
                    <a href="{{ route('shop.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Buat Lapak
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Total Produk</h6>
                                <h3>{{ $productsCount }}</h3>
                            </div>
                            <div>
                                <i class="fas fa-fish fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6>Status Lapak</h6>
                                <h5>{{ ucfirst($shop->status) }}</h5>
                            </div>
                            <div>
                                <i class="fas fa-store fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-store"></i> {{ $shop->name }}</h5>
                        <div>
                            <a href="{{ route('shop.manage') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-cog"></i> Kelola Lapak
                            </a>
                            <a href="{{ route('products.create') }}" class="btn btn-success btn-sm">
                                <i class="fas fa-plus"></i> Tambah Produk
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>{{ $shop->description }}</p>
                        <p><i class="fas fa-map-marker-alt"></i> {{ $shop->address }}</p>
                        <p><i class="fas fa-phone"></i> {{ $shop->phone }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection