<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FD Card — {{ $member->name }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 15mm;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
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
            max-width: 800px;
            margin: 0 auto;
        }

        .card-container {
            width: 100%;
            background: #fff;
            border: 3px solid #333;
        }

        /* Header Banner */
        .card-header {
            background: #1e3a8a;
            color: #fff;
            text-align: center;
            padding: 12px 15px;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Main table */
        .main-table {
            width: 100%;
            border-collapse: collapse;
        }

        .main-table > tbody > tr > td,
        .main-table > tr > td {
            vertical-align: top;
        }

        /* Details Table */
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table td {
            padding: 5px 8px;
            font-size: 13px;
            border: 1px solid #bbb;
            vertical-align: middle;
        }

        .details-table td.label {
            font-weight: 700;
            color: #111;
            white-space: nowrap;
            background: #f5f5f5;
            width: 120px;
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
            width: 110px;
        }

        .details-table td.value2 {
            color: #222;
            font-weight: 500;
        }

        /* Photo */
        .photo-cell {
            width: 150px;
            border-left: 1px solid #bbb;
            text-align: center;
            padding: 8px 8px;
        }

        .photo-cell img {
            width: 120px;
            height: 140px;
            object-fit: cover;
            border: 2px solid #999;
        }

        .photo-placeholder {
            width: 120px;
            height: 140px;
            border: 2px solid #999;
            display: inline-block;
            background: #eee;
            text-align: center;
            line-height: 140px;
            font-size: 36px;
            font-weight: 700;
            color: #999;
        }

        .qr-code {
            margin-top: 8px;
        }

        .qr-code img {
            width: 80px;
            height: 80px;
        }

        /* Footer */
        .card-footer {
            border-top: 1px solid #bbb;
            padding: 20px 15px 10px;
        }

        .footer-table {
            width: 100%;
        }

        .footer-table td {
            font-size: 12px;
            color: #555;
            font-weight: 600;
            vertical-align: bottom;
        }

        .footer-left {
            border-top: 1px dashed #999;
            padding-top: 4px;
            text-align: center;
            width: 220px;
        }

        .footer-right {
            text-align: right;
        }

        /* Print Styles */
        @media print {
            body { background: #fff; padding: 0; margin: 0; }
            .print-controls { display: none !important; }
            .card-wrapper { max-width: 100%; }
            .card-container {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    <div class="print-controls">
        <button class="btn-print" onclick="window.print()">🖨️ Print FD Card</button>
        <a href="{{ route('shgs.members.fd-card.pdf', [$shg, $member]) }}" class="btn-download">📥 Download PDF</a>
        <a href="{{ route('shgs.members.show', [$shg, $member]) }}" class="btn-back">← Back to Member</a>
    </div>

    <div class="card-wrapper">
        <div class="card-container">
            {{-- Header --}}
            <div class="card-header">
                {{ strtoupper($shg->shg_name ?? 'YUVA MAITREE FOUNDATION') }}
            </div>

            {{-- Body: use table for layout consistency with PDF --}}
            <table class="main-table">
                <tr>
                    <td>
                        {{-- Details Table --}}
                        <table class="details-table">
                            <tr>
                                <td class="label">SHG Group Code</td>
                                <td class="value" colspan="3">{{ $shg->shg_code ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Member Name</td>
                                <td class="value" colspan="3">{{ $member->name }}</td>
                            </tr>
                            <tr>
                                <td class="label">Father / Husband</td>
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
                                <td class="value" colspan="3">{{ $member->aadhar_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Member ID</td>
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
                                <td class="label2">Maturity Date</td>
                                <td class="value2">{{ $member->fd_maturity_date ? $member->fd_maturity_date->format('d/m/Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">Maturity Amt</td>
                                <td class="value">Rs. {{ $member->fd_maturity_amount ? number_format($member->fd_maturity_amount, 2) : '0.00' }} — Auto</td>
                                <td class="label2">Bank Name</td>
                                <td class="value2">{{ strtoupper($member->bank_name ?? '-') }}</td>
                            </tr>
                            <tr>
                                <td class="label">Account No.</td>
                                <td class="value">{{ $member->account_number ?? '-' }}</td>
                                <td class="label2">IFSC Code</td>
                                <td class="value2">{{ strtoupper($member->ifsc_code ?? '-') }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="photo-cell">
                        @if($member->passport_photo)
                            <img src="{{ asset('storage/' . $member->passport_photo) }}" alt="{{ $member->name }}">
                        @else
                            <div class="photo-placeholder">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                        @endif

                        <div class="qr-code">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($member->member_id_code . ' | ' . $member->name . ' | ' . ($shg->shg_name ?? '') . ' | ' . ($member->mobile ?? '')) }}" alt="QR Code">
                        </div>
                    </td>
                </tr>
            </table>

            {{-- Footer --}}
            <div class="card-footer">
                <table class="footer-table">
                    <tr>
                        <td class="footer-left">Member Signature / Thumb Impression</td>
                        <td class="footer-right">For Office Use Only</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
