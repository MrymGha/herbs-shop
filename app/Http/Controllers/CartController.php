<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index()
    {
        
        $cart = session()->get('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $quantity = $request->input('quantity', 1);

        if (!$product->hasStock($quantity)) {
            return redirect()->back()->with('error', 'Product is out of stock.');
        }
        
        $cart = session()->get('cart', []);
               
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => 1,
                'image'    => $product->image ?? 'default.jpg',
            ];
        }

        session()->put('cart', $cart);

        return  response()->json([
            'success' => true,
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    public function count()
    {
        $cart = session()->get('cart', []);
        return response()->json(['count' => array_sum(array_column($cart, 'quantity'))]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier !');
    }

    public function update(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Panier mis à jour');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Panier vidé avec succès !');
    }
}
