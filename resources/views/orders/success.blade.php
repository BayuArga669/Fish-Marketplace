{{-- resources/views/orders/success.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                </div>
                
                <h1 class="text-success mb-3">Pesanan Berhasil Dibuat!</h1>
                <p class="lead">Terima kasih telah berbelanja di Pasar Ikan Online</p>
                
                <div class="card mx-auto mb-4" style="max-width: 500px;">
                    <div class="card-body">
                        <h5 class="card-title">Detail Pesanan</h5>
                        <hr>
                        <div class="row text-start">
                            <div class="col-6">
                                <strong>Nomor Pesanan:</strong>
                            </div>
                            <div class="col-6">
                                #{{ $order->order_number }}
                            </div>
                        </div>
                        <div class="row text-start mt-2">
                            <div class="col-6">
                                <strong>Total Pembayaran:</strong>
                            </div>
                            <div class="col-6">
                                {{ $order->formatted_total }}
                            </div>
                        </div>
                        <div class="row text-start mt-2">
                            <div class="col-6">
                                <strong>Metode Pembayaran:</strong>
                            </div>
                            <div class="col-6">
                                {{ $order->payment_method_text }}
                            </div>
                        </div>
                        <div class="row text-start mt-2">
                            <div class="col-6">
                                <strong>Status:</strong>
                            </div>
                            <div class="col-6">
                                <span class="badge bg-{{ $order->status_color }}">{{ $order->status_text }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle"></i> Langkah Selanjutnya:</h6>
                    <ul class="list-unstyled mb-0">
                        <li>✓ Pesanan Anda sedang menunggu konfirmasi dari penjual</li>
                        <li>✓ Anda akan mendapat notifikasi status pesanan via sistem</li>
                        <li>✓ Siapkan uang tunai untuk pembayaran COD saat barang tiba</li>
                        <li>✓ Pastikan nomor telepon dan alamat yang benar</li>
                    </ul>
                </div>
                
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-eye"></i> Lihat Detail Pesanan
                    </a>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-list-alt"></i> Semua Pesanan
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-success btn-lg">
                        <i class="fas fa-fish"></i> Belanja Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection