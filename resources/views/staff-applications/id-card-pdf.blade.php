<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff ID Card — {{ $staffApplication->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; }

        .card {
            width: 100%;
            background: #fff;
            border: 2px solid #999;
            margin-bottom: 30px;
        }

        .card-header {
            background: #1e3a8a;
            color: #fff;
            text-align: center;
            padding: 12px 20px;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .card-header .subtitle {
            font-size: 11px;
            font-weight: 400;
            opacity: 0.85;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
        }
        .main-table > tr > td {
            vertical-align: top;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            padding: 5px 8px;
            font-size: 12px;
            border: 1px solid #ccc;
            vertical-align: middle;
        }
        .details-table .label {
            background: #f3f4f6;
            font-weight: 700;
            color: #555;
            width: 90px;
        }
        .details-table .value {
            color: #111;
            font-weight: 600;
        }

        .photo-cell {
            width: 130px;
            padding: 10px;
            text-align: center;
        }
        .photo-cell img {
            width: 110px;
            height: 130px;
            object-fit: cover;
            border: 2px solid #1e3a8a;
        }
        .photo-placeholder {
            width: 110px;
            height: 130px;
            background: #f3f4f6;
            border: 2px solid #1e3a8a;
            text-align: center;
            line-height: 130px;
            font-size: 36px;
            font-weight: 700;
            color: #999;
        }

        .qr-code {
            margin-top: 8px;
        }
        .qr-code img {
            width: 90px;
            height: 90px;
        }

        .id-badge {
            background: #1e3a8a;
            color: #fff;
            text-align: center;
            padding: 6px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .validity {
            background: #f0fdf4;
            text-align: center;
            padding: 5px;
            font-size: 11px;
            color: #166534;
            font-weight: 600;
            border-top: 1px solid #ccc;
        }

        .card-footer {
            border-top: 1px solid #bbb;
            padding: 14px 15px 10px;
        }
        .footer-table {
            width: 100%;
        }
        .footer-table td {
            font-size: 11px;
            color: #555;
            font-weight: 600;
            vertical-align: bottom;
        }
        .footer-left {
            border-top: 1px dashed #999;
            padding-top: 4px;
            text-align: center;
            width: 150px;
        }
        .footer-right {
            text-align: right;
        }
    </style>
</head>
<body>

    {{-- Front --}}
    <div class="card">
        <div class="card-header">
            YUVA MAITREE FOUNDATION
            <div class="subtitle">युवा मैत्री फाउंडेशन</div>
        </div>

        <table class="main-table">
            <tr>
                <td>
                    <table class="details-table">
                        <tr>
                            <td class="label">Name:</td>
                            <td class="value">{{ strtoupper($staffApplication->name) }}</td>
                        </tr>
                        <tr>
                            <td class="label">Father/H:</td>
                            <td class="value">{{ strtoupper($staffApplication->husband_father_name ?? '-') }}</td>
                        </tr>
                        <tr>
                            <td class="label">DOB:</td>
                            <td class="value">{{ $staffApplication->date_of_birth ? $staffApplication->date_of_birth->format('d/m/Y') : '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Blood:</td>
                            <td class="value">{{ $staffApplication->blood_group ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Mobile:</td>
                            <td class="value">{{ $staffApplication->mobile ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="label">Designation:</td>
                            <td class="value">{{ strtoupper($staffApplication->designation ?? 'STAFF MEMBER') }}</td>
                        </tr>
                        <tr>
                            <td class="label">Address:</td>
                            <td class="value">{{ strtoupper($staffApplication->address ?? '-') }}</td>
                        </tr>
                    </table>
                </td>
                <td class="photo-cell">
                    @if($staffApplication->passport_photo)
                        <img src="{{ public_path('storage/' . $staffApplication->passport_photo) }}" alt="{{ $staffApplication->name }}">
                    @else
                        <div class="photo-placeholder">{{ strtoupper(substr($staffApplication->name, 0, 1)) }}</div>
                    @endif

                    <div class="qr-code">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($staffApplication->staff_id_code . ' | ' . $staffApplication->name . ' | STAFF | ' . ($staffApplication->mobile ?? '')) }}" alt="QR">
                    </div>
                </td>
            </tr>
        </table>

        <div class="id-badge">
            STAFF ID: {{ $staffApplication->staff_id_code }}
        </div>

        <div class="validity">
            Valid: {{ $staffApplication->valid_from ? $staffApplication->valid_from->format('d/m/Y') : '-' }}
            to {{ $staffApplication->valid_to ? $staffApplication->valid_to->format('d/m/Y') : '-' }}
        </div>
    </div>

    {{-- Back --}}
    <div class="card">
        <div class="card-header" style="font-size: 14px;">
            STAFF IDENTITY CARD — BACK
        </div>

        <div style="padding: 12px 15px;">
            <table class="details-table">
                <tr>
                    <td class="label">Aadhar No.:</td>
                    <td class="value">{{ $staffApplication->aadhar_number ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">PAN No.:</td>
                    <td class="value">{{ strtoupper($staffApplication->pan_number ?? '-') }}</td>
                </tr>
                <tr>
                    <td class="label">Email:</td>
                    <td class="value">{{ $staffApplication->email ?? '-' }}</td>
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
            </table>
        </div>

        <div class="card-footer">
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
    </div>

</body>
</html>
