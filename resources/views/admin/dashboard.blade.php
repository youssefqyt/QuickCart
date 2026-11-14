@extends('layouts.app')

@section('title', 'Admin Dashboard - QuickCart')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-10">

    @include('components.admin-nav', ['title' => 'Admin Dashboard'])

    <!-- Key Performance Indicators -->
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

        <div class="rounded-3xl bg-emerald-500 p-6 text-white shadow-lg shadow-emerald-500/10">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-100">Total Revenue</span>
            <p class="mt-3 text-3xl font-black">${{ number_format($stats['total_revenue'], 2) }}</p>
            <p class="mt-1 text-xs text-emerald-100">Paid orders</p>
        </div>

        <div class="rounded-3xl bg-slate-900 p-6 text-white shadow-lg dark:bg-slate-900 dark:border dark:border-slate-800">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Orders</span>
            <p class="mt-3 text-3xl font-black">{{ $stats['total_orders'] }}</p>
            <p class="mt-1 text-xs text-amber-400 font-bold">{{ $stats['pending_orders'] }} pending fulfillment</p>
        </div>

        <div class="rounded-3xl bg-white p-6 border border-slate-200 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Products in Catalog</span>
            <p class="mt-3 text-3xl font-black text-slate-900 dark:text-white">{{ $stats['total_products'] }}</p>
            <a href="{{ route('admin.products.create') }}" class="mt-1 text-xs font-bold text-emerald-500 hover:underline inline-block">+ Add product</a>
        </div>

        <div class="rounded-3xl bg-white p-6 border border-slate-200 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Categories</span>
            <p class="mt-3 text-3xl font-black text-slate-900 dark:text-white">{{ $stats['total_categories'] }}</p>
            <a href="{{ route('admin.categories.create') }}" class="mt-1 text-xs font-bold text-emerald-500 hover:underline inline-block">+ Add category</a>
        </div>

    </div>

    <!-- Quick Sections Grid -->
    <div class="mt-10 grid gap-8 lg:grid-cols-12">

        <!-- Recent Orders -->
        <div class="lg:col-span-8 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Recent Orders</h2>
                    <p class="text-xs text-slate-400">Latest orders placed by customers</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-500 hover:underline">
                    View All Orders →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-xs text-slate-400 uppercase tracking-wider dark:border-slate-800">
                            <th class="pb-3">Order</th>
                            <th class="pb-3">Customer</th>
                            <th class="pb-3">Total</th>
                            <th class="pb-3">Payment</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="py-3 font-bold text-slate-900 dark:text-white">#{{ $order->id }}</td>
                                <td class="py-3">
                                    <div class="font-medium text-slate-900 dark:text-slate-200">{{ $order->customer_name }}</div>
                                    <div class="text-xs text-slate-400">{{ $order->customer_email }}</div>
                                </td>
                                <td class="py-3 font-bold text-slate-900 dark:text-white">${{ number_format($order->total, 2) }}</td>
                                <td class="py-3">
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-300' : 'bg-amber-100 text-amber-700 dark:bg-amber-950/80 dark:text-amber-300' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ $order->status === 'delivered' ? 'bg-blue-100 text-blue-700 dark:bg-blue-950/80 dark:text-blue-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 text-right">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-xs font-bold text-emerald-500 hover:text-emerald-600">
                                        Manage
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-xs text-slate-400">No orders placed yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inventory Alerts -->
        <div class="lg:col-span-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-lg font-black text-slate-900 dark:text-white">Stock Alerts</h2>
                    <p class="text-xs text-slate-400">Products running low (&lt; 5 units)</p>
                </div>
                <span class="rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-bold text-red-700 dark:bg-red-950/80 dark:text-red-300">
                    {{ $stats['low_stock_count'] }}
                </span>
            </div>

            <div class="space-y-3">
                @forelse($lowStockProducts as $product)
                    <div class="flex items-center justify-between rounded-2xl bg-slate-50 p-3 dark:bg-slate-950">
                        <div class="pr-2">
                            <p class="text-xs font-bold text-slate-900 dark:text-white line-clamp-1">{{ $product->name }}</p>
                            <p class="text-[11px] text-slate-400">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="rounded-lg px-2 py-0.5 text-xs font-black {{ $product->stock == 0 ? 'bg-red-500 text-white' : 'bg-amber-500 text-white' }}">
                                {{ $product->stock }} left
                            </span>
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-xs font-bold text-slate-400 hover:text-slate-900 dark:hover:text-white">
                                ✏️
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-xs text-slate-400">
                        ✓ All products have adequate inventory.
                    </div>
                @endforelse
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                <a href="{{ route('admin.products.index') }}" class="block text-center text-xs font-bold text-slate-600 hover:text-emerald-500 dark:text-slate-400">
                    Manage Entire Catalog →
                </a>
            </div>
        </div>

    </div>

</div>

@endsection
