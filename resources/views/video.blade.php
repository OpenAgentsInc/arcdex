<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arc</title>
    <link rel="icon" href="/img/logo.png" type="image/png" sizes="16x16">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>

<body class="h-full dark:bg-gray-800">

    <!-- top-left logo that links back to the homepage -->
    <a href="/" class="absolute top-0 left-0 sm:p-8 z-10 p-4">
        <img src="/img/logo.png" alt="logo" class="w-12 sm:w-16">
    </a>

    <div
        class="p-4 relative sm:flex sm:justify-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <div class="flex flex-col items-center pt-16">
            <a href="/videos">
                <h3 style="color: rgb(116,65,244);" class="uppercase font-sm mb-4 tracking-wider">Building Arc</h3>
            </a>
            <h1 class="text-2xl text-center dark:text-white font-bold mb-4">{{ $video['title'] }}</h1>
            <h3 class="text-gray-500 dark:text-gray-400 mb-12">{{ $video['subtitle'] }}</h3>

            <div class="max-w-7xl">
                <video width="100%" height="100%" controls>
                    <source src="{{ $video['url'] }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
</body>

</html>
