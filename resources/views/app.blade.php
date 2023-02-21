<!DOCTYPE html>
<html class="dark">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Arc</title>
    <link rel="icon" href="/img/logo.png" type="image/png" sizes="16x16">
    @viteReactRefresh
    @vite(['resources/js/app.jsx', 'resources/css/app.css'])
    @inertiaHead
</head>

<body class="antialiased font-sans">
    <div class="bg-gray-100 dark:bg-gray-900">
        @inertia
    </div>
</body>

</html>
