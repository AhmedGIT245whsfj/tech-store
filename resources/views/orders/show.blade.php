@extends('layouts.app')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">
            Order #{{ $order->id }}
        </h2>

        <p class="text-muted mb-0">
            {{ $order->created_at->format('d M Y H:i') }}
        </p>
    </div>

    <a href="{{ route('web.orders.index') }}" class="btn btn-outline-secondary">
        Back to Orders
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card content-card">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Order Items</h5>
            </div>

            <div class="card-body">
                @foreach($order->items as $item)
                    <div class="d-flex align-items-center gap-3 py-3 border-bottom">
                        <img
                            src="{{ asset('storage/' . $item->product->image) }}"
                            width="90"
                            height="90"
                            style="object-fit: contain"
                            alt="{{ $item->product->name }}"
                            onerror="this.src='https://placehold.co/100x100?text=Product'"
                        >

                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">
                                {{ $item->product->name }}
                            </h6>

                            <div class="text-muted">
                                Quantity: {{ $item->quantity }}
                            </div>
                        </div>

                        <div class="text-end">
                            <div>
                                {{ number_format($item->price, 2) }} EGP
                            </div>

                            <strong>
                                {{ number_format($item->price * $item->quantity, 2) }} EGP
                            </strong>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card content-card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Order Summary</h5>

                <div class="d-flex justify-content-between mb-3">
                    <span>Status</span>

                    @if($order->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @elseif($order->status === 'processing')
                        <span class="badge bg-primary">Processing</span>
                    @elseif($order->status === 'completed')
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <strong>Total</strong>
                    <strong>
                        {{ number_format($order->total_price, 2) }} EGP
                    </strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
