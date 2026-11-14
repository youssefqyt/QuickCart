@extends('layouts.app')

@section('title', 'Track Order - QuickCart')

@section('content')

<div class="mx-auto max-w-4xl px-6 py-12">

    <div class="mb-10 text-center">
        <p class="text-xs font-bold uppercase tracking-wider text-emerald-500">REAL-TIME STATUS</p>
        <h1 class="mt-1 text-3xl font-black text-slate-900 dark:text-white">Track Your Order</h1>
        <p class="mt-2 text-sm text-slate-500">Enter your order ID and email to view current shipment and payment status.</p>
    </div>

    <!-- Search Form -->
    <div class="mx-auto max-w-xl rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" action="{{ route('orders.track') }}" class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Order ID</label>
                <input
                    type="number"
                    name="order_id"
                    value="{{ request('order_id') }}"
                    placeholder="e.g. 1"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950"
                    required
                >
            </div>

            <div>
                <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Email Address</label>
                <input
                    type="email"
                    name="email"
                    value="{{ request('email') }}"
                    placeholder="e.g. john@example.com"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950"
                    required
                >
            </div>

            <button
                type="submit"
                class="sm:col-span-2 rounded-xl bg-emerald-500 py-3 text-sm font-bold text-white shadow-md shadow-emerald-500/20 transition hover:bg-emerald-600"
            >
                Find Order →
            </button>
        </form>
    </div>

    <!-- Results Section -->
    @if($order)
        <div class="mt-10 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">

            <div class="border-b border-slate-200 bg-slate-50 p-6 dark:border-slate-800 dark:bg-slate-950">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Order #{{ $order->id }}</span>
                        <p class="text-sm font-semibold text-slate-500">Placed on {{ $order->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="flex gap-2">
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-300">
                            Status: {{ ucfirst($order->status) }}
                        </span>
                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700 dark:bg-blue-950/80 dark:text-blue-300">
                            Payment: {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Progress Tracker -->
            @php
                $statuses = ['pending', 'processing', 'shipped', 'delivered'];
                $currentIndex = array_search($order->status, $statuses);
                if ($currentIndex === false && $order->status === 'completed') $currentIndex = 3;
                if ($order->status === 'cancelled') $currentIndex = -1;
            @endphp

            @if($order->status === 'cancelled')
                <div class="p-6 bg-red-50 text-red-700 text-center text-sm font-bold dark:bg-red-950/30 dark:text-red-300">
                    This order has been cancelled.
                </div>
            @else
                <div class="p-6 border-b border-slate-100 dark:border-slate-800">
                    <div class="grid grid-cols-4 gap-2 text-center text-xs font-bold">
                        @foreach($statuses as $index => $step)
                            @php
                                $isCompleted = $currentIndex !== false && $index <= $currentIndex;
                            @endphp
                            <div class="flex flex-col items-center">
                                <div class="flex h-9 w-9 items-center justify-center rounded-full text-xs font-black transition {{ $isCompleted ? 'bg-emerald-500 text-white' : 'bg-slate-200 text-slate-500 dark:bg-slate-800' }}">
                                    {{ $isCompleted ? '✓' : ($index + 1) }}
                                </div>
                                <span class="mt-2 capitalize {{ $isCompleted ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-400' }}">
                                    {{ $step }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="p-6 sm:p-8 space-y-6">
                <!-- Delivery & Shipping -->
                <div class="grid gap-6 sm:grid-cols-2 text-sm">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Recipient</span>
                        <p class="font-bold text-slate-900 dark:text-white mt-1">{{ $order->customer_name }}</p>
                        <p class="text-slate-500">{{ $order->customer_email }}</p>
                    </div>

                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Delivery Address</span>
                        <p class="text-slate-700 dark:text-slate-300 mt-1 whitespace-pre-line">{{ $order->address }}</p>
                    </div>
                </div>

                <!-- Items list -->
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Items Ordered</span>
                    <div class="mt-3 divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($order->items as $item)
                            <div class="flex items-center justify-between py-3">
                                <div>
                                    <p class="font-bold text-sm text-slate-900 dark:text-white">
                                        {{ $item->product->name ?? 'Product #' . $item->product_id }}
                                    </p>
                                    <p class="text-xs text-slate-400">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
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
                    <span class="text-base font-bold text-slate-700 dark:text-slate-300">Total Amount</span>
                    <span class="text-2xl font-black text-emerald-500">${{ number_format($order->total, 2) }}</span>
                </div>
            </div>

        </div>
    @elseif($searched)
        <div class="mt-10 rounded-3xl border border-dashed border-slate-300 p-12 text-center dark:border-slate-800">
            <div class="text-5xl">🔎</div>
            <h2 class="mt-4 text-xl font-bold text-slate-900 dark:text-white">No Order Found</h2>
            <p class="mt-2 text-sm text-slate-500">We couldn't find an order with that ID and email combination. Please double check the details.</p>
        </div>
    @endif

</div>

@endsection
