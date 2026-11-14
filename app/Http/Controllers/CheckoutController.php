<?php

namespace App\Http\Controllers;

use App\Models\Order;
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
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()
                ->route('products.index')
                ->with('error', 'Your cart is empty.');
        }

        $total = collect($cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | 1. Create local order
            |--------------------------------------------------------------------------
            */

            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'address' => $validated['address'],
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
            ]);

            /*
            |--------------------------------------------------------------------------
            | 2. Create order items
            |--------------------------------------------------------------------------
            */

            foreach ($cart as $item) {
                $order->items()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | 3. Create Stripe Checkout Session
            |--------------------------------------------------------------------------
            */

            Stripe::setApiKey(config('services.stripe.secret'));

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

                'success_url' => route('checkout.success')
                    . '?session_id={CHECKOUT_SESSION_ID}',

                'cancel_url' => route('checkout.cancel')
                    . '?order_id=' . $order->id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | 4. Save Stripe session ID
            |--------------------------------------------------------------------------
            */

            $order->update([
                'stripe_session_id' => $stripeSession->id,
            ]);

            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | 5. Redirect customer to Stripe
            |--------------------------------------------------------------------------
            */

            return redirect($stripeSession->url);

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        return view('checkout.success', compact('sessionId'));
    }

    public function cancel(Request $request)
    {
        $orderId = $request->query('order_id');

        return view('checkout.cancel', compact('orderId'));
    }
}