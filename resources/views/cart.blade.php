@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')

<div class="mx-auto max-w-5xl px-6 py-16">

    <h1 class="text-4xl font-black">
        Shopping Cart
    </h1>

    <div class="mt-10 space-y-4">

        @forelse($cart as $item)

            <div class="flex flex-col gap-5 rounded-2xl border border-slate-200 bg-white p-5 md:flex-row md:items-center dark:border-slate-800 dark:bg-slate-900">

                <div class="flex h-24 w-24 items-center justify-center rounded-xl bg-slate-100 text-4xl dark:bg-slate-800">
                    🛍️
                </div>

                <div class="flex-1">

                    <h2 class="font-bold">
                        {{ $item['name'] }}
                    </h2>

                    <p class="mt-1 text-emerald-500">
                        ${{ number_format($item['price'], 2) }}
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('cart.update', $item['id']) }}"
                    class="flex gap-2"
                >

                    @csrf

                    <input
                        type="number"
                        name="quantity"
                        min="1"
                        value="{{ $item['quantity'] }}"
                        class="w-20 rounded-lg border px-3 py-2 dark:bg-slate-950"
                    >

                    <button class="rounded-lg bg-slate-900 px-3 py-2 text-white dark:bg-white dark:text-black">
                        Update
                    </button>

                </form>


                <form
                    method="POST"
                    action="{{ route('cart.remove', $item['id']) }}"
                >

                    @csrf
                    @method('DELETE')

                    <button class="text-red-500 hover:text-red-600">
                        Remove
                    </button>

                </form>

            </div>

        @empty

            <div class="py-20 text-center">

                <div class="text-7xl">
                    🛒
                </div>

                <h2 class="mt-5 text-2xl font-black">
                    Your cart is empty
                </h2>

                <a
                    href="{{ route('products.index') }}"
                    class="mt-6 inline-block rounded-xl bg-emerald-500 px-6 py-3 font-bold text-white"
                >
                    Start Shopping
                </a>

            </div>

        @endforelse

    </div>


    @if(count($cart))

        <div class="mt-10 rounded-2xl border border-slate-200 bg-white p-8 dark:border-slate-800 dark:bg-slate-900">

            <div class="flex items-center justify-between">

                <span class="text-lg text-slate-500">
                    Total
                </span>

                <span class="text-3xl font-black">
                    ${{ number_format($total, 2) }}
                </span>

            </div>

            <a
                href="{{ route('checkout.index') }}"
                class="mt-6 block rounded-xl bg-emerald-500 py-4 text-center font-bold text-white hover:bg-emerald-600"
            >
                Proceed to Checkout →
            </a>

        </div>

    @endif

</div>

@endsection