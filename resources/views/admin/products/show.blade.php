@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="img-fluid rounded">
        </div>

        <!-- Product Info -->
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</p>
            <h4>{{ number_format($product->price, 2) }} MAD</h4>

            <p>{{ $product->description }}</p>

            <p>
                <strong>Stock:</strong> 
                {{ $product->stock > 0 ? $product->stock : 'Out of stock' }}
            </p>

            @if ($product->stock > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center mb-3">
                        <input type="number" name="quantity" 
                               value="1" 
                               min="1" 
                               max="{{ $product->stock }}" 
                               class="form-control w-25 me-2">
                        <button type="submit" class="btn btn-success">
                            Add to Cart
                        </button>
                    </div>
                </form>
            @else
                <button class="btn btn-secondary" disabled>Out of Stock</button>
            @endif
        </div>
    </div>
</div>
@endsection
