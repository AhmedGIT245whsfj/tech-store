@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Dashboard</h2>
        <p class="text-muted mb-0">
            Welcome, {{ auth()->user()->name }}
        </p>
    </div>
</div>

<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="text-muted">Available Products</div>
                <div class="display-5 fw-bold">
                    {{ $productsCount }}
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card dashboard-card">
            <div class="card-body p-4">
                <div class="text-muted">My Orders</div>
                <div class="display-5 fw-bold">
                    {{ $ordersCount }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Latest Products</h4>
</div>

<div class="row g-4">
    @foreach($latestProducts as $product)
        <div class="col-md-6 col-lg-4">
            <div class="card product-card">
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    class="product-image"
                    alt="{{ $product->name }}"
                    onerror="this.src='https://placehold.co/600x400?text=Product+Image'"
                >

                <div class="card-body">
                    <span class="badge bg-secondary mb-2">
                        {{ $product->category->name }}
                    </span>

                    <h5 class="card-title">
                        {{ $product->name }}
                    </h5>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <strong>
                            {{ number_format($product->price, 2) }} EGP
                        </strong>

                        <span class="text-muted">
                            Stock: {{ $product->stock }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
