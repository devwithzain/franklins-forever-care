<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f0f2f8; margin: 0; padding: 40px; }
        .container { max-width: 600px; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.06); }
        .header { background: #1a3cdc; padding: 30px; text-align: center; color: white; }
        .content { padding: 40px; text-align: center; }
        .otp { font-size: 36px; font-weight: 800; color: #1a3cdc; letter-spacing: 8px; margin: 30px 0; padding: 20px; background: #f8fafc; border-radius: 12px; border: 2px dashed #cbd5e1; }
        .footer { padding: 30px; text-align: center; color: #64748b; font-size: 13px; background: #f8fafc; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin:0; font-size: 24px;">Franklin's Forever Care</h1>
        </div>
        <div class="content">
            <h2 style="color: #1e293b; margin-top:0;">2FA Login Verification</h2>
            <p style="color: #64748b; line-height: 1.6;">A login attempt was made to your account. Use the following code to verify your identity. This code will expire in 10 minutes.</p>
            <div class="otp">{{ $code }}</div>
            <p style="color: #64748b; font-size: 14px;">If this wasn't you, please change your password immediately.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Franklin's Forever Care. All rights reserved.
        </div>
    </div>
</body>
</html>
