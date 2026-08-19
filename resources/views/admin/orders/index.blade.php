@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Orders</h2>
    <p class="text-muted mb-0">Manage customer orders</p>
</div>

<div class="card content-card table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Order</th>
                    <th>User</th>
                    <th>Email</th>
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
                            <strong>{{ $order->user->name }}</strong>
                        </td>

                        <td>{{ $order->user->email }}</td>

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
                                href="{{ route('admin.orders.show', $order) }}"
                                class="btn btn-sm btn-outline-dark"
                            >
                                Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            No orders found.
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
