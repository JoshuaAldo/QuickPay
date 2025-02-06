<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuickPay Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 20px;
            border-radius: 15px;
            display: inline-block;
        }

        .button {
            background-color: #3490dc;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }

        .footer {
            font-size: 12px;
            color: #888;
            margin-top: 30px;
        }

        /* Untuk mengatur tata letak secara vertikal (column) */
        .vertical-layout {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Untuk mengatur tata letak secara horizontal (row) */
    </style>
</head>

<body>
    <div class="container">
        <!-- Logo -->
        <img src="{{ asset('image/logo.png') }}" alt="QuickPay Logo" class="logo">

        <!-- Greeting -->
        <h1>Hello!</h1>

        <!-- Intro Lines -->
        <p>Thank you for signing up with QuickPay. Please click the button below to verify your email address.</p>

        <!-- Action Button -->
        <a href="{{ $actionUrl }}" class="button">Verify Email</a>

        <!-- Outro Lines -->
        <p style="text-align: center">If you did not request this, please ignore this email.</p>

        <div class="footer" style="text-align: left">
            <p style="text-align: left">Regards,<br>QuickPay Team</p>
        </div>
    </div>
</body>

</html>
