<!DOCTYPE html>
<html lang="ms" class="h-full bg-washed" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>ICTServe – Sistem Pengurusan Perkhidmatan ICT MOTAC</title>
    <meta name="description" content="Sistem Pengurusan Perkhidmatan ICT MOTAC (ICTServe/iServe) – Pinjaman peralatan & helpdesk ICT. MYDS, Livewire, Filament, Laravel 12.">
    <!-- Fonts: Poppins (heading), Inter (body) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Tailwind CSS (latest v4) & Filament CSS (auto-included via @vite if installed) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Bootstrap Icons for fallback -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    @livewireStyles
    @stack('styles')
    <style>
        body, html { font-family: 'Inter', Arial, sans-serif; }
        h1, h2, h3, .font-poppins { font-family: 'Poppins', 'Inter', Arial, sans-serif; }
        .myds-gradient { background: linear-gradient(90deg, #2563EB 0%, #3A75F6 100%); }
        .myds-glass { background: rgba(255,255,255,0.88); backdrop-filter: blur(8px); }
        .hero-bg {
            background: url('/build/ictserve-hero-bg.svg'), linear-gradient(90deg,#EFF6FF 0,#DBEAFE 100%);
            background-repeat: no-repeat;
            background-size: cover;
        }
        .shadow-card {
            box-shadow: 0 2px 6px 0 rgba(0,0,0,0.05), 0 6px 24px 0 rgba(0,0,0,0.05);
        }
    </style>
</head>
<body class="min-h-full bg-washed text-black-900 antialiased">
    <!-- Skiplink (MYDS standard) -->
    <a href="#main-content" class="sr-only focus:not-sr-only fixed z-[100] left-4 top-4 bg-white px-4 py-2 rounded shadow-lg text-primary-600 ring-0 focus:ring-4 focus:ring-fr-primary transition">Langkau ke kandungan utama</a>

    <!-- Main navigation bar (Livewire if needed for future dynamic nav/user state) -->
    <header class="w-full bg-white shadow-sm">
        <div class="mx-auto max-w-7xl flex items-center justify-between px-6 py-3">
            <div class="flex items-center gap-3">
                <img src="/build/motac-intranet-logo.svg" alt="Logo MOTAC Intranet" class="h-10" />
                <span class="font-poppins text-xl font-semibold tracking-tight text-primary-600">ICTServe <span class="text-gray-700 font-normal text-base align-top">iServe</span></span>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-base" aria-label="Navigasi utama">
                <a href="#" class="hover:text-primary-600 transition">Utama</a>
                <a href="#modul" class="hover:text-primary-600 transition">Modul</a>
                <a href="#kenapa" class="hover:text-primary-600 transition">Kenapa ICTServe?</a>
                <a href="#akses" class="hover:text-primary-600 transition">Akses</a>
                <a href="{{ route('login') }}" class="flex items-center gap-1 hover:text-primary-600 transition"><i class="bi bi-box-arrow-in-right"></i> Log Masuk</a>
            </nav>
            <!-- Mobile Nav Hamburger -->
            <button class="md:hidden p-2 rounded hover:bg-washed focus:outline-none focus:ring-2 focus:ring-primary-500" aria-label="Buka menu navigasi">
                <i class="bi bi-list text-2xl"></i>
            </button>
        </div>
    </header>

    <!-- Phase banner (MYDS Phase Banner) -->
    <div class="w-full bg-warning-100 text-warning-700 px-6 py-2 text-sm flex items-center gap-3" role="status">
        <span class="inline-flex items-center gap-1 bg-warning-400 text-white font-semibold rounded px-2 py-0.5 text-xs"><i class="bi bi-exclamation-triangle-fill mr-1"></i>Beta</span>
        ICTServe v1.0 – Ujian pengesahan pengguna & demo operasi BPM. <a href="#maklumbalas" class="underline hover:text-warning-900 ml-2">Hantar maklum balas</a>
    </div>

    <!-- Hero Section (MYDS 12-8-4 grid, responsive) -->
    <main id="main-content" class="hero-bg relative">
        <div class="max-w-5xl mx-auto px-6 py-16 flex flex-col md:flex-row items-center gap-10 md:gap-16">
            <div class="flex-1">
                <h1 class="font-poppins text-4xl md:text-5xl font-semibold text-primary-700 mb-4 leading-tight">
                    Sistem Pengurusan Perkhidmatan ICT MOTAC
                </h1>
                <p class="text-lg md:text-xl text-black-700 mb-6">
                    Pengurusan pinjaman peralatan ICT & tiket helpdesk dalam satu platform moden – <span class="font-semibold text-primary-600">mesra rakyat</span>, <span class="font-semibold text-success-700">selamat</span>, dan <span class="font-semibold text-warning-700">cekap</span>.
                    <span class="block mt-2">Berasaskan <span class="underline">MYDS</span> & <span class="underline">MyGovEA</span>.</span>
                </p>
                <!-- Quick action buttons (Livewire for future: login/register, etc) -->
                <div class="flex gap-4">
                    <a href="{{ route('equipment-loan.create') }}" class="inline-flex items-center bg-primary-600 text-white font-semibold px-6 py-3 rounded-lg shadow-card hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-400 transition text-base">
                        <i class="bi bi-person-plus-fill mr-2"></i> Permohonan Pinjaman ICT
                    </a>
                    <a href="{{ route('damage-complaint.create') }}" class="inline-flex items-center bg-success-700 text-white font-medium px-6 py-3 rounded-lg shadow-card hover:bg-success-800 focus:outline-none focus:ring-2 focus:ring-success-400 transition text-base">
                        <i class="bi bi-tools mr-2"></i> Aduan Kerosakan
                    </a>
                </div>
            </div>
            <div class="flex-1 flex items-center justify-center">
                <img src="/build/ictserve-hero-illustration.svg" alt="ICTServe illustration" class="w-full max-w-sm md:max-w-md drop-shadow-lg" loading="lazy" />
            </div>
        </div>
    </main>

    <!-- Features/Modules Section (MYDS Panel/Card) -->
    <section id="modul" class="max-w-6xl mx-auto px-6 py-14 md:py-20">
        <h2 class="font-poppins text-2xl md:text-3xl font-semibold text-primary-700 mb-6">Modul Utama ICTServe</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Loan Module Card -->
            <div class="bg-white shadow-card rounded-lg p-7 flex flex-col gap-4 border border-otl-divider">
                <div class="flex items-center gap-3">
                    <div class="bg-primary-100 text-primary-700 p-3 rounded-md"><i class="bi bi-laptop text-2xl"></i></div>
                    <h3 class="font-poppins text-xl font-semibold">Pinjaman Peralatan ICT</h3>
                </div>
                <ul class="list-disc ml-8 text-black-700 space-y-1">
                    <li>Borang permohonan digital (auto-isi, validasi masa nyata)</li>
                    <li>Aliran kelulusan automatik mengikut gred</li>
                    <li>Senarai semak pengeluaran & pemulangan lengkap</li>
                    <li>Notifikasi e-mel & dashboard setiap status</li>
                </ul>
                <a href="#" class="inline-flex items-center gap-2 text-primary-700 font-semibold hover:underline mt-2">Lihat aliran permohonan <i class="bi bi-arrow-right"></i></a>
            </div>
            <!-- Helpdesk Card -->
            <div id="modul-helpdesk" class="bg-white shadow-card rounded-lg p-7 flex flex-col gap-4 border border-otl-divider">
                <div class="flex items-center gap-3">
                    <div class="bg-success-100 text-success-700 p-3 rounded-md"><i class="bi bi-headset text-2xl"></i></div>
                    <h3 class="font-poppins text-xl font-semibold">Helpdesk & Aduan Kerosakan ICT</h3>
                </div>
                <ul class="list-disc ml-8 text-black-700 space-y-1">
                    <li>Borang aduan satu lajur, mudah & pantas</li>
                    <li>Kategori kerosakan dinamik, dropdown MYDS</li>
                    <li>Thread komen kronologi, status lencana warna</li>
                    <li>Notifikasi segera (emel & in-app)</li>
                </ul>
                <a href="#" class="inline-flex items-center gap-2 text-success-700 font-semibold hover:underline mt-2">Lihat aliran helpdesk <i class="bi bi-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- Why Section -->
    <section id="kenapa" class="bg-primary-50 py-16 px-6">
        <div class="max-w-6xl mx-auto">
            <h2 class="font-poppins text-2xl md:text-3xl text-primary-700 font-semibold mb-8">Kenapa Pilih ICTServe?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white shadow-card rounded-lg p-6 flex flex-col gap-3 border border-otl-divider">
                    <i class="bi bi-person-check-fill text-primary-600 text-3xl mb-2"></i>
                    <h4 class="font-poppins text-lg font-semibold">Berpaksikan Rakyat</h4>
                    <p class="text-black-700 text-base">Antara muka ringkas, navigasi dua klik ke fungsi utama, bantuan dan auto-isi untuk pengguna.</p>
                </div>
                <div class="bg-white shadow-card rounded-lg p-6 flex flex-col gap-3 border border-otl-divider">
                    <i class="bi bi-shield-lock-fill text-success-700 text-3xl mb-2"></i>
                    <h4 class="font-poppins text-lg font-semibold">Selamat & Terkawal</h4>
                    <p class="text-black-700 text-base">Akses peranan, audit log, dan validasi data automatik melindungi maklumat organisasi anda.</p>
                </div>
                <div class="bg-white shadow-card rounded-lg p-6 flex flex-col gap-3 border border-otl-divider">
                    <i class="bi bi-lightning-charge-fill text-warning-600 text-3xl mb-2"></i>
                    <h4 class="font-poppins text-lg font-semibold">Cekap & Responsif</h4>
                    <p class="text-black-700 text-base">Notifikasi masa sebenar, dashboard metrik, dan laporan automatik untuk operasi ICT efisien.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Access Steps -->
    <section id="akses" class="max-w-5xl mx-auto px-6 py-16">
        <h2 class="font-poppins text-2xl md:text-3xl text-primary-700 font-semibold mb-8">Cara Akses ICTServe</h2>
        <ol class="space-y-4 text-black-900">
            <li class="flex items-start gap-4">
                <span class="inline-flex items-center justify-center bg-primary-600 text-white font-bold rounded-full w-10 h-10 text-lg">1</span>
                <div>
                    <strong>Layari Portal ICTServe</strong><br>
                    <span class="text-black-700">Gunakan pautan <a href="https://ictserve.motac.gov.my" class="text-primary-700 underline">ictserve.motac.gov.my</a> dari rangkaian intranet MOTAC.</span>
                </div>
            </li>
            <li class="flex items-start gap-4">
                <span class="inline-flex items-center justify-center bg-primary-600 text-white font-bold rounded-full w-10 h-10 text-lg">2</span>
                <div>
                    <strong>Log Masuk Selamat</strong><br>
                    <span class="text-black-700">Masukkan ID/Emel MOTAC & kata laluan. Sistem mengesahkan akses berdasarkan peranan anda.</span>
                </div>
            </li>
            <li class="flex items-start gap-4">
                <span class="inline-flex items-center justify-center bg-primary-600 text-white font-bold rounded-full w-10 h-10 text-lg">3</span>
                <div>
                    <strong>Pilih Modul & Mulakan</strong><br>
                    <span class="text-black-700">Teruskan dengan permohonan pinjaman, aduan kerosakan, atau semak status dari dashboard peribadi anda.</span>
                </div>
            </li>
        </ol>
    </section>

    <!-- Livewire authentication actions (modular, can be replaced with Filament auth in admin panel) -->
    <section class="max-w-md mx-auto px-6 my-8">
        @if (Route::has('login'))
            <div class="flex justify-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="myds-btn myds-btn-primary px-6 py-2 rounded-sm transition" role="button" aria-label="Pergi ke dashboard utama">
                        <i class="bi bi-grid mr-2"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="myds-btn myds-btn-secondary px-6 py-2 rounded-sm transition" role="button" aria-label="Log masuk ke akaun">
                        <i class="bi bi-box-arrow-in-right mr-2"></i> Log Masuk
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="myds-btn myds-btn-ghost px-6 py-2 rounded-sm transition" role="button" aria-label="Daftar akaun baru">
                            <i class="bi bi-person-plus mr-2"></i> Daftar
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </section>

    <!-- Footer (MYDS standard, dynamic year) -->
    <footer class="w-full border-t border-otl-divider bg-white py-8 px-6">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <img src="/build/bpm-logo.svg" alt="BPM Logo" class="h-8">
                <span class="text-black-500 text-base">Bahagian Pengurusan Maklumat</span>
            </div>
            <div class="text-black-500 text-sm text-center md:text-left">
                © <span id="year"></span> Hakcipta Terpelihara MOTAC & BPM
            </div>
            <div class="flex items-center gap-3">
                <a href="https://facebook.com/motacmalaysia" target="_blank" class="text-primary-600 hover:text-primary-800" aria-label="Facebook"><i class="bi bi-facebook text-xl"></i></a>
                <a href="https://instagram.com/motacmalaysia" target="_blank" class="text-primary-600 hover:text-primary-800" aria-label="Instagram"><i class="bi bi-instagram text-xl"></i></a>
                <a href="https://www.youtube.com/@motacmalaysia" target="_blank" class="text-primary-600 hover:text-primary-800" aria-label="YouTube"><i class="bi bi-youtube text-xl"></i></a>
            </div>
        </div>
    </footer>
    @livewireScripts
    @stack('scripts')
    <script>
        // Dynamic year in footer
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>
</body>
</html>
