# Jadual Data Pengguna & Organisasi Teras (v1.0)

Dokumen ini menyediakan gambaran keseluruhan tahap tinggi mengenai jadual pangkalan data teras dalam ICTServe (iServe) v1.0, komponen Laravel yang berkaitan, serta tujuan penggunaannya dalam sistem. Penambahbaikan selaras dengan PRINSIP REKA BENTUK MYGOVEA (18 Prinsip) dan MYDS (Malaysia Government Design System).
<!-- Nota: Pemetaan prinsip MyGOVEA disediakan di bahagian akhir untuk verifikasi pematuhan. -->

---

## 1. Jadual Data Pengguna & Organisasi Teras

Jadual-jadual ini mendasari pengurusan pengguna, peranan, dan struktur organisasi, sejajar dengan prinsip Berpaksikan Rakyat, Komunikasi, Struktur Hierarki dan Tipografi.

### 1.1 `users` (Pengguna)

Menyimpan maklumat semua pengguna sistem. Versi v1.0 telah diperkemas untuk menghapuskan medan modul legasi dan menambah integrasi MYDS.

- **Model:** `app/Models/User.php`
- **Controller:** `app/Http/Controllers/UserController.php`, pelbagai pengawal autentikasi
- **Factory:** `Database\Factories\UserFactory.php`
- **Seeder:** `Database\Seeders\UserSeeder.php`, `Database\Seeders\AdminUserSeeder.php`

#### Prinsip Berkaitan Pengguna

- **Berpaksikan Rakyat**: Pengurusan pengguna direka untuk memenuhi keperluan sebenar pengguna/agensi.
- **Komunikasi**: Pengguna boleh menerima notifikasi dan berinteraksi dalam sistem.

---

### 1.2 `roles`, `permissions`, `model_has_roles`, dsb

Jadual ini diurus oleh pakej [spatie/laravel-permission](https://github.com/spatie/laravel-permission) dan mendefinisikan kawalan akses terperinci.

- **Model:** `Spatie\Permission\Models\Role`, `Spatie\Permission\Models\Permission`
- **Seeder:** `Database\Seeders\RoleAndPermissionSeeder.php`

#### Prinsip Berkaitan Settings

- **Kawalan Pengguna**: Pengguna diberikan kawalan akses berdasarkan peranan dan kebenaran.
- **Pencegahan Ralat**: Pengurusan peranan/kebenaran membantu mengurangkan kesilapan akses.

---

### 1.3 `departments`, `positions`, `grades`

Jadual ini menyimpan struktur organisasi MOTAC.

- **Model:** `app/Models/Department.php`, `app/Models/Position.php`, `app/Models/Grade.php`
- **Controller:** `app/Http/Controllers/Admin/DepartmentController.php`, dsb.
- **Seeder:** `Database\Seeders\DepartmentSeeder.php`, `Database\Seeders\PositionSeeder.php`, `Database\Seeders\GradesSeeder.php`

#### Prinsip Berkaitan Organisasi

- **Struktur Hierarki**: Menyusun organisasi secara hierarki untuk navigasi & pengurusan jelas.
- **Seragam**: Penyeragaman struktur organisasi di seluruh modul.

---

## 2. Jadual Peralatan ICT & Lokasi

Jadual ini khusus untuk pengurusan aset fizikal ICT dan lokasinya, selaras dengan prinsip Teknologi Bersesuaian, Fleksibel, Kandungan Terancang dan Seragam.

### 2.1 `equipment_categories` & `sub_categories`

Mengatur peralatan dalam struktur hierarki.

- **Model:** `app/Models/EquipmentCategory.php`, `app/Models/SubCategory.php`
- **Controller:** `app/Http/Controllers/Admin/EquipmentCategoryController.php`
- **Seeder:** `Database\Seeders\EquipmentCategorySeeder.php`, `Database\Seeders\SubCategoriesSeeder.php`

---

### 2.2 `equipment`

Menyimpan butiran semua peralatan ICT yang boleh dipinjam.

- **Model:** `app/Models/Equipment.php`
- **Controller:** `app/Http/Controllers/Admin/EquipmentController.php`
- **Seeder:** `Database\Seeders\EquipmentSeeder.php`

---

### 2.3 `locations`

Mengurus lokasi fizikal peralatan boleh disimpan atau digunakan.

- **Model:** `app/Models/Location.php`
- **Controller:** `app/Http/Controllers/Admin/LocationController.php`
- **Seeder:** `Database\Seeders\LocationSeeder.php`

#### Prinsip Berkaitan Helpdesk

- **Realistik**: Lokasi dan kategori diurus mengikut keperluan sebenar operasi.
- **Struktur Hierarki**: Mengatur kategori, subkategori dan lokasi secara hierarki.

---

## 3. Jadual Modul Pinjaman ICT

Jadual ini khusus untuk fungsi pinjaman peralatan ICT, menepati prinsip Kawalan Pengguna, Fleksibel dan Pencegahan Ralat.

### 3.1 `loan_applications` & `loan_application_items`

Merekod semua permohonan pinjaman peralatan ICT dan item yang dimohon.

- **Model:** `app/Models/LoanApplication.php`, `app/Models/LoanApplicationItem.php`
- **Controller:** `app/Http/Controllers/LoanApplicationController.php`
- **Livewire:** `App\Livewire\ResourceManagement\LoanApplication\ApplicationForm.php`
- **Seeder:** `Database\Seeders\LoanApplicationSeeder.php`

---

### 3.2 `loan_transactions` & `loan_transaction_items`

Merekod pengeluaran dan pemulangan item peralatan yang dipinjam.

- **Model:** `app/Models/LoanTransaction.php`, `app/Models/LoanTransactionItem.php`
- **Controller:** `app/Http/Controllers/LoanTransactionController.php`
- **Livewire:** `App\Livewire\ResourceManagement\Admin\BPM\ProcessIssuance.php`, `ProcessReturn.php`
- **Seeder:** `Database\Seeders\LoanTransactionSeeder.php`

#### Prinsip Berkaitan

- **Fleksibel**: Proses pinjaman boleh diubah suai mengikut keperluan.
- **Pencegahan Ralat**: Kawalan dan pengesahan jelas semasa transaksi.

---

## 4. Jadual Modul Helpdesk & Sokongan ICT

Jadual untuk menyokong sistem helpdesk dan pengurusan tiket, berteraskan prinsip Komunikasi, Kawalan Pengguna dan Panduan.

### 4.1 `helpdesk_tickets`

Menyimpan maklumat teras setiap tiket aduan kerosakan ICT yang dihantar pengguna.

- **Model:** `app/Models/HelpdeskTicket.php`
- **Controller:** `app/Http/Controllers/Helpdesk/TicketController.php`
- **Livewire:** `App\Livewire\Helpdesk\TicketForm.php`, `TicketList.php`, `TicketDetail.php`
- **Factory:** `Database\Factories\HelpdeskTicketFactory.php`
- **Seeder:** `Database\Seeders\HelpdeskTicketSeeder.php`

---

### 4.2 `helpdesk_categories`

Menentukan kategori tiket helpdesk (cth: 'Perkakasan', 'Perisian', 'Rangkaian').

- **Model:** `app/Models/HelpdeskCategory.php`
- **Controller:** `app/Http/Controllers/Admin/HelpdeskCategoryController.php`
- **Factory:** `Database\Factories\HelpdeskCategoryFactory.php`
- **Seeder:** `Database\Seeders\HelpdeskCategorySeeder.php`

---

### 4.3 `helpdesk_comments`

Menyimpan komen dan respons berangkai bagi setiap tiket helpdesk untuk komunikasi antara pengguna dan agen IT.

- **Model:** `app/Models/HelpdeskComment.php`
- **Controller:** Diurus dalam `app/Http/Controllers/Helpdesk/TicketController.php`
- **Factory:** `Database\Factories\HelpdeskCommentFactory.php`
- **Seeder:** Disemai bersama `HelpdeskTicketSeeder.php`

#### 4.4 Prinsip Berkaitan

- **Komunikasi**: Memudahkan komunikasi jelas antara pengguna dan penyokong IT.
- **Panduan & Dokumentasi**: Memudahkan rujukan dan rekod interaksi.

---

## 5. Jadual Aliran Kerja & Utiliti Berkongsi

Menyokong aliran kerja dan fungsi sistem yang digunakan oleh pelbagai modul, menepati prinsip Struktur Hierarki, Kawalan Pengguna, Komunikasi dan Realistik.

### 5.1 `approvals`

Jadual polimorfik untuk menyimpan maklumat kelulusan pelbagai proses seperti permohonan pinjaman ICT.

- **Model:** `app/Models/Approval.php`
- **Controller:** `app/Http/Controllers/ApprovalController.php`
- **Livewire:** `App\Livewire\ResourceManagement\Approval\Dashboard.php`
- **Seeder:** `Database\Seeders\ApprovalSeeder.php`

---

### 5.2 `notifications`

Menyimpan notifikasi pangkalan data untuk pengguna.

- **Model:** `app/Models/Notification.php`
- **Controller:** `app/Http/Controllers/NotificationController.php`
- **Seeder:** `Database\Seeders\NotificationSeeder.php`

---

### 5.3 `settings`

Jadual satu baris untuk menyimpan tetapan global aplikasi.

- **Model:** `app/Models/Setting.php`
- **Controller:** `app/Http/Controllers/Admin/SettingsController.php`
- **Seeder:** `Database\Seeders\SettingsSeeder.php`

#### 5.4 Prinsip Berkaitan Settings

- **Tetapan Lalai**: Mengurus nilai lalai aplikasi untuk memudahkan penggunaan.
- **Pencegahan Ralat**: Mengurangkan kesilapan dengan tetapan lalai yang sesuai.
- **Kebolehcapaian & Fleksibel**: Tetapan boleh diubah mengikut keperluan.

---

## 6. Senarai Semak Pematuhan 18 Prinsip MyGOVEA (Ringkas)

- **Berpaksikan Rakyat**: Struktur jadual menyokong pengalaman pengguna yang jelas
- **Berpacukan Data**: Skema konsisten dan boleh audit
- **Kandungan Terancang**: Penamaan jadual/medan konsisten dan bermakna
- **Teknologi Bersesuaian**: Laravel 12 + MySQL piawai + Livewire 3 + Filament 4
- **Antara Muka Minimalis dan Mudah**: Skema memudahkan pemetaan UI ringkas
- **Seragam**: Konvensyen penamaan seragam merentas modul
- **Paparan/Menu Jelas**: Medan menyokong label/paparan yang jelas
- **Realistik**: Jadual memodelkan kekangan operasi sebenar
- **Kognitif**: Struktur data mengurangkan beban kognitif pembangun
- **Fleksibel**: Jadual polimorfik dan konfigurasi tetapan
- **Komunikasi**: Jadual komen/notifikasi menyokong komunikasi
- **Struktur Hierarki**: Model organisasi dan kategori berhierarki
- **Komponen UI/UX**: Data menyokong komponen UI standard MYDS
- **Tipografi**: Medan label/teks membolehkan tipografi konsisten MYDS
- **Tetapan Lalai**: Jadual `settings` mengurus lalai sistem
- **Kawalan Pengguna**: Jadual peranan/kebenaran
- **Pencegahan Ralat**: Kekangan skema dan validasi menyokong pencegahan
- **Panduan & Dokumentasi**: Fail ini berperanan sebagai rujukan skema

---

## See Also

- [System Design Documentation](Dokumentasi_Reka_Bentuk_Sistem_ICTServe(iServe).md)
- [ICT Equipment Loan Application Flow](Dokumentasi_Flow_Sistem_Permohonan_Pinjaman_Aset_ICT_ICTServe(iServe).md)
- [Email Notification System](Dokumentasi_Sistem_Notifikasi_E-mel_ICTServe(iServe).md)
- [General System Documentation](Dokumentasi_Sistem_ICTServe(iServe).md)
- [UI/UX Design Documentation](Dokumentasi_Reka_Bentuk_ICTServe(iServe).md)

---

## Contributor Guidance & MYDS/MyGovEA Compliance

This document must be maintained in accordance with the standards set by the Malaysia Government Design System (MYDS) and MyGovEA principles. All contributors must adhere to the following:

- **Clarity and Conciseness**: Ensure all descriptions are clear, unambiguous, and easy for both technical and non-technical stakeholders to understand.
- **MYDS Compliance**: All UI/UX components referenced or documented must align with the official MYDS component library, tokens, and accessibility standards.
- **MyGovEA Principles**: Documentation should reflect citizen-centric design ("Berpaksikan Rakyat"), simplicity ("Antara Muka Minimalis dan Mudah"), and uniformity ("Seragam").
- **Version Control**: All changes must be tracked via Git, with clear commit messages explaining the purpose of the update.
- **Review Process**: Significant changes must be submitted via a pull request and reviewed by the project maintainer to ensure compliance and accuracy.

Failure to adhere to these standards may result in the rejection of contributions.

---

## References

- **MYDS Official Documentation**: [design.digital.gov.my](https://design.digital.gov.my/en)
- **MyGovEA Design Principles**: [MyGovEA Prinsip Reka Bentuk](https://www.digital.gov.my/storage/2023/11/MyGOVEA-Prinsip-Reka-Bentuk-Perkhidmatan-Digital-Kerajaan.pdf)
- **Laravel 12 Documentation**: [laravel.com/docs/12.x](https://laravel.com/docs/12.x)
- **Filament 4 Documentation**: [filamentphp.com/docs/4.x](https://filamentphp.com/docs/4.x)
- **Livewire 3 Documentation**: [livewire.laravel.com/docs/3.x](https://livewire.laravel.com/docs/3.x)

---

## 7. Integrasi MYDS (Malaysia Government Design System)

### 7.1 Warna & Token MYDS

ICTServe menggunakan sistem token MYDS untuk memastikan keseragaman visual dan aksesibiliti:

- **Primitive Colours**: Warna asas yang tetap untuk semua mod (light/dark)
- **Colour Tokens**: Token dinamik yang berubah mengikut mod (contoh: `bg-primary-600`, `txt-danger`)
- **Focus Rings**: Untuk tumpuan papan kekunci (aksesibiliti) dengan `fr-primary`
- **Outline Tokens**: Untuk sempadan dan pemisah dengan `otl-divider`

### 7.2 Tipografi MYDS

- **Heading**: Poppins untuk tajuk dan seksyen
- **Body**: Inter untuk teks badan dan butiran
- **Rich Text Format**: Untuk artikel dan dokumentasi

### 7.3 Komponen MYDS Terintegrasi

Komponen UI yang digunakan dalam ICTServe telah diselaraskan dengan MYDS:

- **Buttons**: Termasuk variasi Primary, Secondary, Danger untuk pelbagai keperluan
- **Forms**: Input, Select, Date Field, Radio, Checkbox mengikut spesifikasi MYDS
- **Feedback**: Alert, Toast, dan Dialog untuk pemberitahuan dan interaksi
- **Tables**: Dengan pengepala, badan, dan kaki meja yang konsisten
- **Layout**: Struktur grid 12-8-4 untuk semua halaman dan seksyen

---

**Catatan Implementasi:**
ICTServe (iServe) adalah penambahbaikan daripada sistem terdahulu dengan fokus pada pematuhan MYDS, kebolehcapaian yang lebih baik, dan pengalaman pengguna yang berpaksikan rakyat. Struktur pangkalan data dikekalkan dengan penambahbaikan untuk memenuhi keperluan semasa.
