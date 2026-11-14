@extends('layouts.app')

@section('title', 'Add Product')

@section('content')

<div class="mx-auto max-w-3xl px-6 py-12">

    <h1 class="text-4xl font-black">
        Add Product
    </h1>

  <form
    method="POST"
    action="{{ route('admin.products.store') }}"
    enctype="multipart/form-data"
    class="mt-10 space-y-6 rounded-2xl border border-slate-200 bg-white p-8 dark:border-slate-800 dark:bg-slate-900"
>

        @csrf

        <div>

            <label class="mb-2 block font-bold">
                Name
            </label>

            <input
                name="name"
                value="{{ old('name') }}"
                required
                class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
            >

            @error('name')
                <p class="text-sm text-red-500">{{ $message }}</p>
            @enderror

        </div>


        <div>

            <label class="mb-2 block font-bold">
                Category
            </label>

            <select
                name="category_id"
                required
                class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
            >

                @foreach($categories as $category)

                    <option value="{{ $category->id }}">
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
            >{{ old('description') }}</textarea>

        </div>


        <div class="grid gap-5 md:grid-cols-2">

            <div>

                <label class="mb-2 block font-bold">
                    Price
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="price"
                    required
                    class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
                >

            </div>


            <div>

                <label class="mb-2 block font-bold">
                    Stock
                </label>

                <input
                    type="number"
                    name="stock"
                    required
                    class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
                >

            </div>

        </div>


        <div>

            <label class="mb-2 block font-bold">
                Rating
            </label>

            <input
                type="number"
                step="0.1"
                min="0"
                max="5"
                name="rating"
                value="0"
                class="w-full rounded-xl border px-4 py-3 dark:border-slate-700 dark:bg-slate-950"
            >

        </div>


        <label class="flex items-center gap-3">

            <input
                type="checkbox"
                name="featured"
                value="1"
            >

            <span class="font-bold">
                Featured Product
            </span>

        </label>
<div>
    <label class="mb-2 block font-bold">
        Product Image
    </label>

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

    <p class="mt-2 text-xs text-slate-500">
        JPG, PNG or WEBP. Maximum 2MB.
    </p>
</div>

        <button
            class="w-full rounded-xl bg-emerald-500 py-4 font-bold text-white"
        >
            Create Product
        </button>

    </form>

</div>

@endsection