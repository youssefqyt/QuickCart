@extends('layouts.app')

@section('title', 'Products - QuickCart')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-12">

    <div class="mb-10">

        <p class="font-bold text-emerald-500">
            SHOP
        </p>

        <h1 class="mt-2 text-4xl font-black">
            Explore Products
        </h1>

    </div>


    <form
        method="GET"
        action="{{ route('products.index') }}"
        class="mb-10 grid gap-4 rounded-2xl border border-slate-200 bg-white p-5 md:grid-cols-3 dark:border-slate-800 dark:bg-slate-900"
    >

        <input
            type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Search products..."
            class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 outline-none focus:border-emerald-500 dark:border-slate-700 dark:bg-slate-950"
        >

        <select
            name="category"
            class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
        >

            <option value="">
                All Categories
            </option>

            @foreach($categories as $category)

                <option
                    value="{{ $category->id }}"
                    @selected(request('category') == $category->id)
                >
                    {{ $category->name }}
                </option>

            @endforeach

        </select>

        <select
            name="sort"
            class="rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
        >

            <option value="">
                Latest
            </option>

            <option
                value="price_low"
                @selected(request('sort') === 'price_low')
            >
                Price: Low to High
            </option>

            <option
                value="price_high"
                @selected(request('sort') === 'price_high')
            >
                Price: High to Low
            </option>

        </select>

        <button
            class="rounded-xl bg-emerald-500 px-5 py-3 font-bold text-white hover:bg-emerald-600 md:col-span-3"
        >
            Search Products
        </button>

    </form>


    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

        @forelse($products as $product)

            @include('components.product-card', [
                'product' => $product
            ])

        @empty

            <div class="col-span-full py-20 text-center">

                <div class="text-6xl">
                    🔍
                </div>

                <h2 class="mt-4 text-2xl font-black">
                    No products found
                </h2>

            </div>

        @endforelse

    </div>


    <div class="mt-10">
        {{ $products->links() }}
    </div>

</div>

@endsection