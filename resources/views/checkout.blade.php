@extends('layouts.app')

@section('title', 'Checkout')

@section('content')

<div class="mx-auto max-w-5xl px-6 py-16">

    <h1 class="text-4xl font-black">
        Checkout
    </h1>

    <div class="mt-10 grid gap-10 md:grid-cols-2">

        <form
            method="POST"
            action="{{ route('checkout.store') }}"
            class="rounded-2xl border border-slate-200 bg-white p-7 dark:border-slate-800 dark:bg-slate-900"
        >

            @csrf

            <h2 class="text-2xl font-black">
                Customer Information
            </h2>

            <div class="mt-6 space-y-5">

                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Full Name
                    </label>

                    <input
                        type="text"
                        name="customer_name"
                        value="{{ old('customer_name') }}"
                        class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
                        required
                    >

                    @error('customer_name')
                        <p class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Email
                    </label>

                    <input
                        type="email"
                        name="customer_email"
                        value="{{ old('customer_email') }}"
                        class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
                        required
                    >

                </div>


                <div>

                    <label class="mb-2 block text-sm font-bold">
                        Address
                    </label>

                    <textarea
                        name="address"
                        rows="4"
                        class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
                        required
                    >{{ old('address') }}</textarea>

                </div>

            </div>

            <button
        type="submit"
        class="w-full rounded-xl bg-emerald-600 px-6 py-3
               font-semibold text-white transition
               hover:bg-emerald-700">

        Pay with Stripe

    </button>

        </form>


        <div class="h-fit rounded-2xl bg-slate-950 p-7 text-white">

            <h2 class="text-2xl font-black">
                Order Summary
            </h2>

            <div class="mt-6 space-y-4">

                @foreach($cart as $item)

                    <div class="flex justify-between">

                        <span class="text-slate-400">
                            {{ $item['name'] }} × {{ $item['quantity'] }}
                        </span>

                        <span>
                            ${{ number_format($item['price'] * $item['quantity'], 2) }}
                        </span>

                    </div>

                @endforeach

            </div>

            <div class="mt-8 border-t border-slate-700 pt-6">

                <div class="flex justify-between text-xl font-black">

                    <span>Total</span>

                    <span>
                        ${{ number_format($total, 2) }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection