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
</head>

<body class="bg-PinkMuda font-zenOldMincho">

    <div class="bg-PinkTua text-white font-bold h-11 p-1">
        <p class="text-center text-2xl font-zenOldMincho font-bold">QuickPay</p>
    </div>

    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-lg mx-auto px-4 py-16">
            <div class="mx-auto max-w-lg text-center">
                <h1 class="text-2xl font-bold sm:text-3xl font-zenOldMincho">Hi, Welcome!</h1>
            </div>

            <form action="{{ route('login.submit') }}" method="post" class="mx-auto mb-0 mt-8 max-w-md space-y-6">
                @csrf
                <div>
                    <label for="email" class="p-2 font-zenOldMincho text-gray-500">Email</label>

                    <div class="relative">
                        <input type="email" id="email" name="email" required
                            class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm font-zenOldMincho items-center"
                            placeholder="Enter email" />
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div>
                    <label for="password" class="p-2 font-zenOldMincho text-gray-500">Password</label>
                    <div class="relative">
                        <input type="password" class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm"
                            placeholder="Enter password" id="password" name="password" required />
                        <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                    </div>
                </div>

                @if (session('failed'))
                    <p class="text-red-700 text-center font-zenMaruGothic">{{ session('failed') }}</p>
                @endif
                <div class="flex items-center justify-center w-full">
                    <a href="/registration" class="hover:text-blue-600 text-sm font-bold">Don't have account?
                        Register Here</a>
                </div>
                <div class="flex items-center justify-center w-full">
                    <button type="submit"
                        class="inline-block rounded-lg bg-PinkTua px-5 py-3 text-lg font-bold text-white w-32">
                        LOGIN
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
