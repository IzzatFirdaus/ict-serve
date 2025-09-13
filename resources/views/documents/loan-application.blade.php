<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        :root {
            /* MYDS Colors for PDF */
            --color-primary-600: var(--color-primary-600);
            --color-gray-900: #18181B;
            --color-gray-800: #27272A;
            --color-gray-700: #3F3F46;
            --color-gray-600: #52525B;
            --color-gray-500: #71717A;
            --color-gray-400: #A1A1AA;
            --color-gray-300: #D4D4D8;
            --color-gray-200: #E4E4E7;
            --color-gray-100: #F4F4F5;
            --color-gray-50: #FAFAFA;
            --color-black: var(--color-black)000;
            --color-white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: var(--color-gray-800);
            background: var(--color-white);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--color-primary-600);
            padding-bottom: 20px;
        }

        .logo-section {
            margin-bottom: 15px;
        }

        .ministry-name {
            font-size: 16px;
            font-weight: 700;
            color: var(--color-gray-800);
            margin-bottom: 5px;
        }

        .department-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--color-gray-600);
            margin-bottom: 10px;
        }

        .form-title {
            font-size: 18px;
            font-weight: 700;
            color: var(--color-primary-600);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-subtitle {
            font-size: 14px;
            color: var(--color-gray-500);
            margin-top: 5px;
        }

        .reference-info {
            text-align: right;
            margin-bottom: 20px;
            font-size: 11px;
            color: var(--color-gray-500);
        }

        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--color-gray-800);
            background-color: var(--color-gray-100);
            padding: 8px 12px;
            border-left: 4px solid var(--color-primary-600);
            margin-bottom: 15px;
        }

        .form-row {
            display: flex;
            margin-bottom: 12px;
            align-items: flex-start;
        }

        .form-label {
            font-weight: 500;
            color: var(--color-gray-700);
            width: 150px;
            flex-shrink: 0;
            padding-right: 10px;
        }

        .form-value {
            flex: 1;
            color: var(--color-gray-800);
            border-bottom: 1px dotted var(--color-gray-300);
            padding-bottom: 2px;
            min-height: 16px;
        }

        .form-value.empty {
            color: var(--color-gray-400);
            font-style: italic;
        }

        .equipment-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11px;
        }

        .equipment-table th,
        .equipment-table td {
            border: 1px solid var(--color-gray-300);
            padding: 8px;
            text-align: left;
        }

        .equipment-table th {
            background-color: var(--color-gray-50);
            font-weight: 600;
            color: var(--color-gray-700);
        }

        .equipment-table tbody tr:nth-child(even) {
            background-color: var(--color-gray-50);
        }

        .signature-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-row {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }

        .signature-block {
            width: 45%;
            text-align: center;
        }

        .signature-line {
            border-bottom: 1px solid var(--color-black);
            height: 60px;
            margin-bottom: 5px;
            position: relative;
        }

        .signature-label {
            font-weight: 500;
            font-size: 11px;
            margin-top: 5px;
        }

        .signature-date {
            font-size: 10px;
            color: var(--color-gray-500);
            margin-top: 3px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid var(--color-gray-200);
            font-size: 10px;
            color: var(--color-gray-500);
            text-align: center;
        }

        .checkbox {
            width: 12px;
            height: 12px;
            border: 1px solid var(--color-gray-300);
            display: inline-block;
            margin-right: 5px;
            vertical-align: middle;
        }

        .checkbox.checked {
            background-color: var(--color-primary-600);
            position: relative;
        }

        .checkbox.checked::after {
            content: '✓';
            color: white;
            font-size: 10px;
            position: absolute;
            top: -2px;
            left: 1px;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: 600; }
        .text-small { font-size: 10px; }

    /* Replacements for previous inline styles */
    .w-5p { width: 5%; }
    .w-10p { width: 10%; }
    .w-15p { width: 15%; }
    .w-25p { width: 25%; }
    .w-30p { width: 30%; }
    .mb-10px { margin-bottom: 10px; }
    .sig-img { max-height: 50px; margin-top: 5px; }
    .footer-generated-by { margin-top: 10px; font-size: 9px; }

        @media print {
            body { -webkit-print-color-adjust: exact; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body>
    {{-- Header --}}
    <div class="header">
        <div class="logo-section">
            {{-- Add logo here if available --}}
        </div>
        <div class="ministry-name">{{ $ministry }}</div>
        <div class="department-name">{{ $department }}</div>
        <div class="form-title">{{ $title }}</div>
        <div class="form-subtitle">ICT Equipment Loan Application Form</div>
    </div>

    {{-- Reference Information --}}
    <div class="reference-info">
        <strong>No. Rujukan:</strong> {{ $loanRequest->reference_number ?? 'AKAN DIBERIKAN' }}<br>
        <strong>Tarikh:</strong> {{ $generatedAt->format('d/m/Y') }}
    </div>

    {{-- Section 1: Applicant Information --}}
    <div class="section">
        <div class="section-title">BAHAGIAN A: MAKLUMAT PEMOHON</div>

        <div class="form-row">
            <div class="form-label">Nama Penuh:</div>
            <div class="form-value">{{ $loanRequest->applicant_name ?? $user->name }}</div>
        </div>

        <div class="form-row">
            <div class="form-label">No. MyKad:</div>
            <div class="form-value">{{ $loanRequest->applicant_mykad ?? 'N/A' }}</div>
        </div>

        <div class="form-row">
            <div class="form-label">Jawatan:</div>
            <div class="form-value">{{ $loanRequest->applicant_position ?? 'N/A' }}</div>
        </div>

        <div class="form-row">
            <div class="form-label">Gred:</div>
            <div class="form-value">{{ $loanRequest->applicant_grade ?? 'N/A' }}</div>
        </div>

        <div class="form-row">
            <div class="form-label">Bahagian/Unit:</div>
            <div class="form-value">{{ $loanRequest->applicant_department ?? 'N/A' }}</div>
        </div>

        <div class="form-row">
            <div class="form-label">No. Telefon Pejabat:</div>
            <div class="form-value">{{ $loanRequest->applicant_office_phone ?? 'N/A' }}</div>
        </div>

        <div class="form-row">
            <div class="form-label">No. Telefon Bimbit:</div>
            <div class="form-value">{{ $loanRequest->applicant_mobile_phone ?? 'N/A' }}</div>
        </div>

        <div class="form-row">
            <div class="form-label">Alamat E-mel:</div>
            <div class="form-value">{{ $loanRequest->applicant_email ?? $user->email }}</div>
        </div>
    </div>

    {{-- Section 2: Equipment Details --}}
    <div class="section">
        <div class="section-title">BAHAGIAN B: BUTIRAN PERALATAN</div>

        @if($equipmentItems && $equipmentItems->count() > 0)
            <table class="equipment-table">
                <thead>
                    <tr>
                        <th class="w-5p">Bil.</th>
                        <th class="w-30p">Nama Peralatan</th>
                        <th class="w-15p">Jenama/Model</th>
                        <th class="w-10p">Kuantiti</th>
                        <th class="w-15p">Tempoh Pinjaman</th>
                        <th class="w-25p">Tujuan Penggunaan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($equipmentItems as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->brand ?? 'N/A' }} / {{ $item->model ?? 'N/A' }}</td>
                            <td class="text-center">{{ $item->pivot->quantity ?? 1 }}</td>
                            <td class="text-center">
                                {{ $loanRequest->loan_start_date?->format('d/m/Y') }} -
                                {{ $loanRequest->loan_end_date?->format('d/m/Y') }}
                            </td>
                            <td>{{ $loanRequest->purpose ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="form-value empty">Tiada peralatan dipilih</div>
        @endif
    </div>

    {{-- Section 3: Loan Details --}}
    <div class="section">
        <div class="section-title">BAHAGIAN C: BUTIRAN PINJAMAN</div>

        <div class="form-row">
            <div class="form-label">Tarikh Mula Pinjaman:</div>
            <div class="form-value">{{ $loanRequest->loan_start_date?->format('d/m/Y') ?? 'N/A' }}</div>
        </div>

        <div class="form-row">
            <div class="form-label">Tarikh Tamat Pinjaman:</div>
            <div class="form-value">{{ $loanRequest->loan_end_date?->format('d/m/Y') ?? 'N/A' }}</div>
        </div>

        <div class="form-row">
            <div class="form-label">Tempoh Pinjaman:</div>
            <div class="form-value">
                @if($loanRequest->loan_start_date && $loanRequest->loan_end_date)
                    {{ $loanRequest->loan_start_date->diffInDays($loanRequest->loan_end_date) + 1 }} hari
                @else
                    N/A
                @endif
            </div>
        </div>

        <div class="form-row">
            <div class="form-label">Tujuan Penggunaan:</div>
            <div class="form-value">{{ $loanRequest->purpose ?? 'N/A' }}</div>
        </div>

        <div class="form-row">
            <div class="form-label">Lokasi Penggunaan:</div>
            <div class="form-value">{{ $loanRequest->usage_location ?? 'N/A' }}</div>
        </div>
    </div>

    {{-- Section 4: Terms and Conditions --}}
    <div class="section">
        <div class="section-title">BAHAGIAN D: TERMA DAN SYARAT</div>

        <div class="mb-10px">
            <span class="checkbox {{ $loanRequest->terms_accepted ? 'checked' : '' }}"></span>
            Saya bersetuju untuk mematuhi semua terma dan syarat yang ditetapkan oleh BPM
        </div>

        <div class="mb-10px">
            <span class="checkbox {{ $loanRequest->responsibility_accepted ? 'checked' : '' }}"></span>
            Saya bertanggungjawab sepenuhnya terhadap peralatan yang dipinjam
        </div>

        <div class="mb-10px">
            <span class="checkbox {{ $loanRequest->return_commitment ? 'checked' : '' }}"></span>
            Saya berjanji untuk memulangkan peralatan dalam keadaan baik pada tarikh yang ditetapkan
        </div>
    </div>

    {{-- Signature Section --}}
    <div class="signature-section">
        <div class="section-title">BAHAGIAN E: TANDATANGAN</div>

        <div class="signature-row">
            <div class="signature-block">
                <div class="signature-line">
                    @if($loanRequest->applicant_signature)
                        <img src="{{ $loanRequest->applicant_signature }}" class="sig-img" alt="Tandatangan Pemohon">
                    @endif
                </div>
                <div class="signature-label">TANDATANGAN PEMOHON</div>
                <div class="signature-date">
                    <strong>Nama:</strong> {{ $loanRequest->applicant_name ?? $user->name }}<br>
                    <strong>Tarikh:</strong> {{ $loanRequest->created_at?->format('d/m/Y') }}
                </div>
            </div>

            <div class="signature-block">
                <div class="signature-line">
                    @if($loanRequest->receiving_bpm_officer_signature)
                        <img src="{{ $loanRequest->receiving_bpm_officer_signature }}" class="sig-img" alt="Tandatangan Pegawai BPM">
                    @endif
                </div>
                <div class="signature-label">PEGAWAI PENERIMA BPM</div>
                <div class="signature-date">
                    <strong>Nama:</strong> ________________________<br>
                    <strong>Tarikh:</strong> ______________________
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>Borang ini dijana secara automatik oleh Sistem ICTServe pada {{ $generatedAt->format('d/m/Y H:i:s') }}</p>
        <p>Untuk sebarang pertanyaan, sila hubungi Bahagian Pengurusan Maklumat (BPM)</p>

        @if($generatedBy)
            <p class="footer-generated-by">
                Dijana oleh: {{ $generatedBy->name }} | {{ $generatedBy->email }}
            </p>
        @endif
    </div>
</body>
</html>











