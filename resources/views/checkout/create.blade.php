@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Checkout</h1>

    {{-- Flash messages --}}
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Cart Summary --}}
    <h4>Your Cart</h4>
    <table class="table table-bordered mb-4">
        <thead class="table-light">
            <tr>
                <th>Product</th>
                <th width="100">Qty</th>
                <th width="120">Price</th>
                <th width="120">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
                @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>${{ number_format($subtotal, 2) }}</td>
                </tr>
            @endforeach
            <tr class="table-secondary fw-bold">
                <td colspan="3" class="text-end">Total</td>
                <td>${{ number_format($total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Checkout Form --}}
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="shipping_name" class="form-label">Full Name</label>
            <input type="text" name="shipping_name" id="shipping_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="shipping_phone" class="form-label">Phone</label>
            <input type="text" name="shipping_phone" id="shipping_phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="shipping_address" class="form-label">Shipping Address</label>
            <textarea name="shipping_address" id="shipping_address" class="form-control" rows="2" required></textarea>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Order Notes (optional)</label>
            <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
        </div>

        {{-- Payment (placeholder) --}}
        <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" class="form-select" required>
                <option value="cod">Cash on Delivery</option>
                <option value="paypal">PayPal (coming soon)</option>
                <option value="stripe">Stripe (coming soon)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Place Order</button>
        <a href="{{ route('cart.index') }}" class="btn btn-secondary">Back to Cart</a>
    </form>
</div>
@endsection
