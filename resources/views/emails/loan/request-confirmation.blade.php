@php
/**
 * Pengesahan Permohonan Pinjaman Peralatan ICT – MYDS & MyGovEA (Bahasa Melayu)
 * Untuk ICTServe (iServe)
 * Semua istilah utama, label, dan arahan dalam Bahasa Melayu.
 */
@endphp
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pengesahan Permohonan Pinjaman Peralatan ICTServe</title>
 * Loan Request Confirmation Email – MYDS & MyGovEA compliant
 * For ICTServe (iServe)
 * Follows MYDS grid, typography, color tokens, and status components.
 * Uses inline styles for email client compatibility.
 */
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ICTServe Loan Request Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- MYDS Typography (system fallback) -->
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@600&display=swap');
    </style>
</head>
<body style="margin:0;padding:0;font-family:'Inter',Arial,sans-serif;background:#FAFAFA;color:#18181B;">
    <!-- Masthead -->
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#2563EB;border-bottom:4px solid #3A75F6;">
        <tr>
            <td style="padding:24px;">
                <table width="600" align="center" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px;">
                    <tr>
                        <td valign="middle" style="width:56px;">
                            <img src="{{ asset('img/motac-logo.png') }}" alt="Logo MOTAC" width="48" height="48" style="display:block;border-radius:6px;">
                            <!-- Ministry/Dept Logo (replace src as needed) -->
                            <img src="{{ asset('images/malaysia_tourism_ministry_motac.jpeg') }}" alt="MOTAC Logo" width="48" height="48" style="display:block;border-radius:6px;">
                        </td>
                        <td style="padding-left:16px;">
                            <div style="font-family:Poppins,Arial,sans-serif;font-size:18px;font-weight:600;color:#fff;line-height:1.1;">
                                Kementerian Pelancongan, Seni dan Budaya Malaysia
                            </div>
                            <div style="font-family:Inter,Arial,sans-serif;font-size:14px;font-weight:400;color:#C2D5FF;">
                                Bahagian Pengurusan Maklumat (BPM) – ICTServe (iServe)
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Main content container -->
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td style="padding:32px 0;">
                <table width="600" align="center" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);padding:0 24px 24px 24px;">
                    <!-- Panel (MYDS) -->
                    <tr>
                        <td colspan="2" style="padding:32px 0 12px 0;">
                            <div style="border-radius:12px;padding:20px 24px;background:#EFF6FF;border-left:8px solid #2563EB;">
                                <span style="font-family:Poppins,Arial,sans-serif;font-size:22px;font-weight:600;color:#2563EB;display:block;margin-bottom:6px;">Pengesahan Permohonan Pinjaman</span>
                                <span style="font-size:15px;color:#3F3F46;">Terima kasih kerana mengemukakan permohonan pinjaman peralatan ICT. Permohonan anda sedang diproses oleh pasukan ICT kami.</span>
                                <span style="font-family:Poppins,Arial,sans-serif;font-size:22px;font-weight:600;color:#2563EB;display:block;margin-bottom:6px;">Loan Request Confirmation</span>
                                <span style="font-size:15px;color:#3F3F46;">Thank you for submitting your equipment loan request. Our ICT team is now processing your application.</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Status & Request Info -->
                    <tr>
                        <td colspan="2" style="padding-top:18px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-size:14px;">
                                <tr>
                                    <td style="padding:0 0 8px 0;">
                                        <strong style="color:#2563EB;">No. Permohonan:</strong>
                                        <span style="font-family:monospace;color:#18181B;">{{ $loanRequest->request_number }}</span>
                                    </td>
                                    <td align="right" style="color:#71717A;">
                                        <strong>Dihantar pada:</strong>
                                        <strong style="color:#2563EB;">Request Number:</strong>
                                        <span style="font-family:monospace;color:#18181B;">{{ $loanRequest->request_number }}</span>
                                    </td>
                                    <td align="right" style="color:#71717A;">
                                        <strong>Submitted:</strong>
                                        {{ $loanRequest->created_at->format('d M Y, g:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Status:</strong>
                                        <span style="background:#DBEAFE;color:#2563EB;border-radius:6px;padding:2px 10px;font-size:13px;font-weight:600;vertical-align:middle;">
                                            {{ $loanRequest->status->name }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Summary List (MYDS) -->
                    <tr>
                        <td colspan="2" style="padding-top:28px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0;font-size:14px;">
                                <tr>
                                    <td colspan="2" style="font-size:16px;font-family:Poppins,Arial,sans-serif;font-weight:600;color:#2563EB;padding-bottom:8px;">Maklumat Pemohon</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;width:150px;padding:4px 0;">Nama</td>
                                    <td>{{ $loanRequest->user->name }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">E-mel</td>
                                    <td>{{ $loanRequest->user->email }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Bahagian</td>
                                    <td>{{ $loanRequest->user->department }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Unit</td>
                                    <td>{{ $loanRequest->user->division }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Jawatan</td>
                                    <td colspan="2" style="font-size:16px;font-family:Poppins,Arial,sans-serif;font-weight:600;color:#2563EB;padding-bottom:8px;">Borrower Information</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;width:150px;padding:4px 0;">Name</td>
                                    <td>{{ $loanRequest->user->name }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Email</td>
                                    <td>{{ $loanRequest->user->email }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Department</td>
                                    <td>{{ $loanRequest->user->department }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Division</td>
                                    <td>{{ $loanRequest->user->division }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Position</td>
                                    <td>{{ $loanRequest->user->position }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:24px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0;font-size:14px;">
                                <tr>
                                    <td colspan="2" style="font-size:16px;font-family:Poppins,Arial,sans-serif;font-weight:600;color:#2563EB;padding-bottom:8px;">Butiran Pinjaman</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;width:150px;padding:4px 0;">Tarikh Mula</td>
                                    <td>{{ $loanRequest->loan_start_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Tarikh Tamat</td>
                                    <td>{{ $loanRequest->loan_end_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Tempoh</td>
                                    <td>
                                        {{ $loanRequest->loan_start_date->diffInDays($loanRequest->loan_end_date) }} hari
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Tujuan</td>
                                    <td>{{ $loanRequest->purpose }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Lokasi</td>
                                    <td colspan="2" style="font-size:16px;font-family:Poppins,Arial,sans-serif;font-weight:600;color:#2563EB;padding-bottom:8px;">Loan Details</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;width:150px;padding:4px 0;">Start Date</td>
                                    <td>{{ $loanRequest->loan_start_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">End Date</td>
                                    <td>{{ $loanRequest->loan_end_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Duration</td>
                                    <td>
                                        {{ $loanRequest->loan_start_date->diffInDays($loanRequest->loan_end_date) }} days
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Purpose</td>
                                    <td>{{ $loanRequest->purpose }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Location</td>
                                    <td>{{ $loanRequest->location }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:24px;">
                            <div style="font-size:14px;">
                                <span style="font-weight:600;color:#2563EB;">Peralatan Dipohon:</span>
                                <span style="font-weight:600;color:#2563EB;">Requested Equipment:</span>
                                <ul style="margin:8px 0 0 20px;padding:0;color:#18181B;">
                                    @foreach($loanRequest->loanItems as $loanItem)
                                        <li>
                                            {{ $loanItem->equipmentItem->category->name }}: {{ $loanItem->equipmentItem->brand }} {{ $loanItem->equipmentItem->model }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </td>
                    </tr>

                    <!-- Next Steps Callout -->
                    <tr>
                        <td colspan="2" style="padding-top:28px;">
                            <div style="border-left:4px solid #2563EB;padding:12px 0 12px 16px;background:#EFF6FF;border-radius:6px;font-size:14px;">
                                <strong style="color:#2563EB;">Apa Seterusnya?</strong>
                                <ol style="margin:8px 0 0 18px;padding:0;color:#18181B;">
                                    <li>Pasukan ICT akan menyemak permohonan dan menyemak ketersediaan peralatan.</li>
                                    <li>Anda akan menerima notifikasi kelulusan dalam tempoh 1–2 hari bekerja.</li>
                                    <li>Sebaik diluluskan, anda boleh mengambil peralatan di pejabat ICT.</li>
                                    <li>Sila semak e-mel anda secara berkala untuk makluman lanjut.</li>
                                <strong style="color:#2563EB;">What happens next?</strong>
                                <ol style="margin:8px 0 0 18px;padding:0;color:#18181B;">
                                    <li>ICT team will review your request and check equipment availability.</li>
                                    <li>You will receive approval notification within 1–2 business days.</li>
                                    <li>Once approved, collect equipment at the ICT office.</li>
                                    <li>Check your email regularly for updates.</li>
                                </ol>
                            </div>
                        </td>
                    </tr>

                    <!-- MYDS Button (Track Status) -->
                    <tr>
                        <td colspan="2" align="center" style="padding-top:26px;">
                            <a href="{{ route('public.track').'?tracking_number='.$loanRequest->request_number }}"
                               style="background:#2563EB;color:#fff;font-family:Poppins,Arial,sans-serif;font-size:16px;font-weight:600;display:inline-block;padding:12px 30px;border-radius:6px;text-decoration:none;box-shadow:0 2px 6px rgba(37,99,235,0.16);">
                                Jejak Status Permohonan
                                Track Request Status
                            </a>
                        </td>
                    </tr>

                    <!-- Important Notes -->
                    <tr>
                        <td colspan="2" style="padding-top:28px;">
                            <ul style="font-size:13px;color:#71717A;line-height:1.6;padding-left:18px;">
                                <li>Sila simpan nombor permohonan untuk rujukan.</li>
                                <li>Status permohonan boleh dijejak pada pautan di atas.</li>
                                <li>Hubungi pasukan ICT sekiranya ada pertanyaan atau ingin membuat perubahan permohonan.</li>
                                <li>Please save your request number for reference.</li>
                                <li>You can track your request status at any time.</li>
                                <li>Contact the ICT team if you have any questions or need to modify your request.</li>
                            </ul>
                        </td>
                    </tr>

                    <!-- Support Contacts / Footer -->
                    <tr>
                        <td colspan="2" style="padding-top:24px;text-align:center;font-size:13px;color:#52525B;">
                            <div>
                                <span style="color:#2563EB;font-weight:600;">Pasukan Sokongan ICT</span><br>
                                E-mel: <a href="mailto:ict-support@example.gov.my" style="color:#2563EB;text-decoration:underline;">ict-support@example.gov.my</a><br>
                                Telefon: +60 3-xxxx xxxx<br>
                                Waktu Operasi: Isnin - Jumaat, 8:00 pagi – 5:00 petang
                                <span style="color:#2563EB;font-weight:600;">ICT Support Team</span><br>
                                Email: <a href="mailto:ict-support@example.gov.my" style="color:#2563EB;text-decoration:underline;">ict-support@example.gov.my</a><br>
                                Phone: +60 3-xxxx xxxx<br>
                                Office hours: Mon-Fri, 8:00 AM–5:00 PM
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:30px;padding-bottom:8px;text-align:center;font-size:12px;color:#A1A1AA;">
                            &copy; {{ date('Y') }} Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia. Dikuasakan oleh ICTServe (iServe).
                            &copy; {{ date('Y') }} Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia. Powered by ICTServe (iServe).
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
