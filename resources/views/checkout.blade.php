@extends('layouts.app')

@section('title', 'Checkout - QuickCart')

@section('content')

<div class="mx-auto max-w-5xl px-6 py-12">

    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-wider text-emerald-500">FINAL STEP</p>
        <h1 class="mt-1 text-3xl font-black text-slate-900 dark:text-white">Secure Checkout</h1>
    </div>

    <div class="grid gap-10 lg:grid-cols-12">

        <!-- Form Column -->
        <div class="lg:col-span-7">
            <form
                method="POST"
                action="{{ route('checkout.store') }}"
                class="rounded-3xl border border-slate-200 bg-white p-7 shadow-sm dark:border-slate-800 dark:bg-slate-900"
            >
                @csrf

                <h2 class="text-xl font-black text-slate-900 dark:text-white">Shipping & Contact Details</h2>

                <div class="mt-6 space-y-4">
                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Full Name
                        </label>
                        <input
                            type="text"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            placeholder="John Doe"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950"
                            required
                        >
                        @error('customer_name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Email Address
                        </label>
                        <input
                            type="email"
                            name="customer_email"
                            value="{{ old('customer_email') }}"
                            placeholder="john@example.com"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950"
                            required
                        >
                        @error('customer_email')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Delivery Address
                        </label>
                        <textarea
                            name="address"
                            rows="3"
                            placeholder="123 Street Name, City, Country"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950"
                            required
                        >{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4">
                        <label class="mb-3 block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">
                            Payment Method
                        </label>

                        <div class="grid gap-3 sm:grid-cols-2">
                            <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-emerald-500/40 bg-emerald-50/40 p-4 dark:border-emerald-500/30 dark:bg-emerald-950/20">
                                <input type="radio" name="payment_method" value="stripe" checked class="text-emerald-500 focus:ring-emerald-500">
                                <div>
                                    <span class="block text-sm font-bold text-slate-900 dark:text-white">Credit / Debit Card</span>
                                    <span class="text-xs text-slate-500">Secured with Stripe</span>
                                </div>
                            </label>

                            <label class="flex cursor-pointer items-center gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 dark:border-slate-800 dark:bg-slate-950">
                                <input type="radio" name="payment_method" value="cod" class="text-emerald-500 focus:ring-emerald-500">
                                <div>
                                    <span class="block text-sm font-bold text-slate-900 dark:text-white">Cash on Delivery</span>
                                    <span class="text-xs text-slate-500">Pay when delivered</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <button
                    type="submit"
                    class="mt-8 w-full rounded-xl bg-emerald-500 py-4 font-bold text-white shadow-lg shadow-emerald-500/25 transition hover:bg-emerald-600"
                >
                    Confirm & Place Order →
                </button>
            </form>
        </div>

        <!-- Summary Column -->
        <div class="lg:col-span-5">
            <div class="rounded-3xl bg-slate-950 p-7 text-white shadow-xl dark:border dark:border-slate-800">
                <h2 class="text-xl font-black">Order Summary</h2>

                <div class="mt-6 divide-y divide-slate-800 space-y-3">
                    @foreach($cart as $item)
                        <div class="flex items-center justify-between pt-3 first:pt-0">
                            <div class="pr-4">
                                <p class="text-sm font-semibold text-slate-200">{{ $item['name'] }}</p>
                                <p class="text-xs text-slate-400">Qty: {{ $item['quantity'] }} × ${{ number_format($item['price'], 2) }}</p>
                            </div>
                            <span class="font-bold text-sm text-white">
                                ${{ number_format($item['price'] * $item['quantity'], 2) }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 border-t border-slate-800 pt-6">
                    <div class="flex justify-between text-slate-400 text-sm mb-2">
                        <span>Shipping</span>
                        <span class="text-emerald-400 font-semibold">Free</span>
                    </div>
                    <div class="flex justify-between text-xl font-black">
                        <span>Total Due</span>
                        <span class="text-emerald-400">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                <div class="mt-6 rounded-2xl bg-slate-900 p-4 text-xs text-slate-400">
                    🔒 All transactions are protected with SSL encryption. Free returns within 30 days.
                </div>
            </div>
        </div>

    </div>

</div>

@endsection
