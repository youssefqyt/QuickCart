@extends('layouts.app')

@section('title', 'Shopping Cart - QuickCart')

@section('content')

<div class="mx-auto max-w-5xl px-6 py-12">

    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-emerald-500">YOUR SELECTION</p>
            <h1 class="mt-1 text-3xl font-black text-slate-900 dark:text-white">Shopping Cart</h1>
        </div>

        @if(count($cart))
            <form method="POST" action="{{ route('cart.clear') }}" onsubmit="return confirm('Are you sure you want to clear your entire cart?');">
                @csrf
                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-600 transition">
                    Empty Cart 🗑️
                </button>
            </form>
        @endif
    </div>

    <div class="mt-8 space-y-4">

        @forelse($cart as $item)

            <div class="flex flex-col gap-5 rounded-2xl border border-slate-200 bg-white p-5 sm:flex-row sm:items-center dark:border-slate-800 dark:bg-slate-900">

                <div class="flex h-20 w-20 flex-shrink-0 items-center justify-center overflow-hidden rounded-xl bg-slate-100 text-3xl dark:bg-slate-800">
                    @if(!empty($item['image']))
                        <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover">
                    @else
                        🛍️
                    @endif
                </div>

                <div class="flex-1">
                    @if(!empty($item['slug']))
                        <a href="{{ route('products.show', $item['slug']) }}" class="font-bold text-slate-900 hover:text-emerald-500 dark:text-white">
                            {{ $item['name'] }}
                        </a>
                    @else
                        <h2 class="font-bold text-slate-900 dark:text-white">{{ $item['name'] }}</h2>
                    @endif

                    <p class="mt-1 text-sm font-semibold text-emerald-500">
                        ${{ number_format($item['price'], 2) }} each
                    </p>

                    @if(!empty($item['stock']))
                        <p class="text-xs text-slate-400 mt-1">Available: {{ $item['stock'] }} in stock</p>
                    @endif
                </div>

                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('cart.update', $item['id']) }}" class="flex items-center gap-2">
                        @csrf
                        <input
                            type="number"
                            name="quantity"
                            min="1"
                            max="{{ $item['stock'] ?? 999 }}"
                            value="{{ $item['quantity'] }}"
                            class="w-16 rounded-xl border border-slate-200 px-3 py-1.5 text-center text-sm font-bold dark:border-slate-700 dark:bg-slate-950"
                        >
                        <button type="submit" class="rounded-xl bg-slate-100 px-3 py-1.5 text-xs font-bold text-slate-700 hover:bg-slate-200 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                            Update
                        </button>
                    </form>

                    <div class="text-right min-w-[80px]">
                        <span class="font-black text-slate-900 dark:text-white">
                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                        </span>
                    </div>

                    <form method="POST" action="{{ route('cart.remove', $item['id']) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Remove item" class="p-2 text-slate-400 hover:text-red-500 transition">
                            ✕
                        </button>
                    </form>
                </div>

            </div>

        @empty

            <div class="rounded-3xl border border-dashed border-slate-200 py-16 text-center dark:border-slate-800">
                <div class="text-6xl">🛒</div>
                <h2 class="mt-4 text-2xl font-black text-slate-900 dark:text-white">Your cart is currently empty</h2>
                <p class="mt-2 text-sm text-slate-500">Explore our catalog and find the products you need!</p>
                <a
                    href="{{ route('products.index') }}"
                    class="mt-6 inline-block rounded-xl bg-emerald-500 px-6 py-3 font-bold text-white shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition"
                >
                    Browse Products →
                </a>
            </div>

        @endforelse

    </div>

    @if(count($cart))
        <div class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 sm:p-8 dark:border-slate-800 dark:bg-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-sm font-semibold text-slate-500">Order Subtotal</span>
                    <p class="text-xs text-slate-400">Taxes & shipping calculated at checkout</p>
                </div>
                <span class="text-3xl font-black text-slate-900 dark:text-white">
                    ${{ number_format($total, 2) }}
                </span>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row gap-4">
                <a
                    href="{{ route('products.index') }}"
                    class="rounded-xl border border-slate-200 py-3.5 px-6 text-center font-bold text-slate-700 hover:bg-slate-100 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-800 transition"
                >
                    ← Continue Shopping
                </a>
                <a
                    href="{{ route('checkout.index') }}"
                    class="flex-1 rounded-xl bg-emerald-500 py-3.5 text-center font-bold text-white shadow-lg shadow-emerald-500/20 hover:bg-emerald-600 transition"
                >
                    Proceed to Checkout →
                </a>
            </div>
        </div>
    @endif

</div>

@endsection
