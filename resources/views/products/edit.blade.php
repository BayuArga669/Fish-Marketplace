{{-- resources/views/products/edit.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-white">
                    <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Produk Ikan</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Ikan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                               id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="0.01" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="stock" class="form-label">Stok</label>
                                    <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                           id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0" required>
                                    @error('stock')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="unit" class="form-label">Satuan</label>
                                    <select class="form-select @error('unit') is-invalid @enderror" id="unit" name="unit" required>
                                        <option value="">Pilih Satuan</option>
                                        <option value="kg" {{ old('unit', $product->unit) == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                        <option value="ekor" {{ old('unit', $product->unit) == 'ekor' ? 'selected' : '' }}>Ekor</option>
                                        <option value="ons" {{ old('unit', $product->unit) == 'ons' ? 'selected' : '' }}>Ons</option>
                                        <option value="gram" {{ old('unit', $product->unit) == 'gram' ? 'selected' : '' }}>Gram</option>
                                    </select>
                                    @error('unit')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fish_type" class="form-label">Jenis Ikan</label>
                                    <select class="form-select @error('fish_type') is-invalid @enderror" id="fish_type" name="fish_type" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="air_tawar" {{ old('fish_type', $product->fish_type) == 'air_tawar' ? 'selected' : '' }}>Air Tawar</option>
                                        <option value="air_laut" {{ old('fish_type', $product->fish_type) == 'air_laut' ? 'selected' : '' }}>Air Laut</option>
                                        <option value="air_payau" {{ old('fish_type', $product->fish_type) == 'air_payau' ? 'selected' : '' }}>Air Payau</option>
                                    </select>
                                    @error('fish_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($product->images && count($product->images) > 0)
                            <div class="mb-3">
                                <label class="form-label">Foto Saat Ini</label>
                                <div class="row">
                                    @foreach($product->images as $image)
                                        <div class="col-md-3 mb-2">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 class="img-fluid rounded" 
                                                 style="height: 100px; object-fit: cover; width: 100%;"
                                                 alt="Current Image">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="images" class="form-label">Update Foto Ikan (Opsional)</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                   id="images" name="images[]" accept="image/*" multiple>
                            <div class="form-text">Kosongkan jika tidak ingin mengubah foto. Format: JPG, PNG, GIF. Maksimal 2MB per foto.</div>
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('shop.manage') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection