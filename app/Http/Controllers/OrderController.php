<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Show checkout form (customer)
     */
    public function create()
    {
        $cart = $this->cartService->all();

        if (count($cart) === 0) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.create', compact('cart'));
    }

    /**
     * Store new order (customer)
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name'    => 'required|string|max:255',
    //         'address' => 'required|string|max:500',
    //         'phone'   => 'required|string|max:20',
    //     ]);

    //     $cart = $this->cartService->all();

    //     if (count($cart) === 0) {
    //         return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
    //     }

    //     $total = $this->cartService->total();

    //     // Create order
    //     $order = Order::create([
    //         'user_id' => Auth::id(),
    //         'name'    => $request->name,
    //         'address' => $request->address,
    //         'phone'   => $request->phone,
    //         'total'   => $total,
    //         'status'  => 'pending',
    //     ]);

    //     // Create order items
    //     foreach ($cart as $item) {
    //         OrderItem::create([
    //             'order_id'   => $order->id,
    //             'product_id' => $item['id'],
    //             'quantity'   => $item['quantity'],
    //             'price'      => $item['price'],
    //         ]);
    //     }

    //     // Clear cart
    //     $this->cartService->clear();

    //     return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    // }
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Check stock before confirming order
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            if (!$product->hasStock($item['quantity'])) {
                return redirect()->back()->with('error', "Not enough stock for {$product->name}.");
            }
        }

        // Create the order
        $order = Order::create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total' => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'shipping_name' => $request->input('shipping_name'),
            'shipping_phone' => $request->input('shipping_phone'),
            'shipping_address' => $request->input('shipping_address'),
            'notes' => $request->input('notes'),
        ]);

        // Attach items + decrement stock
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);

            $order->items()->create([
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

        $product->decrementStock($item['quantity']);
    }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }   


    /**
     * Show customer’s own orders
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Admin: view all orders
     */
    public function adminIndex()
    {
        $orders = Order::latest()->with('user')->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Admin: update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated.');
    }
}
