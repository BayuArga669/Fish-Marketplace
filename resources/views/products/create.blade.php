{{-- resources/views/products/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-fish"></i> Tambah Produk Ikan</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Ikan</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
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
                                               id="price" name="price" value="{{ old('price') }}" min="0" step="0.01" required>
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
                                           id="stock" name="stock" value="{{ old('stock') }}" min="0" required>
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
                                        <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                        <option value="ekor" {{ old('unit') == 'ekor' ? 'selected' : '' }}>Ekor</option>
                                        <option value="ons" {{ old('unit') == 'ons' ? 'selected' : '' }}>Ons</option>
                                        <option value="gram" {{ old('unit') == 'gram' ? 'selected' : '' }}>Gram</option>
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
                                        <option value="air_tawar" {{ old('fish_type') == 'air_tawar' ? 'selected' : '' }}>Air Tawar</option>
                                        <option value="air_laut" {{ old('fish_type') == 'air_laut' ? 'selected' : '' }}>Air Laut</option>
                                        <option value="air_payau" {{ old('fish_type') == 'air_payau' ? 'selected' : '' }}>Air Payau</option>
                                    </select>
                                    @error('fish_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="images" class="form-label">Foto Ikan (Maksimal 5 foto)</label>
                            <input type="file" class="form-control @error('images') is-invalid @enderror" 
                                   id="images" name="images[]" accept="image/*" multiple>
                            <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB per foto.</div>
                            @error('images')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('shop.manage') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Simpan Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection