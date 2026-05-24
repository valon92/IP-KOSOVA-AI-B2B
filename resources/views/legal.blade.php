<!DOCTYPE html>
<html lang="sq" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPKO.ai — {{ $title ?? 'Legal' }}</title>
    <meta name="description" content="{{ $description ?? 'Dokumentacion ligjor dhe status i platformës IPKO.ai B2B IP Intelligence.' }}">
    @include('partials.favicon')
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans">
    <div id="ipko-legal" data-section="{{ $section ?? 'privacy' }}"></div>
</body>
</html>
