<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="{{ asset('style.css') }}">
        <script src="{{ asset('script.js') }}"></script>
    </head>
    <body>
        <div style="min-height: 100vh; background-color: var(--light-gray);">
            @include('layouts.navigation')

            @isset($header)
                <header style="background-color: var(--white); box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 1.5rem 0;">
                    <div style="max-width: 1200px; margin: 0 auto; padding: 0 1rem;">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
