<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff ID Card — {{ $staffApplication->name }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 30mm;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; }

        .card {
            width: 100%;
            background: #fff;
            border: 3px solid #1b6a3c;
            margin-bottom: 20px;
        }

        /* Header */
        .card-header-table {
            width: 100%;
            background: #f0fdf4;
            border-bottom: 3px solid #1b6a3c;
        }
        .card-header-table td {
            padding: 12px 15px;
            vertical-align: middle;
        }
        .logo-cell {
            width: 65px;
        }
        .logo-cell img {
            width: 60px;
            height: 60px;
        }
        .org-name-hi {
            font-size: 20px;
            font-weight: 800;
            color: #14532d;
        }
        .org-name-en {
            font-size: 14px;
            font-weight: 700;
            color: #166534;
        }

        /* Green bar */
        .green-bar {
            background: #16a34a;
            height: 8px;
        }

        /* Photo section */
        .photo-section {
            text-align: center;
            padding: 14px 0 8px;
        }
        .photo-section img {
            width: 130px;
            height: 160px;
            object-fit: cover;
            border: 3px solid #1b6a3c;
        }
        .photo-placeholder {
            display: inline-block;
            width: 130px;
            height: 160px;
            background: #f3f4f6;
            border: 3px solid #1b6a3c;
            text-align: center;
            line-height: 160px;
            font-size: 46px;
            font-weight: 700;
            color: #999;
        }

        /* ID Code */
        .id-code {
            text-align: center;
            padding: 6px 0 2px;
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
        }

        /* Name */
        .staff-name {
            text-align: center;
            padding: 2px 0 6px;
            font-size: 24px;
            font-weight: 900;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Designation */
        .designation-row {
            text-align: center;
            padding: 0 0 8px;
        }
        .designation-badge {
            display: inline-block;
            border: 2px solid #1b6a3c;
            border-radius: 16px;
            padding: 4px 18px;
            font-size: 13px;
            font-weight: 700;
            color: #14532d;
        }

        /* Contact rows */
        .contact-table {
            width: 100%;
            border-collapse: collapse;
        }
        .contact-table td {
            padding: 4px 20px;
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            vertical-align: middle;
        }
        .contact-label {
            font-weight: 800;
            color: #14532d;
            text-transform: uppercase;
        }

        /* Website footer */
        .card-website {
            background: #14532d;
            color: #fff;
            text-align: center;
            padding: 8px;
            font-size: 14px;
            font-weight: 700;
        }

        /* Back card */
        .back-header {
            background: #1b6a3c;
            color: #fff;
            text-align: center;
            padding: 8px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }
        .details-table td {
            padding: 4px 15px;
            font-size: 11px;
            vertical-align: top;
        }
        .details-table .label {
            font-weight: 700;
            color: #555;
            width: 90px;
        }
        .details-table .value {
            color: #111;
            font-weight: 600;
        }

        .qr-section {
            text-align: center;
            padding: 6px 0;
        }
        .qr-section img {
            width: 90px;
            height: 90px;
        }

        .footer-table {
            width: 100%;
            border-top: 1px solid #bbb;
        }
        .footer-table td {
            padding: 12px 15px 8px;
            font-size: 10px;
            color: #555;
            font-weight: 600;
            vertical-align: bottom;
        }
        .footer-left {
            border-top: 1px dashed #999;
            padding-top: 3px;
            text-align: center;
            width: 140px;
        }
        .footer-right {
            text-align: right;
        }
    </style>
</head>
<body>

    {{-- Front Card --}}
    <div class="card">
        {{-- Header with logo --}}
        <table class="card-header-table">
            <tr>
                <td class="logo-cell">
                    <img src="{{ public_path('images/logo.png') }}" alt="Logo">
                </td>
                <td>
                    <div class="org-name-hi">युवा मैत्री फाउंडेशन</div>
                    <div class="org-name-en">Yuva Maitree Foundation</div>
                </td>
            </tr>
        </table>

        <div class="green-bar"></div>

        {{-- Photo --}}
        <div class="photo-section">
            @if($staffApplication->passport_photo)
                <img src="{{ public_path('storage/' . $staffApplication->passport_photo) }}" alt="{{ $staffApplication->name }}">
            @else
                <div class="photo-placeholder">{{ strtoupper(substr($staffApplication->name, 0, 1)) }}</div>
            @endif
        </div>

        {{-- ID Code --}}
        <div class="id-code">ID: {{ str_replace('/', '-', $staffApplication->staff_id_code) }}</div>

        {{-- Name --}}
        <div class="staff-name">{{ $staffApplication->name }}</div>

        {{-- Designation --}}
        <div class="designation-row">
            <span class="designation-badge">{{ $staffApplication->designation ?? 'Staff Member' }}</span>
        </div>

        {{-- Contact Info --}}
        <table class="contact-table">
            <tr>
                <td><span class="contact-label">MOBILE:</span> {{ $staffApplication->mobile ?? '-' }}</td>
            </tr>
            <tr>
                <td style="font-size: 12px;">{{ $staffApplication->email ?? '-' }}</td>
            </tr>
            <tr>
                <td><span class="contact-label">DATE OF JOINING:</span> {{ $staffApplication->valid_from ? $staffApplication->valid_from->format('d/m/Y') : '-' }}</td>
            </tr>
        </table>

        {{-- Website --}}
        <div class="card-website">www.yuvamaitree.org.in</div>
    </div>

    {{-- Back Card --}}
    <div class="card">
        <div class="back-header">STAFF IDENTITY CARD — BACK</div>

        <table class="details-table">
            <tr>
                <td class="label">Address:</td>
                <td class="value">{{ strtoupper($staffApplication->address ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Aadhar No.:</td>
                <td class="value">{{ $staffApplication->aadhar_number ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">PAN No.:</td>
                <td class="value">{{ strtoupper($staffApplication->pan_number ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Bank:</td>
                <td class="value">{{ strtoupper($staffApplication->bank_name ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Account No.:</td>
                <td class="value">{{ $staffApplication->account_number ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">IFSC Code:</td>
                <td class="value">{{ strtoupper($staffApplication->ifsc_code ?? '-') }}</td>
            </tr>
            <tr>
                <td class="label">Blood Group:</td>
                <td class="value">{{ $staffApplication->blood_group ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Valid Till:</td>
                <td class="value">{{ $staffApplication->valid_to ? $staffApplication->valid_to->format('d/m/Y') : '-' }}</td>
            </tr>
        </table>

        <div class="qr-section">
            @if(!empty($qrBase64))
                <img src="{{ $qrBase64 }}" alt="QR">
            @endif
        </div>

        <table class="footer-table">
            <tr>
                <td>
                    <div class="footer-left">Holder's Signature</div>
                </td>
                <td class="footer-right">
                    Authorized Signatory<br>
                    Yuva Maitree Foundation
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
