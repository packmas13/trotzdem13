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
</head>

<body class="font-sans antialiased text-xl bg-sepiaGray-200 flex flex-col min-h-screen">
    <header class="flex justify-between items-center bg-teal-500 px-2 shadow-xl">
        <a href="/" class="w-48">LOGO</a>
        <a href="/"
            class="text-center text-5xl px-3 py-2 mt-3 mb-5 text-mango-700 bg-white rounded-xl shadow-lg font-black">
            Trotzdem ’13
        </a>
        <a href="/dashboard"
            class="text-white border-white border-2 block px-4 p-2 rounded-full w-48 text-center">Anmelden</a>
    </header>
    <nav class="bg-teal-600 text-white shadow-xl flex items-center justify-center">
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
    <div class="flex-auto">
        {{ $slot }}
    </div>
    <nav class="bg-teal-500 text-white shadow-xl flex items-center justify-center">
        <a class="p-2 hover:underline {{$navMain =='/impressum'?'underline':''}}" href="/impressum">Impressum</a>
        <a class="p-2 hover:underline {{$navMain =='/datenschutz'?'underline':''}}" href="/datenschutz">Datenschutz</a>
        <a class="p-2 hover:underline" href="#">Facebook</a>
        <a class="p-2 hover:underline" href="#">Youtube</a>
        <a class="p-2 hover:underline" href="#">Instragram</a>
    </nav>
</body>

</html>
