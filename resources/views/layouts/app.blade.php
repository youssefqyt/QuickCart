<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'QuickCart - Modern E-Commerce')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }

        // Apply dark mode immediately to avoid flash
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</head>

<body class="min-h-screen flex flex-col bg-slate-50 text-slate-900 transition-colors duration-200 dark:bg-slate-950 dark:text-slate-100">

    @include('components.navbar')

    @if(session('success'))
        <div id="toast-success" class="fixed right-6 top-20 z-50 transition-all duration-300">
            <div class="flex items-center gap-3 rounded-2xl bg-emerald-600 px-5 py-3 text-white shadow-2xl">
                <span>✓</span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
                <button onclick="document.getElementById('toast-success').remove()" class="ml-2 text-emerald-200 hover:text-white">✕</button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div id="toast-error" class="fixed right-6 top-20 z-50 transition-all duration-300">
            <div class="flex items-center gap-3 rounded-2xl bg-red-600 px-5 py-3 text-white shadow-2xl">
                <span>⚠</span>
                <span class="font-medium text-sm">{{ session('error') }}</span>
                <button onclick="document.getElementById('toast-error').remove()" class="ml-2 text-red-200 hover:text-white">✕</button>
            </div>
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="mt-20 border-t border-slate-200 bg-white/50 backdrop-blur-sm dark:border-slate-800 dark:bg-slate-950/50">
        <div class="mx-auto flex max-w-7xl flex-col items-center justify-between gap-4 px-6 py-8 md:flex-row text-sm text-slate-500 dark:text-slate-400">
            <div>
                © {{ date('Y') }} <span class="font-bold text-slate-800 dark:text-white"><span class="text-emerald-500">Quick</span>Cart</span>. Modern e-commerce shopping experience.
            </div>
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="hover:text-emerald-500">Home</a>
                <a href="{{ route('products.index') }}" class="hover:text-emerald-500">Products</a>
                <a href="{{ route('orders.track') }}" class="hover:text-emerald-500">Track Order</a>
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-500">Admin Portal</a>
            </div>
        </div>
    </footer>

</body>
</html>
