<!DOCTYPE html>
<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Candy Craft Hub') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('asset/logo.png') }}">
        <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        @include('layouts.partials.tailwind-config')
        @include('layouts.partials.theme-styles')
    </head>
    <body class="bg-background text-on-background font-body-md antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 px-margin-mobile">
            <div>
                <a href="{{ route('home') }}">
                    <x-application-logo class="w-40 h-40 object-contain" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-surface-container-lowest border border-outline-variant shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>

            <p class="mt-md text-label-sm text-on-surface-variant">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">← Back to Candy Craft Hub</a>
            </p>
        </div>
    </body>
</html>
