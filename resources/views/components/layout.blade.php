<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QuickPay</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="{{ asset('image/logo.png') }}" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Zen+Old+Mincho:wght@400;500;600;700;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Zen+Maru+Gothic:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&family=Zen+Maru+Gothic:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>

<body class="flex h-full overflow-auto font-zenMaruGothic w-screen lg:w-full">
    <x-sidebar></x-sidebar>
    <div class="flex-grow flex flex-col">
        <!-- Header -->
        <x-header>
            <x-slot name="redirect">{{ $redirect }}</x-slot>
        </x-header>

        <!-- Main Content -->
        <div class="flex-grow p-4 w-screen lg:w-full">
            {{ $slot }}
        </div>
    </div>
</body>

</html>
