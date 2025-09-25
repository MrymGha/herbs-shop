@extends('layouts.app')

@section('content')
<h1 class="mb-4">All Herbs</h1>

<div class="row">
    @foreach($products as $product)
        <a href="{{ route('products.show', $product->id) }}">
        <div class="col-md-4 mb-3">
            <div class="card h-100">
                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">${{ $product->price }}</p>

                    @auth
                        @if(auth()->user()->hasRole('customer'))
                            <form action="{{ route('cart.store', $product) }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="number" name="quantity" value="1" min="1" class="form-control mb-2">
                                <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                            </form>
                        @else
                            <p class="text-muted mt-auto">Only customers can add to cart.</p>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 mt-auto">Login to Buy</a>
                    @endauth
                </div>
            </div>
        </div>
        </a>
    @endforeach
</div>
@endsection
