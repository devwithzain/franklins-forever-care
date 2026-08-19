<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #0b0f19;
            color: #f8fafc;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .wrapper {
            width: 100%;
            background-color: #0b0f19;
            padding: 40px 15px;
            box-sizing: border-box;
        }
        .container {
            max-width: 540px;
            margin: 0 auto;
            background: #131b2e;
            border: 1px solid #1e293b;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        .header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 32px 30px;
            text-align: center;
            border-bottom: 1px solid #1e293b;
        }
        .brand-title {
            color: #3b82f6;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin: 0;
            text-transform: uppercase;
        }
        .brand-subtitle {
            color: #64748b;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 1px;
            margin-top: 4px;
            text-transform: uppercase;
        }
        .content {
            padding: 40px 32px;
            text-align: center;
        }
        .icon-badge {
            width: 56px;
            height: 56px;
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: #f59e0b;
        }
        .heading {
            color: #f8fafc;
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 10px 0;
        }
        .description {
            color: #94a3b8;
            font-size: 14.5px;
            line-height: 1.6;
            margin: 0 0 28px 0;
        }
        .otp-box {
            background: #0f172a;
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 22px;
            margin: 0 0 28px 0;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        .otp-code {
            font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace;
            font-size: 38px;
            font-weight: 800;
            color: #f59e0b;
            letter-spacing: 10px;
            margin: 0;
            text-shadow: 0 0 12px rgba(245, 158, 11, 0.3);
        }
        .expiry-note {
            color: #64748b;
            font-size: 13px;
            margin: 0;
        }
        .info-note {
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.2);
            border-radius: 10px;
            padding: 14px 18px;
            margin-top: 24px;
            text-align: left;
            color: #93c5fd;
            font-size: 13px;
            line-height: 1.5;
        }
        .footer {
            background: #0f172a;
            padding: 24px 30px;
            text-align: center;
            border-top: 1px solid #1e293b;
        }
        .footer-text {
            color: #64748b;
            font-size: 12px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ asset('assets/logoDark.png') }}" alt="Franklin's Forever Care" style="max-width: 220px; width: 100%; height: auto; display: block; margin: 0 auto 6px auto;">
                <div class="brand-subtitle">Password Recovery</div>
            </div>
            <div class="content">
                <div class="icon-badge">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 9.9-1"></path>
                    </svg>
                </div>
                <h2 class="heading">Reset Your Password</h2>
                <p class="description">You requested to reset your password. Use the verification OTP code below to create a new password. This code expires in 10 minutes.</p>

                <div class="otp-box">
                    <div class="otp-code">{{ $otp }}</div>
                </div>

                <p class="expiry-note">⏳ This verification code will expire in <strong>10 minutes</strong>.</p>

                <div class="info-note">
                    ℹ️ If you did not request a password reset, you can safely ignore this email. Your password will remain unchanged.
                </div>
            </div>
            <div class="footer">
                <p class="footer-text">&copy; {{ date('Y') }} Franklin's Forever Care. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
