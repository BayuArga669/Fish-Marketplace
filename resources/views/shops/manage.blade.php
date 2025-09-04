{{-- resources/views/shops/manage.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-cog"></i> Kelola Lapak</h2>
                <div>
                    <a href="{{ route('shop.edit') }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Lapak
                    </a>
                    <a href="{{ route('products.create') }}" class="btn btn-success">
                        <i class="fas fa-plus"></i> Tambah Produk
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Shop Info -->
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
                                <div class="bg-light rounded p-3 text-center">
                                    <i class="fas fa-store fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-10">
                            <h4>{{ $shop->name }}</h4>
                            <p>{{ $shop->description }}</p>
                            <p><i class="fas fa-map-marker-alt"></i> {{ $shop->address }}</p>
                            <p><i class="fas fa-phone"></i> {{ $shop->phone }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products List -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-fish"></i> Produk Ikan</h5>
                </div>
                <div class="card-body">
                    @if($products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Jenis</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{ $product->name }}</td>
                                            <td>{{ $product->formatted_price }}/{{ $product->unit }}</td>
                                            <td>{{ $product->stock }} {{ $product->unit }}</td>
                                            <td>{{ $product->fish_type_text }}</td>
                                            <td>
                                                <span class="badge bg-{{ $product->status == 'available' ? 'success' : 'warning' }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('products.show', $product) }}" 
                                                       class="btn btn-info" title="Lihat">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('products.edit', $product) }}" 
                                                       class="btn btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('products.destroy', $product) }}" 
                                                          method="POST" style="display: inline;"
                                                          onsubmit="return confirm('Yakin ingin hapus produk ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger" title="Hapus">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        {{ $products->links() }}
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-fish fa-3x text-muted mb-3"></i>
                            <h5>Belum Ada Produk</h5>
                            <p>Mulai tambahkan produk ikan untuk lapak Anda.</p>
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Tambah Produk Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection