@php
    $cart = session('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));
@endphp

<nav class="sticky top-0 z-40 border-b border-slate-200/70 bg-white/80 backdrop-blur-xl dark:border-slate-800 dark:bg-slate-950/80">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">

        <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-slate-900 dark:text-white">
            <span class="text-emerald-500">Quick</span>Cart
        </a>

        <!-- Desktop Navigation -->
        <div class="hidden items-center gap-7 md:flex">
            <a href="{{ route('home') }}" class="text-sm font-semibold transition hover:text-emerald-500 {{ request()->routeIs('home') ? 'text-emerald-500' : '' }}">
                Home
            </a>

            <a href="{{ route('products.index') }}" class="text-sm font-semibold transition hover:text-emerald-500 {{ request()->routeIs('products.*') ? 'text-emerald-500' : '' }}">
                Shop
            </a>

            <a href="{{ route('orders.track') }}" class="text-sm font-semibold transition hover:text-emerald-500 {{ request()->routeIs('orders.track') ? 'text-emerald-500' : '' }}">
                Track Order
            </a>

            <a href="{{ route('admin.dashboard') }}" class="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold uppercase tracking-wider text-slate-600 transition hover:border-emerald-500 hover:text-emerald-500 dark:border-slate-800 dark:text-slate-400">
                Admin
            </a>

            <a href="{{ route('cart.index') }}" class="relative flex items-center gap-2 rounded-full bg-slate-100 px-4 py-2 text-sm font-semibold transition hover:bg-emerald-500 hover:text-white dark:bg-slate-900">
                <span>🛒 Cart</span>
                @if($cartCount > 0)
                    <span class="flex h-5 min-w-[20px] items-center justify-center rounded-full bg-emerald-500 px-1 text-xs font-bold text-white group-hover:bg-white group-hover:text-emerald-500">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            <button onclick="toggleTheme()" type="button" aria-label="Toggle dark mode" class="rounded-full border border-slate-200 p-2 text-sm transition hover:bg-slate-100 dark:border-slate-800 dark:hover:bg-slate-900">
                <span class="dark:hidden">🌙</span>
                <span class="hidden dark:inline">☀️</span>
            </button>
        </div>

        <!-- Mobile Menu Toggle Button -->
        <div class="flex items-center gap-3 md:hidden">
            <a href="{{ route('cart.index') }}" class="relative rounded-full bg-slate-100 p-2 text-sm dark:bg-slate-900">
                <span>🛒</span>
                @if($cartCount > 0)
                    <span class="absolute -right-1 -top-1 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-emerald-500 px-1 text-[10px] font-bold text-white">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>

            <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" type="button" class="rounded-xl border border-slate-200 p-2 text-slate-700 dark:border-slate-800 dark:text-slate-200">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

    </div>

    <!-- Mobile Dropdown Menu -->
    <div id="mobile-menu" class="hidden border-t border-slate-200 px-6 py-4 md:hidden dark:border-slate-800">
        <div class="flex flex-col gap-4">
            <a href="{{ route('home') }}" class="text-sm font-semibold hover:text-emerald-500">Home</a>
            <a href="{{ route('products.index') }}" class="text-sm font-semibold hover:text-emerald-500">Shop Products</a>
            <a href="{{ route('orders.track') }}" class="text-sm font-semibold hover:text-emerald-500">Track My Order</a>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold hover:text-emerald-500">Admin Dashboard</a>
            <div class="flex items-center justify-between pt-2 border-t border-slate-200 dark:border-slate-800">
                <span class="text-xs text-slate-500">Theme</span>
                <button onclick="toggleTheme()" type="button" class="rounded-lg border border-slate-200 px-3 py-1 text-xs dark:border-slate-800">
                    Switch Mode
                </button>
            </div>
        </div>
    </div>
</nav>
