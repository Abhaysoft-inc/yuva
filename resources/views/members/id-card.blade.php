<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FD Card — {{ $member->name }}</title>
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

        .card-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border: 2px solid #ccc;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        /* Header Banner */
        .card-header {
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            color: #fff;
            text-align: center;
            padding: 14px 20px;
            font-size: 20px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* Main Content Area */
        .card-body {
            display: table;
            width: 100%;
        }

        .card-left {
            display: table-cell;
            vertical-align: top;
        }

        .card-right {
            display: table-cell;
            vertical-align: top;
            width: 175px;
            border-left: 1px solid #bbb;
        }

        /* Details Table */
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 7px 10px;
            font-size: 13.5px;
            border: 1px solid #bbb;
            vertical-align: middle;
        }

        .details-table td.label {
            font-weight: 700;
            color: #111;
            white-space: nowrap;
            background: #f5f5f5;
            width: 140px;
        }

        .details-table td.value {
            color: #222;
            font-weight: 500;
        }

        .details-table td.label2 {
            font-weight: 700;
            color: #111;
            white-space: nowrap;
            background: #f5f5f5;
            width: 130px;
        }

        .details-table td.value2 {
            color: #222;
            font-weight: 500;
        }

        /* Photo */
        .photo-section {
            padding: 10px;
            text-align: center;
        }

        .photo-frame {
            width: 150px;
            height: 170px;
            margin: 0 auto;
            border: 2px solid #999;
            overflow: hidden;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-frame .placeholder {
            font-size: 48px;
            font-weight: 700;
            color: #9ca3af;
        }

        /* QR Code */
        .qr-section {
            padding: 8px 10px;
            text-align: center;
        }

        .qr-frame {
            width: 110px;
            height: 110px;
            margin: 0 auto;
        }

        .qr-frame img {
            width: 100%;
            height: 100%;
        }

        /* Footer */
        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            padding: 20px 20px 12px;
            border-top: 1px solid #bbb;
            min-height: 70px;
        }

        .signature-area {
            font-size: 13px;
            color: #555;
            font-weight: 600;
            border-top: 1px dashed #999;
            padding-top: 6px;
            min-width: 260px;
            text-align: center;
        }

        .office-area {
            font-size: 13px;
            color: #555;
            font-weight: 600;
            text-align: right;
        }

        /* Print Styles */
        @media print {
            body { background: #fff; padding: 10px; margin: 0; }
            .print-controls { display: none !important; }
            .card-container {
                box-shadow: none;
                border: 1px solid #999;
                max-width: 100%;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }

        @page {
            size: A4 landscape;
            margin: 15mm;
        }
    </style>
</head>
<body>

    <div class="print-controls">
        <button class="btn-print" onclick="window.print()">🖨️ Print FD Card</button>
        <a href="{{ route('shgs.members.fd-card.pdf', [$shg, $member]) }}" class="btn-download">📥 Download PDF</a>
        <a href="{{ route('shgs.members.show', [$shg, $member]) }}" class="btn-back">← Back to Member</a>
    </div>

    <div class="card-container">
        {{-- Header --}}
        <div class="card-header">
            {{ strtoupper($shg->shg_name ?? 'YUVA MAITREE FOUNDATION') }}
        </div>

        {{-- Body --}}
        <div class="card-body">
            {{-- Left: Details Table --}}
            <div class="card-left">
                <table class="details-table">
                    <tr>
                        <td class="label">SHG Group Code</td>
                        <td class="value" colspan="3">{{ $shg->shg_code ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Member Name:</td>
                        <td class="value" colspan="3">{{ $member->name }}</td>
                    </tr>
                    <tr>
                        <td class="label">Father / Husband<br>Name.</td>
                        <td class="value" colspan="3">{{ strtoupper($member->husband_father_name ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Address</td>
                        <td class="value" colspan="3">{{ strtoupper($member->address ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Contact No.</td>
                        <td class="value" colspan="3">{{ $member->mobile ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">PAN No.</td>
                        <td class="value" colspan="3">{{ strtoupper($member->pan_number ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Aadhar No.</td>
                        <td class="value" colspan="3">{{ $member->member_id_code ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">FD Amount</td>
                        <td class="value">Rs. {{ $member->fd_amount ? number_format($member->fd_amount, 0) : '0' }} — Auto</td>
                        <td class="label2">Interest Rate</td>
                        <td class="value2">{{ $member->fd_interest_rate ?? '12' }}% p.a.</td>
                    </tr>
                    <tr>
                        <td class="label">FD Start Date</td>
                        <td class="value">{{ $member->fd_start_date ? $member->fd_start_date->format('d/m/Y') : '-' }}</td>
                        <td class="label2">FD Maturity Date</td>
                        <td class="value2">{{ $member->fd_maturity_date ? $member->fd_maturity_date->format('d/m/Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Maturity Amount</td>
                        <td class="value">Rs. {{ $member->fd_maturity_amount ? number_format($member->fd_maturity_amount, 2) : '0.00' }} — Auto</td>
                        <td class="label2">Bank Name:</td>
                        <td class="value2">{{ strtoupper($member->bank_name ?? '-') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Bank Name</td>
                        <td class="value">{{ strtoupper($member->bank_name ?? '-') }}</td>
                        <td class="label2">IFSC Code</td>
                        <td class="value2">{{ strtoupper($member->ifsc_code ?? '-') }}</td>
                    </tr>
                </table>
            </div>

            {{-- Right: Photo + QR --}}
            <div class="card-right">
                <div class="photo-section">
                    <div class="photo-frame">
                        @if($member->passport_photo)
                            <img src="{{ asset('storage/' . $member->passport_photo) }}" alt="{{ $member->name }}">
                        @else
                            <div class="placeholder">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                        @endif
                    </div>
                </div>
                <div class="qr-section">
                    <div class="qr-frame">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($member->member_id_code . ' | ' . $member->name . ' | ' . ($shg->shg_name ?? '') . ' | ' . ($member->mobile ?? '')) }}" alt="QR Code">
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="card-footer">
            <div class="signature-area">
                Member Signature / Thumb Impression
            </div>
            <div class="office-area">
                For Office Use Only
            </div>
        </div>
    </div>

</body>
</html>
