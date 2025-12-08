<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLV SHIELD - Account Request Status</title>
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
            background: linear-gradient(135deg, #8B0000 0%, #A52A2A 100%);
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
        .message {
            text-align: center;
            margin-bottom: 30px;
        }
        .message h2 {
            color: #8B0000;
            font-size: 24px;
            margin-bottom: 15px;
        }
        .info-box {
            background: #fff8f8;
            border-left: 4px solid #8B0000;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .reason-box {
            background: #fef2f2;
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
            color: #7f1d1d;
        }
        .reason-box h3 {
            color: #8B0000;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .next-steps {
            background: #f8fafc;
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .next-steps h3 {
            color: #1f2937;
            margin-top: 0;
        }
        .next-steps ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .next-steps li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
            color: #374151;
        }
        .next-steps li:before {
            content: "→";
            position: absolute;
            left: 0;
            color: #8B0000;
            font-weight: bold;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background-color: #1a4d2e;
            color: #ffffff !important;
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
        .next-steps {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 4px;
            margin: 20px 0;
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
            <h1>PLV SHIELD Account Status Update</h1>
        </div>

        <div class="content">
            <h2>Hello {{ $request->first_name }},</h2>
            
            <p>We have reviewed your application to join PLV SHIELD (Student ID: <strong>{{ $request->plv_student_id }}</strong>). Unfortunately, we are unable to approve your account request at this time.</p>
            
            <div class="reason-box">
                <h3 style="margin-top: 0;">Reason for Rejection:</h3>
                <p style="margin-bottom: 0;">{{ $reason }}</p>
            </div>

            <div class="next-steps">
                <h3>What You Can Do Next:</h3>
                <ul>
                    <li>Review the rejection reason carefully</li>
                    <li>Gather any additional required documentation</li>
                    <li>Submit a new application with updated information</li>
                    <li>Contact our support team if you need clarification</li>
                </ul>
            </div>

            <div class="button-container">
                <a href="{{ url('/signup') }}" class="button">Submit New Application</a>
            </div>

            <p style="font-size: 14px; color: #666;">If you believe this decision was made in error or if you have additional documentation to support your application, please don't hesitate to contact us.</p>
        </div>

        <div class="footer">
            <p>This is an automated message from PLV SHIELD. Please do not reply to this email.</p>
            <p>If you have any questions or need assistance, please contact our support team.</p>
            <p>&copy; {{ date('Y') }} PLV SHIELD. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
