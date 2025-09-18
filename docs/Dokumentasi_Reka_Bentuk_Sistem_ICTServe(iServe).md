# Sistem Pengurusan Perkhidmatan ICT MOTAC (ICTServe v1.0)

**Versi Dokumen:** 1.0  
**Tarikh Semakan:** 12 September 2025  
**Penulis:** IzzatFirdaus  
**Berdasarkan:** BORANG PINJAMAN PERALATAN ICT 2024 SEWAAN C, BORANG ADUAN KEROSAKAN ICT, keperluan helpdesk dalaman, dan pematuhan MYDS/MyGOVEA.  
<!-- Nota: Dokumen ini telah disemak untuk pematuhan kepada MYDS dan 18 Prinsip MyGOVEA. -->

---

## See Also

- [Dokumentasi Flow Sistem Permohonan Pinjaman Aset ICT](./Dokumentasi_Flow_Sistem_Permohonan_Pinjaman_Aset_ICT_ICTServe(iServe).md)
- [Dokumentasi Jadual Data Pengguna & Organisasi Teras](./Dokumentasi_Jadual_Data_Pengguna_Organisasi_Teras_ICTServe(iServe).md)
- [Dokumentasi Reka Bentuk ICTServe](./Dokumentasi_Reka_Bentuk_ICTServe(iServe).md)
- [Dokumentasi Sistem ICTServe](./Dokumentasi_Sistem_ICTServe(iServe).md)
- [Dokumentasi Sistem Notifikasi E-mel ICTServe](./Dokumentasi_Sistem_Notifikasi_E-mel_ICTServe(iServe).md)

---

## 1. Gambaran Umum

Sistem Pengurusan Perkhidmatan ICT MOTAC (ICTServe v1.0) adalah platform moden dan fokus yang menggabungkan dua bidang operasi utama:

- **Pengurusan Pinjaman Peralatan ICT:** Memudahkan permintaan, kelulusan, pengeluaran dan pemulangan peralatan ICT (laptop, projektor, dan lain-lain) untuk tujuan rasmi.
- **Pengurusan Helpdesk & Sokongan ICT:** Sistem tiket menyeluruh untuk mengurus permintaan sokongan IT, aduan kerosakan, dan operasi helpdesk.

Sistem ini menyediakan platform berasaskan Laravel 12 yang menyatukan aliran kerja, menguatkuasakan peraturan perniagaan, dan memberikan pengalaman pengguna yang konsisten mengikut [MYDS](https://design.digital.gov.my/) (Malaysia Government Design System). Reka bentuk ini menggabungkan keperluan daripada borang rasmi permohonan dan mencerminkan struktur projek yang dioptimumkan untuk keperluan operasi teras MOTAC.

---

## 2. Objektif Sistem

- **Pengurusan Data Bersatu:** Menyatukan data pengguna, permohonan pinjaman, tiket helpdesk, kelulusan dan notifikasi dalam satu pangkalan data MySQL.
- **Aliran Kerja Automatik & Standard:** Mengautomasi dan menstandardkan proses untuk pinjaman peralatan ICT dan sokongan helpdesk, mematuhi prosedur organisasi yang telah ditetapkan.
- **Akses Berdasarkan Peranan & Keselamatan:** Memastikan pengguna, penyokong, staf BPM dan Agen IT mempunyai tahap akses yang betul dengan langkah keselamatan yang kukuh, termasuk logik kelulusan berdasarkan gred dan polisi kebenaran yang terperinci.
- **Laporan & Notifikasi Masa Sebenar:** Membolehkan laporan masa sebenar mengenai penggunaan sumber dan prestasi sokongan serta memaklumkan pengguna tentang kejadian kritikal melalui e-mel dan notifikasi dalam aplikasi.
- **Seni Bina Modular & Boleh Skala:** Membina sistem menggunakan rangka kerja Laravel 12 MVC dengan pemisahan fungsi yang jelas, menggunakan Livewire untuk antara muka dinamik dan lapisan servis yang tersusun.
- **Sokongan Operasi Diperhebat:** Menyediakan pengurusan tiket sokongan IT yang komprehensif dengan fungsi penugasan, penjejakan, eskalasi dan penyelesaian.
- **Kepatuhan MYDS:** Mematuhi garis panduan Malaysia Government Design System untuk memastikan antara muka dan pengalaman pengguna yang konsisten.

---

## 3. Seni Bina Tahap Tinggi

Sistem ini dibina menggunakan rangka kerja Laravel 12, mengaplikasikan corak Model-View-Controller (MVC) yang dipertingkatkan dengan Livewire untuk antara muka pengguna dinamik dan Filament untuk panel pentadbiran.

### 3.1 Corak MVC Laravel/Livewire

#### Pengawal (Controllers)

Pengawal PHP tradisional mengendalikan permintaan HTTP backend, interaksi API, dan tindakan yang tidak sepenuhnya dikendalikan oleh komponen dinamik front-end. Banyak interaksi antara muka pengguna dikendalikan oleh komponen Livewire untuk pengalaman pengguna yang lebih kaya.

**Pengawal aktif utama termasuk:**

- `App/Http/Controllers/LanguageController.php`: Mengurus penukaran bahasa aplikasi.
- `App/Http/Controllers/WebhookController.php`: Mengendalikan webhook GitHub untuk pencetus deployment, dilindungi oleh pengesahan tandatangan.
- `App/Http/Controllers/ApprovalController.php`: Mengurus interaksi pengguna dengan tugas kelulusan (senarai kelulusan tertunda, sejarah, paparan perincian, pencatatan keputusan).
- `App/Http/Controllers/EquipmentController.php`: Membenarkan pengguna umum melihat senarai peralatan dan perincian.
- `App/Http/Controllers/LoanApplicationController.php`: Mengurus logik backend untuk permohonan pinjaman ICT; termasuk penjanaan PDF untuk borang pinjaman.
- `App/Http/Controllers/LoanTransactionController.php`: Mengendalikan pemprosesan backend untuk pengeluaran dan pemulangan peralatan.
- `App/Http/Controllers/Helpdesk/TicketController.php`: Mengurus operasi tiket helpdesk, penugasan dan kemas kini status.
- `App/Http/Controllers/Helpdesk/DamageReportController.php`: Mengendalikan aduan kerosakan ICT yang dilaporkan oleh pengguna.
- `App/Http/Controllers/NotificationController.php`: Membolehkan pengguna melihat dan mengurus notifikasi sistem mereka.
- `App/Http/Controllers/ReportController.php`: Mengandungi kaedah untuk mendapatkan data pelbagai laporan termasuk analitik pinjaman dan helpdesk.
- `App/Http/Controllers/Admin/GradeController.php`: Mengurus operasi CRUD untuk gred organisasi.
- `App/Http/Controllers/Admin/EquipmentController.php`: Mengurus operasi CRUD untuk inventori peralatan.
- `App/Http/Controllers/Admin/HelpdeskCategoryController.php`: Mengurus kategori dan keutamaan tiket helpdesk.
- **Pengawal asas:** Fungsi asas melalui `Controller.php` dan pengawal autentikasi (Fortify/Jetstream).

#### Model

Mewakili dan mengurus data menggunakan Eloquent ORM, termasuk hubungan polimorfik untuk kelulusan dan jejak audit automatik.

**Model teras:**

- `User`: Pengguna sistem dengan peranan dan data organisasi
- `Department`: Jabatan dan unit organisasi
- `Position`: Jawatan dalam MOTAC
- `Grade`: Gred organisasi dengan hierarki kelulusan
- `Equipment`: Pengurusan inventori peralatan ICT
- `EquipmentCategory`: Pengkategorian peralatan
- `SubCategory`: Sub-kategori peralatan
- `Location`: Lokasi fizikal penyimpanan/penggunaan peralatan
- `LoanApplication`: Permohonan pinjaman peralatan ICT
- `LoanApplicationItem`: Item individu dalam permohonan pinjaman
- `LoanTransaction`: Transaksi pengeluaran dan pemulangan peralatan
- `LoanTransactionItem`: Item peralatan individu dalam transaksi
- `HelpdeskTicket`: Tiket sokongan IT dan permintaan
- `DamageReport`: Aduan kerosakan ICT
- `HelpdeskCategory`: Pengkategorian tiket (Perkakasan, Perisian, Rangkaian, dll.)
- `HelpdeskComment`: Komen berantai dan respons pada tiket
- `Approval`: Rekod kelulusan polimorfik
- `Notification`: Notifikasi sistem
- `Setting`: Tetapan aplikasi global

#### Paparan (Views)

Templat Blade merender antara muka pengguna, termasuk komponen Livewire untuk seksyen dinamik. Komponen direka untuk mematuhi sepenuhnya piawaian MYDS. Terletak di `resources/views/` dan `resources/views/livewire/`.

**Direktori paparan utama:**

- `resources/views/loan-applications/`: Paparan permohonan pinjaman ICT
- `resources/views/loan-transactions/`: Paparan pengeluaran/pemulangan peralatan
- `resources/views/helpdesk/`: Paparan pengurusan tiket helpdesk
- `resources/views/damage-reports/`: Paparan untuk aduan kerosakan
- `resources/views/livewire/`: Paparan komponen Livewire dinamik
- `resources/views/emails/`: Templat notifikasi e-mel
- `resources/views/components/myds/`: Komponen MYDS (butang, medan teks, pemberitahuan, dll.)

#### Servis

Mengandungi logik perniagaan untuk memastikan pengawal kekal ringkas. Terletak di `app/Services/`.

**Servis teras:**

- `LoanApplicationService`: Logik perniagaan untuk permohonan pinjaman
- `LoanTransactionService`: Pemprosesan pengeluaran/pemulangan peralatan

---

## Contributor Guidance & MYDS/MyGovEA Compliance

- Dokumentasi ini adalah rujukan utama untuk semua perubahan pada seni bina dan reka bentuk sistem.
- Sentiasa rujuk [MYDS](https://design.digital.gov.my/en/docs/design) dan [MyGovEA Principles](https://mygovea.jdn.gov.my/page-prinsip-reka-bentuk/) sebelum membuat perubahan pada antara muka atau aliran kerja.
- Pastikan setiap kemas kini pada kod atau dokumentasi mengekalkan konsistensi, aksesibiliti, dan pematuhan kepada prinsip MYDS/MyGovEA.
- Apabila mengubah struktur data, aliran kerja, atau antara muka, kemas kini dokumen ini dan cross-reference ke dokumen lain dalam `/docs`.

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
