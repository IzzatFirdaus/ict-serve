<!doctype html>
<html lang="ms">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>{{ $title ?? 'Borang Permohonan Peminjaman Peralatan ICT' }}</title>

    <!-- MYDS typography: Poppins for headings, Inter for body -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <style>
        /* ----------------------------------------------------------------
         MYDS-aligned colour tokens (light mode). Values taken from
         MYDS-Colour-Reference.md (primary, gray scale, semantic tokens).
         These are used in the PDF/web export to keep consistent branding.
         ---------------------------------------------------------------- */
        :root{
            --color-primary-600: #2563EB; /* MYDS Blue */
            --color-primary-500: #3A75F6;
            --color-gray-900: #18181B;
            --color-gray-800: #27272A;
            --color-gray-700: #3F3F46;
            --color-gray-600: #52525B;
            --color-gray-500: #71717A;
            --color-gray-400: #A1A1AA;
            --color-gray-300: #D4D4D8;
            --color-gray-200: #E4E4E7;
            --color-gray-100: #F4F4F5;
            --color-gray-50:  #FAFAFA;
            --color-black:    #000000;
            --color-white:    #FFFFFF;

            /* Spacing / rhythm */
            --space-2: 8px;
            --space-3: 12px;
            --space-4: 16px;
            --space-6: 24px;
            --max-width: 920px;
        }

        /* Global reset */
        *{ box-sizing: border-box; }
        html,body{ height:100%; margin:0; background:var(--color-white); -webkit-font-smoothing:antialiased; -moz-osx-font-smoothing:grayscale; }
        body{
            font-family: "Inter", Arial, sans-serif;
            color: var(--color-gray-800);
            font-size: 13px;
            line-height: 1.45;
            padding: 24px;
        }

        /* Container */
        .doc {
            max-width: var(--max-width);
            margin: 0 auto;
            background: var(--color-white);
            border-radius: 8px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.04);
            padding: 24px;
        }

        /* Header (MYDS Masthead style) */
        header.masthead {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:16px;
            border-bottom: 4px solid var(--color-primary-600);
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .branding {
            display:flex;
            gap:12px;
            align-items:center;
        }

        .branding img{ height:44px; width:auto; display:block; }
        .agency {
            font-weight:700;
            font-family: "Poppins", "Inter", sans-serif;
            color: var(--color-gray-900);
            font-size:16px;
            line-height:1.1;
        }
        .department {
            font-weight:600;
            color: var(--color-gray-600);
            font-size:13px;
        }

        .doc-title {
            text-align:center;
            flex:1;
            font-family: "Poppins", "Inter", sans-serif;
            font-size:18px;
            font-weight:700;
            color: var(--color-primary-600);
            text-transform:uppercase;
            letter-spacing:0.6px;
        }

        /* Reference area (aligned right) */
        .reference {
            text-align:right;
            font-size:12px;
            color:var(--color-gray-600);
            min-width:180px;
        }

        /* Sections */
        main section {
            margin-top: 18px;
            page-break-inside: avoid;
        }

        .section-title {
            display:block;
            font-weight:600;
            background: var(--color-gray-100);
            padding:10px 12px;
            border-left:6px solid var(--color-primary-600);
            margin-bottom:12px;
            color:var(--color-gray-800);
            font-size:13px;
        }

        /* Form rows */
        .row {
            display:flex;
            gap:12px;
            align-items:flex-start;
            margin-bottom:10px;
        }
        .label {
            width:170px;
            min-width:120px;
            color:var(--color-gray-700);
            font-weight:600;
            font-size:13px;
        }
        .value {
            flex:1;
            padding-bottom:6px;
            border-bottom:1px dotted var(--color-gray-300);
            color:var(--color-gray-800);
            min-height:20px;
        }
        .value.empty { color:var(--color-gray-400); font-style:italic; }

        /* Equipment table matches MYDS table guidance */
        table.equipment {
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
            font-size:12px;
        }
        table.equipment caption{
            caption-side:top;
            text-align:left;
            font-weight:600;
            margin-bottom:8px;
            color:var(--color-gray-700);
        }
        table.equipment thead th {
            background: var(--color-gray-50);
            text-align:left;
            padding:8px;
            border:1px solid var(--color-gray-300);
            font-weight:600;
            color:var(--color-gray-700);
        }
        table.equipment tbody td {
            padding:8px;
            border:1px solid var(--color-gray-300);
            vertical-align:top;
            color:var(--color-gray-800);
        }
        table.equipment tbody tr:nth-child(even){ background: var(--color-gray-50); }

        /* Signature area */
        .signatures {
            display:flex;
            gap:18px;
            justify-content:space-between;
            margin-top:28px;
        }
        .sig-block { width:48%; text-align:center; }
        .sig-line {
            height:64px;
            border-bottom:1px solid var(--color-gray-300);
            margin-bottom:6px;
        }
        .sig-img { max-height:64px; display:block; margin:8px auto 0; }

        /* Footer */
        footer {
            margin-top:28px;
            border-top:1px solid var(--color-gray-200);
            padding-top:12px;
            font-size:12px;
            color:var(--color-gray-600);
            text-align:center;
        }

        /* Checkbox visual (MYDS Checkbox) */
        .checkbox {
            display:inline-block;
            width:14px;
            height:14px;
            border:1px solid var(--color-gray-300);
            vertical-align:middle;
            margin-right:8px;
            border-radius:3px;
            position:relative;
            background:transparent;
        }
        .checkbox.checked{
            background:var(--color-primary-600);
            border-color:var(--color-primary-600);
        }
        .checkbox.checked::after{
            content: "✓";
            color: #fff;
            font-size:11px;
            position:absolute;
            top:-1px;
            left:2px;
        }

        /* Accessibility helpers */
        .sr-only{
            position:absolute !important;
            width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;
        }

        /* Print friendly */
        @media print {
            body { color-adjust:exact; -webkit-print-color-adjust:exact; }
            .doc { box-shadow:none; border-radius:0; }
            .masthead { border-bottom-width:3px; }
        }
    </style>
</head>
<body>
    <!-- Skip link (MYDS accessibility requirement) -->
    <a href="#main-content" class="sr-only" id="skip-link">Langkau ke kandungan utama</a>

    <div class="doc" role="document" aria-labelledby="doc-title">
        <header class="masthead" role="banner" aria-hidden="false">
            <div class="branding" aria-hidden="false">
                {{-- If you have a hosted logo, use an <img> here. For PDF generation a base64 image is acceptable --}}
                @if(isset($agencyLogo))
                    <img src="{{ $agencyLogo }}" alt="Logo {{ $ministry ?? 'Kementerian' }}" />
                @else
                    <div aria-hidden="true" style="width:44px;height:44px;border-radius:6px;background:var(--color-primary-600);display:inline-block;"></div>
                @endif

                <div>
                    <div class="agency">{{ $ministry ?? 'Kementerian Pelancongan, Seni dan Budaya' }}</div>
                    <div class="department">{{ $department ?? 'Bahagian Pengurusan Maklumat (BPM)' }}</div>
                </div>
            </div>

            <div id="doc-title" class="doc-title" role="heading" aria-level="1">
                {{ $title ?? 'Borang Permohonan Peminjaman Peralatan ICT' }}
            </div>

            <div class="reference" aria-label="Maklumat rujukan borang">
                <div><strong>No. Rujukan:</strong></div>
                <div>{{ $loanRequest->reference_number ?? 'AKAN DIBERIKAN' }}</div>
                <div style="margin-top:6px;"><strong>Tarikh:</strong></div>
                <div>{{ $generatedAt->format('d/m/Y') }}</div>
            </div>
        </header>

        <main id="main-content" role="main" aria-labelledby="main-heading">
            <h2 id="main-heading" class="sr-only">Borang Permohonan Peminjaman Peralatan ICT</h2>

            {{-- Intro / short instructions (citizen-centric) --}}
            <section aria-labelledby="instructions">
                <p id="instructions" style="margin:0 0 12px; color:var(--color-gray-600);">
                    Sila lengkapkan maklumat berikut dengan tepat. Medan bertanda '*' adalah wajib. Borang ini adalah untuk kegunaan rasmi sahaja.
                </p>
            </section>

            {{-- Section A: Applicant Information --}}
            <section aria-labelledby="section-a">
                <span class="section-title" id="section-a">BAHAGIAN A: MAKLUMAT PEMOHON</span>

                <div class="row" role="group" aria-labelledby="applicant-name">
                    <div class="label" id="applicant-name">Nama Penuh *</div>
                    <div class="value" aria-describedby="applicant-name">
                        {{ $loanRequest->applicant_name ?? $user->name ?? 'N/A' }}
                    </div>
                </div>

                <div class="row">
                    <div class="label">No. MyKad</div>
                    <div class="value">{{ $loanRequest->applicant_mykad ?? 'N/A' }}</div>
                </div>

                <div class="row">
                    <div class="label">Jawatan & Gred</div>
                    <div class="value">{{ $loanRequest->applicant_position ?? 'N/A' }} @if($loanRequest->applicant_grade) (Gred {{ $loanRequest->applicant_grade }}) @endif</div>
                </div>

                <div class="row">
                    <div class="label">Bahagian / Unit</div>
                    <div class="value">{{ $loanRequest->applicant_department ?? 'N/A' }}</div>
                </div>

                <div class="row">
                    <div class="label">No. Telefon Pejabat</div>
                    <div class="value">{{ $loanRequest->applicant_office_phone ?? 'N/A' }}</div>
                </div>

                <div class="row">
                    <div class="label">No. Telefon Bimbit *</div>
                    <div class="value">{{ $loanRequest->applicant_mobile_phone ?? 'N/A' }}</div>
                </div>

                <div class="row">
                    <div class="label">Alamat E-mel *</div>
                    <div class="value">{{ $loanRequest->applicant_email ?? $user->email ?? 'N/A' }}</div>
                </div>
            </section>

            {{-- Section B: Equipment --}}
            <section aria-labelledby="section-b">
                <span class="section-title" id="section-b">BAHAGIAN B: BUTIRAN PERALATAN</span>

                @if($equipmentItems && $equipmentItems->count())
                    <table class="equipment" role="table" aria-describedby="equipment-caption">
                        <caption id="equipment-caption">Senarai peralatan yang dipohon</caption>
                        <thead>
                            <tr>
                                <th scope="col" style="width:5%;">Bil.</th>
                                <th scope="col" style="width:30%;">Nama Peralatan</th>
                                <th scope="col" style="width:15%;">Jenama / Model</th>
                                <th scope="col" style="width:10%;">Kuantiti</th>
                                <th scope="col" style="width:15%;">Tempoh Pinjaman</th>
                                <th scope="col" style="width:25%;">Tujuan Penggunaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($equipmentItems as $index => $item)
                                <tr>
                                    <td class="text-center" style="text-align:center;">{{ $index + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->brand ?? '—' }} / {{ $item->model ?? '—' }}</td>
                                    <td style="text-align:center;">{{ $item->pivot->quantity ?? 1 }}</td>
                                    <td style="text-align:center;">
                                        {{ $loanRequest->loan_start_date?->format('d/m/Y') ?? '—' }} —
                                        {{ $loanRequest->loan_end_date?->format('d/m/Y') ?? '—' }}
                                    </td>
                                    <td>{{ $loanRequest->purpose ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="value empty">Tiada peralatan dipilih</div>
                @endif
            </section>

            {{-- Section C: Loan Details --}}
            <section aria-labelledby="section-c">
                <span class="section-title" id="section-c">BAHAGIAN C: BUTIRAN PINJAMAN</span>

                <div class="row">
                    <div class="label">Tarikh Mula Pinjaman</div>
                    <div class="value">{{ $loanRequest->loan_start_date?->format('d/m/Y') ?? 'N/A' }}</div>
                </div>

                <div class="row">
                    <div class="label">Tarikh Tamat Pinjaman</div>
                    <div class="value">{{ $loanRequest->loan_end_date?->format('d/m/Y') ?? 'N/A' }}</div>
                </div>

                <div class="row" aria-live="polite">
                    <div class="label">Tempoh Pinjaman</div>
                    <div class="value">
                        @if($loanRequest->loan_start_date && $loanRequest->loan_end_date)
                            {{ $loanRequest->loan_start_date->diffInDays($loanRequest->loan_end_date) + 1 }} hari
                        @else
                            N/A
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="label">Tujuan Penggunaan</div>
                    <div class="value">{{ $loanRequest->purpose ?? 'N/A' }}</div>
                </div>

                <div class="row">
                    <div class="label">Lokasi Penggunaan</div>
                    <div class="value">{{ $loanRequest->usage_location ?? 'N/A' }}</div>
                </div>
            </section>

            {{-- Section D: Terms and Conditions --}}
            <section aria-labelledby="section-d">
                <span class="section-title" id="section-d">BAHAGIAN D: TERMA DAN SYARAT</span>

                {{-- Accessible checkboxes (visual + aria) --}}
                <div style="margin-bottom:8px;">
                    <span role="checkbox"
                          aria-checked="{{ $loanRequest->terms_accepted ? 'true' : 'false' }}"
                          class="checkbox {{ $loanRequest->terms_accepted ? 'checked' : '' }}"
                          aria-label="Saya bersetuju untuk mematuhi semua terma dan syarat yang ditetapkan oleh BPM"></span>
                    <span style="color:var(--color-gray-800);">Saya bersetuju untuk mematuhi semua terma dan syarat yang ditetapkan oleh BPM</span>
                </div>

                <div style="margin-bottom:8px;">
                    <span role="checkbox"
                          aria-checked="{{ $loanRequest->responsibility_accepted ? 'true' : 'false' }}"
                          class="checkbox {{ $loanRequest->responsibility_accepted ? 'checked' : '' }}"
                          aria-label="Saya bertanggungjawab sepenuhnya terhadap peralatan yang dipinjam"></span>
                    <span>Saya bertanggungjawab sepenuhnya terhadap peralatan yang dipinjam</span>
                </div>

                <div style="margin-bottom:8px;">
                    <span role="checkbox"
                          aria-checked="{{ $loanRequest->return_commitment ? 'true' : 'false' }}"
                          class="checkbox {{ $loanRequest->return_commitment ? 'checked' : '' }}"
                          aria-label="Saya berjanji untuk memulangkan peralatan dalam keadaan baik pada tarikh yang ditetapkan"></span>
                    <span>Saya berjanji untuk memulangkan peralatan dalam keadaan baik pada tarikh yang ditetapkan</span>
                </div>

                {{-- Short accessibility note --}}
                <p style="margin-top:12px;color:var(--color-gray-600);font-size:12px;">
                    Nota: Dengan menandatangani borang ini, pemohon mengesahkan pematuhan kepada peraturan BPM dan faham dengan tanggungjawab yang dikenakan.
                </p>
            </section>

            {{-- Section E: Signatures --}}
            <section aria-labelledby="section-e" class="signatures" style="gap:24px;">
                <span class="section-title" id="section-e" style="flex-basis:100%;">BAHAGIAN E: TANDATANGAN</span>

                <div class="sig-block" role="group" aria-labelledby="sig-applicant">
                    <div id="sig-applicant" class="sig-line" aria-hidden="true">
                        @if(!empty($loanRequest->applicant_signature))
                            <img src="{{ $loanRequest->applicant_signature }}" alt="Tandatangan Pemohon: {{ $loanRequest->applicant_name ?? $user->name }}" class="sig-img" />
                        @endif
                    </div>
                    <div style="font-weight:600;">TANDATANGAN PEMOHON</div>
                    <div style="color:var(--color-gray-600); font-size:12px; margin-top:6px;">
                        <strong>Nama:</strong> {{ $loanRequest->applicant_name ?? $user->name ?? '—' }}<br>
                        <strong>Tarikh:</strong> {{ $loanRequest->created_at?->format('d/m/Y') ?? '—' }}
                    </div>
                </div>

                <div class="sig-block" role="group" aria-labelledby="sig-bpm">
                    <div id="sig-bpm" class="sig-line" aria-hidden="true">
                        @if(!empty($loanRequest->receiving_bpm_officer_signature))
                            <img src="{{ $loanRequest->receiving_bpm_officer_signature }}" alt="Tandatangan Pegawai BPM" class="sig-img" />
                        @endif
                    </div>
                    <div style="font-weight:600;">PEGAWAI PENERIMA BPM</div>
                    <div style="color:var(--color-gray-600); font-size:12px; margin-top:6px;">
                        <strong>Nama:</strong> ________________________<br>
                        <strong>Tarikh:</strong> ______________________
                    </div>
                </div>
            </section>

            {{-- For BPM: Loan collection & return (condensed for printable form) --}}
            <section aria-labelledby="section-bpm">
                <span class="section-title" id="section-bpm">BAHAGIAN F (UNTUK KEGUNAAN BPM)</span>

                <div style="display:flex;gap:18px;">
                    <div style="flex:1;">
                        <div class="label" style="width:auto;">Pegawai Pengeluar</div>
                        <div class="value">{{ $loanRequest->issuing_officer_name ?? '—' }}</div>
                        <div style="margin-top:8px;color:var(--color-gray-600);font-size:12px;">Tandatangan & Cop</div>
                    </div>
                    <div style="flex:1;">
                        <div class="label" style="width:auto;">Pegawai Terima Pulangan</div>
                        <div class="value">{{ $loanRequest->return_receiving_officer_name ?? '—' }}</div>
                        <div style="margin-top:8px;color:var(--color-gray-600);font-size:12px;">Tandatangan & Cop</div>
                    </div>
                </div>
            </section>
        </main>

        <footer role="contentinfo">
            <div>
                Borang ini dijana secara automatik oleh Sistem ICTServe (iServe) pada {{ $generatedAt->format('d/m/Y H:i:s') }}.
            </div>
            <div style="margin-top:6px;">
                Untuk sebarang pertanyaan, sila hubungi Bahagian Pengurusan Maklumat (BPM).
            </div>

            @if(!empty($generatedBy))
                <div style="margin-top:8px; font-size:11px; color:var(--color-gray-600);">
                    Dijana oleh: {{ $generatedBy->name }} | {{ $generatedBy->email }}
                </div>
            @endif
        </footer>
    </div>
</body>
</html>
