<?php
namespace App\Services;


use App\Models\Product;

class CartService
{
    protected $sessionKey = 'cart';


    public function add(Product $product, int $qty = 1)
    {
        $cart = session()->get($this->sessionKey, []);


        $id = (string)$product->id;
        if (isset($cart[$id])) {
        $cart[$id]['quantity'] += $qty;
        } else {
        $cart[$id] = [
        'product_id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
        'quantity' => $qty,
        'image' => $product->image,
        ];
        }


        session()->put($this->sessionKey, $cart);
    }


    public function update(Product $product, int $qty)
    {
        $cart = session()->get($this->sessionKey, []);
        $id = (string)$product->id;
        if (isset($cart[$id])) {
        $cart[$id]['quantity'] = max(1, $qty);
        session()->put($this->sessionKey, $cart);
    }
    }


    public function remove(Product $product)
    {
        $cart = session()->get($this->sessionKey, []);
        $id = (string)$product->id;
        if (isset($cart[$id])) {
        unset($cart[$id]);
        session()->put($this->sessionKey, $cart);
    }
    }


    public function clear()
    {
        session()->forget($this->sessionKey);
    }


    public function all()
    {
        return session()->get($this->sessionKey, []);
    }


    public function total(): float
    {
        $total = 0;
        foreach ($this->all() as $item) {
        $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}