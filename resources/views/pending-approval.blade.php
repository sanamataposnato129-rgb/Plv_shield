<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Approval - PLV SHIELD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .approval-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 20px;
        }

        h1 {
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }

        p {
            color: #666;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #5a6fd8;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="approval-container">
        <div class="success-icon">
            <i class="fas fa-clock"></i>
        </div>
        <h1>Registration Submitted for Approval</h1>
        <p>Thank you for registering. Your account request has been sent to our administrator for review. You will receive a confirmation email once your account has been activated.</p>
        
        @if(session('success'))
            <div style="color: #28a745; margin-bottom: 20px; font-weight: 500;">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('student.login') }}" class="btn">Go to Login</a>
    </div>
</body>
</html>