<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::role('customer')->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function destroy(User $customer)
    {
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Customer deleted successfully.');
    }

    public function block(User $customer)
    {
        $customer->update(['status' => 'blocked']); // ⚠️ You need to add a "status" column in users table
        return redirect()->route('admin.customers.index')->with('success', 'Customer blocked successfully.');
    }
}
