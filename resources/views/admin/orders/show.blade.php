@extends('layouts.app')

@section('title', 'Manage Order #' . $order->id . ' - QuickCart Admin')

@section('content')

<div class="mx-auto max-w-5xl px-6 py-10">

    @include('components.admin-nav', ['title' => 'Order #' . $order->id . ' Details'])

    <div class="grid gap-8 lg:grid-cols-12">

        <!-- Order Information & Status Update Form -->
        <div class="lg:col-span-8 space-y-6">

            <!-- Items Card -->
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-lg font-black text-slate-900 dark:text-white mb-4">Ordered Items</h2>

                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between py-4">
                            <div class="flex items-center gap-4">
                                <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl bg-slate-100 text-xl dark:bg-slate-800">
                                    @if($item->product && $item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover">
                                    @else
                                        🛍️
                                    @endif
                                </div>
                                <div>
                                    @if($item->product)
                                        <a href="{{ route('products.show', $item->product) }}" class="font-bold text-sm text-slate-900 hover:text-emerald-500 dark:text-white">
                                            {{ $item->product->name }}
                                        </a>
                                    @else
                                        <p class="font-bold text-sm text-slate-900 dark:text-white">Product #{{ $item->product_id }}</p>
                                    @endif
                                    <p class="text-xs text-slate-400">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                </div>
                            </div>
                            <span class="font-bold text-sm text-slate-900 dark:text-white">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4 border-t border-slate-100 pt-4 flex justify-between items-center dark:border-slate-800">
                    <span class="font-bold text-slate-700 dark:text-slate-300">Total Order Value</span>
                    <span class="text-2xl font-black text-emerald-500">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Customer & Shipping Card -->
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-lg font-black text-slate-900 dark:text-white mb-4">Customer & Shipping Information</h2>

                <div class="grid gap-6 sm:grid-cols-2 text-sm">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Recipient Name</span>
                        <p class="font-bold text-slate-900 dark:text-white mt-1">{{ $order->customer_name }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Email Address</span>
                        <p class="font-bold text-slate-900 dark:text-white mt-1">{{ $order->customer_email }}</p>
                    </div>

                    <div class="sm:col-span-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Shipping Address</span>
                        <p class="text-slate-700 dark:text-slate-300 mt-1 whitespace-pre-line">{{ $order->address }}</p>
                    </div>
                </div>
            </div>

            <!-- Stripe / Payment Details -->
            @if($order->stripe_session_id || $order->stripe_payment_intent_id)
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                    <h2 class="text-lg font-black text-slate-900 dark:text-white mb-3">Stripe Payment Info</h2>
                    <div class="space-y-2 text-xs font-mono text-slate-500">
                        @if($order->stripe_session_id)
                            <div><span class="text-slate-400 font-sans">Session ID:</span> {{ $order->stripe_session_id }}</div>
                        @endif
                        @if($order->stripe_payment_intent_id)
                            <div><span class="text-slate-400 font-sans">Payment Intent:</span> {{ $order->stripe_payment_intent_id }}</div>
                        @endif
                    </div>
                </div>
            @endif

        </div>

        <!-- Order Control Panel Sidebar -->
        <div class="lg:col-span-4 space-y-6">

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
                <h2 class="text-lg font-black text-slate-900 dark:text-white mb-4">Update Order Status</h2>

                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Fulfillment Status
                        </label>
                        <select
                            name="status"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 font-bold"
                        >
                            <option value="pending" @selected($order->status === 'pending')>Pending</option>
                            <option value="processing" @selected($order->status === 'processing')>Processing</option>
                            <option value="shipped" @selected($order->status === 'shipped')>Shipped</option>
                            <option value="delivered" @selected($order->status === 'delivered')>Delivered</option>
                            <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Payment Status
                        </label>
                        <select
                            name="payment_status"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950 font-bold"
                        >
                            <option value="pending" @selected($order->payment_status === 'pending')>Pending</option>
                            <option value="paid" @selected($order->payment_status === 'paid')>Paid</option>
                            <option value="failed" @selected($order->payment_status === 'failed')>Failed</option>
                        </select>
                    </div>

                    <button
                        type="submit"
                        class="w-full rounded-xl bg-emerald-500 py-3 text-xs font-bold text-white shadow-md shadow-emerald-500/20 hover:bg-emerald-600 transition"
                    >
                        Save Status Changes
                    </button>
                </form>
            </div>

            <!-- Metadata card -->
            <div class="rounded-3xl bg-slate-50 p-6 text-xs text-slate-500 dark:bg-slate-950 dark:border dark:border-slate-800">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Created:</span>
                        <span class="font-bold text-slate-700 dark:text-slate-300">{{ $order->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Last Updated:</span>
                        <span class="font-bold text-slate-700 dark:text-slate-300">{{ $order->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-slate-200 dark:border-slate-800">
                    <a href="{{ route('admin.orders.index') }}" class="block text-center font-bold text-emerald-500 hover:underline">
                        ← Back to Orders List
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

@endsection
