<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation Receipt - {{ $donation->receipt_number }}</title>
    <style>
        @page {
            margin: 12mm;
            size: A4;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 9.5px;
            line-height: 1.3;
            color: #000;
        }
        .outer-border {
            border: 8px solid #2d7a5e;
            padding: 2px;
        }
        .inner-border {
            border: 1.5px solid #2d7a5e;
            padding: 16px;
        }
        .header {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }
        .header-left {
            display: table-cell;
            width: 60%;
            vertical-align: top;
        }
        .header-right {
            display: table-cell;
            width: 40%;
            vertical-align: top;
            text-align: right;
        }
        .org-name {
            font-size: 18px;
            font-weight: bold;
            color: #2d7a5e;
            margin-bottom: 5px;
            letter-spacing: 1.5px;
        }
        .org-details {
            font-size: 8px;
            line-height: 1.5;
            color: #333;
        }
        .logo-section {
            text-align: center;
        }
        .logo {
            width: 90px;
            height: 90px;
            margin-bottom: 3px;
        }
        .iso-cert {
            font-size: 7px;
            color: #333;
            font-weight: bold;
        }
        .divider {
            border-bottom: 1.5px solid #2d7a5e;
            margin: 6px 0;
        }
        .receipt-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            color: #2d7a5e;
            margin: 10px 0 12px 0;
        }
        .receipt-info {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .receipt-left {
            display: table-cell;
            width: 50%;
        }
        .receipt-right {
            display: table-cell;
            width: 50%;
            text-align: right;
        }
        .info-row {
            margin-bottom: 7px;
            line-height: 1.4;
        }
        .info-label {
            display: inline-block;
            width: 130px;
            font-weight: normal;
        }
        .info-value {
            display: inline-block;
            font-weight: normal;
        }
        .info-value-bold {
            font-weight: bold;
            text-decoration: underline;
        }
        .amount-row {
            margin: 10px 0;
        }
        .thank-you-section {
            text-align: center;
            margin: 10px 0;
            font-size: 9px;
            line-height: 1.4;
        }
        .note-section {
            margin: 10px 0;
            font-size: 8.5px;
            line-height: 1.4;
        }
        .note-title {
            font-weight: bold;
            margin-bottom: 3px;
        }
        .bottom-section {
            display: table;
            width: 100%;
            margin-top: 12px;
        }
        .qr-box {
            display: table-cell;
            width: 48%;
            border: 1.5px solid #2d7a5e;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }
        .signature-box {
            display: table-cell;
            width: 48%;
            border: 1.5px solid #2d7a5e;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
            margin-left: 4%;
        }
        .box-title {
            font-weight: bold;
            font-size: 9px;
            margin-bottom: 5px;
        }
        .signature-text {
            font-family: 'Brush Script MT', cursive, 'DejaVu Sans';
            font-size: 18px;
            color: #1a5c8a;
            font-style: italic;
            margin: 6px 0;
        }
        .signature-label {
            font-size: 8px;
            margin-top: 5px;
            font-weight: bold;
        }
        .contact-section {
            margin-top: 12px;
            padding-top: 8px;
            border-top: 1.5px solid #2d7a5e;
            text-align: center;
        }
        .contact-title {
            font-weight: bold;
            font-size: 9.5px;
            color: #2d7a5e;
            margin-bottom: 4px;
            letter-spacing: 2px;
        }
        .contact-details {
            font-size: 8px;
            line-height: 1.5;
        }
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 90px;
            color: rgba(45, 122, 94, 0.03);
            font-weight: bold;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="watermark">YUVA MAITREE FOUNDATION</div>
    
    <div class="outer-border">
        <div class="inner-border">
            {{-- Header Section --}}
            <div class="header">
                <div class="header-left">
                    <div class="org-name">YUVA MAITREE FOUNDATION</div>
                    <div class="org-details">
                        <strong>REGD NO:</strong> U88900UP2025NPL237230<br>
                        <strong>12 ACT REGD NO:</strong> AACCY1166EE20251<br>
                        <strong>PAN NO:</strong> AACCY1166E<br>
                        <strong>ALL DONATION ARE EXEMPTED U/S 80G OF<br>INCOME TAX ACT,1961</strong>
                    </div>
                </div>
                <div class="header-right">
                    <div class="logo-section">
                        @php
                            $logoPng = public_path('images/logo.png');
                            $logoWebp = public_path('images/logo.webp');
                            $logoPath = file_exists($logoPng) ? $logoPng : (file_exists($logoWebp) ? $logoWebp : null);
                        @endphp
                        @if($logoPath)
                            <img src="file://{{ str_replace('\\', '/', $logoPath) }}" alt="Yuva Maitree Foundation Logo" class="logo">
                        @else
                            <div style="width: 90px; height: 90px; margin: 0 auto 3px; border: 2px solid #2d7a5e; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 24px; color: #2d7a5e;">YMF</div>
                        @endif
                        <div style="font-size: 10px; font-weight: bold; color: #2d7a5e; margin-top: 3px;">Yuva Maitree Foundation</div>
                        
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            {{-- Receipt Title --}}
            <div class="receipt-title">Donation Receipt</div>

            {{-- Receipt Number and Date --}}
            <div class="receipt-info">
                <div class="receipt-left">
                    <strong>Receipt No: <span class="info-value-bold">{{ $donation->receipt_number }}</span></strong>
                </div>
                <div class="receipt-right">
                    <strong>Date: <span class="info-value-bold">{{ $donation->paid_at->format('d-m-Y') }}</span></strong>
                </div>
            </div>

            {{-- Donor Details --}}
            <div class="info-row">
                <span class="info-label">Donor Name</span>
                <span class="info-value">: <span class="info-value-bold">{{ strtoupper($donation->donor_name) }}</span></span>
            </div>

            <div class="info-row amount-row">
                <span class="info-label">Amount (in words)</span>
                <span class="info-value">: <span class="info-value-bold">{{ number_format($donation->amount, 0) }}/- ( {{ ucwords(\App\Helpers\NumberToWords::convert($donation->amount)) }} )</span></span>
            </div>

            <div class="info-row">
                <span class="info-label">Mobile No</span>
                <span class="info-value">: {{ $donation->phone }}</span>
            </div>

            @if($donation->address || $donation->city || $donation->state || $donation->pincode)
            <div class="info-row">
                <span class="info-label">Address</span>
                <span class="info-value">: 
                    @if($donation->address){{ $donation->address }}@endif
                    @if($donation->city), {{ $donation->city }}@endif
                    @if($donation->state), {{ $donation->state }}@endif
                    @if($donation->pincode) - {{ $donation->pincode }}@endif
                </span>
            </div>
            @endif

            @if($donation->pan_number)
            <div class="info-row">
                <span class="info-label">PAN No</span>
                <span class="info-value">: {{ strtoupper($donation->pan_number) }}</span>
            </div>
            @endif

            <div class="receipt-info" style="margin-top: 10px;">
                <div class="receipt-left">
                    <div class="info-row" style="margin-bottom: 0;">
                        <span class="info-label">Donation Date</span>
                        <span class="info-value">: {{ $donation->paid_at->format('d-m-Y') }}</span>
                    </div>
                    <div class="info-row" style="margin-bottom: 0;">
                        <span class="info-label">Date of Birth</span>
                        <span class="info-value">: </span>
                    </div>
                </div>
                <div class="receipt-right">
                    <div class="info-row" style="margin-bottom: 0; text-align: right;">
                        <span class="info-label">Payment Mode</span>
                        <span class="info-value">: {{ ucfirst($donation->payment_method ?? 'Online') }}</span>
                    </div>
                    <div class="info-row" style="margin-bottom: 0; text-align: right;">
                        <span class="info-label">Payment ID</span>
                        <span class="info-value">: {{ substr($donation->razorpay_payment_id ?? 'N/A', 0, 20) }}</span>
                    </div>
                </div>
            </div>

            {{-- Thank You Message --}}
            <div class="thank-you-section">
                <strong>Thank you so much for contributing to YUVA MAITREE FOUNDATION.</strong> We express our as this donation benefits food, medicine, education, women empowerment & livelihoods needs of disadvantaged and orphaned children.
            </div>

            {{-- Note Section --}}
            <div class="note-section">
                <div class="note-title">NOTE: ALL DONATION ARE EXEMPTED U/S 80G OF INCOME TAX ACT,1961</div>
                This document is only an acknowledgement of your payment. If you have donated to an organization, which is offering tax-exemption, you will receive the same from the non-profit within a month of your transaction. Please consider this as your transaction receipt for future reference.
            </div>

            {{-- Bottom Section with QR and Signature --}}
            <div class="bottom-section">
                <div class="qr-box">
                    <div class="box-title">Scan here for<br>E-Receipt</div>
                    <div style="height: 60px; display: flex; align-items: center; justify-content: center;">
                        @if(!empty($qrCodeDataUri))
                            <img src="{{ $qrCodeDataUri }}" alt="E-Receipt QR Code" style="width: 60px; height: 60px;">
                        @else
                            <div style="width: 60px; height: 60px; border: 1.5px solid #ccc; display: flex; align-items: center; justify-content: center; font-size: 7px; color: #999; text-align: center; padding: 3px;">
                                QR Code<br>{{ $donation->receipt_number }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="signature-box" style="margin-left: 4%;">
                    <div class="box-title">FOR YUVA MAITREE FOUNDATION</div>
                    <div style="font-style: italic; font-size: 8px; margin-bottom: 3px;">For YUVA MAITREE FOUNDATION</div>
                    <div class="signature-text">Asfaq Ansari</div>
                    <div class="signature-label">AUTHORIZED SIGNATORY</div>
                </div>
            </div>

            {{-- Contact Section --}}
            <div class="contact-section">
                <div class="contact-title">CONTACT US</div>
                <div class="contact-details">
                    <strong>+91 5567357294 | info@yuvamaitree.org</strong><br>
                    <strong>Ward No: 02, YUVA MAITREE FOUNDATION, Abdul Hamid Nagar, Hata, Uttar Pradesh - 274203 | www.yuvamaitree.org</strong>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
