{{-- resources/views/orders/show.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="fas fa-receipt"></i> Detail Pesanan #{{ $order->order_number }}</h2>
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Order Status -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle"></i> Status Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $order->status_color }} ms-1">{{ $order->status_text }}</span>
                            </p>
                            <p><strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y, H:i') }}</p>
                            @if($order->confirmed_at)
                                <p><strong>Dikonfirmasi:</strong> {{ $order->confirmed_at->format('d M Y, H:i') }}</p>
                            @endif
                            @if($order->shipped_at)
                                <p><strong>Dikirim:</strong> {{ $order->shipped_at->format('d M Y, H:i') }}</p>
                            @endif
                            @if($order->delivered_at)
                                <p><strong>Diterima:</strong> {{ $order->delivered_at->format('d M Y, H:i') }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <p><strong>Metode Pembayaran:</strong> {{ $order->payment_method_text }}</p>
                            <p><strong>Status Pembayaran:</strong> 
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ $order->payment_status === 'paid' ? 'Dibayar' : 'Belum Dibayar' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Order Items -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5><i class="fas fa-fish"></i> Produk Pesanan</h5>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                        <div class="row align-items-center border-bottom py-3">
                            <div class="col-md-2">
                                @if($item->product->images && count($item->product->images) > 0)
                                    <img src="{{ asset('storage/' . $item->product->images[0]) }}" 
                                         class="img-fluid rounded" alt="{{ $item->product->name }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="height: 80px;">
                                        <i class="fas fa-fish text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6>{{ $item->product->name }}</h6>
                                <p class="text-muted mb-1">{{ $item->product->shop->name }}</p>
                                <small class="text-muted">{{ $item->product->species }} - {{ $item->product->fish_type_text }}</small>
                            </div>
                            <div class="col-md-2">
                                <span>{{ $item->quantity }} {{ $item->product->unit }}</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <strong>{{ $item->formatted_total }}</strong>
                                <br>
                                <small class="text-muted">{{ $item->formatted_price }}/{{ $item->product->unit }}</small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Shipping Info -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-shipping-fast"></i> Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Penerima:</strong> {{ $order->recipient_name }}</p>
                            <p><strong>Telepon:</strong> {{ $order->recipient_phone }}</p>
                            <p><strong>Alamat:</strong><br>{{ $order->shipping_address }}</p>
                        </div>
                        <div class="col-md-6">
                            @if($order->notes)
                                <p><strong>Catatan:</strong><br>{{ $order->notes }}</p>
                            @endif
                            
                            @if($order->tracking_number)
                                <p><strong>Nomor Resi:</strong> {{ $order->tracking_number }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Ringkasan Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>{{ $order->formatted_total }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Ongkos Kirim:</span>
                        <span class="text-success">GRATIS</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>{{ $order->formatted_total }}</strong>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    @if($order->status === 'pending')
                        <div class="d-grid gap-2">
                            <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-danger w-100"
                                        onclick="return confirm('Yakin ingin batalkan pesanan?')">
                                    <i class="fas fa-times"></i> Batalkan Pesanan
                                </button>
                            </form>
                        </div>
                    @endif
                    
                    @if($order->status === 'shipped')
                        <div class="d-grid">
                            <form action="{{ route('orders.confirm-delivery', $order) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success w-100"
                                        onclick="return confirm('Konfirmasi bahwa pesanan sudah diterima?')">
                                    <i class="fas fa-check"></i> Konfirmasi Diterima
                                </button>
                            </form>
                        </div>
                    @endif
                    
                    @if($order->status === 'delivered')
                        <div class="alert alert-success text-center mb-0">
                            <i class="fas fa-check-circle"></i>
                            <strong>Pesanan Selesai</strong>
                            <br>
                            <small>Terima kasih telah berbelanja!</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection