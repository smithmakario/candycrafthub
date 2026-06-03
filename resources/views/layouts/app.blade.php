<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Candy Craft Hub - Admin Portal')</title>
    <link rel="icon" type="image/png" href="{{ asset('asset/logo.png') }}">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    @include('layouts.partials.tailwind-config')
    @include('layouts.partials.theme-styles')
</head>
<body class="bg-background text-on-background font-body-md antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <div class="min-h-screen pt-14 md:pt-0 pl-0 md:pl-64 flex flex-col">
            @isset($header)
                <header class="border-b border-outline-variant/20 bg-surface-container-lowest shrink-0">
                    <div class="px-margin-mobile md:px-margin-desktop py-md max-w-[1600px] mx-auto w-full">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main class="flex-1 w-full max-w-[1600px] mx-auto px-margin-mobile md:px-margin-desktop py-xl">
                {{ $slot }}
            </main>
        </div>

        <div class="fixed inset-0 pointer-events-none z-[-1] overflow-hidden opacity-10">
            <div class="absolute top-20 left-10 transition-transform duration-1000 ease-in-out" id="float-1">
                <span class="material-symbols-outlined text-[80px] text-primary">cake</span>
            </div>
            <div class="absolute bottom-40 right-20 transition-transform duration-1000 ease-in-out" id="float-2">
                <span class="material-symbols-outlined text-[100px] text-secondary">icecream</span>
            </div>
            <div class="absolute top-1/2 left-1/2 transition-transform duration-1000 ease-in-out" id="float-3">
                <span class="material-symbols-outlined text-[60px] text-tertiary">cookie</span>
            </div>
        </div>
    </div>

    @include('layouts.scripts')
</body>
</html>
