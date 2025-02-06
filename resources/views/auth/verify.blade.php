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
    <div class="bg-[url('/background/background.jpg')] bg-cover bg-center opacity-80 h-screen overflow-auto">
        <div class="text-white font-bold h-11 p-1">
            <p class="text-center text-4xl font-zenOldMincho font-bold">QuickPay</p>
        </div>

        <div class="flex items-center justify-center min-h-full">
            <div
                class="flex bg-white bg-opacity-30 backdrop-blur-lg p-8 rounded-xl shadow-xl max-w-md mx-auto text-white mb-4 flex-col justify-center">
                <div>
                    <h1 class="font-zenMaruGothic font-bold text-center text-xl mb-4">Verify Your Email Address</h1>
                </div>
                <div class="text-center mb-4">
                    <p>Before proceeding, please check your email for a verification link.</p>
                    <p>If you did not receive the email, request another below:</p>
                </div>

                <div class="flex justify-center">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit"
                            class="bg-blue-700 transition duration-200 transform hover:scale-95 hover:bg-blueRevamp3 text-white px-4 py-2 rounded">
                            Resend Verification Email
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

</html>
