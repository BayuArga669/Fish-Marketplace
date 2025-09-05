{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h2><i class="fas fa-list-alt"></i> Pesanan Saya</h2>
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
                                    <h6>Items:</h6>
                                    @foreach($order->items as $item)
                                        <div class="d-flex align-items-center mb-2">
                                            @if($item->product->images && count($item->product->images) > 0)
                                                <img src="{{ asset('storage/' . $item->product->images[0]) }}" 
                                                     class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;" 
                                                     alt="{{ $item->product->name }}">
                                            @endif
                                            <div>
                                                <strong>{{ $item->product->name }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $item->quantity }} {{ $item->product->unit }} × {{ $item->formatted_price }}</small>
                                            </div>
                                        </div>
                                    @endforeach
                                    
                                    <div class="mt-3">
                                        <p><strong>Penerima:</strong> {{ $order->recipient_name }}</p>
                                        <p><strong>Telepon:</strong> {{ $order->recipient_phone }}</p>
                                        <p><strong>Alamat:</strong> {{ $order->shipping_address }}</p>
                                        @if($order->notes)
                                            <p><strong>Catatan:</strong> {{ $order->notes }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <h5>Total: {{ $order->formatted_total }}</h5>
                                    <p class="text-muted">{{ $order->payment_method_text }}</p>
                                    
                                    @if($order->status === 'pending')
                                        <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin batalkan pesanan?')">
                                                <i class="fas fa-times"></i> Batalkan
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(in_array($order->status, ['confirmed', 'processing', 'shipped']))
                                        <button class="btn btn-success btn-sm" disabled>
                                            <i class="fas fa-check"></i> Dikonfirmasi
                                        </button>
                                    @endif
                                    
                                    @if($order->status === 'delivered')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle"></i> Selesai
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                {{ $orders->links() }}
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-list-alt fa-5x text-muted mb-3"></i>
                    <h4>Belum Ada Pesanan</h4>
                    <p class="text-muted">Anda belum memiliki pesanan apapun.</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary">
                        <i class="fas fa-fish"></i> Mulai Belanja
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
