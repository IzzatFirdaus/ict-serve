# ICTServe (iServe): Sistem Notifikasi E-mel (v1.0)

Dokumen ini menerangkan pelaksanaan sistem notifikasi e-mel dalam aplikasi ICTServe (iServe) v1.0. Dalam versi ini, "ciri e-mel" merujuk khusus kepada notifikasi automatik yang dihantar kepada pengguna untuk memaklumkan kejadian dan perubahan status dalam modul teras aplikasi. Dokumentasi ini telah diselaraskan dengan PRINSIP REKA BENTUK MYGOVEA (18 Prinsip).

---

## See Also

- [Dokumentasi Flow Sistem Permohonan Pinjaman Aset ICT](./Dokumentasi_Flow_Sistem_Permohonan_Pinjaman_Aset_ICT_ICTServe(iServe).md)
- [Dokumentasi Jadual Data Pengguna & Organisasi Teras](./Dokumentasi_Jadual_Data_Pengguna_Organisasi_Teras_ICTServe(iServe).md)
- [Dokumentasi Reka Bentuk ICTServe](./Dokumentasi_Reka_Bentuk_ICTServe(iServe).md)
- [Dokumentasi Reka Bentuk Sistem ICTServe](./Dokumentasi_Reka_Bentuk_Sistem_ICTServe(iServe).md)
- [Dokumentasi Sistem ICTServe](./Dokumentasi_Sistem_ICTServe(iServe).md)

---

## 1. Gambaran Umum

Sistem notifikasi e-mel berfungsi sebagai utiliti latar belakang untuk memastikan pengguna, pegawai penyokong, dan pentadbir sentiasa dimaklumkan mengenai perkembangan permohonan mereka. Ia bukan modul yang boleh diakses pengguna secara langsung, sebaliknya menjadi saluran komunikasi utama yang menyokong aliran kerja aplikasi.

Notifikasi dihantar secara automatik untuk kejadian penting dalam modul-modul berikut:

- **Pengurusan Pinjaman Peralatan ICT**
- **Pengurusan Aduan Kerosakan ICT**

Selaras dengan prinsip **Komunikasi** dan **Berpaksikan Rakyat**, sistem ini bertujuan untuk memastikan maklumat sampai kepada semua pihak berkepentingan dengan jelas dan tepat pada masanya.

## 2. Bagaimana Ia Berfungsi: Aliran Notifikasi

Proses notifikasi mengikut pola konsisten berasaskan kejadian di seluruh aplikasi, mematuhi prinsip **Paparan/Menu Jelas**, **Pencegahan Ralat**, dan **Kawalan Pengguna**.

1. **Tindakan Pengguna Berlaku:**  
   Pengguna atau pentadbir melakukan tindakan penting dalam sistem (cth: menghantar permohonan pinjaman, pentadbir menetapkan tiket aduan).

2. **Logik Lapisan Servis:**  
   Kelas servis berkaitan (cth: `LoanService`, `HelpdeskService`) memproses tindakan tersebut.

3. **Notifikasi Dijalankan (Dispatched):**  
   Selepas tindakan berjaya dilaksanakan, servis memanggil `NotificationService` untuk menyediakan dan menjadualkan notifikasi spesifik.

4. **Notifikasi Dihantar:**  
   Sistem menghantar notifikasi kepada pengguna melalui dua saluran:
   - **Pangkalan Data:** Notifikasi dalam aplikasi direkodkan dalam jadual notifikasi, boleh dilihat di dashboard pengguna.
   - **E-mel:** E-mel berbentuk rasmi dihantar ke alamat e-mel pengguna yang berdaftar menggunakan pemandu e-mel aplikasi (cth: SMTP).

```mermaid
graph TD
    A[Tindakan Pengguna (cth: Hantar Permohonan Pinjaman)] --> B{Lapisan Servis (cth: LoanService)}
    B --> C{NotificationService Dipanggil}
    C --> D[Bina Notifikasi Pangkalan Data]
    C --> E[Hantar Notifikasi E-mel]
    D --> F[Pengguna nampak amaran di Dashboard ICTServe]
    E --> G[Pengguna terima e-mel di peti masuk]
```

## 3. Kejadian Utama Notifikasi Mengikut Modul

Jadual berikut menyenaraikan kejadian utama yang akan mencetuskan notifikasi e-mel, selaras dengan prinsip **Komunikasi**, **Pencegahan Ralat**, dan **Panduan & Dokumentasi**.

### 3.1 Modul Pinjaman Peralatan ICT

| Kelas Notifikasi                              | Kejadian Pencetus                              | Penerima              |
|----------------------------------------------- |----------------------------------------------- |-----------------------|
| `LoanApplicationSubmitted`                    | Pengguna menghantar permohonan pinjaman baru.  | Pemohon               |
| `LoanApplicationNeedsAction`                  | Permohonan sedia untuk kelulusan.              | Pegawai Penyokong     |
| `LoanApplicationApproved`                     | Permohonan pinjaman diluluskan.                | Pemohon               |
| `LoanApplicationRejected`                     | Permohonan pinjaman ditolak.                   | Pemohon               |
| `LoanApplicationReadyForIssuanceNotification` | Pinjaman diluluskan sedia untuk diproses.      | Staf BPM              |
| `EquipmentIssuedNotification`                 | Peralatan dikeluarkan kepada pemohon.          | Pemohon               |
| `EquipmentReturnedNotification`               | Peralatan yang dipinjam telah dipulangkan.     | Pemohon               |
| `EquipmentReturnReminderNotification`         | Tarikh akhir pemulangan hampir tiba.           | Pemohon               |
| `EquipmentOverdueNotification`                | Tarikh akhir pemulangan telah melepasi.        | Pemohon, Staf BPM     |
| `EquipmentIncidentNotification`               | Peralatan dilaporkan hilang/rosak.             | Staf BPM, pegawai berkaitan |

### 3.2 Modul Aduan Kerosakan ICT

| Kelas Notifikasi                  | Kejadian Pencetus                              | Penerima                |
|-----------------------------------|----------------------------------------------- |------------------------|
| `DamageReportSubmittedNotification` | Pengguna menghantar aduan kerosakan baru.      | Pengguna, Pasukan IT   |
| `DamageReportAssignedNotification`  | Aduan diberikan kepada agen IT.                | Agen IT                |
| `DamageReportStatusUpdatedNotification` | Status aduan berubah.                      | Pengguna               |
| `DamageReportCommentAddedNotification`  | Komen baru ditambah pada aduan.             | Pengguna, Agen IT      |
| `DamageReportResolvedNotification`    | Aduan telah diselesaikan.                   | Pengguna               |

## 4. Pelaksanaan Teknikal

Sistem notifikasi dibina menggunakan ciri standard Laravel dan kelas servis khusus, mematuhi prinsip **Teknologi Bersesuaian**, **Seragam**, dan **Panduan & Dokumentasi**.

| Komponen               | Laluan / Contoh                                    | Tujuan                                                                 |
|------------------------|----------------------------------------------------|------------------------------------------------------------------------|
| Notification Service   | `app/Services/NotificationService.php`             | Kelas servis pusat untuk penghantaran semua notifikasi.                |
| Notification Classes   | `app/Notifications/`                               | Setiap kejadian notifikasi ada kelas sendiri (cth: `App\Notifications\LoanApplicationApproved`) yang menentukan saluran penghantaran (e-mel, pangkalan data) dan format data. |
| Mailable Classes       | `app/Mail/`                                        | Untuk e-mel kompleks, kelas Mailable (cth: `App\Mail\EquipmentReturnReminder`) digunakan untuk membina kandungan e-mel dan lampiran. |
| Email Templates        | `resources/views/emails/`                          | Templat Blade yang menentukan struktur HTML dan kandungan e-mel keluar. |
| Configuration          | `config/mail.php`, `.env`                          | Fail `.env` dan `config/mail.php` digunakan untuk tetapan pemandu e-mel (SMTP, Mailgun) dan kelayakan. Untuk pembangunan, Mailtrap biasanya digunakan. |

## 5. Pematuhan 18 Prinsip MyGOVEA (Ringkas)

- **Komunikasi**: Notifikasi tepat masa, jelas dan relevan
- **Paparan/Menu Jelas**: Kandungan e-mel dan notifikasi ringkas dan boleh diimbas
- **Kawalan Pengguna**: Keutamaan notifikasi boleh dikonfigurasi (melalui tetapan sistem)
- **Pencegahan Ralat**: Peringatan tarikh akhir dan amaran lewat
- **Panduan & Dokumentasi**: Komen kod dan templat e-mel didokumentasi
- **Teknologi Bersesuaian**: Gunakan saluran e-mel dan pangkalan data standard
- **Seragam**: Pola notifikasi konsisten merentas modul

## 6. Kesimpulan

Dalam versi 1.0 ICTServe (iServe), sistem e-mel adalah utiliti sokongan kritikal yang menumpukan kepada komunikasi. Ia memastikan semua pihak berkepentingan sentiasa dimaklumkan sepanjang aliran kerja pinjaman ICT dan aduan kerosakan, memupuk ketelusan dan meningkatkan pengalaman pengguna tanpa menjadi modul aplikasi yang boleh diakses secara langsung.

Sistem ini selaras dengan PRINSIP REKA BENTUK MYGOVEA, mengutamakan komunikasi jelas, kawalan pengguna, pencegahan ralat serta dokumentasi lengkap untuk kelancaran operasi aplikasi kerajaan.

---

## Contributor Guidance & MYDS/MyGovEA Compliance

- Dokumentasi ini adalah rujukan utama untuk semua perubahan pada sistem notifikasi.
- Sentiasa rujuk [MYDS](https://design.digital.gov.my/en/docs/design) dan [MyGovEA Principles](https://mygovea.jdn.gov.my/page-prinsip-reka-bentuk/) sebelum membuat perubahan pada templat e-mel atau aliran notifikasi.
- Pastikan setiap kemas kini pada kod atau dokumentasi mengekalkan konsistensi, aksesibiliti, dan pematuhan kepada prinsip MYDS/MyGovEA.
- Apabila menambah notifikasi baru, pastikan ia didokumenkan di sini dan di cross-reference dari dokumen lain yang berkaitan dalam `/docs`.

---

## References

- [MYDS Official Site](https://design.digital.gov.my/)
- [MYDS Figma Kit](https://www.figma.com/file/svmWSPZarzWrJ116CQ8zpV/MYDS-(Beta))
- [MYDS Storybook](https://myds-storybook.vercel.app/)
- [MyGovEA Principles](https://mygovea.jdn.gov.my/page-prinsip-reka-bentuk/)
- [Laravel Documentation](https://laravel.com/docs)
- [Filament Documentation](https://filamentphp.com/docs)
- [Livewire Documentation](https://laravel-livewire.com/docs)
- [See Also: Dokumentasi Sistem ICTServe](./Dokumentasi_Sistem_ICTServe(iServe).md)
