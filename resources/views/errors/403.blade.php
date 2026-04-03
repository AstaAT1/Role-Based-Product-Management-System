<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>403 | Access Denied</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-100 font-sans antialiased">
        <div class="mx-auto flex min-h-screen max-w-3xl items-center px-6 py-12">
            <div class="w-full rounded-2xl border border-slate-200 bg-white p-8 shadow-sm">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-rose-600">403</p>
                <h1 class="mt-3 text-3xl font-semibold text-slate-900">You are not authorized to access this page.</h1>
                <p class="mt-4 text-sm leading-7 text-red-600">
                    Your account does not have the required role or permission for this action. Sign in with one of the seeded demo accounts or ask an admin to update your access.
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
                            Back to Dashboard
                        </a>

                        @can('view products')
                            <a href="{{ route('products.index') }}" class="inline-flex items-center rounded-md border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50">
                                Go to Products
                            </a>
                        @endcan
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white transition hover:bg-slate-800">
                            Go to Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </body>
</html>
