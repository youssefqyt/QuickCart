<div class="group flex flex-col justify-between overflow-hidden rounded-2xl border border-slate-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-xl dark:border-slate-800 dark:bg-slate-900">

    <div>
        <a href="{{ route('products.show', $product) }}">
            <div class="relative flex h-52 items-center justify-center bg-slate-100 overflow-hidden text-7xl dark:bg-slate-800">
                @if($product->image)
                    <img
                        src="{{ asset('storage/' . $product->image) }}"
                        alt="{{ $product->name }}"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    >
                @else
                    <div class="text-6xl transition duration-300 group-hover:scale-110">
                        🛍️
                    </div>
                @endif

                <div class="absolute left-3 top-3 flex flex-col gap-1.5">
                    @if($product->featured)
                        <span class="rounded-full bg-emerald-500 px-3 py-0.5 text-[11px] font-bold text-white shadow">
                            TRENDING
                        </span>
                    @endif

                    @if($product->stock <= 0)
                        <span class="rounded-full bg-red-600 px-3 py-0.5 text-[11px] font-bold text-white shadow">
                            OUT OF STOCK
                        </span>
                    @elseif($product->stock < 5)
                        <span class="rounded-full bg-amber-500 px-3 py-0.5 text-[11px] font-bold text-white shadow">
                            Only {{ $product->stock }} left
                        </span>
                    @endif
                </div>
            </div>
        </a>

        <div class="p-5">
            <p class="text-xs font-bold uppercase tracking-wider text-emerald-500">
                {{ $product->category->name ?? 'Uncategorized' }}
            </p>

            <a href="{{ route('products.show', $product) }}">
                <h3 class="mt-1 text-base font-bold text-slate-900 line-clamp-1 transition group-hover:text-emerald-500 dark:text-white">
                    {{ $product->name }}
                </h3>
            </a>

            <div class="mt-2 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
                <span class="text-amber-400 font-bold">★ {{ number_format($product->rating, 1) }}</span>
                <span>•</span>
                <span>{{ $product->stock > 0 ? $product->stock . ' in stock' : 'Unavailable' }}</span>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between border-t border-slate-100 p-5 dark:border-slate-800/80">
        <span class="text-xl font-black text-slate-900 dark:text-white">
            ${{ number_format($product->price, 2) }}
        </span>

        @if($product->stock > 0)
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-xs font-bold text-white transition hover:bg-emerald-500 dark:bg-white dark:text-slate-900 dark:hover:bg-emerald-500 dark:hover:text-white">
                    + Add to Cart
                </button>
            </form>
        @else
            <button disabled class="cursor-not-allowed rounded-xl bg-slate-200 px-4 py-2 text-xs font-bold text-slate-400 dark:bg-slate-800 dark:text-slate-600">
                Sold Out
            </button>
        @endif
    </div>

</div>
