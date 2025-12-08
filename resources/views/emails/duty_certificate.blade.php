<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duty Certificate - PLV SHIELD</title>
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
        .greeting {
            font-size: 18px;
            color: #1a4d2e;
            margin-bottom: 20px;
        }
        .info-box {
            background: #f0fdf4;
            border-left: 4px solid #1a4d2e;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }
        .info-box h3 {
            color: #1a4d2e;
            margin-top: 0;
        }
        .info-item {
            margin: 10px 0;
            color: #374151;
        }
        .info-item strong {
            color: #1a4d2e;
        }
        .certificate-notice {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
            color: #856404;
        }
        .footer {
            text-align: center;
            padding-top: 30px;
            margin-top: 40px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('ASSETS/shield-logo.png') }}" alt="PLV SHIELD Logo">
            <h1>Duty Certificate</h1>
        </div>

        <div class="content">
            <p class="greeting">Hello {{ $participant->first_name }},</p>

            <p>Congratulations! We are pleased to present you with your official Duty Certificate for your outstanding participation and exemplary service in the PLV SHIELD program.</p>

            <div class="info-box">
                <h3>Certificate Details</h3>
                <div class="info-item"><strong>Participant:</strong> {{ $participant->first_name }} {{ $participant->last_name }}</div>
                <div class="info-item"><strong>Student ID:</strong> {{ $participant->plv_student_id ?? 'N/A' }}</div>
                <div class="info-item"><strong>Email:</strong> {{ $participant->email ?? 'N/A' }}</div>
                <div class="info-item"><strong>Duty Event:</strong> {{ $duty->title }}</div>
                <div class="info-item"><strong>Date:</strong> {{ $duty->duty_date ? $duty->duty_date->format('F d, Y') : 'N/A' }}</div>
                <div class="info-item"><strong>Time:</strong> {{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}</div>
            </div>

            <div class="certificate-notice">
                <strong>📎 Attachment:</strong> Your official duty certificate is attached to this email. Please download and keep it for your records.
            </div>

            @if(!empty($downloadUrl))
                <p style="text-align:center; margin: 20px 0;">
                    <a href="{{ $downloadUrl }}" style="display:inline-block; background:#1a4d2e; color:white; padding:12px 20px; border-radius:6px; text-decoration:none;">Download your certificate</a>
                </p>
            @endif

            <p>This certificate recognizes your dedication, commitment, and exemplary performance during your duty service. It serves as official proof of your participation in this important PLV SHIELD event.</p>

            <p style="color: #666; font-size: 14px; margin-top: 30px;">If you have any questions about this certificate or need any clarification, please don't hesitate to contact us.</p>
        </div>

        <div class="footer">
            <p>This is an automated message from the PLV SHIELD system.</p>
            <p>If you need assistance, please contact your administrator.</p>
            <p>&copy; {{ date('Y') }} PLV SHIELD. All rights reserved.</p>
        </div>
    </div>
</body>
</html>