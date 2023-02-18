<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Arc</title>
        <link rel="icon" href="/img/logo.png" type="image/png" sizes="16x16">
        @viteReactRefresh
        @vite(['resources/js/app.jsx', 'resources/css/app.css'])
    </head>
    <body class="h-screen w-screen">
        <div id="root" class="h-full w-full"></div>
    </body>
</html>
