@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Order Confirmation</h2>
    <p>Thank you! Your order has been placed successfully.</p>

    <h4>Order Details</h4>
    <p><strong>Order ID:</strong> {{ $order->id }}</p>
    <p><strong>Payment Status:</strong> {{ ucfirst($order->payment_status) }}</p>

    <h5>Items:</h5>
    <ul>
        @foreach ($order->products as $product)
            <li>{{ $product->name }} (x{{ $product->pivot->quantity }}) - ${{ $product->pivot->price }}</li>
        @endforeach
    </ul>
</div>
@endsection
