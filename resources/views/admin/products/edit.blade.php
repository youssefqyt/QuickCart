@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')

<div class="mx-auto max-w-3xl px-6 py-12">

    <h1 class="text-4xl font-black">
        Edit Product
    </h1>

    <form
    method="POST"
    action="{{ route('admin.products.update', $product) }}"
    enctype="multipart/form-data"
    class="mt-10 space-y-6 rounded-2xl border border-slate-200 bg-white p-8 dark:border-slate-800 dark:bg-slate-900"
>

        @csrf
        @method('PUT')

        <div>

            <label class="mb-2 block font-bold">
                Name
            </label>

            <input
                name="name"
                value="{{ old('name', $product->name) }}"
                required
                class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
            >

        </div>


        <div>

            <label class="mb-2 block font-bold">
                Category
            </label>

            <select
                name="category_id"
                class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
            >

                @foreach($categories as $category)

                    <option
                        value="{{ $category->id }}"
                        @selected($product->category_id == $category->id)
                    >
                        {{ $category->name }}
                    </option>

                @endforeach

            </select>

        </div>


        <div>

            <label class="mb-2 block font-bold">
                Description
            </label>

            <textarea
                name="description"
                rows="5"
                class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
            >{{ old('description', $product->description) }}</textarea>

        </div>


        <div class="grid gap-5 md:grid-cols-2">

            <input
                type="number"
                step="0.01"
                name="price"
                value="{{ $product->price }}"
                class="rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
            >

            <input
                type="number"
                name="stock"
                value="{{ $product->stock }}"
                class="rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
            >

        </div>


        <input
            type="number"
            step="0.1"
            min="0"
            max="5"
            name="rating"
            value="{{ $product->rating }}"
            class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
        >


        <label class="flex items-center gap-3">

            <input
                type="checkbox"
                name="featured"
                value="1"
                @checked($product->featured)
            >

            Featured

        </label>
<div>

    <label class="mb-2 block font-bold">
        Product Image
    </label>

    @if($product->image)
        <img
            src="{{ asset('storage/' . $product->image) }}"
            alt="{{ $product->name }}"
            class="mb-4 h-40 w-40 rounded-xl object-cover"
        >
    @endif

    <input
        type="file"
        name="image"
        accept="image/jpeg,image/png,image/webp"
        class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
    >

    @error('image')
        <p class="mt-2 text-sm text-red-500">
            {{ $message }}
        </p>
    @enderror

</div>

        <button
            class="w-full rounded-xl bg-emerald-500 py-4 font-bold text-white"
        >
            Update Product
        </button>

    </form>

</div>

@endsection