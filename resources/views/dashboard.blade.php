<!DOCTYPE html>
<html lang="sq" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IPKO.ai — B2B Analytics Dashboard</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        window.IPKO_DASHBOARD_API_KEY = @json(config('ipko.demo_api_key'));
    </script>
</head>
<body class="h-full font-sans">
    <div id="ipko-dashboard"></div>
</body>
</html>
