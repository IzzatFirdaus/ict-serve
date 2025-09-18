@extends('layouts.app')

@section('title', 'Semua Permohonan Saya')

@section('content')
<div class="bg-washed min-h-screen">
    <main id="main-content" class="w-full mx-auto myds-container px-4 md:px-6 py-10" tabindex="-1">
        {{-- Page Header --}}
        <div class="mb-8">
            <h1 class="myds-heading-xl font-semibold tracking-tight text-txt-black-900">Semua Permohonan Saya</h1>
            <p class="myds-body-lg text-txt-black-700 mt-2">Jejak status permohonan pinjaman peralatan dan aduan kerosakan ICT anda di satu tempat.</p>
        </div>

        {{-- Section: ICT Equipment Loan Applications --}}
        <section class="mb-12" aria-labelledby="loan-requests-heading">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <h2 id="loan-requests-heading" class="myds-heading-lg text-txt-black-900">Permohonan Pinjaman Peralatan ICT</h2>
                <a href="{{ route('equipment-loan.create') }}" class="myds-btn myds-btn-primary myds-btn-sm" aria-label="Mohon Peminjaman Peralatan ICT Baru">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Mohon Pinjaman Baru
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-card border border-otl-gray-200 overflow-x-auto">
                <table class="min-w-full divide-y divide-otl-gray-200 myds-table">
                    <thead class="bg-black-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">ID Rujukan</th>
                            <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">Tujuan</th>
                            <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">Tarikh Mohon</th>
                            <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">Status</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Tindakan</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-otl-gray-200">
                        {{-- @forelse ($loanRequests as $request) --}}
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap myds-body-sm font-medium text-txt-black-900">LOAN-00123</td>
                            <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">Mesyuarat JTICT di Aras 14</td>
                            <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">15 Sep 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="myds-badge myds-badge-success">Diluluskan</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right myds-body-sm font-medium">
                                <a href="#" class="text-txt-primary hover:underline">Lihat</a>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap myds-body-sm font-medium text-txt-black-900">LOAN-00121</td>
                            <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">Taklimat Pelancongan di PICC</td>
                            <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">12 Sep 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="myds-badge myds-badge-warning">Menunggu Sokongan</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right myds-body-sm font-medium">
                                <a href="#" class="text-txt-primary hover:underline">Lihat</a>
                            </td>
                        </tr>
                        {{-- @empty --}}
                        {{-- Uncomment this block when data is connected --}}
                        {{-- <tr>
                            <td colspan="5" class="px-6 py-12 text-center myds-body-md text-txt-black-700">
                                Tiada rekod permohonan pinjaman dijumpai.
                            </td>
                        </tr> --}}
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Section: Helpdesk Tickets --}}
        <section aria-labelledby="helpdesk-tickets-heading">
            <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
                <h2 id="helpdesk-tickets-heading" class="myds-heading-lg text-txt-black-900">Aduan Kerosakan ICT</h2>
                 <a href="{{ route('helpdesk.create-ticket') }}" class="myds-btn myds-btn-danger myds-btn-sm" aria-label="Buat Aduan Kerosakan Baru">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Buat Aduan Baru
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-card border border-otl-gray-200 overflow-x-auto">
                <table class="min-w-full divide-y divide-otl-gray-200 myds-table">
                    <thead class="bg-black-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">ID Tiket</th>
                            <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">Subjek</th>
                            <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">Tarikh Aduan</th>
                            <th scope="col" class="px-6 py-3 text-left myds-body-sm font-medium text-txt-black-700 uppercase tracking-wider">Status</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Tindakan</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-otl-gray-200">
                        {{-- @forelse ($helpdeskTickets as $ticket) --}}
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap myds-body-sm font-medium text-txt-black-900">HD-202509-001</td>
                            <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">Tidak dapat akses emel MyGovUC 3.0</td>
                            <td class="px-6 py-4 whitespace-nowrap myds-body-sm text-txt-black-700">18 Sep 2025</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="myds-badge myds-badge-info">Dalam Tindakan</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right myds-body-sm font-medium">
                                <a href="#" class="text-txt-primary hover:underline">Lihat</a>
                            </td>
                        </tr>
                        {{-- @empty --}}
                        {{-- Uncomment this block when data is connected --}}
                        {{-- <tr>
                            <td colspan="5" class="px-6 py-12 text-center myds-body-md text-txt-black-700">
                                Tiada rekod aduan kerosakan dijumpai.
                            </td>
                        </tr> --}}
                        {{-- @endforelse --}}
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</div>
@endsection
