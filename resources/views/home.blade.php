{{--
    File: resources/views/home.blade.php
    Purpose: Home/Dashboard for ICTServe (iServe)
    MYDS-compliant (Design, Develop, Icons, Colour)
    MyGovEA citizen-centric, accessible, and inclusive
--}}

@extends('layouts.app')

@section('content')
{{-- Skip Link for accessibility --}}
<a href="#main-content" class="myds-skip-link sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:bg-white focus:shadow-context-menu focus:rounded focus:p-4 focus:z-50 text-txt-black-900">
    Skip to main content
</a>

<div class="bg-washed min-h-screen flex flex-col py-8">
    <main id="main-content" tabindex="-1" class="flex-1 flex justify-center items-start">
        <section class="w-full max-w-lg mx-auto">
            {{-- Card: Welcome Panel --}}
            <div class="bg-white rounded-xl shadow-card border border-otl-gray-200 overflow-hidden">
                {{-- Header: Home Icon and Title --}}
                <header class="flex items-center gap-3 px-6 py-5 bg-primary-600">
                    {{-- MYDS Home Icon (20x20, 1.5px stroke, accessible) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" aria-hidden="true" class="text-white">
                        <path d="M12.354 3.146a.5.5 0 0 0-.708 0l-7 7A.5.5 0 0 0 5 10.5V20a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1v-4h2v4a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V10.5a.5.5 0 0 0-.146-.354l-7-7zM19 20h-3v-4a1 1 0 0 0-1-1h-2a1 1 0 0 0-1 1v4H5V10.707l7-7 7 7V20z" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                    <span class="myds-heading-xs font-semibold text-white">Dashboard</span>
                </header>
                <div class="px-6 py-8 text-center bg-washed">
                    @if (session('status'))
                        {{-- MYDS Success Callout --}}
                        <div class="inline-flex items-center gap-2 bg-success-100 border border-otl-success-200 rounded-md px-4 py-3 mb-6" role="status" aria-live="polite">
                            <svg width="20" height="20" fill="none" aria-hidden="true" class="text-success-700">
                                <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="1.5"/>
                                <path d="M7.5 10.5L9 12l3.5-3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                            </svg>
                            <span class="myds-body-sm text-success-700">{{ session('status') }}</span>
                        </div>
                    @endif
                    <h2 class="myds-heading-md font-bold text-success-700 mb-2">Selamat Datang!</h2>
                    <p class="myds-body-md text-txt-black-500 mb-6">Anda telah berjaya log masuk ke ICTServe (iServe).</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="{{ route('dashboard') }}"
                           class="myds-btn myds-btn-primary px-6 py-2 rounded shadow-button font-semibold text-white bg-primary-600 hover:bg-primary-700 focus-visible:outline-2 focus-visible:outline-primary-600 transition"
                           aria-label="Pergi ke Dashboard ICTServe">
                            Dashboard ICTServe
                        </a>
                        <a href="{{ route('helpdesk.create-ticket') }}"
                           class="myds-btn myds-btn-secondary px-6 py-2 rounded shadow-button font-semibold text-primary-600 bg-white border border-otl-primary-300 hover:bg-primary-50 focus-visible:outline-2 focus-visible:outline-primary-600 transition"
                           aria-label="Buat Aduan Kerosakan ICT">
                            Buat Aduan Kerosakan
                        </a>
                        <a href="{{ route('equipment-loan.create') }}"
                           class="myds-btn myds-btn-secondary px-6 py-2 rounded shadow-button font-semibold text-primary-600 bg-white border border-otl-primary-300 hover:bg-primary-50 focus-visible:outline-2 focus-visible:outline-primary-600 transition"
                           aria-label="Mohon Peminjaman Peralatan ICT">
                            Mohon Peminjaman ICT
                        </a>
                    </div>
                </div>
            </div>
            {{-- Accessibility Note --}}
            <div class="mt-6 text-center text-txt-black-500 myds-body-xs" aria-live="polite">
                <span>Untuk bantuan akses atau pertanyaan, hubungi Unit Operasi Rangkaian &amp; Khidmat Pengguna BPM (<a href="tel:1234" class="text-primary-600 hover:underline" aria-label="Hubungi sambungan 1234">ext. 1234</a>).</span>
            </div>
        </section>
    </main>
</div>
@endsection
