@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="list-group">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active">
                    Dashboard
                </a>
                <a href="{{ route('admin.customers.index') }}" class="list-group-item list-group-item-action">
                    Manage Customers
                </a>
                <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">
                    Manage Products
                </a>
                <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action">
                    Manage Orders
                </a>
            </div>
        </div>

        <!-- Main content -->
        <div class="col-md-9">
            <h1>Admin Dashboard</h1>
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h3>{{ $totalCustomers }}</h3>
                        <p>Customers</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h3>{{ $totalProducts }}</h3>
                        <p>Products</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h3>{{ $totalOrders }}</h3>
                        <p>Total Orders</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-center p-3">
                        <h3>{{ $pendingOrders }}</h3>
                        <p>Pending Orders</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- @extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Admin Dashboard</h1>
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h3>{{ $totalCustomers }}</h3>
                <p>Customers</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h3>{{ $totalProducts }}</h3>
                <p>Products</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h3>{{ $totalOrders }}</h3>
                <p>Total Orders</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center p-3">
                <h3>{{ $pendingOrders }}</h3>
                <p>Pending Orders</p>
            </div>
        </div>
    </div>
</div>
@endsection --}}
