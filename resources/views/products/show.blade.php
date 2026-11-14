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

            @if($product->stock <= 0)
                <div class="mt-4">
                    <span class="rounded-full bg-red-100 px-3.5 py-1 text-xs font-bold text-red-700 dark:bg-red-950/80 dark:text-red-300">
                        Out of Stock
                    </span>
                </div>

                <div class="mt-8">
                    <button disabled class="w-full cursor-not-allowed rounded-xl bg-slate-200 py-3.5 font-bold text-slate-400 dark:bg-slate-800 dark:text-slate-600">
                        Currently Unavailable
                    </button>
                </div>
            @else
                <p class="mt-3 text-sm {{ $product->stock < 5 ? 'text-amber-500 font-bold' : 'text-slate-500' }}">
                    @if($product->stock < 5)
                        ⚠️ Only {{ $product->stock }} left in stock - order soon!
                    @else
                        ✓ {{ $product->stock }} items available in stock
                    @endif
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
                        class="w-24 rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-900 font-bold text-center"
                    >

                    <button
                        class="flex-1 rounded-xl bg-emerald-500 px-6 py-3 font-bold text-white shadow-lg shadow-emerald-500/25 transition hover:bg-emerald-600"
                    >
                        🛒 Add to Cart
                    </button>
                </form>
            @endif

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