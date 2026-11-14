@extends('layouts.app')

@section('content')

<div class="min-h-[70vh] flex items-center justify-center px-4">

    <div class="max-w-lg w-full text-center">

        <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center
                    rounded-full bg-emerald-100 dark:bg-emerald-900/30">

            <svg class="h-10 w-10 text-emerald-600"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M5 13l4 4L19 7"/>

            </svg>

        </div>

        <h1 class="text-3xl font-bold text-slate-900 dark:text-white">
            Payment Successful!
        </h1>

        <p class="mt-4 text-slate-600 dark:text-slate-300">
            Thank you for your order.
            Your payment has been received.
        </p>

        @if($sessionId)

            <p class="mt-4 text-sm text-slate-500">
                Payment session:
                <span class="font-mono">
                    {{ $sessionId }}
                </span>
            </p>

        @endif

        <a href="{{ route('products.index') }}"
           class="mt-8 inline-flex rounded-xl bg-emerald-600
                  px-6 py-3 font-semibold text-white
                  transition hover:bg-emerald-700">

            Continue Shopping

        </a>

    </div>

</div>

@endsection