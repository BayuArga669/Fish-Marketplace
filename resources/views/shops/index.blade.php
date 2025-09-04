{{-- resources/views/shops/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-store"></i> Semua Lapak</h2>
            <p class="lead">Temukan lapak ikan terpercaya di seluruh Indonesia</p>
        </div>
    </div>

    <div class="row">
        @forelse($shops as $shop)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                @if($shop->logo)
                                    <img src="{{ asset('storage/' . $shop->logo) }}" 
                                         class="img-fluid rounded" alt="Logo">
                                @else
                                    <div class="bg-light rounded p-3 text-center">
                                        <i class="fas fa-store fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-8">
                                <h5 class="card-title">{{ $shop->name }}</h5>
                                <p class="card-text">{{ Str::limit($shop->description, 80) }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-user"></i> {{ $shop->user->name }}
                                </small>
                            </div>
                        </div>
                        <hr>
                        <p class="mb-1"><i class="fas fa-map-marker-alt"></i> {{ Str::limit($shop->address, 60) }}</p>
                        <p class="mb-3"><i class="fas fa-phone"></i> {{ $shop->phone }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">{{ $shop->fishProducts->count() }} produk</small>
                            <a href="{{ route('shops.show', $shop) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Lihat Lapak
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-store fa-3x text-muted mb-3"></i>
                    <h4>Belum Ada Lapak</h4>
                    <p class="text-muted">Belum ada lapak yang terdaftar saat ini.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($shops->hasPages())
        <div class="row">
            <div class="col-12">
                {{ $shops->links() }}
            </div>
        </div>
    @endif
</div>
@endsection