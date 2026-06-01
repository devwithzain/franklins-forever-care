<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Newsletter Subscription Confirmation</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #7E80B0 0%, #5a5c8a 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }
        .content h2 {
            color: #7E80B0;
            font-size: 22px;
            margin-top: 0;
        }
        .content p {
            font-size: 16px;
            color: #666666;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background-color: #F0BB4C;
            color: #000000;
            text-decoration: none;
            padding: 14px 32px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
        }
        .button:hover {
            background-color: #d8a540;
        }
        .features {
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 25px 0;
        }
        .features ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .features li {
            padding: 10px 0;
            font-size: 15px;
            color: #555555;
        }
        .features li:before {
            content: "✓";
            color: #4A9D7A;
            font-weight: bold;
            margin-right: 10px;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        .footer p {
            font-size: 13px;
            color: #999999;
            margin: 5px 0;
        }
        .social-links {
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 8px;
            color: #7E80B0;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Welcome to Our Newsletter!</h1>
        </div>
        
        <div class="content">
            <h2>Thank You for Subscribing!</h2>
            
            <p>Dear Subscriber,</p>
            
            <p>Thank you for subscribing to our newsletter! We're excited to have you on board. You'll now receive regular updates about:</p>
            
            <div class="features">
                <ul>
                    <li>Latest healthcare tips and wellness advice</li>
                    <li>New services and care packages</li>
                    <li>Special offers and promotions</li>
                    <li>Expert insights from our care professionals</li>
                    <li>Community stories and testimonials</li>
                </ul>
            </div>
            
            <p>We respect your privacy and will never share your email address with third parties. You can unsubscribe at any time by clicking the link in our emails.</p>
            
            <center>
                <a href="{{ route('home') }}" class="button">Visit Our Website</a>
            </center>
            
            <p>If you have any questions or need assistance, please don't hesitate to contact us at support@franklinsforevercare.com</p>
            
            <p>Best regards,<br>
            <strong>The Franklin's Forever Care Team</strong></p>
        </div>
        
        <div class="footer">
            <div class="social-links">
                <a href="#">Facebook</a> | 
                <a href="#">Twitter</a> | 
                <a href="#">Instagram</a>
            </div>
            <p>&copy; {{ date('Y') }} Franklin's Forever Care. All rights reserved.</p>
            <p>This email was sent to {{ $email }}</p>
            <p style="margin-top: 15px; font-size: 11px;">
                If you no longer wish to receive these emails, you can <a href="#" style="color: #999999;">unsubscribe here</a>.
            </p>
        </div>
    </div>
</body>
</html>
