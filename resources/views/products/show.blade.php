@extends('layouts.app')

@section('title', $product->name . ' - QuickCart')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-16">

    <div class="grid gap-12 md:grid-cols-2">

       <div class="flex min-h-[500px] items-center justify-center overflow-hidden rounded-3xl bg-slate-100 dark:bg-slate-900">

    @if($product->image)

        <img
            src="{{ asset('storage/' . $product->image) }}"
            alt="{{ $product->name }}"
            class="h-full w-full object-cover"
        >

    @else

        <div class="text-9xl">
            🛍️
        </div>

    @endif

</div>


        <div class="flex flex-col justify-center">

            <p class="font-bold uppercase tracking-wider text-emerald-500">
                {{ $product->category->name }}
            </p>

            <h1 class="mt-3 text-5xl font-black">
                {{ $product->name }}
            </h1>

            <div class="mt-5 text-lg">
                ⭐ {{ number_format($product->rating, 1) }}
            </div>

            <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-400">
                {{ $product->description }}
            </p>

            <div class="mt-8 text-4xl font-black">
                ${{ number_format($product->price, 2) }}
            </div>

            <p class="mt-3 text-sm text-slate-500">
                {{ $product->stock }} items available
            </p>


            <form
                method="POST"
                action="{{ route('cart.add', $product) }}"
                class="mt-8 flex gap-3"
            >

                @csrf

                <input
                    type="number"
                    name="quantity"
                    value="1"
                    min="1"
                    max="{{ $product->stock }}"
                    class="w-24 rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-900"
                >

                <button
                    class="flex-1 rounded-xl bg-emerald-500 px-6 py-3 font-bold text-white hover:bg-emerald-600"
                >
                    🛒 Add to Cart
                </button>

            </form>

        </div>

    </div>


    <section class="mt-24">

        <h2 class="mb-8 text-3xl font-black">
            You may also like
        </h2>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

            @foreach($relatedProducts as $product)

                @include('components.product-card', [
                    'product' => $product
                ])

            @endforeach

        </div>

    </section>

</div>

@endsection