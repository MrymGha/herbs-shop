<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
class AdminController extends Controller
{
    public function index()
    {
        $totalCustomers = User::role('customer')->count();
        $totalProducts  = Product::count();
        $totalOrders    = Order::count();
        $pendingOrders  = Order::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalCustomers', 'totalProducts', 'totalOrders', 'pendingOrders'));
    }
}
