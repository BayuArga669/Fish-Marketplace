{{-- resources/views/seller/orders.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-clipboard-list"></i> Pesanan Masuk</h2>
        </div>
    </div>
    
    <!-- Filter Tabs -->
    <div class="row mb-4">
        <div class="col-12">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ request('status') ? '' : 'active' }}" href="{{ route('seller.orders.index') }}">
                        Semua <span class="badge bg-secondary ms-1">{{ $allCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'pending' ? 'active' : '' }}" 
                       href="{{ route('seller.orders.index', ['status' => 'pending']) }}">
                        Menunggu <span class="badge bg-warning ms-1">{{ $pendingCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'confirmed' ? 'active' : '' }}" 
                       href="{{ route('seller.orders.index', ['status' => 'confirmed']) }}">
                        Dikonfirmasi <span class="badge bg-info ms-1">{{ $confirmedCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'processing' ? 'active' : '' }}" 
                       href="{{ route('seller.orders.index', ['status' => 'processing']) }}>
                        Diproses <span class="badge bg-primary ms-1">{{ $processingCount }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'shipped' ? 'active' : '' }}" 
                       href="{{ route('seller.orders.index', ['status' => 'shipped']) }}">
                        Dikirim <span class="badge bg-success ms-1">{{ $shippedCount }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    @if($orders->count() > 0)
        <div class="row">
            <div class="col-12">
                @foreach($orders as $order)
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Order #{{ $order->order_number }}</strong>
                                <span class="badge bg-{{ $order->status_color }} ms-2">{{ $order->status_text }}</span>
                            </div>
                            <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h6>Pembeli: {{ $order->user->name }}</h6>
                                    <p><strong>Penerima:</strong> {{ $order->recipient_name }} ({{ $order->recipient_phone }})</p>
                                    <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                                    @if($order->notes)
                                        <p><strong>Catatan:</strong> {{ $order->notes }}</p>
                                    @endif
                                    
                                    <h6 class="mt-3">Items:</h6>
                                    @foreach($order->items->where('product.shop_id', auth()->user()->shop->id ?? 0) as $item)
                                        <div class="d-flex align-items-center mb-2">
                                            @if($item->product->images && count($item->product->images) > 0)
                                                <img src="{{ asset('storage/' . $item->product->images[0]) }}" 
                                                     class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;" 
                                                     alt="{{ $item->product->name }}">
                                            @endif
                                            <div>
                                                <strong>{{ $item->product->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $item->quantity }} {{ $item->product->unit }} × {{ $item->formatted_price }} = {{ $item->formatted_total }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-4 text-end">
                                    <h5>Total: {{ $order->formatted_total }}</h5>
                                    <p class="text-muted">{{ $order->payment_method_text }}</p>
                                    
                                    @if($order->status === 'pending')
                                        <div class="btn-group-vertical w-100" role="group">
                                            <form action="{{ route('seller.orders.confirm', $order) }}" method="POST" class="mb-2">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success w-100">
                                                    <i class="fas fa-check"></i> Terima Pesanan
                                                </button>
                                            </form>
                                            <form action="{{ route('seller.orders.reject', $order) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger w-100"
                                                        onclick="return confirm('Yakin ingin tolak pesanan?')">
                                                    <i class="fas fa-times"></i> Tolak Pesanan
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                    
                                    @if($order->status === 'confirmed')
                                        <form action="{{ route('seller.orders.process', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-primary w-100">
                                                <i class="fas fa-cog"></i> Mulai Proses
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($order->status === 'processing')
                                        <button type="button" class="btn btn-info w-100" 
                                                data-bs-toggle="modal" data-bs-target="#shipModal{{ $order->id }}">
                                            <i class="fas fa-shipping-fast"></i> Kirim Pesanan
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Ship Modal -->
                    @if($order->status === 'processing')
                        <div class="modal fade" id="shipModal{{ $order->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('seller.orders.ship', $order) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title">Kirim Pesanan #{{ $order->order_number }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="tracking_number{{ $order->id }}" class="form-label">Nomor Resi (Opsional)</label>
                                                <input type="text" class="form-control" 
                                                       id="tracking_number{{ $order->id }}" name="tracking_number" 
                                                       placeholder="Masukkan nomor resi jika ada">
                                            </div>
                                            <div class="mb-3">
                                                <label for="shipping_notes{{ $order->id }}" class="form-label">Catatan Pengiriman (Opsional)</label>
                                                <textarea class="form-control" id="shipping_notes{{ $order->id }}" 
                                                          name="shipping_notes" rows="3" 
                                                          placeholder="Tambahkan catatan pengiriman..."></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-shipping-fast"></i> Kirim Sekarang
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                
                {{ $orders->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-clipboard-list fa-5x text-muted mb-3"></i>
                    <h4>Belum Ada Pesanan</h4>
                    <p class="text-muted">Belum ada pesanan masuk untuk lapak Anda.</p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection