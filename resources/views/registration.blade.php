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
                    <h1 class="text-3xl font-extrabold font-zenOldMincho text-white">Registration</h1>
                </div>
                <form action="{{ route('registration.submit') }}" method="post"
                    class="mx-auto mb-0 mt-8 max-w-md space-y-6">
                    @csrf
                    <div>
                        <label class="font-zenOldMincho font-semibold text-white">Full Name</label>

                        <div class="relative">
                            <input type="text" id="name" name="name" required
                                class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm font-zenOldMincho items-center"
                                placeholder="Enter Full Name" value="{{ old('name') }}" />
                            @error('name')
                                <div class="invalid-feedback text-center text-red-500 text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <label class="font-zenOldMincho font-semibold text-white">Email</label>

                        <div class="relative">
                            <input type="email" id="email" name="email" required
                                class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm font-zenOldMincho items-center"
                                placeholder="Enter email" value="{{ old('email') }}" />
                            @error('email')
                                <div class="invalid-feedback text-center text-white text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="font-zenOldMincho font-semibold text-white">Password</label>
                        <div class="relative">
                            <input type="password" class="w-full rounded-lg border-gray-200 p-4 text-sm shadow-sm"
                                placeholder="Enter password" id="password" name="password" required />
                            @error('password')
                                <div class="invalid-feedback text-center text-white text-sm">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="flex items-center justify-center w-full">
                        <a href="/login" class="hover:text-blue-600 text-white text-sm font-bold">Already Have Account?
                            Login Here!</a>
                    </div>
                    <div class="flex items-center justify-center w-full">
                        <button type="submit"
                            class="inline-block rounded-lg bg-blueRevamp px-5 py-3 text-lg font-bold text-white w-32 transition duration-200 transform hover:scale-95 hover:bg-blueRevamp3">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
</body>

</html>
