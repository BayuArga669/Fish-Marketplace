{{-- resources/views/products/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            <h2><i class="fas fa-fish"></i> Semua Produk Ikan</h2>
        </div>
    </div>
    
    <!-- Filter and Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('products.index') }}">
                        <div class="row align-items-end">
                            <div class="col-md-3">
                                <label for="search" class="form-label">Cari Produk</label>
                                <input type="text" class="form-control" id="search" name="search" 
                                       value="{{ request('search') }}" placeholder="Nama ikan, spesies...">
                            </div>
                            <div class="col-md-2">
                                <label for="fish_type" class="form-label">Jenis Ikan</label>
                                <select class="form-select" id="fish_type" name="fish_type">
                                    <option value="">Semua Jenis</option>
                                    <option value="freshwater" {{ request('fish_type') === 'freshwater' ? 'selected' : '' }}>Air Tawar</option>
                                    <option value="saltwater" {{ request('fish_type') === 'saltwater' ? 'selected' : '' }}>Air Laut</option>
                                    <option value="brackish" {{ request('fish_type') === 'brackish' ? 'selected' : '' }}>Air Payau</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="min_price" class="form-label">Harga Min</label>
                                <input type="number" class="form-control" id="min_price" name="min_price" 
                                       value="{{ request('min_price') }}" placeholder="0">
                            </div>
                            <div class="col-md-2">
                                <label for="max_price" class="form-label">Harga Max</label>
                                <input type="number" class="form-control" id="max_price" name="max_price" 
                                       value="{{ request('max_price') }}" placeholder="1000000">
                            </div>
                            <div class="col-md-2">
                                <label for="sort" class="form-label">Urutkan</label>
                                <select class="form-select" id="sort" name="sort">
                                    <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Terbaru</option>
                                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Terlama</option>
                                    <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Harga Rendah</option>
                                    <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Harga Tinggi</option>
                                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama A-Z</option>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    @if($products->count() > 0)
        <div class="row">
            @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="position-relative">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]) }}" 
                                     class="card-img-top" style="height: 200px; object-fit: cover;" 
                                     alt="{{ $product->name }}">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-fish fa-3x text-muted"></i>
                                </div>
                            @endif
                            
                            @if($product->is_featured)
                                <span class="position-absolute top-0 start-0 badge bg-warning text-dark m-2">
                                    <i class="fas fa-star"></i> Unggulan
                                </span>
                            @endif
                            
                            @if($product->status !== 'available' || $product->stock <= 0)
                                <div class="position-absolute top-0 end-0 bottom-0 start-0 d-flex align-items-center justify-content-center bg-dark bg-opacity-50">
                                    <span class="badge bg-danger fs-6">Habis</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <p class="card-text text-muted small mb-2">
                                <i class="fas fa-store"></i> {{ $product->shop->name }}
                            </p>
                            
                            <div class="mb-2">
                                <span class="badge bg-info">{{ $product->fish_type_text }}</span>
                                <span class="badge bg-secondary">{{ $product->species }}</span>
                            </div>
                            
                            <p class="card-text small text-muted">
                                {{ Str::limit($product->description, 80) }}
                            </p>
                            
                            <div class="mt-auto">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="text-primary mb-0">{{ $product->formatted_price }}</h5>
                                    <small class="text-muted">/{{ $product->unit }}</small>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">
                                        <i class="fas fa-box"></i> Stok: {{ $product->stock }} {{ $product->unit }}
                                    </small>
                                    <span class="badge bg-{{ $product->status == 'available' ? 'success' : 'danger' }}">
                                        {{ $product->status == 'available' ? 'Tersedia' : 'Habis' }}
                                    </span>
                                </div>
                                
                                <div class="d-grid">
                                    <a href="{{ route('products.show', $product) }}" class="btn btn-primary">
                                        <i class="fas fa-eye"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-search fa-5x text-muted mb-3"></i>
                    <h4>Produk Tidak Ditemukan</h4>
                    <p class="text-muted">Coba ubah filter pencarian atau kata kunci Anda.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-refresh"></i> Reset Filter
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection