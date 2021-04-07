<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title.' - Trotzdem ’13' : 'Trotzdem ’13' }}</title>
    <meta name="description" content="Trotzdem ’13 ist ein DPSG Bannerlauf verteilt über die gesamte Diözese München und Freising.">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/style.css') }}">
    @stack('styles')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700;800&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> -->

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
    <div class="relative">
        &nbsp;
        @if ($showLoginLink || auth()->user())
        <a href="{{route('app.team.index')}}" class="float-right block text-white font-bold text-center group py-1 px-2  text-sm sm:text-base shadow-lg bg-mango-600 mr-2 -mb-2">
            @auth
            Mitglieder-Bereich
            @else
            Anmeldung
            @endauth
        </a>
        @endif
    </div>
    <a href="/" class="clear-both flex justify-between items-center bg-teal-500 px-2">
        <div class="sm:flex-1"><img src="{{asset('img/logo_192.png')}}" class="w-24" alt="Logo von Trotzdem ’13" width="192" height="155" /></div>
        <h1 class="text-center sm:text-5xl text-2xl px-1 sm:px-3 sm:py-1 sm:mb-3 text-mango-600 bg-white shadow-lg font-black uppercase">
            Trotzdem ’13
        </h1>
        <div class="sm:flex-1"></div>
    </a>

    <nav class="bg-teal-600 text-white shadow-xl flex flex-wrap items-center justify-center sm:text-lg">
        <a class="block px-4 pt-2 font-bold border-b-8 border-teal-600 hover:border-mango-500 {{$navMain =='/'?'border-mango-500':''}}" href="/">
            Bannerlauf
        </a>
        <a class="block px-4 pt-2 font-bold border-b-8 border-teal-600 hover:border-mango-500 {{$navMain =='/ablauf'?'border-mango-500':''}}" href="/ablauf">
            Ablauf
        </a>
        <a class="block px-4 pt-2 font-bold border-b-8 border-teal-600 hover:border-mango-500 {{$navMain =='/projekte'?'border-mango-500':''}}" href="/projekte">
            Projekte
        </a>
        <a class="block px-4 pt-2 font-bold border-b-8 border-teal-600 hover:border-mango-500 {{$navMain =='/karte'?'border-mango-500':''}}" href="/karte">
            Karte
        </a>
        @if(false)
        <a class="block px-4 pt-2 font-bold border-b-8 border-teal-600 hover:border-mango-500 {{$navMain =='/teilnehmer'?'border-mango-500':''}}" href="/teilnehmer">
            Teilnehmer
        </a>
        @endif
    </nav>
    <main class="flex-auto bg-sepiaGray-100" id="main">
        {{ $slot }}
    </main>
    <nav class="bg-teal-600 text-white shadow-xl flex flex-wrap items-center justify-center text-sm sm:text-base">
        <a class="p-2 hover:underline {{$navMain =='/impressum'?'underline':''}}" href="/impressum">Impressum</a>
        <a class="p-2 hover:underline {{$navMain =='/datenschutz'?'underline':''}}" hreftodo="/datenschutz" href="https://www.dpsg1300.de/datenschutz/">Datenschutz</a>
        <a class="p-2 hover:underline" target="_blank" rel="noopener noreferrer" href="https://www.instagram.com/trotzdem_13/">Instragram</a>
    </nav>

    @stack('scripts')
    @production
    <script async defer data-domain="trotzdem13.de" src="https://plausible.io/js/plausible.js"></script>
    @endproduction
</body>

</html>
