@extends('layouts.app')

@section('title', 'Manage Orders - QuickCart Admin')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-10">

    @include('components.admin-nav', ['title' => 'Orders Management'])

    <!-- Search & Filter Bar -->
    <div class="mb-6 rounded-3xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="grid gap-3 sm:grid-cols-2 md:grid-cols-4">
            <div>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by ID, name, or email..."
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950"
                >
            </div>

            <div>
                <select
                    name="status"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950"
                >
                    <option value="">All Fulfillment Statuses</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                    <option value="processing" @selected(request('status') === 'processing')>Processing</option>
                    <option value="shipped" @selected(request('status') === 'shipped')>Shipped</option>
                    <option value="delivered" @selected(request('status') === 'delivered')>Delivered</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                </select>
            </div>

            <div>
                <select
                    name="payment_status"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-xs outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950"
                >
                    <option value="">All Payment Statuses</option>
                    <option value="pending" @selected(request('payment_status') === 'pending')>Payment: Pending</option>
                    <option value="paid" @selected(request('payment_status') === 'paid')>Payment: Paid</option>
                    <option value="failed" @selected(request('payment_status') === 'failed')>Payment: Failed</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="flex-1 rounded-xl bg-slate-900 py-2.5 text-xs font-bold text-white hover:bg-emerald-500 dark:bg-white dark:text-slate-950 dark:hover:bg-emerald-500 dark:hover:text-white transition">
                    Filter Orders
                </button>
                <a href="{{ route('admin.orders.index') }}" class="rounded-xl border border-slate-200 px-3 py-2.5 text-xs font-bold text-slate-500 hover:bg-slate-100 dark:border-slate-800">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-400 dark:border-slate-800 dark:bg-slate-950">
                        <th class="px-6 py-4">Order</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Items</th>
                        <th class="px-6 py-4">Total</th>
                        <th class="px-6 py-4">Payment</th>
                        <th class="px-6 py-4">Fulfillment</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($orders as $order)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition">
                            <td class="px-6 py-4 font-mono font-bold text-slate-900 dark:text-white">
                                #{{ $order->id }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900 dark:text-white">{{ $order->customer_name }}</div>
                                <div class="text-xs text-slate-400">{{ $order->customer_email }}</div>
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-600 dark:text-slate-400">
                                {{ $order->items->sum('quantity') }} items
                            </td>
                            <td class="px-6 py-4 font-black text-slate-900 dark:text-white">
                                ${{ number_format($order->total, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-300' : ($order->payment_status === 'failed' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700 dark:bg-amber-950/80 dark:text-amber-300') }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-bold {{ $order->status === 'delivered' ? 'bg-blue-100 text-blue-700 dark:bg-blue-950/80 dark:text-blue-300' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs text-slate-400">
                                {{ $order->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-emerald-500 hover:text-white dark:bg-slate-800 dark:text-slate-300 transition">
                                    Manage →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                No orders matching the current filter criteria.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>

</div>

@endsection
