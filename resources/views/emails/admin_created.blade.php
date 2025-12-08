<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin Account Created</title>
  </head>
  <body style="margin:0;padding:0;background:#f4f6f8;font-family:Arial,Helvetica,sans-serif;color:#333;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f8;padding:30px 0;">
      <tr>
        <td align="center">
          <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,0.08);">
            <tr>
              <td style="background:linear-gradient(90deg,#000066,#191970);padding:20px 30px;color:#fff;">
                <h1 style="margin:0;font-size:20px;font-weight:700;">PLV - SHIELD</h1>
              </td>
            </tr>
            <tr>
              <td style="padding:28px 30px;">
                <p style="margin:0 0 12px 0;font-size:16px;color:#1e293b;">Hello {{ $admin->first_name }} {{ $admin->last_name }},</p>
                <p style="margin:0 0 18px 0;font-size:14px;line-height:1.5;color:#475569;">An administrator account has been created for you on <strong>PLV - SHIELD</strong>. Below are your initial credentials — please sign in and change your password as soon as possible.</p>

                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin:18px 0;border:1px solid #eef2ff;background:#fbfbff;border-radius:8px;">
                  <tr>
                    <td style="padding:16px 18px;">
                      <p style="margin:0;font-size:14px;color:#111827;"><strong>Username</strong></p>
                      <p style="margin:6px 0 0 0;font-size:15px;color:#0f172a;">{{ $admin->username }}</p>
                    </td>
                    <td style="padding:16px 18px;border-left:1px solid #eef2ff;">
                      <p style="margin:0;font-size:14px;color:#111827;"><strong>Password</strong></p>
                      <p style="margin:6px 0 0 0;font-size:15px;color:#0f172a;">{{ $password }}</p>
                    </td>
                  </tr>
                </table>

                <p style="margin:18px 0 20px 0;text-align:center;">
                  <a href="{{ url('/admin/login') }}" style="display:inline-block;padding:12px 22px;background:#000066;color:#fff;border-radius:8px;text-decoration:none;font-weight:600;">Sign in to Admin</a>
                </p>

                <p style="margin:0;font-size:13px;color:#6b7280;">If you did not request this account, please contact your system administrator immediately.</p>
              </td>
            </tr>
            <tr>
              <td style="background:#f8fafc;padding:14px 20px;text-align:center;color:#64748b;font-size:13px;">
                <div>PLV - SHIELD • Polytechnic University of the Philippines</div>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>