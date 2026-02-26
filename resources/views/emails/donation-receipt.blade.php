<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Receipt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            background: linear-gradient(135deg, #2d7a5e 0%, #1a5c8a 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        .content {
            padding: 30px;
            background: #f9f9f9;
            border: 2px solid #2d7a5e;
            border-top: none;
            border-radius: 0 0 10px 10px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2d7a5e;
        }
        .details-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2d7a5e;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #555;
        }
        .detail-value {
            color: #333;
        }
        .amount {
            font-size: 24px;
            color: #2d7a5e;
            font-weight: bold;
        }
        .message {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            color: #777;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #2d7a5e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .tax-info {
            background: #e8f5e9;
            border: 1px solid #4caf50;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🙏 Thank You for Your Donation!</h1>
        <p>Yuva Maitree Foundation</p>
    </div>

    <div class="content">
        <div class="greeting">
            Dear <strong>{{ $donation->donor_name }}</strong>,
        </div>

        <p>
            Thank you so much for your generous contribution to <strong>Yuva Maitree Foundation</strong>. 
            Your support enables us to continue our mission of empowering communities through education, 
            women empowerment, and livelihood initiatives.
        </p>

        <div class="details-box">
            <h2 style="margin-top: 0; color: #2d7a5e;">Donation Details</h2>
            
            <div class="detail-row">
                <span class="detail-label">Receipt Number:</span>
                <span class="detail-value">{{ $donation->receipt_number }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Donation Amount:</span>
                <span class="amount">₹{{ number_format($donation->amount, 2) }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Date:</span>
                <span class="detail-value">{{ $donation->paid_at->format('d/m/Y, h:i A') }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Payment ID:</span>
                <span class="detail-value" style="font-family: monospace; font-size: 11px;">{{ $donation->razorpay_payment_id ?? 'N/A' }}</span>
            </div>
            
            <div class="detail-row">
                <span class="detail-label">Payment Method:</span>
                <span class="detail-value">{{ ucfirst($donation->payment_method ?? 'Online') }}</span>
            </div>
        </div>

        @if($donation->pan_number)
        <div class="tax-info">
            <strong>📄 80G Tax Exemption Certificate</strong><br>
            <small>Your tax exemption certificate under Section 80G of the Income Tax Act, 1961 
            is attached with this email. This will help you claim tax benefits on your donation.</small>
        </div>
        @endif

        <div class="message">
            <strong>Note:</strong> Your donation receipt is attached to this email as a PDF document. 
            Please save it for your records and tax purposes.
        </div>

        <p>
            Your contribution directly supports:
        </p>
        <ul>
            <li>Education programs for underprivileged children</li>
            <li>Women empowerment and skill development initiatives</li>
            <li>Healthcare and nutrition support</li>
            <li>Livelihood and community development projects</li>
        </ul>

        <p>
            We will keep you updated on how your donation is making a difference in the lives 
            of those we serve.
        </p>

        <p style="margin-top: 30px;">
            <strong>With Gratitude,</strong><br>
            <span style="color: #2d7a5e; font-size: 18px; font-style: italic;">Team Yuva Maitree Foundation</span>
        </p>
    </div>

    <div class="footer">
        <p>
            <strong>Yuva Maitree Foundation</strong><br>
            Near DAV School, Mohandari, Etawah, Uttar Pradesh - 206001<br>
            Phone: 5567357294 | Email: info@yuvamaitree.org<br>
            Website: www.yuvamaitree.org
        </p>
        <p style="margin-top: 10px; font-size: 11px;">
            This is an automated email. Please do not reply to this message.
        </p>
    </div>
</body>
</html>
