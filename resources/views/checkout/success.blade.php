@extends('layouts.app')

@section('title', 'Order Confirmed - QuickCart')

@section('content')

<div class="mx-auto max-w-3xl px-6 py-16">

    <div class="text-center">
        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-3xl text-emerald-600 dark:bg-emerald-950/60 dark:text-emerald-400">
            ✓
        </div>

        <h1 class="text-3xl font-black text-slate-900 dark:text-white">
            Thank You for Your Order!
        </h1>

        <p class="mt-2 text-slate-600 dark:text-slate-400 text-sm">
            We've received your order and are currently preparing it for shipment.
        </p>
    </div>

    @if($order)
        <div class="mt-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="border-b border-slate-200 bg-slate-50 p-6 dark:border-slate-800 dark:bg-slate-950">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Order Number</span>
                        <p class="text-lg font-black text-slate-900 dark:text-white">#{{ $order->id }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-300">
                            Fulfillment: {{ ucfirst($order->status) }}
                        </span>
                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700 dark:bg-blue-950/80 dark:text-blue-300">
                            Payment: {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="p-6 sm:p-8 space-y-6">
                <!-- Customer Details -->
                <div class="grid gap-6 sm:grid-cols-2 text-sm">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Customer Info</span>
                        <p class="font-bold text-slate-900 dark:text-white mt-1">{{ $order->customer_name }}</p>
                        <p class="text-slate-500">{{ $order->customer_email }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Delivery Address</span>
                        <p class="text-slate-700 dark:text-slate-300 mt-1 whitespace-pre-line">{{ $order->address }}</p>
                    </div>
                </div>

                <!-- Items Breakdown -->
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Items Ordered</span>
                    <div class="mt-3 divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between py-3">
                                <div>
                                    <p class="font-bold text-sm text-slate-900 dark:text-white">
                                        {{ $item->product->name ?? 'Product #' . $item->product_id }}
                                    </p>
                                    <p class="text-xs text-slate-400">Quantity: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                </div>
                                <span class="font-bold text-sm text-slate-900 dark:text-white">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Total -->
                <div class="border-t border-slate-100 pt-4 flex justify-between items-center dark:border-slate-800">
                    <span class="text-base font-bold text-slate-700 dark:text-slate-300">Grand Total</span>
                    <span class="text-2xl font-black text-emerald-500">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
    @elseif($sessionId)
        <div class="mt-8 rounded-2xl bg-slate-100 p-6 text-center text-sm dark:bg-slate-900">
            <span class="text-slate-500">Stripe Session:</span>
            <span class="font-mono text-xs block mt-1 text-slate-700 dark:text-slate-300">{{ $sessionId }}</span>
        </div>
    @endif

    <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
        @if($order)
            <a
                href="{{ route('orders.track', ['order_id' => $order->id, 'email' => $order->customer_email]) }}"
                class="rounded-xl border border-slate-200 px-6 py-3 text-center text-sm font-bold text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 transition"
            >
                Track This Order
            </a>
        @endif

        <a
            href="{{ route('products.index') }}"
            class="rounded-xl bg-emerald-500 px-8 py-3 text-center text-sm font-bold text-white shadow-lg shadow-emerald-500/25 hover:bg-emerald-600 transition"
        >
            Continue Shopping →
        </a>
    </div>

</div>

@endsection
