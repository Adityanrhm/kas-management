<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/mcr-logoo.png') }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
   <div
    class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-black"
    data-aos="fade-up"             
    data-aos-duration="800"          
    data-aos-once="false">       

    @include('partials.preloader')

    <div data-aos="zoom-in" data-aos-delay="200" data-aos-duration="900">
        <a href="/">
            <x-application-logo class="w-24 h-24 fill-current text-gray-500 wds" />
        </a>
    </div>

    <div
        class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg"
        data-aos="fade-up" data-aos-delay="400" data-aos-duration="900">
        {{ $slot }}
    </div>
</div>

</body>

</html>
