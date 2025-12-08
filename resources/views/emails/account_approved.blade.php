<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to PLV SHIELD - Account Approved</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #2d3748;
            margin: 0;
            padding: 0;
            background-color: #f7fafc;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 30px 20px;
            background: linear-gradient(135deg, #1a4d2e 0%, #2c6e44 100%);
            border-radius: 12px 12px 0 0;
            margin-bottom: 0;
        }
        .header img {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
        }
        .header h1 {
            color: white;
            font-size: 28px;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .content {
            background: white;
            padding: 40px 30px;
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 30px;
        }
        .welcome-message h2 {
            color: #1a4d2e;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .info-box {
            background: #f8fafc;
            border-left: 4px solid #1a4d2e;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .features-list {
            background: #f0fdf4;
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .features-list h3 {
            color: #1a4d2e;
            margin-top: 0;
        }
        .features-list ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .features-list li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
            color: #374151;
        }
        .features-list li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #1a4d2e;
            font-weight: bold;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #1a4d2e;
            color: white !important;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: bold;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #666666;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
        }
        ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }
        li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV SHIELD Logo" class="logo">
            <h1>Welcome to PLV SHIELD!</h1>
        </div>

        <div class="content">
            <h2>Congratulations, {{ $student->first_name }}!</h2>
            
            <p>We're pleased to inform you that your account request for PLV SHIELD has been approved. Welcome aboard — your membership is now active.</p>
            
            <div class="features">
                <h3>Your Account Details:</h3>
                <ul>
                    <li><strong>Student ID:</strong> {{ $student->plv_student_id }}</li>
                    <li><strong>Email:</strong> {{ $student->email }}</li>
                </ul>

                <h3>What you can do now:</h3>
                <ul>
                    <li>✓ Access your personalized dashboard</li>
                    <li>✓ View and manage duty schedules</li>
                    <li>✓ Receive important announcements</li>
                    <li>✓ Track your duty history</li>
                    <li>✓ Connect with team leaders</li>
                </ul>
            </div>

            <div class="button-container">
                <a href="{{ url('/student/login') }}" class="button">Login to Your Account →</a>
            </div>

            <p style="font-size: 14px; color: #666;">If you did not set a password during signup, click the login button and choose "Forgot Password" to set a secure password for your account. Keep your credentials safe.</p>
        </div>

        <div class="footer">
            <p>This is an automated message from PLV SHIELD. Please do not reply to this email.</p>
            <p>If you have any questions or need assistance, please contact your administrator or reply to this email.</p>
            <p>&copy; {{ date('Y') }} PLV SHIELD. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
