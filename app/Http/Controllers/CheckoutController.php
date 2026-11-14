<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return view('checkout', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string'],
            'payment_method' => ['nullable', 'in:stripe,cod'],
        ]);

        $paymentMethod = $validated['payment_method'] ?? 'stripe';
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Your cart is empty.');
        }

        // Verify stock for all items
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product || $product->stock < $item['quantity']) {
                $available = $product ? $product->stock : 0;
                return back()
                    ->withInput()
                    ->with('error', 'Item "' . $item['name'] . '" has only ' . $available . ' available in stock.');
            }
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        DB::beginTransaction();

        try {
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'address' => $validated['address'],
                'total' => $total,
                'status' => $paymentMethod === 'cod' ? 'processing' : 'pending',
                'payment_status' => $paymentMethod === 'cod' ? 'pending' : 'pending',
            ]);

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            if ($paymentMethod === 'cod') {
                $order->decrementStock();
                DB::commit();

                session()->forget('cart');

                return redirect()
                    ->route('checkout.success', ['order_id' => $order->id])
                    ->with('success', 'Order placed successfully!');
            }

            // Stripe Payment
            $stripeSecret = config('services.stripe.secret');
            if (empty($stripeSecret)) {
                // If stripe secret is not configured, fall back to completing order for development
                $order->update(['payment_status' => 'paid', 'status' => 'processing']);
                $order->decrementStock();
                DB::commit();

                session()->forget('cart');

                return redirect()
                    ->route('checkout.success', ['order_id' => $order->id])
                    ->with('success', 'Order completed successfully in test mode.');
            }

            Stripe::setApiKey($stripeSecret);

            $lineItems = [];
            foreach ($cart as $item) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $item['name'],
                        ],
                        'unit_amount' => (int) round($item['price'] * 100),
                    ],
                    'quantity' => $item['quantity'],
                ];
            }

            $stripeSession = StripeSession::create([
                'mode' => 'payment',
                'customer_email' => $validated['customer_email'],
                'line_items' => $lineItems,
                'metadata' => [
                    'order_id' => $order->id,
                ],
                'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}&order_id=' . $order->id,
                'cancel_url' => route('checkout.cancel') . '?order_id=' . $order->id,
            ]);

            $order->update([
                'stripe_session_id' => $stripeSession->id,
            ]);

            DB::commit();

            return redirect($stripeSession->url);

        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        // Clear cart on checkout success
        session()->forget('cart');

        $sessionId = $request->query('session_id');
        $orderId = $request->query('order_id');
        $order = null;

        if ($orderId) {
            $order = Order::with('items.product')->find($orderId);
        } elseif ($sessionId) {
            $order = Order::with('items.product')
                ->where('stripe_session_id', $sessionId)
                ->first();
        }

        if ($order && $order->payment_status !== 'paid' && $sessionId) {
            $order->update([
                'payment_status' => 'paid',
                'status' => 'processing',
            ]);
            $order->decrementStock();
        }

        return view('checkout.success', compact('sessionId', 'order'));
    }

    public function cancel(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = $orderId ? Order::find($orderId) : null;

        return view('checkout.cancel', compact('orderId', 'order'));
    }
}
