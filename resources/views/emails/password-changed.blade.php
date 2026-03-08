<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Changed</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f6f9;font-family:'Segoe UI',Arial,sans-serif;">

    <!-- Outer wrapper -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#f4f6f9;padding:40px 16px;">
        <tr>
            <td align="center">

                <!-- Email card -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0"
                       style="max-width:580px;background-color:#ffffff;border-radius:12px;
                              box-shadow:0 4px 20px rgba(0,0,0,0.08);overflow:hidden;">

                    <!-- Header -->
                    <tr>
                        <td style="background:linear-gradient(135deg,#1e40af,#2563eb);
                                   padding:36px 40px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:#bfdbfe;
                                      letter-spacing:2px;text-transform:uppercase;font-weight:600;">
                                E-Barangay Integrated Services Platform
                            </p>
                            <h1 style="margin:12px 0 0;font-size:26px;font-weight:700;color:#ffffff;">
                                Password Updated
                            </h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:40px 40px 32px;">

                            <!-- Lock icon -->
                            <div style="text-align:center;margin-bottom:28px;">
                                <div style="display:inline-flex;align-items:center;justify-content:center;
                                            background-color:#eff6ff;border-radius:50%;
                                            width:72px;height:72px;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" style="color:#2563eb;">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                              stroke-linejoin="round" stroke-width="2"
                                              d="M5 13a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2zm3-2V7a4 4 0 1 1 8 0v4"/>
                                    </svg>
                                </div>
                            </div>

                            <h2 style="margin:0 0 8px;font-size:20px;font-weight:700;
                                       color:#1e293b;text-align:center;">
                                Hello, {{ $user->name ?? 'User' }}
                            </h2>

                            <p style="margin:0 0 20px;font-size:15px;color:#475569;
                                      text-align:center;line-height:1.6;">
                                This is a confirmation that your account password was
                                <strong>successfully changed</strong>.
                            </p>

                            <!-- Divider -->
                            <hr style="border:none;border-top:1px solid #e2e8f0;margin:28px 0;">

                            <!-- Security notice -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="background-color:#fffbeb;border:1px solid #fde68a;
                                               border-radius:8px;padding:14px 18px;">
                                        <p style="margin:0;font-size:13px;color:#92400e;line-height:1.5;">
                                            <strong>&#9888;&#65039; Security Notice:</strong>
                                            If you did not make this change, please reset your password immediately
                                            or contact your system administrator.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Additional info -->
                            <p style="margin:24px 0 0;font-size:13px;color:#64748b;
                                      text-align:center;line-height:1.6;">
                                For security reasons, we recommend keeping your password confidential
                                and avoiding sharing it with anyone.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f8fafc;border-top:1px solid #e2e8f0;
                                   padding:24px 40px;text-align:center;">
                            <p style="margin:0;font-size:12px;color:#94a3b8;line-height:1.6;">
                                This email was sent by the <strong style="color:#64748b;">Incident Reporting System</strong>.<br>
                                If you have questions, please contact your system administrator.
                            </p>
                        </td>
                    </tr>

                </table>
                <!-- End email card -->

            </td>
        </tr>
    </table>

</body>
</html>