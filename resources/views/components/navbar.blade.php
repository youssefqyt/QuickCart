<nav class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/80 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/80">

    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

        <a
            href="{{ route('home') }}"
            class="text-2xl font-black tracking-tight"
        >
            <span class="text-emerald-500">Quick</span>Cart
        </a>

        <div class="hidden items-center gap-8 md:flex">

            <a
                href="{{ route('home') }}"
                class="text-sm font-medium hover:text-emerald-500"
            >
                Home
            </a>

            <a
                href="{{ route('products.index') }}"
                class="text-sm font-medium hover:text-emerald-500"
            >
                Products
            </a>

            <a
                href="{{ route('cart.index') }}"
                class="rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold hover:bg-emerald-500 hover:text-white dark:bg-slate-900"
            >
                🛒 Cart
            </a>

            <button
                onclick="document.documentElement.classList.toggle('dark')"
                class="rounded-full border border-slate-200 px-3 py-2 dark:border-slate-700"
            >
                ☀️
            </button>

        </div>

    </div>

</nav>