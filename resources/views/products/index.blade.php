@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Products</h2>
        <p class="text-muted mb-0">Browse our technology products</p>
    </div>
</div>

<div class="card content-card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('web.products.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-8">
                    <label class="form-label">Category</label>

                    <select name="category" class="form-select">
                        <option value="">All Categories</option>

                        @foreach($categories as $category)
                            <option
                                value="{{ $category->slug }}"
                                @selected(request('category') === $category->slug)
                            >
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <div class="d-flex gap-2">
                        <button class="btn btn-dark flex-grow-1" type="submit">
                            Filter
                        </button>

                        <a href="{{ route('web.products.index') }}" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    @forelse($products as $product)
        <div class="col-md-6 col-lg-4">
            <div class="card product-card">
                <img
                    src="{{ asset('storage/' . $product->image) }}"
                    class="product-image"
                    alt="{{ $product->name }}"
                    onerror="this.src='https://placehold.co/600x400?text=Product+Image'"
                >

                <div class="card-body d-flex flex-column">
                    <div>
                        <span class="badge bg-secondary mb-2">
                            {{ $product->category->name }}
                        </span>

                        <h5 class="card-title">
                            {{ $product->name }}
                        </h5>

                        <p class="text-muted">
                            {{ \Illuminate\Support\Str::limit($product->description, 90) }}
                        </p>
                    </div>

                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <strong>
                                {{ number_format($product->price, 2) }} EGP
                            </strong>

                            @if($product->stock > 0)
                                <span class="badge bg-success">
                                    Stock: {{ $product->stock }}
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Out of stock
                                </span>
                            @endif
                        </div>

                        <a
                            href="{{ route('web.products.show', $product) }}"
                            class="btn btn-dark w-100"
                        >
                            View Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                No products found.
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
