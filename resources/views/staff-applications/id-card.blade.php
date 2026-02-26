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
            max-width: 400px;
            margin: 0 auto;
        }

        .card {
            background: #fff;
            border: 3px solid #1b6a3c;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            margin-bottom: 24px;
            position: relative;
        }

        /* Header with logo and org name */
        .card-header {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            padding: 18px 20px 12px;
            display: flex;
            align-items: center;
            gap: 14px;
            border-bottom: 3px solid #1b6a3c;
        }
        .card-header .logo {
            width: 70px;
            height: 70px;
            flex-shrink: 0;
        }
        .card-header .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .card-header .org-info {
            flex: 1;
        }
        .card-header .org-name-hi {
            font-size: 22px;
            font-weight: 800;
            color: #14532d;
            line-height: 1.2;
        }
        .card-header .org-name-en {
            font-size: 15px;
            font-weight: 700;
            color: #166534;
            margin-top: 2px;
        }

        /* Green wave decoration */
        .wave-decoration {
            height: 20px;
            background: linear-gradient(90deg, #16a34a, #22c55e, #16a34a);
            clip-path: ellipse(55% 100% at 50% 0%);
        }

        /* Photo section */
        .photo-section {
            text-align: center;
            padding: 16px 20px 10px;
        }
        .photo-frame {
            width: 150px;
            height: 180px;
            border: 3px solid #1b6a3c;
            border-radius: 8px;
            overflow: hidden;
            display: inline-block;
            background: #f3f4f6;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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
            font-size: 50px;
            font-weight: 700;
            color: #999;
        }

        /* ID Code */
        .id-code {
            text-align: center;
            padding: 8px 20px 4px;
            font-size: 16px;
            font-weight: 700;
            color: #1f2937;
            letter-spacing: 0.5px;
        }

        /* Name */
        .staff-name {
            text-align: center;
            padding: 2px 20px 6px;
            font-size: 26px;
            font-weight: 900;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Designation badge */
        .designation-badge {
            text-align: center;
            padding: 0 40px 10px;
        }
        .designation-badge span {
            display: inline-block;
            background: #fff;
            border: 2px solid #1b6a3c;
            border-radius: 20px;
            padding: 6px 20px;
            font-size: 14px;
            font-weight: 700;
            color: #14532d;
            letter-spacing: 0.5px;
        }

        /* Contact info */
        .contact-info {
            padding: 8px 24px 10px;
        }
        .contact-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 5px 0;
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
        }
        .contact-row .icon {
            width: 28px;
            height: 28px;
            background: #14532d;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .contact-row .icon svg {
            width: 14px;
            height: 14px;
            fill: #fff;
        }
        .contact-row .contact-label {
            font-weight: 800;
            color: #14532d;
            text-transform: uppercase;
            margin-right: 2px;
        }

        /* Website footer */
        .card-website {
            background: #14532d;
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Back Card */
        .card-back-header {
            background: linear-gradient(135deg, #1b6a3c, #16a34a);
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .card-back-body {
            padding: 16px 20px;
        }
        .card-back-body table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        .card-back-body td {
            padding: 4px 0;
            font-size: 12px;
            vertical-align: top;
        }
        .card-back-body .label {
            color: #666;
            font-weight: 600;
            width: 100px;
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
            {{-- Header with logo --}}
            <div class="card-header">
                <div class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="YMF Logo">
                </div>
                <div class="org-info">
                    <div class="org-name-hi">युवा मैत्री फाउंडेशन</div>
                    <div class="org-name-en">Yuva Maitree Foundation</div>
                </div>
            </div>

            {{-- Green wave --}}
            <div class="wave-decoration"></div>

            {{-- Photo --}}
            <div class="photo-section">
                <div class="photo-frame">
                    @if($staffApplication->passport_photo)
                        <img src="{{ asset('storage/' . $staffApplication->passport_photo) }}" alt="{{ $staffApplication->name }}">
                    @else
                        <div class="photo-placeholder">{{ strtoupper(substr($staffApplication->name, 0, 1)) }}</div>
                    @endif
                </div>
            </div>

            {{-- ID Code --}}
            <div class="id-code">
                ID: {{ str_replace('/', '-', $staffApplication->staff_id_code) }}
            </div>

            {{-- Name --}}
            <div class="staff-name">{{ $staffApplication->name }}</div>

            {{-- Designation --}}
            <div class="designation-badge">
                <span>{{ $staffApplication->designation ?? 'Staff Member' }}</span>
            </div>

            {{-- Contact Info --}}
            <div class="contact-info">
                {{-- Mobile --}}
                <div class="contact-row">
                    <div class="icon">
                        <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                    </div>
                    <div><span class="contact-label">MOBILE:</span>{{ $staffApplication->mobile ?? '-' }}</div>
                </div>

                {{-- Email --}}
                <div class="contact-row">
                    <div class="icon">
                        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    </div>
                    <div style="font-size: 13px;">{{ $staffApplication->email ?? '-' }}</div>
                </div>

                {{-- Date of Joining --}}
                <div class="contact-row">
                    <div class="icon">
                        <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <div><span class="contact-label">DATE OF JOINING:</span>{{ $staffApplication->valid_from ? $staffApplication->valid_from->format('d/m/Y') : '-' }}</div>
                </div>
            </div>

            {{-- Website --}}
            <div class="card-website">www.yuvamaitree.org.in</div>
        </div>

        {{-- Back --}}
        <div class="card">
            <div class="card-back-header">STAFF IDENTITY CARD — BACK</div>

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
                    {!! \SimpleSoftwareIo\QrCode\Facades\QrCode::size(200)->generate($staffApplication->staff_id_code . ' | ' . $staffApplication->name . ' | STAFF | ' . ($staffApplication->mobile ?? '')) !!}
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
