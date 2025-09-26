{{-- @extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Edit Product</h1>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price ($)</label>
            <input type="number" name="price" step="0.01" class="form-control" value="{{ $product->price }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @if($product->category_id == $cat->id) selected @endif>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="Product" width="120" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input 
                type="checkbox" 
                name="featured" 
                id="featured" 
                class="form-check-input" 
                value="1" 
                {{ $product->featured ? 'checked' : '' }}>
            <label for="featured" class="form-check-label">Featured</label>
        </div>

        <button type="submit" class="btn btn-success">💾 Update</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">⬅️ Back</a>
    </form>
</div>
@endsection --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Edit Product</h1>

    {{-- Show validation errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Product Name --}}
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
        </div>

        {{-- Price --}}
        <div class="mb-3">
            <label class="form-label">Price ($)</label>
            <input type="number" name="price" step="0.01" class="form-control" 
                   value="{{ old('price', $product->price) }}" required>
        </div>

        {{-- Stock --}}
        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control" 
                   value="{{ old('stock', $product->stock) }}" required>
        </div>

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control" required>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Current Image --}}
        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}" alt="Product" width="120" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control">
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Featured Checkbox --}}
        <div class="form-check mb-3">
            <input 
                type="checkbox" 
                name="featured" 
                id="featured" 
                class="form-check-input" 
                {{ $product->featured ? 'checked' : '' }}>
            <label for="featured" class="form-check-label">Featured</label>
        </div>

        {{-- Buttons --}}
        <button type="submit" class="btn btn-success">💾 Update</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">⬅️ Back</a>
    </form>
</div>
@endsection
