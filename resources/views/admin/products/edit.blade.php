@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Edit Product</h2>
    <p class="text-muted mb-0">{{ $product->name }}</p>
</div>

<div class="card content-card">
    <div class="card-body p-4">
        <form
            action="{{ route('admin.products.update', $product) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select
                    name="category_id"
                    class="form-select @error('category_id') is-invalid @enderror"
                    required
                >
                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected(old('category_id', $product->category_id) == $category->id)
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Name</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                    class="form-control @error('name') is-invalid @enderror"
                    required
                >

                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea
                    name="description"
                    class="form-control @error('description') is-invalid @enderror"
                    rows="4"
                >{{ old('description', $product->description) }}</textarea>

                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Price</label>
                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        name="price"
                        value="{{ old('price', $product->price) }}"
                        class="form-control @error('price') is-invalid @enderror"
                        required
                    >

                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Stock</label>
                    <input
                        type="number"
                        min="0"
                        name="stock"
                        value="{{ old('stock', $product->stock) }}"
                        class="form-control @error('stock') is-invalid @enderror"
                        required
                    >

                    @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Image</label>

                <div>
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        width="140"
                        height="140"
                        style="object-fit: contain"
                        onerror="this.src='https://placehold.co/140x140?text=Product'"
                    >
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Replace Image</label>
                <input
                    type="file"
                    name="image"
                    accept=".jpg,.jpeg,.png,.webp"
                    class="form-control @error('image') is-invalid @enderror"
                >

                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-dark" type="submit">
                    Save Changes
                </button>

                <a
                    href="{{ route('admin.products.index') }}"
                    class="btn btn-outline-secondary"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
