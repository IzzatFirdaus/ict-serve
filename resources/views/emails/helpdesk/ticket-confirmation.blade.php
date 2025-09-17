@php
/**
 * Pengesahan Tiket Sokongan – MYDS & MyGovEA (Bahasa Melayu)
 * Untuk ICTServe (iServe)
 * Gaya, warna, tipografi dan struktur ikut MYDS & prinsip MyGovEA.
 * Semua istilah utama, label, dan arahan dalam Bahasa Melayu.
 */
@endphp
<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Pengesahan Tiket Sokongan ICTServe</title>
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
                                <span style="font-family:Poppins,Arial,sans-serif;font-size:22px;font-weight:600;color:#2563EB;display:block;margin-bottom:6px;">Pengesahan Tiket Sokongan</span>
                                <span style="font-size:15px;color:#3F3F46;">Terima kasih kerana melaporkan isu ICT anda. Tiket sokongan anda telah diterima dan sedang diproses oleh pasukan kami.</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Status & Ticket Info -->
                    <tr>
                        <td colspan="2" style="padding-top:18px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="font-size:14px;">
                                <tr>
                                    <td style="padding:0 0 8px 0;">
                                        <strong style="color:#2563EB;">No. Tiket:</strong>
                                        <span style="font-family:monospace;color:#18181B;">{{ $ticket->ticket_number }}</span>
                                    </td>
                                    <td align="right" style="color:#71717A;">
                                        <strong>Dihantar pada:</strong>
                                        {{ $ticket->created_at->format('d M Y, g:i A') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Status:</strong>
                                        <span style="background:#DBEAFE;color:#2563EB;border-radius:6px;padding:2px 10px 2px 8px;font-size:13px;font-weight:600;vertical-align:middle;">
                                            {{ $ticket->status->name }}
                                        </span>
                                    </td>
                                    <td align="right">
                                        <strong>Keutamaan:</strong>
                                        @php
                                            $priorityColor = [
                                                'urgent' => ['#DC2626','#FEF2F2'],
                                                'high' => ['#CA8A04','#FEF9C3'],
                                                'medium'=> ['#2563EB','#EFF6FF'],
                                                'low' => ['#71717A','#F4F4F5'],
                                            ][$ticket->priority] ?? ['#2563EB','#EFF6FF'];
                                        @endphp
                                        <span style="background:{{ $priorityColor[1] }};color:{{ $priorityColor[0] }};border-radius:6px;padding:2px 10px 2px 8px;font-size:13px;font-weight:600;">
                                            {{ ucfirst($ticket->priority) }}
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
                                    <td colspan="2" style="font-size:16px;font-family:Poppins,Arial,sans-serif;font-weight:600;color:#2563EB;padding-bottom:8px;">Maklumat Pelapor</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;width:150px;padding:4px 0;">Nama</td>
                                    <td>{{ $ticket->user->name }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">E-mel</td>
                                    <td>{{ $ticket->user->email }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Bahagian</td>
                                    <td>{{ $ticket->user->department }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Unit</td>
                                    <td>{{ $ticket->user->division }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Jawatan</td>
                                    <td>{{ $ticket->user->position }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:24px;">
                            <table width="100%" cellpadding="0" cellspacing="0" style="border-spacing:0;font-size:14px;">
                                <tr>
                                    <td colspan="2" style="font-size:16px;font-family:Poppins,Arial,sans-serif;font-weight:600;color:#2563EB;padding-bottom:8px;">Maklumat Aduan</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;width:150px;padding:4px 0;">Kategori</td>
                                    <td>{{ $ticket->category->name }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Tajuk</td>
                                    <td>{{ $ticket->title }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#71717A;padding:4px 0;">Lokasi</td>
                                    <td>{{ $ticket->location }}</td>
                                </tr>
                                @if($ticket->equipmentItem)
                                    <tr>
                                        <td style="color:#71717A;padding:4px 0;">Peralatan Berkaitan</td>
                                        <td>{{ $ticket->equipmentItem->brand }} {{ $ticket->equipmentItem->model }}</td>
                                    </tr>
                                @endif
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:24px;">
                            <div style="font-size:14px;color:#18181B;">
                                <span style="font-weight:600;color:#2563EB;">Perihal Aduan:</span><br>
                                <span>{{ $ticket->description }}</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Response Time Panel -->
                    <tr>
                        <td colspan="2" style="padding-top:24px;">
                            <div style="background:#F4F4F5;border-radius:8px;padding:16px 20px;">
                                <span style="font-weight:600;color:#2563EB;">Jangkaan Masa Respon:</span>
                                <ul style="padding-left:24px;margin:8px 0 0 0;color:#3F3F46;">
                                    @if($ticket->priority === 'urgent')
                                        <li>Segera: Respon dalam masa 2-4 jam waktu bekerja</li>
                                    @elseif($ticket->priority === 'high')
                                        <li>Tinggi: Respon dalam 8-12 jam waktu bekerja</li>
                                    @elseif($ticket->priority === 'medium')
                                        <li>Sederhana: Respon dalam 1-2 hari bekerja</li>
                                    @else
                                        <li>Rendah: Respon dalam 3-5 hari bekerja</li>
                                    @endif
                                </ul>
                                @if($ticket->due_at)
                                    <div style="margin-top:8px;color:#18181B;">
                                        <strong>Jangkaan Selesai:</strong> {{ $ticket->due_at->format('d M Y, g:i A') }}
                                    </div>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <!-- Next Steps Callout -->
                    <tr>
                        <td colspan="2" style="padding-top:24px;">
                            <div style="border-left:4px solid #2563EB;padding:12px 0 12px 16px;background:#EFF6FF;border-radius:6px;font-size:14px;">
                                <strong style="color:#2563EB;">Apa Seterusnya?</strong>
                                <ol style="margin:8px 0 0 18px;padding:0;color:#18181B;">
                                    <li>Pasukan ICT akan menyemak dan mengutamakan aduan anda.</li>
                                    <li>Juruteknik akan ditugaskan untuk aduan ini.</li>
                                    <li>Anda akan menerima kemas kini sepanjang proses aduan.</li>
                                    <li>Juruteknik mungkin menghubungi anda untuk maklumat tambahan.</li>
                                </ol>
                            </div>
                        </td>
                    </tr>

                    <!-- MYDS Button (Track Status) -->
                    <tr>
                        <td colspan="2" align="center" style="padding-top:26px;">
                            <a href="{{ route('public.track').'?tracking_number='.$ticket->ticket_number }}"
                               style="background:#2563EB;color:#fff;font-family:Poppins,Arial,sans-serif;font-size:16px;font-weight:600;display:inline-block;padding:12px 30px;border-radius:6px;text-decoration:none;box-shadow:0 2px 6px rgba(37,99,235,0.16);">
                                Jejak Status Tiket
                            </a>
                        </td>
                    </tr>

                    <!-- Emergency Info (MYDS Callout style) -->
                    <tr>
                        <td colspan="2" style="padding-top:32px;">
                            <div style="background:#FEF2F2;border-left:5px solid #DC2626;padding:16px 24px;border-radius:6px;">
                                <span style="font-weight:600;color:#DC2626;">Sokongan Kecemasan:</span>
                                <span style="color:#B91C1C;">Jika ini isu kritikal yang menjejaskan operasi, sila hubungi talian kecemasan 24/7: <b>+60 3-yyyy yyyy</b></span>
                            </div>
                        </td>
                    </tr>

                    <!-- Important Notes -->
                    <tr>
                        <td colspan="2" style="padding-top:24px;">
                            <ul style="font-size:13px;color:#71717A;line-height:1.6;padding-left:18px;">
                                <li>Sila simpan nombor tiket untuk rujukan akan datang.</li>
                                <li>Status tiket boleh dijejak pada pautan di atas.</li>
                                <li>Boleh balas e-mel ini untuk maklumat tambahan.</li>
                                <li>Elakkan membuat tiket aduan berulang untuk isu yang sama.</li>
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
                                Talian Kecemasan: +60 3-yyyy yyyy (24/7)<br>
                                Waktu Operasi: Isnin - Jumaat, 8:00 pagi – 5:00 petang
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top:30px;padding-bottom:8px;text-align:center;font-size:12px;color:#A1A1AA;">
                            &copy; {{ date('Y') }} Bahagian Pengurusan Maklumat (BPM), Kementerian Pelancongan, Seni dan Budaya Malaysia. Dikuasakan oleh ICTServe (iServe).
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
