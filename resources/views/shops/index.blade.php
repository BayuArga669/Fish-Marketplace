{{-- resources/views/shops/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-store"></i> Semua Lapak</h2>
        </div>
    </div>
    
    <!-- Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('shops.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-6">
                                <label for="search" class="form-label">Cari Lapak</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Nama lapak, alamat...">
                            </div>
                            <div class="col-md-4">
                                <label for="sort" class="form-label">Urutkan</label>
                                <select class="form-select" id="sort" name="sort">
                                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                    <option value="products_count" {{ request('sort') === 'products_count' ? 'selected' : '' }}>Terbanyak Produk</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @if($shops->count() > 0)
        <div class="row">
            @foreach($shops as $shop)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                @if($shop->logo)
                                    <img src="{{ asset('storage/' . $shop->logo) }}" 
                                         class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;" 
                                         alt="Logo {{ $shop->name }}">
                                @else
                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px;">
                                        <i class="fas fa-store fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h5 class="card-title mb-1">{{ $shop->name }}</h5>
                                    <span class="badge bg-{{ $shop->status === 'active' ? 'success' : 'warning' }}">
                                        {{ ucfirst($shop->status) }}
                                    </span>
                                </div>
                            </div>
                            
                            <p class="card-text text-muted small">
                                {{ Str::limit($shop->description, 100) }}
                            </p>
                            
                            <div class="mb-3">
                                <p class="mb-1"><i class="fas fa-map-marker-alt text-muted"></i> 
                                    {{ Str::limit($shop->address, 50) }}</p>
                                <p class="mb-1"><i class="fas fa-phone text-muted"></i> {{ $shop->phone }}</p>
                                <p class="mb-0"><i class="fas fa-fish text-muted"></i> 
                                    {{ $shop->products_count }} Produk</p>
                            </div>
                            
                            <div class="d-grid">
                                <a href="{{ route('shops.show', $shop) }}" class="btn btn-primary">
                                    <i class="fas fa-eye"></i> Lihat Lapak
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $shops->withQueryString()->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-5x text-muted mb-3"></i>
                    <h4>Lapak Tidak Ditemukan</h4>
                    <p class="text-muted">Coba ubah kata kunci pencarian Anda.</p>
                    <a href="{{ route('shops.index') }}" class="btn btn-primary">
                        <i class="fas fa-refresh"></i> Reset Pencarian
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection