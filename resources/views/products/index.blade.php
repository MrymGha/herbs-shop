@extends('layouts.app')

@section('content')
<div class="row mb-3">
    <div class="col-md-3">
        <h5>Categories</h5>
        <ul class="list-group">
            @foreach($categories as $category)
                <li class="list-group-item">
                    <a href="{{ route('home', ['category' => $category->slug]) }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="col-md-9">
        <form method="GET" action="{{ route('home') }}" class="mb-4">
            <div class="row">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control"
                    placeholder="Search products..."
                    value="{{ request('search') }}">
            </div>

            <div class="col-md-2">
                <select name="category" class="form-control">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <input type="number" name="min_price" class="form-control"
                    placeholder="Min Price"
                    value="{{ request('min_price') }}">
            </div>
            <div class="col-md-2">
                <input type="number" name="max_price" class="form-control"
                    placeholder="Max Price"
                    value="{{ request('max_price') }}">
            </div>

            <div class="col-md-2">
                <select name="sort" class="form-control">
                    <option value="">Sort by</option>
                    <option value="popularity" {{ request('sort')=='popularity' ? 'selected' : '' }}>
                        Popularity
                    </option>
                </select>
            </div>

            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            </div>
        </form>

        <h1 class="mb-4">All Herbs</h1>

        <div class="row">
            @forelse($products as $product)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <a href="{{ route('products.show', $product->slug) }}" style="color: black; text-decoration: none;">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                        </a>
                            <p class="card-text">${{ $product->price }}</p>

                            @auth
                                @role('customer')
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                                        @csrf
                                        <input type="number" name="quantity" value="1" min="1" class="form-control mb-2">
                                        <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                                    </form>
                                @endrole
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 mt-auto">Login to Buy</a>
                            @endauth
                        </div>
                   
                    </div>
                </div>
            @empty
                <p>No products found.</p>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
