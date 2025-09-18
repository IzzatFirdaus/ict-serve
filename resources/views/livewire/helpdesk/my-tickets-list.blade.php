@extends('layouts.app')

@section('title', 'Aduan Saya')

@section('content')
<div class="bg-washed min-h-screen">
    <main id="main-content" class="w-full mx-auto myds-container px-4 md:px-6 py-10" tabindex="-1">
        {{-- Page Header with Action Button --}}
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="myds-heading-xl font-semibold tracking-tight text-txt-black-900">Aduan Kerosakan Saya</h1>
                <p class="myds-body-lg text-txt-black-700 mt-2">Semak status terkini dan sejarah aduan kerosakan ICT anda.</p>
            </div>
            <a href="{{ route('helpdesk.create-ticket') }}" class="myds-btn myds-btn-danger" aria-label="Buat Aduan Kerosakan Baru">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Buat Aduan Baru
            </a>
        </div>

        {{-- Tickets Table --}}
        <div class="bg-white rounded-lg shadow-card border border-otl-gray-200 overflow-x-auto">
            <table class="min-w-full divide-y divide-otl-gray-200 myds-table">
                <thead class="bg-black-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">ID Tiket</th>
                        <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">Subjek</th>
                        <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">Tarikh Dihantar</th>
                        <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Tindakan</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-otl-gray-200">
                    {{-- This is placeholder data. Replace with a @forelse loop on your actual data collection. --}}
                    {{-- @forelse ($myTickets as $ticket) --}}
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm font-medium text-txt-primary">
                            <a href="#" class="hover:underline">HD-202509-001</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">Aplikasi</td>
                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">Tidak dapat akses emel MyGovUC 3.0</td>
                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">18 Sep 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="myds-badge myds-badge-info">Dalam Tindakan</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right myds-body-sm font-medium">
                            <a href="#" class="text-txt-primary hover:underline">Lihat Butiran</a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm font-medium text-txt-primary">
                             <a href="#" class="hover:underline">HD-202508-045</a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">Perkakasan</td>
                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">Printer di Aras 12 tidak berfungsi</td>
                        <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">25 Ogos 2025</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="myds-badge myds-badge-secondary">Ditutup</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right myds-body-sm font-medium">
                            <a href="#" class="text-txt-primary hover:underline">Lihat Butiran</a>
                        </td>
                    </tr>
                    {{-- @empty --}}
                    <tr>
                        <td colspan="6">
                            <div class="text-center px-6 py-24">
                                <svg class="mx-auto h-12 w-12 text-black-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                </svg>
                                <h3 class="mt-2 myds-body-lg font-medium text-txt-black-900">Tiada aduan dijumpai</h3>
                                <p class="mt-1 myds-body-md text-txt-black-700">Mulakan dengan membuat laporan aduan kerosakan ICT anda yang pertama.</p>
                                <div class="mt-6">
                                    <a href="{{ route('helpdesk.create-ticket') }}" class="myds-btn myds-btn-danger">
                                        Buat Aduan Baru
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    {{-- @endforelse --}}
                </tbody>
            </table>
        </div>
    </main>
</div>
@endsection
