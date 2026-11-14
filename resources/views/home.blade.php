@extends('layouts.app')

@section('title', 'QuickCart - Modern Shopping')

@section('content')

<section class="relative overflow-hidden">

    <div class="absolute -left-40 -top-40 h-96 w-96 rounded-full bg-emerald-400/20 blur-3xl"></div>

    <div class="mx-auto grid max-w-7xl gap-12 px-6 py-20 md:grid-cols-2 md:items-center">

        <div>

            <span class="rounded-full bg-emerald-100 px-4 py-2 text-sm font-bold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                ✨ Modern shopping experience
            </span>

            <h1 class="mt-6 text-5xl font-black leading-tight md:text-7xl">
                Shop
                <span class="text-emerald-500">smarter.</span>
                Live better.
            </h1>

            <p class="mt-6 max-w-xl text-lg text-slate-600 dark:text-slate-400">
                Discover premium products, trending gadgets and
                everyday essentials in one beautiful marketplace.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">

                <a
                    href="{{ route('products.index') }}"
                    class="rounded-xl bg-emerald-500 px-6 py-3 font-bold text-white shadow-lg shadow-emerald-500/20 transition hover:-translate-y-1 hover:bg-emerald-600"
                >
                    Explore Products →
                </a>

                <a
                    href="{{ route('orders.track') }}"
                    class="rounded-xl border border-slate-200 px-6 py-3 font-bold text-slate-700 hover:bg-slate-100 dark:border-slate-800 dark:text-slate-300 dark:hover:bg-slate-900 transition"
                >
                    Track Order 🔍
                </a>

            </div>

        </div>

        <div class="rounded-3xl bg-gradient-to-br from-emerald-400 to-teal-600 p-1 shadow-2xl">

            <div class="flex min-h-[400px] items-center justify-center rounded-[22px] bg-slate-950 p-10 text-center text-white">

                <div>
                    <div class="text-8xl">🛍️</div>

                    <h2 class="mt-6 text-3xl font-black">
                        Everything you need.
                    </h2>

                    <p class="mt-3 text-slate-400">
                        One simple shopping experience.
                    </p>
                </div>

            </div>

        </div>

    </div>

</section>


<section class="mx-auto max-w-7xl px-6 py-12">

    <div class="mb-8 flex items-end justify-between">

        <div>
            <p class="font-bold text-emerald-500">
                EXPLORE
            </p>

            <h2 class="mt-2 text-3xl font-black">
                Categories
            </h2>
        </div>

    </div>

    <div class="grid gap-4 md:grid-cols-3">

        @foreach($categories as $category)

            <a
                href="{{ route('products.index', ['category' => $category->id]) }}"
                class="group rounded-2xl border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:border-emerald-400 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900"
            >

                <div class="text-4xl">
                    🛍️
                </div>

                <h3 class="mt-4 text-xl font-bold">
                    {{ $category->name }}
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $category->products_count }} products
                </p>

            </a>

        @endforeach

    </div>

</section>


<section class="mx-auto max-w-7xl px-6 py-12">

    <div class="mb-8 flex items-end justify-between">

        <div>
            <p class="font-bold text-emerald-500">
                TRENDING NOW
            </p>

            <h2 class="mt-2 text-3xl font-black">
                Featured Products
            </h2>
        </div>

        <a
            href="{{ route('products.index') }}"
            class="font-bold text-emerald-500"
        >
            View all →
        </a>

    </div>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

        @foreach($featuredProducts as $product)

            @include('components.product-card', [
                'product' => $product
            ])

        @endforeach

    </div>

</section>

@endsection