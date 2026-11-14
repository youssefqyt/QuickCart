@extends('layouts.app')

@section('title', 'Manage Products - QuickCart Admin')

@section('content')

<div class="mx-auto max-w-7xl px-6 py-10">

    @include('components.admin-nav', [
        'title' => 'Products Management',
        'actionButton' => '<a href="' . route('admin.products.create') . '" class="rounded-xl bg-emerald-500 px-4 py-2 text-xs font-bold text-white shadow-md shadow-emerald-500/20 hover:bg-emerald-600 transition">+ Add Product</a>'
    ])

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50 text-xs font-bold uppercase tracking-wider text-slate-400 dark:border-slate-800 dark:bg-slate-950">
                        <th class="px-6 py-4">Product</th>
                        <th class="px-6 py-4">Category</th>
                        <th class="px-6 py-4">Price</th>
                        <th class="px-6 py-4">Stock</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">Featured</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 items-center justify-center overflow-hidden rounded-xl bg-slate-100 text-lg dark:bg-slate-800">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                        @else
                                            🛍️
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('products.show', $product) }}" class="font-bold text-slate-900 hover:text-emerald-500 dark:text-white">
                                            {{ $product->name }}
                                        </a>
                                        <div class="text-xs text-slate-400 font-mono">{{ $product->slug }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-xs font-semibold text-slate-600 dark:text-slate-300">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </td>

                            <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                                ${{ number_format($product->price, 2) }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-black {{ $product->stock <= 0 ? 'bg-red-100 text-red-700 dark:bg-red-950/80 dark:text-red-300' : ($product->stock < 5 ? 'bg-amber-100 text-amber-700 dark:bg-amber-950/80 dark:text-amber-300' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300') }}">
                                    {{ $product->stock }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-xs font-bold text-amber-500">
                                ★ {{ number_format($product->rating, 1) }}
                            </td>

                            <td class="px-6 py-4">
                                @if($product->featured)
                                    <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-bold text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-300">
                                        Trending
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">Standard</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="font-bold text-xs text-emerald-500 hover:text-emerald-600">
                                        Edit
                                    </a>

                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete product {{ $product->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-bold text-xs text-red-500 hover:text-red-600">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                No products found. Click "+ Add Product" to add your first product.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>

</div>

@endsection
