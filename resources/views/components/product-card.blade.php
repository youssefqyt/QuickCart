<div class="group overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-300 hover:-translate-y-2 hover:shadow-2xl dark:border-slate-800 dark:bg-slate-900">

    <a href="{{ route('products.show', $product) }}">

        <div class="relative flex h-56 items-center justify-center bg-slate-100 text-7xl dark:bg-slate-800">

          @if($product->image)

    <img
        src="{{ asset('storage/' . $product->image) }}"
        alt="{{ $product->name }}"
        class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
    >

@else

    <div class="text-7xl">
        🛍️
    </div>

@endif

            @if($product->featured)

                <span class="absolute left-3 top-3 rounded-full bg-emerald-500 px-3 py-1 text-xs font-bold text-white">
                    TRENDING
                </span>

            @endif

        </div>

    </a>

    <div class="p-5">

        <p class="text-xs font-bold uppercase tracking-wider text-emerald-500">
            {{ $product->category->name }}
        </p>

        <a href="{{ route('products.show', $product) }}">

            <h3 class="mt-2 text-lg font-bold group-hover:text-emerald-500">
                {{ $product->name }}
            </h3>

        </a>

        <div class="mt-2 text-sm">
            ⭐ {{ number_format($product->rating, 1) }}
        </div>

        <div class="mt-4 flex items-center justify-between">

            <span class="text-xl font-black">
                ${{ number_format($product->price, 2) }}
            </span>

            <form
                method="POST"
                action="{{ route('cart.add', $product) }}"
            >

                @csrf

                <button
                    class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-bold text-white transition hover:bg-emerald-500 dark:bg-white dark:text-slate-900"
                >
                    Add
                </button>

            </form>

        </div>

    </div>

</div>