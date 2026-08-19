<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Franklin's Forever Care</title>
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
            max-width: 560px;
            margin: 0 auto;
            background: #131b2e;
            border: 1px solid #1e293b;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }
        .header {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            padding: 36px 30px;
            text-align: center;
            border-bottom: 1px solid #1e293b;
        }
        .brand-title {
            color: #3b82f6;
            font-size: 22px;
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
        }
        .greeting {
            color: #f8fafc;
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 12px 0;
            text-transform: capitalize;
        }
        .intro {
            color: #94a3b8;
            font-size: 15px;
            line-height: 1.6;
            margin: 0 0 28px 0;
        }
        .details-card {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 28px;
        }
        .details-header {
            color: #3b82f6;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 16px;
            border-bottom: 1px solid #1e293b;
            padding-bottom: 10px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 12px;
        }
        .detail-row:last-child {
            margin-bottom: 0;
        }
        .detail-label {
            color: #64748b;
            font-size: 13.5px;
            width: 90px;
            font-weight: 600;
        }
        .detail-value {
            color: #f8fafc;
            font-size: 13.5px;
            font-weight: 600;
        }
        .cta-center {
            text-align: center;
            margin: 32px 0 20px 0;
        }
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14.5px;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
            transition: all 0.2s ease;
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
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ asset('assets/logoDark.png') }}" alt="Franklin's Forever Care" style="max-width: 220px; width: 100%; height: auto; display: block; margin: 0 auto 6px auto;">
                <div class="brand-subtitle">Welcome to Our Family</div>
            </div>
            <div class="content">
                <h2 class="greeting">Welcome, {{ $name }}! 👋</h2>
                <p class="intro">Thank you for registering with <strong>Franklin's Forever Care</strong>. We are thrilled to have you on board and dedicated to providing you with exceptional care and service.</p>

                <div class="details-card">
                    <div class="details-header">Account Details</div>
                    <div class="detail-row">
                        <span class="detail-label">Name:</span>
                        <span class="detail-value">{{ $name }}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label">Email:</span>
                        <span class="detail-value">{{ $email }}</span>
                    </div>
                </div>

                <div class="cta-center">
                    <a href="{{ route('login') }}" class="btn-primary">Sign In to Your Account</a>
                </div>

                <p style="color: #94a3b8; font-size: 13.5px; line-height: 1.6; margin-top: 24px;">If you have any questions or need assistance, feel free to reply to this email or reach out to our support team.</p>
            </div>
            <div class="footer">
                <p class="footer-text">Best regards,<br><strong>The Franklin's Forever Care Team</strong></p>
                <p class="footer-text" style="margin-top: 10px;">&copy; {{ date('Y') }} Franklin's Forever Care. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>