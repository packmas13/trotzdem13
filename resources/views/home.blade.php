<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Trotzdem ’13</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"> -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body class="font-sans antialiased text-xl bg-sepiaGray-200">
    <header class="flex justify-between items-center bg-teal-500 px-2 shadow-xl">
        <div class="w-48">LOGO</div>
        <h1 class="text-center text-5xl my-2 p-3 text-mango-700 bg-white rounded-xl shadow-lg font-black">
            Trotzdem ’13
        </h1>
        <a href="/dashboard"
            class="text-white border-white border-2 block px-4 p-2 rounded-full w-48 text-center">Anmelden</a>
    </header>

    <h2 class="font-bold text-5xl text-teal-500 bg-white rounded-xl p-3 shadow-lg my-4 mx-1/4 text-center">
        das Projekt
    </h2>
    <h2 class="title">
        die Teilnehmer
    </h2>
    <h2 class="title">
        die Teilnehmer
    </h2>
</body>

</html>
