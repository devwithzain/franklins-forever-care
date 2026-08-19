<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Subscription Confirmation</title>
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
            max-width: 600px;
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
        .heading {
            color: #f8fafc;
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 12px 0;
        }
        .intro {
            color: #94a3b8;
            font-size: 14.5px;
            line-height: 1.6;
            margin-0 0 24px 0;
        }
        .email-display {
            background: #0f172a;
            border: 1px solid #334155;
            padding: 14px 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
            font-size: 15px;
            color: #60a5fa;
            font-weight: 600;
        }
        .confirmation-box {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            padding: 16px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
        }
        .confirmation-text {
            font-size: 14.5px;
            color: #34d399;
            font-weight: 600;
        }
        .features {
            background: #0f172a;
            border: 1px solid #1e293b;
            padding: 24px;
            border-radius: 12px;
            margin: 24px 0;
        }
        .features-title {
            color: #f8fafc;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .features ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .features li {
            padding: 8px 0;
            font-size: 14px;
            color: #cbd5e1;
            display: flex;
            align-items: center;
        }
        .features li:before {
            content: "✓";
            color: #10b981;
            font-weight: bold;
            margin-right: 12px;
        }
        .cta-center {
            text-align: center;
            margin: 32px 0 24px 0;
        }
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #0f172a !important;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 10px;
            font-weight: 800;
            font-size: 14.5px;
            box-shadow: 0 4px 16px rgba(245, 158, 11, 0.3);
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
            margin: 4px 0;
            line-height: 1.5;
        }
        .social-links {
            margin-bottom: 16px;
        }
        .social-links a {
            color: #3b82f6;
            text-decoration: none;
            font-size: 13px;
            margin: 0 8px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ asset('assets/logoDark.png') }}" alt="Franklin's Forever Care" style="max-width: 220px; width: 100%; height: auto; display: block; margin: 0 auto 6px auto;">
                <div class="brand-subtitle">Newsletter Subscription</div>
            </div>
            
            <div class="content">
                <h2 class="heading">🎉 Confirm Your Subscription!</h2>
                
                <p class="intro">Hi <strong>{{ $subscriber->name ?? 'there' }}</strong>,</p>
                
                <p class="intro">Thank you for subscribing to Franklin's Forever Care newsletter! To complete your subscription and receive our latest updates, please confirm your email address.</p>
                
                <div class="email-display">
                    📧 {{ $subscriber->email }}
                </div>

                @if($subscriber->status === 'pending')
                <div class="confirmation-box">
                    <div class="confirmation-text">
                        ✓ Subscription pending confirmation
                    </div>
                </div>
                @endif
                
                <div class="features">
                    <div class="features-title">What you'll receive:</div>
                    <ul>
                        <li>Latest healthcare tips and wellness advice</li>
                        <li>New service announcements & care package updates</li>
                        <li>Exclusive promotional offers</li>
                        <li>Expert insights from our care professionals</li>
                        <li>Community stories and inspirational care updates</li>
                    </ul>
                </div>
                
                <div class="cta-center">
                    <a href="{{ route('home') }}" class="btn-primary">Visit Our Website</a>
                </div>
                
                <p style="color: #64748b; font-size: 13px; line-height: 1.6; margin-top: 20px;">
                    We respect your privacy. You can unsubscribe at any time using the link in our emails.
                </p>
            </div>
            
            <div class="footer">
                <div class="social-links">
                    <a href="#">Facebook</a> • 
                    <a href="#">Twitter</a> • 
                    <a href="#">Instagram</a>
                </div>
                <p class="footer-text">&copy; {{ date('Y') }} Franklin's Forever Care. All rights reserved.</p>
                <p class="footer-text">Sent to {{ $subscriber->email }}</p>
            </div>
        </div>
    </div>
</body>
</html>
