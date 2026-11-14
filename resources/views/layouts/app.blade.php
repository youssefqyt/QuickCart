<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'QuickCart')
    </title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-slate-50 text-slate-900 dark:bg-slate-950 dark:text-white">

    @include('components.navbar')

    @if(session('success'))
        <div class="fixed right-6 top-24 z-50">
            <div class="rounded-xl bg-emerald-500 px-5 py-3 text-white shadow-xl">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="fixed right-6 top-24 z-50">
            <div class="rounded-xl bg-red-500 px-5 py-3 text-white shadow-xl">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="mt-20 border-t border-slate-200 dark:border-slate-800">
        <div class="mx-auto max-w-7xl px-6 py-8 text-center text-sm text-slate-500">
            © {{ date('Y') }} QuickCart. All rights reserved.
        </div>
    </footer>

</body>
</html>