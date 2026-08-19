@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('web.products.index') }}" class="btn btn-outline-secondary">
        Back to Products
    </a>
</div>

<div class="card content-card">
    <div class="card-body p-4">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6">
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    class="product-details-image"
                    alt="{{ $product->name }}"
                    onerror="this.src='https://placehold.co/700x500?text=Product+Image'"
                >
            </div>

            <div class="col-lg-6">
                <span class="badge bg-secondary mb-3">
                    {{ $product->category->name }}
                </span>

                <h1 class="fw-bold">
                    {{ $product->name }}
                </h1>

                <p class="text-muted mt-3">
                    {{ $product->description }}
                </p>

                <h3 class="fw-bold mt-4">
                    {{ number_format($product->price, 2) }} EGP
                </h3>

                <div class="mt-3">
                    @if($product->stock > 0)
                        <span class="badge bg-success">
                            {{ $product->stock }} available
                        </span>
                    @else
                        <span class="badge bg-danger">
                            Out of stock
                        </span>
                    @endif
                </div>

                @if(auth()->user()->role === 'user' && $product->stock > 0)
                    <hr class="my-4">

                    <form
                        action="{{ route('web.orders.store', $product) }}"
                        method="POST"
                    >
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Quantity
                            </label>

                            <input
                                type="number"
                                name="quantity"
                                min="1"
                                max="{{ $product->stock }}"
                                value="{{ old('quantity', 1) }}"
                                class="form-control @error('quantity') is-invalid @enderror"
                                required
                            >

                            @error('quantity')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button class="btn btn-dark btn-lg w-100" type="submit">
                            Place Order
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
