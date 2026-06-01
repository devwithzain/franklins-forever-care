<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
        }
        .content {
            padding: 40px 30px;
            color: #333333;
            line-height: 1.6;
        }
        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #F0BB4C;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }
        .info-row {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .label {
            font-size: 12px;
            font-weight: 700;
            color: #999999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .value {
            font-size: 16px;
            color: #333333;
            font-weight: 500;
        }
        .message-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .message-label {
            font-size: 12px;
            font-weight: 700;
            color: #999999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }
        .message-content {
            font-size: 15px;
            color: #333333;
            line-height: 1.8;
            white-space: pre-wrap;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        .footer p {
            font-size: 13px;
            color: #999999;
            margin: 5px 0;
        }
        .button {
            display: inline-block;
            background-color: #F0BB4C;
            color: #000000;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 New Contact Form Submission</h1>
        </div>
        
        <div class="content">
            <p style="font-size: 16px; color: #666666; margin-bottom: 25px;">
                You have received a new message from the contact form on your website.
            </p>
            
            <div class="info-box">
                <div class="info-row">
                    <div class="label">Full Name</div>
                    <div class="value">{{ $data['name'] ?? 'N/A' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="label">Email Address</div>
                    <div class="value">{{ $data['email'] ?? 'N/A' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="label">Phone Number</div>
                    <div class="value">{{ $data['phone'] ?? 'N/A' }}</div>
                </div>
                
                <div class="info-row">
                    <div class="label">Subject</div>
                    <div class="value">{{ $data['subject'] ?? 'General Inquiry' }}</div>
                </div>
            </div>
            
            <div class="message-box">
                <div class="message-label">Message</div>
                <div class="message-content">{{ $data['message'] ?? 'No message provided' }}</div>
            </div>
            
            <p style="font-size: 14px; color: #999999; margin-top: 25px;">
                <strong>Submitted on:</strong> {{ now()->format('F j, Y \a\t g:i A') }}
            </p>
            
            <center>
                <a href="{{ route('admin.dashboard') }}" class="button">View in Dashboard</a>
            </center>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Franklin's Forever Care. All rights reserved.</p>
            <p>This email was sent from your website contact form.</p>
        </div>
    </div>
</body>
</html>
