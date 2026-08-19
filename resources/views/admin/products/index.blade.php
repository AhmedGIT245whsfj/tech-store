@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Manage Products</h2>
        <p class="text-muted mb-0">Create, edit and delete store products</p>
    </div>

    <a href="{{ route('admin.products.create') }}" class="btn btn-dark">
        Add Product
    </a>
</div>

<div class="card content-card table-card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                width="70"
                                height="70"
                                style="object-fit: contain"
                                onerror="this.src='https://placehold.co/70x70?text=Product'"
                            >
                        </td>

                        <td>
                            <strong>{{ $product->name }}</strong>
                        </td>

                        <td>
                            {{ $product->category->name }}
                        </td>

                        <td>
                            {{ number_format($product->price, 2) }} EGP
                        </td>

                        <td>
                            {{ $product->stock }}
                        </td>

                        <td>
                            <div class="d-flex gap-2">
                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
                                    class="btn btn-sm btn-outline-primary"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.products.delete', $product) }}"
                                    method="POST"
                                    onsubmit="return confirm('Delete this product?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger" type="submit">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $products->links() }}
</div>
@endsection
