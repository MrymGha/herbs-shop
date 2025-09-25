@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1>Welcome to Herbs Shop 🌿</h1>
    <p class="lead">Discover and buy natural herbs easily.</p>
    <a href="{{ route('home') }}" class="btn btn-success btn-lg">Browse Herbs</a>
</div>
@endsection
