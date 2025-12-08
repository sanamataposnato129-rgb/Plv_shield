<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Duty Certificate</title>
<style>
    @page { margin: 0; size: A4; }
    body {
        font-family: 'Times New Roman', serif;
        margin: 0;
        padding: 0;
        background-color: #fff;
        position: relative;
        color: #0b2c69;
    }

    /* ===== HEADER ===== */
    .header {
        text-align: center;
        background-color: #0b2c69;
        color: white;
        padding: 18px 120px 12px 120px;
        font-weight: 700;
        font-size: 14px;
        position: relative;
        box-sizing: border-box;
    }

    .subheader {
        text-align: center;
        background-color: #002060;
        color: white;
        font-size: 11px;
        padding: 6px 120px;
        letter-spacing: 0.6px;
        box-sizing: border-box;
    }

    /* ===== SHIELD LOGO ===== */
    .logo {
        position: absolute;
        top: 14px;
        left: 48px;
        width: 72px;
        height: auto;
    }

    /* ===== MAIN CONTENT ===== */
    .content {
        padding: 60px 70px 160px 70px; /* extra bottom space so footer doesn't overlap */
        text-align: center;
        box-sizing: border-box;
        max-width: 820px;
        margin: 0 auto;
    }

    .content h2 {
        color: #0b2c69;
        font-size: 20pt;
        font-weight: 800;
        margin-bottom: 18px;
        letter-spacing: 1px;
    }

    .content p {
        font-size: 12.5pt;
        text-align: justify;
        line-height: 1.6;
        margin-bottom: 16px;
        color: #223045;
    }

    /* ===== SIGNATURE ===== */
    .signature {
        display: flex;
        justify-content: center;
        gap: 80px;
        margin-top: 48px;
        align-items: flex-end;
    }

    .signature .sig-block {
        text-align: center;
        width: 260px;
    }

    .signature-line {
        width: 220px;
        border-top: 1px solid #000;
        margin: 0 auto 8px auto;
    }

    .signature p {
        font-size: 11pt;
        line-height: 1.3;
        margin: 4px 0 0 0;
        color: #0b2c69;
    }

    /* ===== FOOTER ===== */
    .footer {
        width: calc(100% - 0px);
        background-color: #002060;
        color: white;
        text-align: center;
        font-size: 10pt;
        padding: 10px 0;
        position: absolute;
        bottom: 0;
        left: 0;
        box-sizing: border-box;
    }

    /* ===== CORNER DESIGN ===== */
    .bottom-design {
        position: absolute;
        bottom: 12px;
        left: 12px;
        width: 180px;
        height: 46px;
        pointer-events: none;
    }

    .blue-corner {
        width: 100%;
        height: 100%;
        background-color: #002060;
        clip-path: polygon(0 100%, 20% 0, 100% 0, 100% 100%);
    }

    .yellow-corner {
        width: 36px;
        height: 100%;
        background-color: #ffc000;
        position: absolute;
        left: 0;
        top: 0;
        clip-path: polygon(0 100%, 35% 0, 100% 0, 0 100%);
    }
</style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        PAMANTASAN NG LUNGSOD NG VALENZUELA
    </div>
    <div class="subheader">
        STUDENT HELPING IN IMMINENT EVENTS AND LIFE-THREATENING DISASTERS
    </div>
    <img src="{{ public_path('ASSETS/shield-logo.png') }}" class="logo" alt="SHIELD Logo">

    <!-- CONTENT -->
    <div class="content">
        <h2>DUTY CERTIFICATE</h2>

        <p>
            This is to certify that <strong>{{ $participant->first_name }} {{ $participant->last_name }}</strong>, who served as 
            <strong>Volunteer / Duty Officer</strong> during the <strong>{{ $duty->title }}</strong>, 
            has duly performed official duties from <strong>{{ $duty->duty_date ? $duty->duty_date->format('F d, Y') : 'Date' }}</strong> 
            ({{ $duty->formatted_start_time }} - {{ $duty->formatted_end_time }}).
        </p>

        <p>
            Based on observation and evaluation, the individual's performance 
            has been deemed satisfactory and in accordance with the assigned responsibilities.
        </p>

        <div class="signature">
            <div class="signature-line"></div>
            <p><strong>Authorized Signatory</strong></p>
            <p>PLV - SHIELD Program Coordinator</p>
            <p>Pamantasan ng Lungsod ng Valenzuela</p>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        📧 plvshield@gmail.com &nbsp;&nbsp;&nbsp; 🌐 https://www.facebook.com/PLVSHIELD
    </div>

    <!-- CORNER DESIGN -->
    <div class="bottom-design">
        <div class="blue-corner"></div>
        <div class="yellow-corner"></div>
    </div>

</body>
</html>