@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">{{ $user->name }}</h2>
        <p class="text-muted mb-0">User details and order history</p>
    </div>

    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        Back to Users
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-lg-4">
        <div class="card content-card">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Account Information</h5>

                <div class="mb-3">
                    <div class="text-muted">User ID</div>
                    <strong>#{{ $user->id }}</strong>
                </div>

                <div class="mb-3">
                    <div class="text-muted">Name</div>
                    <strong>{{ $user->name }}</strong>
                </div>

                <div class="mb-3">
                    <div class="text-muted">Email</div>
                    <strong>{{ $user->email }}</strong>
                </div>

                <div class="mb-3">
                    <div class="text-muted">Role</div>

                    @if($user->role === 'admin')
                        <span class="badge bg-primary">Admin</span>
                    @else
                        <span class="badge bg-secondary">User</span>
                    @endif
                </div>

                <div>
                    <div class="text-muted">Total Orders</div>
                    <strong>{{ $user->orders_count }}</strong>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card content-card table-card">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Orders</h5>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Order</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>

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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    This user has no orders.
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
    </div>
</div>
@endsection
