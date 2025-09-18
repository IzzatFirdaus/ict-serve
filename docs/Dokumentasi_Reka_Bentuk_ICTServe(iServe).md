# ICTServe (iServe) - Sistem Pengurusan Perkhidmatan ICT MOTAC

Dokumentasi Bahasa Reka Bentuk Versi 1.0 | Untuk Bahagian Pengurusan Maklumat (BPM)

<!-- Dokumen ini memetakan keputusan reka bentuk kepada 18 Prinsip MyGOVEA; rujuk bahagian "Pematuhan MyGOVEA" di akhir. -->

---

## 1. Prinsip Teras Reka Bentuk

### 1.1 Berpaksikan Rakyat (Mesra Pengguna & Jelas)

- **Akses Pengguna:** Reka bentuk aplikasi menempatkan keperluan dan kehendak pengguna sebagai fokus utama. Paparan antara muka, penggunaan menu, mesej dan komponen dibuat mudah difahami dan relevan.
- **Bahasa Melayu Utama:** Bahasa utama antara muka ialah Bahasa Melayu, dengan pilihan Inggeris secara kontekstual.
- **Penglibatan Pengguna:** Pengguna dilibatkan dalam setiap fasa pembangunan untuk memastikan aplikasi memenuhi keperluan mereka.
- **Memudahkan Pengguna:** Penggunaan navigasi dua klik ke fungsi utama, penandaan medan wajib dengan asterisk merah (\*), dan arahan jelas.

### 1.2 Berpacukan Data

- **Pengurusan Data Selamat:** Data perkhidmatan ICT diurus secara selamat dan mematuhi undang-undang privasi.
- **Pemodelan Data:** Struktur data pinjaman peralatan dan aduan kerosakan dianalisis dan direka supaya mudah difahami oleh semua pihak.
- **Perkongsian Data:** Data perkhidmatan ICT dikongsi mengikut keperluan, persetujuan dan menambah nilai kepada agensi dan pengguna.

### 1.3 Kandungan Terancang

- **Penyediaan Kandungan:** Kandungan, paparan dan maklumat aplikasi ICTServe disusun secara jelas, tepat dan terancang agar matlamat perkhidmatan tercapai.
- **Fasa Reka Bentuk:** Meliputi reka bentuk konsep dan seni bina, termasuk integrasi dengan sistem lain dan keselamatan data pengguna.

### 1.4 Teknologi Bersesuaian

- **Pilihan Teknologi:** Penggunaan Laravel 12, Filament, dan MYDS sebagai teknologi dan alat pembangunan yang sesuai dengan objektif projek.
- **Keselarasan Infrastruktur:** Infrastruktur, hosting dan sistem keselamatan dipilih mengikut keperluan aplikasi perkhidmatan ICT.

### 1.5 Antara Muka Minimalis dan Mudah

- **Minimalis:** Antara muka direka supaya mudah difahami, bebas komponen tidak perlu, dan navigasi intuitif.
- **Responsif:** Rekaan responsif mengikut prinsip 12-8-4 grid MYDS untuk pelbagai peranti dan saiz skrin.

### 1.6 Seragam

- **Keseragaman:** Penggunaan piawaian konsisten dari MYDS untuk memastikan kualiti, kebolehgunaan dan kebolehoperasian antara modul aplikasi.
- **Penyelenggaraan Mudah:** Piawaian memudahkan kemas kini dan mengurangkan kos pembangunan.

### 1.7 Paparan/Menu Jelas

- **Paparan & Menu:** Elemen dan menu dipaparkan secara konsisten, mudah dikenali, dan memberikan maklum balas yang jelas kepada pengguna.

### 1.8 Realistik

- **Ketepatan Fungsi:** Aplikasi dibangunkan mengikut keperluan sebenar pengguna BPM dan keupayaan teknikal pasukan.
- **Analisis Keperluan:** Pengujian dan penambahbaikan berterusan berdasarkan maklum balas pengguna sistem.

### 1.9 Kognitif

- **Reka Bentuk Kognitif:** Antara muka memudahkan proses kognitif pengguna, mengurangkan beban maklumat berlebihan dalam borang pinjaman dan aduan.
- **Maklum Balas Visual:** Penggunaan maklum balas visual dan naratif untuk meningkatkan pengalaman pengguna.

### 1.10 Fleksibel

- **Kebolehskalaan & Modular:** Aplikasi mudah diperluas, diperkecil atau diubah suai tanpa menjejaskan prestasi.
- **Konfigurasi & Integrasi:** Pengguna boleh mengubah tetapan aplikasi. Mudah diintegrasi dengan sistem lain melalui API/Web Services.
- **Pengurusan Data Dinamik:** Mudah untuk import, eksport dan transformasi data perkhidmatan ICT.

### 1.11 Komunikasi

- **Komunikasi Berkesan:** Proses komunikasi antara pengguna, pasukan pembangunan dan pihak berkepentingan adalah jelas dan terbuka.
- **Pengurusan Perubahan:** Semua perubahan dalam aliran kerja ICT dimaklumkan kepada pihak terlibat untuk mengelakkan konflik.

### 1.12 Struktur Hierarki

- **Susunan Hierarki:** Elemen antara muka diatur secara teratur mengikut hierarki logik untuk memudahkan navigasi dan penggunaan.
- **Struktur Papan Pemuka:** Halaman utama, aduan kerosakan, pinjaman peralatan, sejarah perkhidmatan dan subsistem berkaitan.

### 1.13 Komponen Antara Muka & Pengalaman Pengguna (UI/UX)

- **Komponen UI:** Butang, input, menu, bar navigasi dan petunjuk menggunakan komponen MYDS secara konsisten.
- **Pengalaman UX:** Interaksi pengguna, persepsi terhadap aplikasi dan respons emosi diambil kira untuk menjamin kepuasan.

### 1.14 Tipografi

- **Jenis & Saiz Huruf:** Pemilihan jenis huruf, saiz dan jarak antara huruf mengikut piawaian MYDS untuk keterbacaan.
- **Hierarki Visual:** Menggunakan tipografi untuk membentuk hierarki maklumat dalam borang dan paparan.

### 1.15 Tetapan Lalai

- **Nilai Lalai:** Penetapan nilai lalai pada konfigurasi, reka bentuk antara muka, keselamatan dan privasi untuk memudahkan penggunaan serta meningkatkan keselamatan.
- **Responsif Peranti:** Tetapan lalai mengambil kira pelbagai dimensi peranti mengikut grid 12-8-4 MYDS.

### 1.16 Kawalan Pengguna

- **Kawalan Interaktif:** Pengguna diberikan kawalan jelas melalui butang, input, menu dan penunjuk dalam semua borang.
- **Konsisten & Mudah Diakses:** Kawalan konsisten, mudah diakses dan sesuai dengan peranti.

### 1.17 Pencegahan Ralat

- **Panduan & Bantuan:** Menyediakan penunjuk dan bantuan jelas untuk elak kesilapan dalam borang pinjaman dan aduan.
- **Pengesahan & Ujian:** Pengesahan tindakan kritikal dan ujian pengguna untuk meningkatkan ketepatan data.

### 1.18 Panduan & Dokumentasi

- **Panduan Pembangunan:** Arahan dan prosedur pembangunan, ujian dan pelaksanaan aplikasi.
- **Dokumentasi Teknikal & Pengguna:** Manual pengguna, tutorial, FAQ, sejarah perubahan dan dokumentasi keselamatan.
- **Rujukan SPDK:** Agensi disarankan merujuk dokumen SPDK secara berterusan untuk penambahbaikan.

---

## 2. Asas Visual

### 2.1 Palet Warna

| Peranan   | Mod Cerah            | Mod Gelap | Penggunaan                                      |
| --------- | -------------------- | --------- | ----------------------------------------------- |
| Utama     | #0055A4 (Biru MOTAC) | #3D8FD1   | Butang utama, keadaan aktif, pautan, tajuk.     |
| Sekunder  | #6c757d (Kelabu)     | #adb5bd   | Tindakan sekunder, teks tidak aktif, sempadan.  |
| Aksen     | #E60000 (Merah BPM)  | #FF5252   | Ikon grid aplikasi, sorotan, notifikasi segera. |
| Latar     | #F8F9FA              | #121826   | Latar kandungan utama.                          |
| Permukaan | #FFFFFF              | #1E293B   | Kad, panel borang, modals.                      |
| Kritikal  | #DC3545              | #F87171   | Ralat, tindakan merosakkan (cth: butang hapus). |
| Berjaya   | #28A745              | #4ADE80   | Tindakan selesai, mesej kejayaan.               |
| Amaran    | #FFC107              | #FFD60A   | Status tertunda, amaran berhati-hati.           |

### 2.2 Tipografi

- **Font Utama:** Inter untuk keterbacaan Bahasa Melayu dan Inggeris.
- **Skala:**
  - h1: 1.75rem (28px) • Semibold
  - h2: 1.5rem (24px) • Semibold
  - h3: 1.25rem (20px) • Medium
  - Badan: 0.875rem (14px) • Regular
  - Label: 0.75rem (12px) • Medium
- **Ketinggian Garis:** 1.6 untuk teks badan bagi keterbacaan optimum.

### 2.3 Ikonografi

- **Set Utama:** MYDS Icons dan Bootstrap Icons v1.8+
- **Prinsip Penggunaan:**
  - Ikon digabung dengan label teks untuk kejelasan.
  - Saiz standard: 16px untuk teks, 24px untuk butang.
  - Penggunaan warna semantik (merah untuk hapus, hijau untuk tambah).

---

## 3. Pelaksanaan Jenama

### 3.1 Penggunaan Logo

| Konteks         | Logo           | Format | Spesifikasi                               |
| --------------- | -------------- | ------ | ----------------------------------------- |
| Header Intranet | MOTAC Intranet | SVG    | Tinggi 40px, termasuk teks "intranet".    |
| Header Sistem   | ICTServe       | SVG    | Tinggi 40px, dengan teks "iServe".        |
| Footer          | BPM Rasmi      | SVG    | Tinggi 32px, kotak merah berteks putih.   |
| Eksport PDF     | MOTAC Rasmi    | Vektor | Lebar 20mm, di header dokumen.            |
| Templat E-mel   | MOTAC Rasmi    | PNG    | Lebar 120px, dengan alt text yang sesuai. |

### 3.2 Templat E-mel

- **Struktur:** Gunakan mjml untuk responsif dan konsisten.
- **Penjenamaan:** E-mel bermula dengan header logo MOTAC dan diakhiri footer maklumat penghantar (Bahagian Pengurusan Maklumat).
- **Kandungan:** Subjek jelas, salam formal ("Yang dihormati..."), dan arahan langsung jika respon diperlukan.

---

## 4. Pola Khusus Aliran Kerja

### 4.1 Pengurusan Pinjaman ICT

- **Struktur Borang:** Borang dibahagi kepada bahagian bernombor (BAHAGIAN 1, 2, dst.) mengikut borang rasmi PK.(S).MOTAC.07.(L3).
- **Senarai Semak Peralatan:** Semasa pengeluaran/pulangan, senarai semak aksesori digunakan (Power Adapter, Beg, dll).
- **Aliran Kelulusan:** Sistem memaparkan aliran kelulusan secara visual.

```mermaid
%% Carta alir ini menerangkan langkah utama pinjaman ICT dari permohonan sehingga pengeluaran
graph LR
    A[Pemohon: Hantar Permohonan] --> B(Pegawai Penyokong: Semak & Sokong)
    B --> C(BPM: Proses & Luluskan)
    C --> D[BPM: Keluaran Peralatan]
```

### 4.2 Sistem Helpdesk ICT

- **Struktur Borang:** "Borang Aduan Kerosakan ICT" (PK.(S).MOTAC.07.(L1)), borang satu lajur untuk penyerahan tiket pantas.
- **Paparan Butiran Tiket:** Ringkasan tiket di bahagian atas, diikuti thread komen kronologi antara pengguna & agen IT.
- **Penunjuk Status:** Lencana warna dan ikon jelas untuk status tiket (Buka, Dalam Tindakan, Selesai, Ditutup).

| Status         | Ikon             | Warna     | Label          |
| -------------- | ---------------- | --------- | -------------- |
| Buka           | bi-envelope-open | $utama    | Buka           |
| Dalam Tindakan | bi-arrow-repeat  | $amaran   | Dalam Tindakan |
| Selesai        | bi-check-circle  | $berjaya  | Selesai        |
| Ditutup        | bi-archive       | $sekunder | Ditutup        |

---

## 5. Pustaka Komponen

### 5.1 Navigasi

- **Navigasi Sisi Menegak:** Menu boleh dilipat, ikon sahaja dipaparkan secara lalai dan kembang semasa hover/pin. Keadaan disimpan dalam localStorage.
- **Bar Tindakan Atas:** Logo ICTServe, notifikasi global, penukar bahasa dan dropdown profil pengguna.

### 5.2 Input Data

- **Medan Borang:** Setiap medan input mesti ada `<label>` dan teks placeholder. Teks bantuan boleh diberikan di bawah medan.
- **Medan Wajib:** Label untuk medan wajib mesti mempunyai asterisk merah: `<span class="text-danger">*</span>`.

### 5.3 Widget Dashboard

- **Kad Statistik:** Digunakan di papan pemuka untuk paparan metrik utama (cth: "Kelulusan Menunggu," "Tiket Terbuka"). Kad visual yang memudahkan pengguna melihat tugas tertunda.
- **Kad Perkhidmatan:** Panel akses pantas ke fungsi utama sistem (Aduan Kerosakan, Pinjaman Peralatan).

---

## 6. Kebolehcapaian & Tadbir Urus Reka Bentuk

### 6.1 Standard Kebolehcapaian

- **Navigasi Papan Kekunci:** Susunan tab logik dan semua elemen interaktif mesti mempunyai penunjuk fokus jelas (cth: outline biru 3px).
- **Pembaca Skrin:** Gunakan HTML semantik dan label ARIA (cth: `<nav aria-label="Navigasi utama">`).
- **Pengurangan Animasi:** Animasi/transisi mestilah minimum dan menghormati tetapan OS untuk pengurangan gerakan.

### 6.2 Tadbir Urus Reka Bentuk

- **Kawalan Versi:** Token reka bentuk disimpan dalam `design-tokens.json`. Rekod perubahan disimpan dalam `DESIGN_CHANGELOG.md`.
- **Senarai Semak Pematuhan:** Sebelum komponen baru dilepas, ia mesti divalidasi:
  - Teks Bahasa Melayu jelas dan formal.
  - Nisbah kontras WCAG 2.1 AA dipatuhi.
  - Komponen responsif sepenuhnya pada telefon, tablet & desktop.
  - Reka bentuk selaras dengan pola dokumen ini.
  - Penjenamaan MOTAC dan BPM diaplikasi dengan betul.

---

## 7. Pematuhan 18 Prinsip Reka Bentuk MyGOVEA (Ringkas)

- Berpaksikan Rakyat, Berpacukan Data, Kandungan Terancang, Teknologi Bersesuaian
- Antara Muka Minimalis dan Mudah, Seragam, Paparan/Menu Jelas
- Realistik, Kognitif, Fleksibel, Komunikasi, Struktur Hierarki
- Komponen UI/UX, Tipografi, Tetapan Lalai, Kawalan Pengguna
- Pencegahan Ralat, Panduan & Dokumentasi

Semua keputusan reka bentuk dalam dokumen ini disemak melawan prinsip di atas. Rujuk fail prinsip-reka-bentuk-mygovea.md untuk butiran prinsip.

---

## See Also

- [System Design Documentation](<Dokumentasi_Reka_Bentuk_Sistem_ICTServe(iServe).md>)
- [ICT Equipment Loan Application Flow](<Dokumentasi_Flow_Sistem_Permohonan_Pinjaman_Aset_ICT_ICTServe(iServe).md>)
- [Email Notification System](<Dokumentasi_Sistem_Notifikasi_E-mel_ICTServe(iServe).md>)
- [General System Documentation](<Dokumentasi_Sistem_ICTServe(iServe).md>)
- [Core User and Organization Data Tables](<Dokumentasi_Jadual_Data_Pengguna_Organisasi_Teras_ICTServe(iServe).md>)

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

_Dokumen diselenggara oleh Pejabat Reka Bentuk BPM_  
_Tarikh dokumen: 13 September 2025_
