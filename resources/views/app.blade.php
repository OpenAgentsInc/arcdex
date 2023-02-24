<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark h-full">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Arc</title>
    <link rel="icon" href="/img/logo.png" type="image/png" sizes="16x16">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @viteReactRefresh
    @vite(['resources/js/app.jsx', 'resources/css/app.css'])
    @inertiaHead
</head>

<body class="antialiased font-sans h-full nice-scrollbar">
    <div class="bg-gray-100 dark:bg-gray-900 h-full">
        @inertia
    </div>
</body>

</html>
