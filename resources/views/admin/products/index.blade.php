@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-12">

    <div class="mb-8 flex items-center justify-between">

        <div>

            <p class="font-bold text-emerald-500">
                ADMIN
            </p>

            <h1 class="mt-2 text-4xl font-black">
                Products
            </h1>

        </div>

        <a
            href="{{ route('admin.products.create') }}"
            class="rounded-xl bg-emerald-500 px-5 py-3 font-bold text-white"
        >
            + Add Product
        </a>

    </div>


    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">

        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="border-b border-slate-200 dark:border-slate-800">

                    <tr>

                        <th class="px-6 py-4">
                            Product
                        </th>

                        <th class="px-6 py-4">
                            Category
                        </th>

                        <th class="px-6 py-4">
                            Price
                        </th>

                        <th class="px-6 py-4">
                            Stock
                        </th>

                        <th class="px-6 py-4">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($products as $product)

                        <tr class="border-b border-slate-100 dark:border-slate-800">

                            <td class="px-6 py-4 font-bold">
                                {{ $product->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $product->category->name }}
                            </td>

                            <td class="px-6 py-4">
                                ${{ number_format($product->price, 2) }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $product->stock }}
                            </td>

                            <td class="flex gap-3 px-6 py-4">

                                <a
                                    href="{{ route('admin.products.edit', $product) }}"
                                    class="font-bold text-emerald-500"
                                >
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.products.destroy', $product) }}"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button class="font-bold text-red-500">
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-8">
        {{ $products->links() }}
    </div>

</div>

@endsection