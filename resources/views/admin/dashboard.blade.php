@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-12">

    <div class="mb-10">

        <p class="font-bold text-emerald-500">
            ADMIN
        </p>

        <h1 class="mt-2 text-4xl font-black">
            Dashboard
        </h1>

    </div>


    <div class="grid gap-6 md:grid-cols-3">

        <div class="rounded-2xl bg-slate-950 p-6 text-white">

            <p class="text-slate-400">
                Products
            </p>

            <p class="mt-3 text-4xl font-black">
                {{ \App\Models\Product::count() }}
            </p>

        </div>


        <div class="rounded-2xl bg-emerald-500 p-6 text-white">

            <p class="text-emerald-100">
                Categories
            </p>

            <p class="mt-3 text-4xl font-black">
                {{ \App\Models\Category::count() }}
            </p>

        </div>


        <div class="rounded-2xl bg-indigo-600 p-6 text-white">

            <p class="text-indigo-100">
                Orders
            </p>

            <p class="mt-3 text-4xl font-black">
                {{ \App\Models\Order::count() }}
            </p>

        </div>

    </div>


    <div class="mt-10">

        <a
            href="{{ route('admin.products.index') }}"
            class="inline-block rounded-xl bg-slate-900 px-6 py-3 font-bold text-white dark:bg-white dark:text-slate-900"
        >
            Manage Products →
        </a>

    </div>

</div>

@endsection