<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('cart', compact('cart', 'total'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        if ($product->stock <= 0) {
            return back()->with('error', 'Sorry, "' . $product->name . '" is out of stock.');
        }

        $cart = $request->session()->get('cart', []);
        $currentQuantity = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0;

        if ($currentQuantity + $quantity > $product->stock) {
            return back()->with('error', 'Only ' . $product->stock . ' units of "' . $product->name . '" are available in stock.');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => (float) $product->price,
                'image' => $product->image,
                'quantity' => $quantity,
                'stock' => $product->stock,
            ];
        }

        $request->session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('success', '"' . $product->name . '" added to cart.');
    }

    public function update(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $quantity = max(1, (int) $request->quantity);

            if ($quantity > $product->stock) {
                return back()->with('error', 'Only ' . $product->stock . ' units of "' . $product->name . '" are available in stock.');
            }

            $cart[$product->id]['quantity'] = $quantity;
            $request->session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(Request $request, Product $product)
    {
        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $name = $cart[$product->id]['name'];
            unset($cart[$product->id]);
            $request->session()->put('cart', $cart);

            return back()->with('success', '"' . $name . '" removed from cart.');
        }

        return back()->with('success', 'Product removed from cart.');
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');

        return redirect()
            ->route('cart.index')
            ->with('success', 'Your cart has been cleared.');
    }
}
