<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card — {{ $member->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
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
        .btn-back { background: #6b7280; color: #fff; }
        .btn-back:hover { background: #4b5563; }

        .cards-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .card {
            width: 340px;
            height: 540px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            position: relative;
            background: #fff;
        }

        /* ========== FRONT SIDE ========== */
        .card-front .header {
            background: linear-gradient(135deg, #f97316, #ea580c);
            padding: 12px 16px;
            text-align: center;
            color: #fff;
            position: relative;
        }
        .card-front .header .org-name {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.3;
        }
        .card-front .header .org-name-hindi {
            font-size: 13px;
            font-weight: 500;
        }
        .card-front .header .website {
            font-size: 9px;
            color: #fef3c7;
            margin-top: 2px;
        }

        .card-front .body {
            padding: 16px;
            text-align: center;
        }
        .card-front .photo-frame {
            width: 120px;
            height: 140px;
            margin: 0 auto 12px;
            border: 3px solid #ef4444;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
            background: #f3f4f6;
        }
        .card-front .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .card-front .photo-frame .placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: 700;
            color: #9ca3af;
            background: #e5e7eb;
        }

        .card-front .member-name {
            font-size: 20px;
            font-weight: 800;
            color: #1f2937;
            text-transform: uppercase;
            margin-bottom: 2px;
        }
        .card-front .member-role {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 12px;
        }

        .card-front .info-table {
            text-align: left;
            width: 100%;
        }
        .card-front .info-table tr td {
            padding: 2px 0;
            font-size: 12px;
        }
        .card-front .info-table tr td:first-child {
            color: #dc2626;
            font-weight: 700;
            width: 90px;
        }
        .card-front .info-table tr td:nth-child(2) {
            width: 12px;
            text-align: center;
            color: #dc2626;
            font-weight: 700;
        }
        .card-front .info-table tr td:last-child {
            color: #1f2937;
            font-weight: 600;
        }

        .card-front .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #16a34a, #15803d);
            padding: 8px;
            text-align: center;
        }
        .card-front .footer .contact {
            color: #fff;
            font-size: 11px;
            font-weight: 600;
        }

        /* ========== BACK SIDE ========== */
        .card-back .header {
            background: linear-gradient(135deg, #f97316, #ea580c);
            padding: 12px 16px;
            text-align: center;
            color: #fff;
        }
        .card-back .header .org-name {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.3;
        }
        .card-back .header .org-name-hindi {
            font-size: 13px;
            font-weight: 500;
        }
        .card-back .header .website {
            font-size: 9px;
            color: #fef3c7;
            margin-top: 2px;
        }

        .card-back .body {
            padding: 20px;
            min-height: 340px;
        }
        .card-back .qr-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .card-back .qr-section .qr-placeholder {
            width: 100px;
            height: 100px;
            margin: 0 auto;
            border: 2px solid #d1d5db;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f9fafb;
        }
        .card-back .qr-section .qr-placeholder svg {
            width: 80px;
            height: 80px;
            color: #374151;
        }

        .card-back .info-table {
            width: 100%;
            margin-top: 16px;
        }
        .card-back .info-table tr td {
            padding: 4px 0;
            font-size: 13px;
            vertical-align: top;
        }
        .card-back .info-table tr td:first-child {
            color: #dc2626;
            font-weight: 700;
            width: 80px;
        }
        .card-back .info-table tr td:nth-child(2) {
            width: 14px;
            text-align: center;
            color: #dc2626;
            font-weight: 700;
        }
        .card-back .info-table tr td:last-child {
            color: #1f2937;
            font-weight: 600;
        }

        .card-back .footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(135deg, #16a34a, #15803d);
            padding: 8px 12px;
            text-align: center;
        }
        .card-back .footer .office {
            color: #fff;
            font-size: 10px;
            font-weight: 500;
            line-height: 1.4;
        }
        .card-back .footer .contact {
            color: #fef3c7;
            font-size: 10px;
            font-weight: 600;
            margin-top: 2px;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 40px;
            font-weight: 900;
            color: rgba(0,0,0,0.03);
            pointer-events: none;
            white-space: nowrap;
        }

        /* ========== PRINT STYLES ========== */
        @media print {
            body { background: #fff; padding: 0; margin: 0; }
            .print-controls { display: none !important; }
            .cards-container {
                gap: 20px;
                page-break-inside: avoid;
            }
            .card {
                box-shadow: none;
                border: 1px solid #ccc;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <div class="print-controls">
        <button class="btn-print" onclick="window.print()">🖨️ Print ID Card</button>
        <a href="{{ route('shgs.members.show', [$shg, $member]) }}" class="btn-back">← Back to Member</a>
    </div>

    <div class="cards-container">

        {{-- ========== FRONT SIDE ========== --}}
        <div class="card card-front">
            <div class="header">
                <div class="org-name">Yuva Maitree Foundation</div>
                <div class="org-name-hindi">युवा मैत्री फाउंडेशन</div>
            </div>

            <div class="body">
                <div class="photo-frame">
                    @if($member->passport_photo)
                        <img src="{{ asset('storage/' . $member->passport_photo) }}" alt="{{ $member->name }}">
                    @else
                        <div class="placeholder">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                    @endif
                </div>

                <div class="member-name">{{ $member->name }}</div>
                <div class="member-role">{{ ucfirst($member->role) }}</div>

                <table class="info-table">
                    <tr>
                        <td>ID No.</td>
                        <td>:</td>
                        <td>{{ $member->id_number }}</td>
                    </tr>
                    <tr>
                        <td>Blood Group</td>
                        <td>:</td>
                        <td>{{ $member->blood_group ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td>:</td>
                        <td>{{ $member->mobile ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Valid From</td>
                        <td>:</td>
                        <td>{{ $member->valid_from ? $member->valid_from->format('d-M-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Valid To</td>
                        <td>:</td>
                        <td>{{ $member->valid_to ? $member->valid_to->format('d-M-Y') : '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="watermark">YMF</div>

            <div class="footer">
                <div class="contact">Membership ID: {{ $member->member_id_code }}</div>
            </div>
        </div>

        {{-- ========== BACK SIDE ========== --}}
        <div class="card card-back">
            <div class="header">
                <div class="org-name">Yuva Maitree Foundation</div>
                <div class="org-name-hindi">युवा मैत्री फाउंडेशन</div>
            </div>

            <div class="body">
                <div class="qr-section">
                    <div class="qr-placeholder">
                        {{-- QR Code SVG placeholder --}}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 013.75 9.375v-4.5zM3.75 14.625c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5a1.125 1.125 0 01-1.125-1.125v-4.5zM13.5 4.875c0-.621.504-1.125 1.125-1.125h4.5c.621 0 1.125.504 1.125 1.125v4.5c0 .621-.504 1.125-1.125 1.125h-4.5A1.125 1.125 0 0113.5 9.375v-4.5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 6.75h.75v.75h-.75v-.75zM6.75 16.5h.75v.75h-.75v-.75zM16.5 6.75h.75v.75H16.5v-.75zM13.5 13.5h.75v.75h-.75v-.75zM13.5 19.5h.75v.75h-.75v-.75zM19.5 13.5h.75v.75h-.75v-.75zM19.5 19.5h.75v.75h-.75v-.75zM16.5 16.5h.75v.75H16.5v-.75z" />
                        </svg>
                    </div>
                </div>

                <table class="info-table">
                    <tr>
                        <td>S/O</td>
                        <td>:</td>
                        <td>{{ $member->husband_father_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>DOB</td>
                        <td>:</td>
                        <td>{{ $member->date_of_birth ? $member->date_of_birth->format('d-M-Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>SHG</td>
                        <td>:</td>
                        <td>{{ $shg->shg_name }} ({{ $shg->shg_code ?? '' }})</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>:</td>
                        <td>{{ $member->address ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <div class="watermark">YMF</div>

            <div class="footer">
                <div class="office">Unique Form Code: {{ $member->member_id_code }}</div>
                <div class="contact">SHG: {{ $shg->shg_name }} | {{ $shg->village ?? '' }}, {{ $shg->district ?? '' }}</div>
            </div>
        </div>

    </div>

</body>
</html>
