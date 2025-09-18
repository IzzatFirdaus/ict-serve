# Dokumentasi Aliran Sistem Permohonan Pinjaman Peralatan ICT (v4.1 – MYDS & MyGovEA-Compliant)

Dokumen ini menerangkan keseluruhan aliran kerja untuk modul Pinjaman Peralatan ICT, sebagai komponen utama dalam Sistem Pengurusan Sumber Terintegrasi MOTAC. Dokumentasi ini telah dikemaskini sepenuhnya selaras dengan PRINSIP REKA BENTUK MYGOVEA (18 Prinsip) dan Malaysia Government Design System (MYDS) untuk memastikan kepatuhan kepada piawaian UI/UX, aksesibiliti, dan pengalaman pengguna berpaksikan rakyat.

---

## 1. Permulaan Permohonan & Pengesahan

### Proses Permohonan

- Pemohon mengakses dashboard utama dan memilih "Permohonan Pinjaman ICT".
- Borang permohonan disediakan sebagai komponen Livewire, mengikut struktur [ICT EQUIPMENT LOAN APPLICATION FORM - DETAILED BREAKDOWN.txt].
- Borang ini menggunakan grid responsif MYDS (12-8-4) dan komponen rasmi MYDS untuk semua input, tarikh, checkbox, dan dropdown.
- Medan borang:
  - **Bahagian 1**: Maklumat Pemohon (nama, jawatan & gred, bahagian/unit, tujuan, telefon, lokasi, tarikh pinjaman & dijangka pulang).
  - **Bahagian 2**: Maklumat Pegawai Bertanggungjawab (checkbox: sama dengan pemohon, atau isikan maklumat pegawai).
  - **Bahagian 3**: Butiran Peralatan (jadual permohonan peralatan, jenis, kuantiti, catatan).
  - **Bahagian 4**: Pengesahan Pemohon/Pegawai Bertanggungjawab (tarikh, nama, tandatangan digital).
  - **Bahagian 5**: Pengesahan Penyokong (Pegawai Gred 41+, pilihan DISOKONG / TIDAK DISOKONG, tarikh, nama, tandatangan digital).

### Komponen Kod Permohonan

- UI: `App\Livewire\ResourceManagement\LoanApplication\ApplicationForm`
- Templat Blade: `resources/views/livewire/resource-management/loan-application/application-form.blade.php`
- Service: `app\Services\LoanApplicationService`
- Model: `App\Models\LoanApplication`, `App\Models\LoanApplicationItem`
- Request: `app\Http\Requests\StoreLoanApplicationRequest`, `UpdateLoanApplicationRequest`
- Policy: `app\Policies\LoanApplicationPolicy`
- Notifikasi: `App\Notifications\ApplicationSubmitted`

### MYDS & MyGovEA Compliance Permohonan

- **UI/UX**: Semua medan dan komponen mengikut MYDS, warna, tipografi, spacing, dan token.
- **Aksesibiliti**: ARIA label, contrast ratio ≥ 4.5:1, navigasi keyboard.
- **Error Prevention**: Validasi Livewire & backend, mesej ralat jelas dan actionable.
- **Berpaksikan Rakyat**: Maklumat auto-isi, susunan logik, bantuan inline.

---

## 2. Aliran Kelulusan Permohonan

### Proses Kelulusan

- Selepas penghantaran, permohonan masuk ke senarai semakan pegawai penyokong (Gred 41+).
- Pegawai menyemak, memberi keputusan (DISOKONG / TIDAK DISOKONG) dengan komen.
- Status permohonan dikemaskini serta notifikasi dihantar kepada pemohon dan BPM.

### Komponen Kod Kelulusan

- UI: `App\Livewire\ResourceManagement\Approval\Dashboard`
- Service: `app\Services\ApprovalService`
- Controller: `App\Http\Controllers\ApprovalController`
- Model: `App\Models\Approval`, `App\Models\LoanApplication`, `App\Models\LoanApplicationItem`
- Policy: `app\Policies\LoanApplicationPolicy`, `app\Policies\ApprovalPolicy`
- Notifikasi: `App\Notifications\ApplicationNeedsAction`, `ApplicationApproved`, `ApplicationRejected`, `LoanApplicationReadyForIssuanceNotification`

### MYDS & MyGovEA Compliance Kelulusan

- **Struktur Hierarki**: Proses kelulusan bertingkat, status jelas melalui tag MYDS.
- **Komunikasi**: Notifikasi dua saluran (emel, sistem).
- **Seragam**: Semua modul kelulusan guna komponen dan token yang konsisten.

---

## 3. Proses Pengeluaran Peralatan

### Proses Pengeluaran

- Permohonan yang diluluskan diproses BPM.
- Staf BPM memilih aset spesifik, merekod pengeluaran (jenis, jenama, model, siri, aksesori).
- Pengesahan digital kedua-dua pihak (pengeluar dan penerima) melalui MYDS Alert Dialog.
- Status aset ditukar kepada `on_loan`.

### Komponen Kod Pengeluaran

- UI: `App\Livewire\ResourceManagement\Admin\BPM\ProcessIssuance`
- Service: `app\Services\LoanTransactionService` (`processNewIssue()`)
- Templat: `resources/views/loan_transactions/issue.blade.php`
- Model: `App\Models\LoanTransaction`, `LoanTransactionItem`, `Equipment`, `LoanApplication`
- Policy: `app\Policies\LoanTransactionPolicy`
- Notifikasi: `App\Notifications\EquipmentIssuedNotification`

### MYDS & MyGovEA Compliance Pengeluaran

- **Paparan Terancang**: Senarai semak aksesori, status visual (pill/tag MYDS).
- **Fleksibel**: Proses pengeluaran boleh suai mengikut inventori.
- **Pencegahan Ralat**: Validasi dan senarai semak digital.

---

## 4. Proses Pemulangan Peralatan

### Proses Pemulangan

- Pemohon/pegawai memulangkan peralatan; BPM menyemak keadaan peralatan dan aksesori.
- Pengesahan digital kedua-dua pihak (pengembali dan penerima pulangan) melalui Alert Dialog MYDS.
- Status aset dikemas kini kepada `available`, `under_maintenance`, atau lain-lain.
- Catatan dan gambar boleh dimuat naik jika ada isu (mengguna komponen File Upload MYDS).

### Komponen Kod Pemulangan

- UI: `App\Livewire\ResourceManagement\Admin\BPM\ProcessReturn`
- Controller: `App\Http\Controllers\LoanTransactionController`
- Service: `app\Services\LoanTransactionService` (`processExistingReturn()`)
- Templat: `resources/views/loan_transactions/return.blade.php`
- Model: `App\Models\LoanTransaction`, `LoanTransactionItem`, `Equipment`, `LoanApplication`
- Policy: `app\Policies\LoanTransactionPolicy`
- Notifikasi: `App\Notifications\EquipmentReturnedNotification`, `EquipmentReturnReminderNotification`, `EquipmentOverdueNotification`, `EquipmentIncidentNotification`, `EquipmentLostNotification`, `EquipmentDamagedNotification`
- Mailables: `App\Mail\EquipmentReturnedNotification`

### MYDS & MyGovEA Compliance Pemulangan

- **Komponen UI/UX**: Borang pemulangan konsisten, mudah difahami, aksesibiliti terjamin.
- **Pencegahan Ralat**: Senarai semak dan pengesahan keadaan peralatan.
- **Kandungan Terancang**: Nota keadaan dan rekod pemulangan jelas, gambar sebagai bukti.

---

## 5. Komponen Berkongsi & Infrastruktur

### Komponen & Infrastruktur Utama (Berkongsi)

- Model: `User.php`, `Department.php`, `Position.php`, `Grade.php`
- Observer: `app\Observers\BlameableObserver.php` (audit trail, created_by, updated_by, deleted_by)
- Middleware: `auth:sanctum`, `check.gradelevel`, `can:`
- Routing: `routes/web.php` (semua laluan aplikasi)
- Service Provider: `AppServiceProvider`, `AuthServiceProvider`, `EventServiceProvider`
- Konfigurasi: `config/motac.php` (gred minimum, senarai aksesori pinjaman)
- Komponen Blade: `resources/views/components/` (lencana status, pill, tag)
- Helper: `app/Helpers/Helpers.php`

### MYDS & MyGovEA Compliance Berkongsi

- **Seragam & Fleksibel**: Seni bina modular, komponen boleh guna semula.
- **Panduan & Dokumentasi**: Semua kod, polisi dan tetapan didokumentasi.
- **Teknologi Bersesuaian**: Struktur optimum Laravel + Livewire + Filament.

---

## 6. Senarai Semak Pematuhan 18 Prinsip MyGOVEA

| Prinsip                        | Status                  | Penjelasan Ringkas            |
|-------------------------------|-------------------------|-------------------------------|
| Berpaksikan Rakyat            | ✅ Dipenuhi             | Borang jelas, auto-isi, susunan logik |
| Berpacukan Data               | ✅ Dipenuhi             | Rekod status, audit trail     |
| Kandungan Terancang           | ✅ Dipenuhi             | Struktur langkah, senarai semak |
| Teknologi Bersesuaian         | ✅ Dipenuhi             | Laravel 12, Livewire 3, Filament 4 |
| Antara Muka Minimalis dan Mudah | ✅ Dipenuhi           | UI ringkas, token MYDS        |
| Seragam                       | ✅ Dipenuhi             | Pola konsisten, komponen MYDS |
| Paparan/Menu Jelas            | ✅ Dipenuhi             | Dashboard, label status, breadcrumbs |
| Realistik                     | ✅ Dipenuhi             | Syarat gred, ketersediaan aset |
| Kognitif                      | ✅ Dipenuhi             | Kurang beban kognitif, langkah ringkas |
| Fleksibel                     | ✅ Dipenuhi             | Proses boleh suai, modular    |
| Komunikasi                    | ✅ Dipenuhi             | Notifikasi dua saluran        |
| Struktur Hierarki             | ✅ Dipenuhi             | Rantai kelulusan bertahap     |
| Komponen UI/UX                | ✅ Dipenuhi             | Komponen boleh guna semula, MYDS |
| Tipografi                     | ✅ Dipenuhi             | Poppins (heading), Inter (body) |
| Tetapan Lalai                 | ✅ Dipenuhi             | Auto-isi profil, lalai sistem |
| Kawalan Pengguna              | ✅ Dipenuhi             | Policy, peranan, kebenaran    |
| Pencegahan Ralat              | ✅ Dipenuhi             | Validasi, pengesahan          |
| Panduan & Dokumentasi         | ✅ Dipenuhi             | Rujukan kod, fail README.md   |

---

## 7. MYDS Implementation Notes

- **Grid**: Semua paparan mengikut grid responsif 12-8-4 (lihat MYDS-Design-Overview.md).
- **Warna & Token**: Guna token MYDS (lihat MYDS-Colour-Reference.md), tidak hard-coded HEX.
- **Komponen**: Input, select, date, checkbox, pill, tag, button, alert dialog, table, summary list, file upload – semua mengikut spesifikasi MYDS.
- **Aksesibiliti**: ARIA, contrast, keyboard navigation, skiplink, error prevention.
- **Dark Mode**: Sokongan penuh, token automatik (bg-primary-600, txt-danger, dsb).
- **Dokumentasi**: Setiap fungsi dan kelas utama ada PHPDoc ringkas.

---

## Penutup

Aliran sistem pinjaman ICT telah diselaraskan sepenuhnya dengan 18 Prinsip Reka Bentuk MyGOVEA dan MYDS, menjamin aplikasi mesra rakyat, selamat, konsisten, mudah diselenggara dan mendukung keberkesanan operasi digital MOTAC.  
Sebarang penambahbaikan atau maklum balas boleh disalurkan melalui saluran rasmi BPM/MOTAC atau email <design@tech.gov.my>.
