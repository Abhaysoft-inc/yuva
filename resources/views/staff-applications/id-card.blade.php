<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff ID Card — {{ $staffApplication->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, 'Segoe UI', sans-serif;
            background: #f3f4f6;
            padding: 20px;
        }

        .print-controls {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-controls button, .print-controls a {
            display: inline-block;
            padding: 10px 24px;
            margin: 0 8px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
        }
        .btn-print { background: #4f46e5; color: #fff; }
        .btn-print:hover { background: #4338ca; }
        .btn-download { background: #059669; color: #fff; }
        .btn-download:hover { background: #047857; }
        .btn-back { background: #6b7280; color: #fff; }
        .btn-back:hover { background: #4b5563; }

        .card-wrapper {
            max-width: 480px;
            margin: 0 auto;
        }

        .card {
            background: #fff;
            border: 2px solid #ccc;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 24px;
        }

        /* Front Card */
        .card-header {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: #fff;
            text-align: center;
            padding: 14px 20px 10px;
        }
        .card-header .org-name {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }
        .card-header .subtitle {
            font-size: 11px;
            opacity: 0.85;
            margin-top: 2px;
        }

        .card-body {
            display: flex;
            padding: 16px 20px;
            gap: 20px;
        }

        .photo-section {
            flex-shrink: 0;
        }
        .photo-frame {
            width: 110px;
            height: 130px;
            border: 2px solid #1e3a8a;
            border-radius: 6px;
            overflow: hidden;
            background: #f3f4f6;
        }
        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .photo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: 700;
            color: #999;
        }

        .info-section {
            flex: 1;
        }
        .info-section table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-section td {
            padding: 3px 0;
            font-size: 12px;
            vertical-align: top;
        }
        .info-section .label {
            color: #666;
            font-weight: 600;
            width: 85px;
            white-space: nowrap;
        }
        .info-section .value {
            color: #111;
            font-weight: 700;
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

        /* Back Card */
        .card-back-body {
            padding: 16px 20px;
        }
        .card-back-body table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        .card-back-body td {
            padding: 4px 0;
            font-size: 12px;
            vertical-align: top;
        }
        .card-back-body .label {
            color: #666;
            font-weight: 600;
            width: 110px;
        }
        .card-back-body .value {
            color: #111;
            font-weight: 600;
        }

        .qr-section {
            text-align: center;
            margin: 8px 0;
        }
        .qr-section img {
            width: 100px;
            height: 100px;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 10px 20px 14px;
            border-top: 1px solid #ddd;
        }
        .signature-area {
            border-top: 1px dashed #999;
            padding-top: 4px;
            text-align: center;
            font-size: 10px;
            color: #666;
            width: 150px;
        }
        .office-stamp {
            text-align: right;
            font-size: 10px;
            color: #666;
            font-weight: 600;
        }

        .validity {
            background: #f0fdf4;
            border-top: 1px solid #ddd;
            text-align: center;
            padding: 6px;
            font-size: 11px;
            color: #166534;
            font-weight: 600;
        }

        @media print {
            body { background: none; padding: 0; }
            .print-controls { display: none; }
            .card { break-inside: avoid; box-shadow: none; }
        }
    </style>
</head>
<body>

    <div class="print-controls">
        <button class="btn-print" onclick="window.print()">🖨️ Print ID Card</button>
        <a href="{{ route('staff-applications.id-card.pdf', $staffApplication) }}" class="btn-download">📥 Download PDF</a>
        <a href="{{ route('staff-applications.show', $staffApplication) }}" class="btn-back">← Back</a>
    </div>

    <div class="card-wrapper">
        {{-- Front --}}
        <div class="card">
            <div class="card-header">
                <div class="org-name">YUVA MAITREE FOUNDATION</div>
                <div class="subtitle">युवा मैत्री फाउंडेशन</div>
            </div>

            <div class="card-body">
                <div class="photo-section">
                    <div class="photo-frame">
                        @if($staffApplication->passport_photo)
                            <img src="{{ asset('storage/' . $staffApplication->passport_photo) }}" alt="{{ $staffApplication->name }}">
                        @else
                            <div class="photo-placeholder">{{ strtoupper(substr($staffApplication->name, 0, 1)) }}</div>
                        @endif
                    </div>
                </div>

                <div class="info-section">
                    <table>
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
                    </table>
                </div>
            </div>

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
            <div class="card-header">
                <div class="org-name" style="font-size: 14px;">STAFF IDENTITY CARD — BACK</div>
            </div>

            <div class="card-back-body">
                <table>
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

                <div class="qr-section">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($staffApplication->staff_id_code . ' | ' . $staffApplication->name . ' | STAFF | ' . ($staffApplication->mobile ?? '')) }}" alt="QR Code">
                </div>
            </div>

            <div class="card-footer">
                <div class="signature-area">
                    Holder's Signature
                </div>
                <div class="office-stamp">
                    Authorized Signatory<br>
                    Yuva Maitree Foundation
                </div>
            </div>
        </div>
    </div>

</body>
</html>
