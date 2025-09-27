<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
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
     * Show the checkout page (review cart + shipping form)
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
     * Store the order after checkout
     */
    public function store(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Validate shipping + payment info
        $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string|max:255',
            'notes'            => 'nullable|string',
            'payment_method'   => 'required|string', // e.g., dummy, stripe, paypal
        ]);

        // Stock validation
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);
            if (!$product->hasStock($item['quantity'])) {
                return redirect()->back()->with('error', "Not enough stock for {$product->name}.");
            }
        }

        // Create the order
        $order = Order::create([
            'user_id'          => auth()->id(),
            'status'           => 'pending',
            'total'            => collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']),
            'shipping_name'    => $request->input('shipping_name'),
            'shipping_phone'   => $request->input('shipping_phone'),
            'shipping_address' => $request->input('shipping_address'),
            'notes'            => $request->input('notes'),
            'payment_method'   => $request->input('payment_method'),
            'payment_status'   => $request->input('payment_method') === 'dummy' ? 'paid' : 'pending',
        ]);

        // Save order items
        foreach ($cart as $id => $item) {
            $product = Product::findOrFail($id);

            $order->items()->create([
                'product_id' => $id,
                'quantity'   => $item['quantity'],
                'price'      => $item['price'],
            ]);

            // Decrement stock
            $product->decrementStock($item['quantity']);
        }

        // Clear cart
        session()->forget('cart');

        // Redirect to confirmation instead of orders.index
        return redirect()->route('orders.confirmation', $order->id);
    }

    /**
     * User's order list
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    /**
     * Confirmation page after placing order
     */
    public function confirmation($id)
    {
        $order = Order::with('items.product')->where('user_id', Auth::id())->findOrFail($id);
        return view('checkout.confirmation', compact('order'));
    }
}
