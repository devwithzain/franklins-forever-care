<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
        .reference-badge {
            background: rgba(245, 158, 11, 0.12);
            border: 1px solid rgba(245, 158, 11, 0.3);
            border-radius: 10px;
            padding: 12px 20px;
            margin-bottom: 24px;
            text-align: center;
        }
        .reference-label {
            font-size: 11px;
            font-weight: 700;
            color: #f59e0b;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .reference-number {
            font-size: 20px;
            font-weight: 800;
            color: #fbbf24;
            margin-top: 2px;
        }
        .intro {
            color: #94a3b8;
            font-size: 14.5px;
            line-height: 1.6;
            margin-bottom: 24px;
        }
        .info-card {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-left: 4px solid #3b82f6;
            border-radius: 8px 12px 12px 8px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .info-row {
            margin-bottom: 14px;
            padding-bottom: 14px;
            border-bottom: 1px solid #1e293b;
        }
        .info-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        .label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .value {
            font-size: 15px;
            color: #f8fafc;
            font-weight: 600;
        }
        .message-card {
            background: #0f172a;
            border: 1px solid #1e293b;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 24px;
        }
        .message-label {
            font-size: 11px;
            font-weight: 700;
            color: #3b82f6;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        .message-content {
            font-size: 14.5px;
            color: #cbd5e1;
            line-height: 1.7;
            white-space: pre-wrap;
        }
        .timestamp {
            font-size: 12.5px;
            color: #64748b;
            margin-top: 20px;
        }
        .cta-center {
            text-align: center;
            margin: 32px 0 16px 0;
        }
        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 28px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            box-shadow: 0 4px 16px rgba(59, 130, 246, 0.3);
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
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ asset('assets/logoDark.png') }}" alt="Franklin's Forever Care" style="max-width: 220px; width: 100%; height: auto; display: block; margin: 0 auto 6px auto;">
                <div class="brand-subtitle">New Contact Form Submission</div>
            </div>
            
            <div class="content">
                @if($submission && $submission->id)
                <div class="reference-badge">
                    <div class="reference-label">Submission Reference</div>
                    <div class="reference-number">#{{ str_pad($submission->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
                @endif

                <p class="intro">You have received a new contact form submission from your website:</p>
                
                <div class="info-card">
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
                        <div class="value">{{ $data['phone'] ?? 'Not provided' }}</div>
                    </div>
                    
                    <div class="info-row">
                        <div class="label">Subject</div>
                        <div class="value">{{ $data['subject'] ?? 'General Inquiry' }}</div>
                    </div>

                    @if($submission && $submission->ip_address)
                    <div class="info-row">
                        <div class="label">IP Address</div>
                        <div class="value">{{ $submission->ip_address }}</div>
                    </div>
                    @endif
                </div>
                
                <div class="message-card">
                    <div class="message-label">Message Content</div>
                    <div class="message-content">{{ $data['message'] ?? 'No message provided' }}</div>
                </div>
                
                <p class="timestamp">
                    ⏱ <strong>Submitted on:</strong> {{ now()->format('F j, Y \a\t g:i A') }}
                </p>
                
                @if($submission && $submission->id)
                <div class="cta-center">
                    <a href="{{ route('admin.dashboard') }}" class="btn-primary">View in Admin Dashboard</a>
                </div>
                @endif
            </div>
            
            <div class="footer">
                <p class="footer-text">&copy; {{ date('Y') }} Franklin's Forever Care. All rights reserved.</p>
                <p class="footer-text">Sent automatically from website contact form.</p>
            </div>
        </div>
    </div>
</body>
</html>
