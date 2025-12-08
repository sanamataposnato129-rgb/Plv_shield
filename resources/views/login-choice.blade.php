<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLV - SHIELD | Login</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a2a6c, #2a3a7c, #3a4a8c);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        /* === LOGO === */
        .logo {
            width: 200px;
            height: auto;
            margin-bottom: 40px;
        }

        /* === LOGIN CHOICE CONTAINER === */
        .login-choice-container {
            text-align: center;
            width: 100%;
        }

        .login-title {
            font-size: 3rem;
            font-weight: 800;
            color: white;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .login-subtitle {
            font-size: 1.2rem;
            color: #f0f0f0;
            margin-bottom: 50px;
            font-weight: 400;
            opacity: 0.9;
        }

        .login-options {
            display: flex;
            gap: 40px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }

        .login-option {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 40px 30px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 320px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }

        .login-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.6), transparent);
        }

        .login-option:hover {
            transform: translateY(-8px);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
        }

        .option-icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            transition: all 0.3s ease;
            border: 3px solid rgba(255, 255, 255, 0.3);
        }

        .option-icon.admin {
            background: linear-gradient(135deg, #FFD700, #FFA500);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
        }

        .option-icon.student {
            background: linear-gradient(135deg, #4A90E2, #007AFF);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }

        .login-option:hover .option-icon {
            transform: scale(1.1);
            border-color: rgba(255, 255, 255, 0.6);
        }

        .option-icon i {
            font-size: 36px;
            color: white;
        }

        .option-label {
            font-size: 1.6rem;
            font-weight: 700;
            color: white;
            margin-bottom: 15px;
        }

        .option-description {
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.85);
            line-height: 1.5;
            font-weight: 400;
        }

        .back-link {
            color: white;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 12px 25px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 30px;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            margin-top: 20px;
        }

        .back-link:hover {
            color: #FFD700;
            border-color: #FFD700;
            background: rgba(255, 215, 0, 0.1);
            transform: translateY(-2px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }
            
            .login-options {
                flex-direction: column;
                gap: 30px;
                align-items: center;
            }
            
            .login-option {
                width: 100%;
                max-width: 350px;
                padding: 30px 25px;
            }
            
            .login-title {
                font-size: 2.5rem;
            }
            
            .login-subtitle {
                font-size: 1.1rem;
            }
            
            .logo {
                width: 160px;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 480px) {
            .login-title {
                font-size: 2rem;
            }
            
            .login-subtitle {
                font-size: 1rem;
                margin-bottom: 40px;
            }
            
            .option-label {
                font-size: 1.4rem;
            }
            
            .option-icon {
                width: 80px;
                height: 80px;
            }
            
            .option-icon i {
                font-size: 32px;
            }
        }

    </style>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV Shield Logo" class="logo">

        <div class="login-choice-container">
            <h1 class="login-title">Choose Login Type</h1>
            <p class="login-subtitle">Select your role to access the PLV SHIELD system</p>

            <div class="login-options">
                <a href="{{ route('admin.login') }}" class="login-option">
                    <div class="option-icon admin">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <span class="option-label">Admin Login</span>
                    <p class="option-description">Access administrative features, manage users, and oversee system operations</p>
                </a>

                <a href="{{ route('student.login') }}" class="login-option">
                    <div class="option-icon student">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <span class="option-label">Student Login</span>
                    <p class="option-description">Track your progress, submit reports, and accomplish your tasks</p>
                </a>
            </div>

            <a href="{{ url('/') }}" class="back-link">
                <i class="fas fa-arrow-left"></i> Back to Home
            </a>
        </div>
    </div>
</body>
</html>