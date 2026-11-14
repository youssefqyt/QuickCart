<div class="mb-8 border-b border-slate-200 pb-5 dark:border-slate-800">
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <span class="rounded-md bg-emerald-500/10 px-2.5 py-1 text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">
                QuickCart Management
            </span>
            <h1 class="mt-2 text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">
                {{ $title ?? 'Admin Console' }}
            </h1>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 dark:border-slate-800 dark:text-slate-300 dark:hover:bg-slate-800 transition">
                ← View Store
            </a>
            @if(isset($actionButton))
                {!! $actionButton !!}
            @endif
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="mt-6 flex flex-wrap gap-2">
        <a
            href="{{ route('admin.dashboard') }}"
            class="rounded-xl px-4 py-2 text-xs font-bold transition {{ request()->routeIs('admin.dashboard') ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-950' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-900 dark:text-slate-400 dark:hover:bg-slate-800' }}"
        >
            📊 Dashboard
        </a>

        <a
            href="{{ route('admin.products.index') }}"
            class="rounded-xl px-4 py-2 text-xs font-bold transition {{ request()->routeIs('admin.products.*') ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-950' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-900 dark:text-slate-400 dark:hover:bg-slate-800' }}"
        >
            📦 Products
        </a>

        <a
            href="{{ route('admin.categories.index') }}"
            class="rounded-xl px-4 py-2 text-xs font-bold transition {{ request()->routeIs('admin.categories.*') ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-950' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-900 dark:text-slate-400 dark:hover:bg-slate-800' }}"
        >
            🏷️ Categories
        </a>

        <a
            href="{{ route('admin.orders.index') }}"
            class="rounded-xl px-4 py-2 text-xs font-bold transition {{ request()->routeIs('admin.orders.*') ? 'bg-slate-900 text-white dark:bg-white dark:text-slate-950' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 dark:bg-slate-900 dark:text-slate-400 dark:hover:bg-slate-800' }}"
        >
            📑 Orders
        </a>
    </div>
</div>
