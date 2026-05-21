<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#F5F0E8">

    <title>{{ $title ?? 'Trivy' }}</title>

    {{-- Livewire styles (doit être dans le <head>) --}}
    @livewireStyles

    {{-- Vite compile notre CSS + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

{{--
    body : fond crème, centré horizontalement sur desktop.
    Sur mobile, plein écran. Sur desktop, simulé comme un téléphone.
--}}
<body class="bg-[#1a1a1a] antialiased">

    {{--
        .mobile-shell = max-width 390px, centré.
        C'est notre "téléphone" sur desktop.
        bg-cream = le fond de l'app.
    --}}
    <div class="mobile-shell bg-cream">
        {{ $slot }}
    </div>

    {{-- Livewire scripts (doit être avant </body>) --}}
    @livewireScripts
</body>
</html>
