<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title.' - Trotzdem ’13' : 'Trotzdem ’13' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('styles')

    <!-- ****** faviconit.com favicons ****** -->
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="/favicon/favicon.ico">
    <link rel="icon" type="image/png" sizes="196x196" href="/favicon/favicon-192.png">
    <link rel="icon" type="image/png" sizes="160x160" href="/favicon/favicon-160.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96.png">
    <link rel="icon" type="image/png" sizes="64x64" href="/favicon/favicon-64.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16.png">
    <link rel="apple-touch-icon" href="/favicon/favicon-57.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/favicon-114.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/favicon-72.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/favicon-144.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/favicon-60.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/favicon-120.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/favicon-76.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/favicon-152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/favicon-180.png">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="/favicon/favicon-144.png">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <!-- ****** faviconit.com favicons ****** -->
</head>

<body class="font-sans antialiased bg-teal-500 flex flex-col min-h-screen">
    <header class="flex justify-between items-center bg-teal-500 px-2 shadow-xl">
        <a href="/" class="flex-1">LOGO</a>
        <a href="/"
            class="text-center sm:text-5xl text-xl px-3 py-2 my-3 sm:mb-5 text-mango-700 bg-white rounded-xl shadow-lg font-black">
            Trotzdem ’13
        </a>
        <div class="flex-1 text-right">
            <a href="/dashboard"
                class="text-white border-white rounded-full text-center group px-2 border text-sm sm:text-base">
                Anmelden
            </a>
        </div>
    </header>

    <nav class="bg-teal-600 text-white shadow-xl flex flex-wrap items-center justify-center text-sm sm:text-base">
        <a class="block px-3 py-2 mx-2 hover:bg-teal-500 {{$navMain =='/'?'bg-teal-500':''}}" href="/">
            Projekt
        </a>
        <a class="block px-3 py-2 mx-2 hover:bg-teal-500 {{$navMain =='/karte'?'bg-teal-500':''}}" href="/karte">
            Karte
        </a>
        <a class="block px-3 py-2 mx-2 hover:bg-teal-500 {{$navMain =='/teilnehmer'?'bg-teal-500':''}}"
            href="/teilnehmer">
            Teilnehmer
        </a>
        <a class="block px-3 py-2 mx-2 hover:bg-teal-500 {{$navMain =='/challenges'?'bg-teal-500':''}}"
            href="/challenges">
            Challenges
        </a>
    </nav>
    <main class="flex-auto bg-sepiaGray-200" id="main">
        {{ $slot }}
    </main>
    <nav class="bg-teal-500 text-white shadow-xl flex flex-wrap items-center justify-center text-sm sm:text-base">
        <a class="p-2 hover:underline {{$navMain =='/impressum'?'underline':''}}" href="/impressum">Impressum</a>
        <a class="p-2 hover:underline {{$navMain =='/datenschutz'?'underline':''}}" href="/datenschutz">Datenschutz</a>
        <a class="p-2 hover:underline" href="#">Facebook</a>
        <a class="p-2 hover:underline" href="#">Youtube</a>
        <a class="p-2 hover:underline" href="#">Instragram</a>
    </nav>

    @stack('scripts')
</body>

</html>
