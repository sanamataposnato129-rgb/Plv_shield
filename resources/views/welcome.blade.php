<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLV - SHIELD</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        body {
            background: url("{{ asset('ASSETS/bgLanding.png') }}") no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>
<body>
    <div class="overlay">
        <div class="content">
            <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV Shield Logo" class="logo">

            <h1 class="welcome">Welcome to</h1>
            <h1 class="title">PLV – SHIELD</h1>
            <p class="subtitle">Track, Report, Accomplish</p>

        <div class="button-container">
            <a href="{{ route('login.choice') }}" class="login-btn">LOG IN</a>
            <a href="{{ route('signup') }}" class="signup-btn">SIGN UP</a>
        </div>
        </div>
    </div>
</body>
</html>