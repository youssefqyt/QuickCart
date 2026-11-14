<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index(Request $request)
    {
        $order = null;
        $searched = false;

        if ($request->filled('order_id') && $request->filled('email')) {
            $searched = true;
            $order = Order::with('items.product')
                ->where('id', $request->order_id)
                ->where('customer_email', trim($request->email))
                ->first();
        }

        return view('orders.track', compact('order', 'searched'));
    }
}
