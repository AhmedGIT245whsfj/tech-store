@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">My Orders</h2>
    <p class="text-muted mb-0">View your order history</p>
</div>

<div class="card content-card table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Order</th>
                    <th>Items</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>

                        <td>
                            {{ $order->items->sum('quantity') }}
                        </td>

                        <td>
                            {{ number_format($order->total_price, 2) }} EGP
                        </td>

                        <td>
                            @if($order->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order->status === 'processing')
                                <span class="badge bg-primary">Processing</span>
                            @elseif($order->status === 'completed')
                                <span class="badge bg-success">Completed</span>
                            @else
                                <span class="badge bg-danger">Cancelled</span>
                            @endif
                        </td>

                        <td>
                            {{ $order->created_at->format('d M Y H:i') }}
                        </td>

                        <td>
                            <a
                                href="{{ route('web.orders.show', $order) }}"
                                class="btn btn-sm btn-outline-dark"
                            >
                                Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            You have no orders yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $orders->links() }}
</div>
@endsection
