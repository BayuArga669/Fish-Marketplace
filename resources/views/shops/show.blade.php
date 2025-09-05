{{-- resources/views/shops/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Shop Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            @if($shop->logo)
                                <img src="{{ asset('storage/' . $shop->logo) }}" 
                                     class="img-fluid rounded" alt="Logo {{ $shop->name }}">
                            @else
                                <div class="bg-light rounded p-4 text-center">
                                    <i class="fas fa-store fa-4x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h2>{{ $shop->name }}</h2>
                                    <p class="text-muted mb-2">{{ $shop->description }}</p>
                                    <p class="mb-1"><i class="fas fa-map-marker-alt text-muted"></i> {{ $shop->address }}</p>
                                    <p class="mb-1"><i class="fas fa-phone text-muted"></i> {{ $shop->phone }}</p>
                                    <p class="mb-0"><i class="fas fa-fish text-muted"></i> {{ $shop->products->count() }} Produk</p>
                                </div>
                                <div>
                                    <span class="badge bg-{{ $shop->status === 'active' ? 'success' : 'warning' }} fs-6">
                                        {{ ucfirst($shop->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Products -->
    <div class="row mb-4">
        <div class="col-12">
            <h4><i class="fas fa-fish"></i> Produk dari {{ $shop->name }}</h4>
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
                {{ $products->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-fish fa-5x text-muted mb-3"></i>
                    <h4>Belum Ada Produk</h4>
                    <p class="text-muted">Lapak ini belum memiliki produk yang dijual.</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection