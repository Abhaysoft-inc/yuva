<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Form — {{ $member->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Times New Roman', Times, serif;
            background: #f3f4f6;
            padding: 20px;
            color: #000;
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

        .form-page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: #fff;
            padding: 30px 40px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
            position: relative;
        }

        .form-title {
            text-align: center;
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 1px;
            margin-bottom: 24px;
        }

        .top-section {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .barcode-section {
            text-align: left;
        }
        .barcode-section .barcode {
            font-family: 'Libre Barcode 39', 'Free 3 of 9', monospace;
            font-size: 40px;
            letter-spacing: 2px;
            line-height: 1;
        }
        .barcode-section .barcode-text {
            font-size: 11px;
            margin-top: 4px;
        }
        .barcode-section .barcode-text strong {
            color: #dc2626;
        }

        .photo-box {
            width: 100px;
            height: 120px;
            border: 2px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            font-size: 10px;
            line-height: 1.3;
            color: #666;
            overflow: hidden;
        }
        .photo-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .form-table td {
            border: 1px solid #000;
            padding: 10px 12px;
            font-size: 13px;
            vertical-align: top;
        }
        .form-table .label {
            font-weight: 700;
            width: 180px;
            background: #fafafa;
        }
        .form-table .value {
            min-height: 20px;
            font-size: 14px;
        }
        .form-table .value.address {
            min-height: 60px;
        }

        .declaration {
            border: 1px solid #000;
            padding: 10px 12px;
            margin-bottom: 0;
            font-size: 11px;
            color: #dc2626;
            font-style: italic;
            background: #fef2f2;
        }

        .signature-table {
            width: 100%;
            border-collapse: collapse;
        }
        .signature-table td {
            border: 1px solid #000;
            padding: 10px 12px;
            font-size: 13px;
            font-weight: 700;
            height: 60px;
            vertical-align: bottom;
            width: 50%;
        }

        .org-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 10px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .org-footer .org-name {
            font-size: 12px;
            font-weight: 700;
            color: #333;
        }

        /* ========== PRINT ========== */
        @media print {
            body { background: #fff; padding: 0; margin: 0; }
            .print-controls { display: none !important; }
            .form-page {
                box-shadow: none;
                padding: 20px 30px;
                margin: 0;
                width: 100%;
                min-height: auto;
            }
            .form-table td { background: #fff !important; }
            .declaration { background: #fff !important; }
        }

        /* Barcode font fallback - CSS-drawn bars */
        .barcode-visual {
            display: flex;
            align-items: flex-end;
            gap: 1px;
            height: 40px;
            margin-bottom: 4px;
        }
        .barcode-visual .bar {
            background: #000;
            width: 2px;
            display: inline-block;
        }
        .barcode-visual .bar.thin { width: 1px; }
        .barcode-visual .bar.thick { width: 3px; }
        .barcode-visual .space { width: 2px; }
    </style>
</head>
<body>

    <div class="print-controls">
        <button class="btn-print" onclick="window.print()">🖨️ Print / Download Form</button>
        <a href="{{ route('shgs.members.show', [$shg, $member]) }}" class="btn-back">← Back to Member</a>
    </div>

    <div class="form-page">

        <div class="form-title">SELF HELP GROUP (SHG) MEMBERSHIP FORM</div>

        <div class="top-section">
            <div class="barcode-section">
                {{-- Visual barcode representation --}}
                <div class="barcode-visual">
                    @php
                        // Generate pseudo-barcode bars from the member_id_code
                        $code = $member->member_id_code ?? 'YMF/SHG/0000/0000';
                        $bars = [];
                        for ($i = 0; $i < strlen($code); $i++) {
                            $charVal = ord($code[$i]);
                            $bars[] = ($charVal % 3 == 0) ? 'thick' : (($charVal % 2 == 0) ? 'thin' : '');
                        }
                    @endphp
                    @foreach(range(1, 50) as $i)
                        @php $type = $bars[$i % count($bars)] ?? ''; @endphp
                        <div class="bar {{ $type }}" style="height: {{ rand(30, 40) }}px;"></div>
                        @if($i % 3 == 0)<div class="space"></div>@endif
                    @endforeach
                </div>
                <div class="barcode-text"><strong>Unique Form Code:</strong> {{ $member->member_id_code }}</div>
            </div>

            <div class="photo-box">
                @if($member->passport_photo)
                    <img src="{{ asset('storage/' . $member->passport_photo) }}" alt="Photo">
                @else
                    PASTE<br>PASSPORT SIZE<br>PHOTO
                @endif
            </div>
        </div>

        <table class="form-table">
            <tr>
                <td class="label">SHG Group Name</td>
                <td class="value">{{ $shg->shg_name }}</td>
            </tr>
            <tr>
                <td class="label">SHG Group Code</td>
                <td class="value">{{ $shg->shg_code ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Member Name</td>
                <td class="value">{{ $member->name }}</td>
            </tr>
            <tr>
                <td class="label">Father / Husband Name</td>
                <td class="value">{{ $member->husband_father_name ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Date of Birth</td>
                <td class="value">{{ $member->date_of_birth ? $member->date_of_birth->format('d/m/Y') : '' }}</td>
            </tr>
            <tr>
                <td class="label">Mobile Number</td>
                <td class="value">{{ $member->mobile ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Full Address</td>
                <td class="value address">{{ $member->address ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Aadhaar Number</td>
                <td class="value">{{ $member->aadhar_number ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">PAN Number</td>
                <td class="value">{{ $member->pan_number ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Bank Name</td>
                <td class="value">{{ $member->bank_name ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Branch</td>
                <td class="value">{{ $member->branch ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">Account Number</td>
                <td class="value">{{ $member->account_number ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">IFSC Code</td>
                <td class="value">{{ $member->ifsc_code ?? '' }}</td>
            </tr>
        </table>

        <div class="declaration">
            Declaration: I confirm that the above information is true and I agree to follow the rules of the Self Help Group.
        </div>

        <table class="signature-table">
            <tr>
                <td>Member Signature</td>
                <td>Date: {{ now()->format('d/m/Y') }}</td>
            </tr>
        </table>

        <div class="org-footer">
            <div class="org-name">Yuva Maitree Foundation / युवा मैत्री फाउंडेशन</div>
            This is a system-generated membership form.
        </div>

    </div>

</body>
</html>
