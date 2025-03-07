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

<body class="font-zenOldMincho">

    <div class="bg-[url('/background/background.jpg')] bg-cover bg-center opacity-80">
        <div class="text-white font-bold h-11 p-1">
            <p class="text-center text-4xl font-zenOldMincho font-bold mt-2">QuickPay</p>
        </div>

        <div class="flex items-center justify-center min-h-screen">
            <div class="w-full sm:max-w-sm md:max-w-md lg:max-w-lg xl:max-w-lg mx-auto px-4 py-16">
                <div class="mx-auto max-w-lg text-center">
                    <h1 class="text-3xl font-extrabold font-zenOldMincho text-white">Hi, Welcome!</h1>
                </div>

                <form action="{{ route('login.submit') }}" method="post" class="mx-auto mb-0 mt-8 max-w-md space-y-6">
                    @csrf
                    <div>
                        <div class="mb-1">
                            <label for="email" class="font-zenOldMincho font-semibold text-white">Email</label>
                        </div>

                        <div class="relative">
                            <input type="email" id="email" name="email" required
                                class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm font-zenOldMincho items-center "
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
                        <div class="mb-1">
                            <label for="password" class="font-zenOldMincho font-semibold text-white">Password</label>
                        </div>
                        <div class="relative">
                            <input type="password" class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm"
                                placeholder="Enter password" id="password" name="password" required />
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <button type="button" id="togglePassword" class="focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" id="eyeIcon" class="w-6 h-6 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </span>
                        </div>
                    </div>


                    @if (session('failed'))
                        <p class="text-red-700 text-center font-zenMaruGothic">{{ session('failed') }}</p>
                    @endif
                    <div class="flex items-center justify-center w-full">
                        <a href="/registration" class="hover:text-blueRevamp text-white text-sm font-bold ">Don't have
                            account?
                            Register Here</a>
                    </div>
                    <div class="flex items-center justify-center w-full">
                        <button type="submit"
                            class="inline-block rounded-lg bg-blueRevamp text-white px-5 py-3 text-lg font-bold w-32 transition duration-200 transform hover:scale-95 hover:bg-blueRevamp3">
                            LOGIN
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            const passwordInput = document.getElementById('password');
            const togglePasswordButton = document.getElementById('togglePassword');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePasswordButton.addEventListener('click', () => {
                // Toggle tipe input
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
            });
        </script>
    </div>
</body>

</html>
