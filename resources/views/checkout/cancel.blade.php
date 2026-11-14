@extends('layouts.app')

@section('content')

<div class="min-h-[70vh] flex items-center justify-center px-4">

    <div class="max-w-lg w-full text-center">

        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center
                    rounded-full bg-red-100 dark:bg-red-900/30">

            <span class="text-4xl">
                ✕
            </span>

        </div>

        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
            Payment Cancelled
        </h1>

        <p class="mt-4 text-slate-600 dark:text-slate-300">
            Your payment was cancelled.
            Your order has not been marked as paid.
        </p>

        @if($orderId)

            <p class="mt-4 text-sm text-slate-500">
                Order #{{ $orderId }}
            </p>

        @endif

        <div class="mt-8 flex justify-center gap-3">

            <a href="{{ route('checkout.index') }}"
               class="rounded-xl bg-emerald-600
                      px-6 py-3 font-semibold text-white
                      hover:bg-emerald-700">

                Back to Checkout

            </a>

            <a href="{{ route('products.index') }}"
               class="rounded-xl border border-slate-300
                      px-6 py-3 font-semibold
                      text-slate-700
                      hover:bg-slate-100
                      dark:border-slate-700
                      dark:text-slate-200
                      dark:hover:bg-slate-800">

                Shop

            </a>

        </div>

    </div>

</div>

@endsection