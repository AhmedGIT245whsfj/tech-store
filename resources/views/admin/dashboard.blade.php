@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Admin Dashboard</h2>
    <p class="text-muted mb-0">
        Store overview and management
    </p>
</div>

<div class="row g-4">
    <div class="col-md-6 col-xl-3">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="text-muted">Users</div>
                <div class="display-6 fw-bold">
                    {{ $usersCount }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="text-muted">Products</div>
                <div class="display-6 fw-bold">
                    {{ $productsCount }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="text-muted">Orders</div>
                <div class="display-6 fw-bold">
                    {{ $ordersCount }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="text-muted">Pending Orders</div>
                <div class="display-6 fw-bold">
                    {{ $pendingOrdersCount }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
