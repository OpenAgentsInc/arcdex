<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Arc</title>
        <link rel="icon" href="/img/logo.png" type="image/png" sizes="16x16">
        @viteReactRefresh
        @vite(['resources/js/login/login.tsx', 'resources/css/app.css'])
    </head>
    <body class="h-full dark:bg-gray-700">
        <div id="root" class="h-full"></div>
    </body>
</html>
