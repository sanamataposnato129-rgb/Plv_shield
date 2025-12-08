<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Log In - PLV SHIELD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login-style.css') }}">
</head>
<body>
    <img src="{{ asset('ASSETS/bgLanding.png') }}" alt="Background" class="background">
    
    <div class="overlay">
        <!-- Left side content -->
        <div class="content">
            <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV Shield Logo" class="logo">
            <h1 class="welcome">Student Portal</h1>
            <p class="tagline">Track, Report, Accomplish</p>
            <div class="left-section-btn">
                <p>Don't have an account?</p>
                <a href="{{ route('signup') }}" class="secondary-btn">SIGN UP</a>
            </div>
        </div>
        
        <!-- Right side form -->
        <div class="right-section">
            <div class="login-box">
                <h2>Student Log In</h2>
                
                <!-- Error/Success Messages Container -->
                <div id="messageContainer">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                </div>
                
                <form id="loginForm" action="{{ url('/student/login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Student ID or Email</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-group">
                            <input type="password" id="password" name="password" required>
                            <i class="fas fa-eye" id="togglePassword"></i>
                        </div>
                    </div>
                    
                    <div class="form-options">
                        <div class="remember-me">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Remember me</label>
                        </div>
                        <div class="forgot">
                            <a href="#">Forgot Password?</a>
                        </div>
                    </div>
                    
                    <button type="submit" class="primary-btn">STUDENT LOGIN</button>
                    
                    <div class="signup-link">
                        Don't have an account? <a href="{{ route('signup') }}">Sign Up</a>
                    </div>

                    <div class="back-to-choice" style="text-align: center; margin-top: 15px;">
                        <a href="{{ route('login.choice') }}" style="color: #0047b3; text-decoration: none;">
                            <i class="fas fa-arrow-left"></i> Back to Login Options
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Password toggle functionality
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>