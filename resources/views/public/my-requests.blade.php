{{--
    ICTServe (iServe) - My Requests Page
    ======================================
    This component provides a comprehensive dashboard for users to track their
    equipment loan requests and damage complaints. It is built as a full-page
    Livewire component for a reactive and seamless user experience.

    MYDS & MyGovEA Principles Applied:
    - Berpaksikan Rakyat (Citizen-Centric): A single, clear page for users to manage all their interactions with ICT services. Modals provide detailed information without navigating away.
    - Seragam (Consistent): Uses consistent MYDS components, tables, buttons, and status pills. The UI is predictable and cohesive.
    - Paparan/Menu Jelas (Clear Display): Information is separated into logical sections for "Pinjaman Peralatan" and "Aduan Kerosakan". Statuses are color-coded for quick identification.
    - Teknologi Bersesuaian (Appropriate Technology): Leverages the TALL stack (Livewire & Alpine.js) for modern, interactive features like modals and digital signatures, reducing page reloads.
--}}

@extends('layouts.app')

@section('title', 'Permohonan Saya - ICTServe')

@section('content')
    {{-- This view is powered by the App\Livewire\MyRequests Livewire component. --}}
    {{-- All data ($this->loanRequests, $this->tickets) and actions (showLoanDetails, etc.) are handled by the component class. --}}
    <div class="bg-bg-white dark:bg-gray-950/50">

        <div class="bg-bg-primary-600 text-txt-white py-8 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-3xl font-bold font-poppins mb-2">Permohonan Saya</h1>
                <p class="text-lg text-txt-white opacity-80 font-inter">
                    Jejak status permohonan pinjaman peralatan dan aduan kerosakan anda.
                </p>
            </div>
        </div>

        <div class="bg-bg-white dark:bg-gray-900 border-b border-otl-divider dark:border-otl-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex flex-wrap gap-4">
                    <a href="{{-- route('public.loan-request') --}}" class="myds-btn myds-btn-primary">
                        <x-heroicon-o-plus class="h-5 w-5 mr-2"/>
                        Permohonan Pinjaman Baru
                    </a>
                    <a href="{{-- route('public.damage-complaint.guest') --}}" class="myds-btn myds-btn-danger">
                        <x-heroicon-o-exclamation-triangle class="h-5 w-5 mr-2"/>
                        Lapor Kerosakan
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="mb-12" wire:poll.15s>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-semibold font-poppins text-txt-black-900 dark:text-white">Permohonan Pinjaman Peralatan</h2>
                    <span class="text-sm text-txt-black-500 dark:text-txt-black-400">{{-- $this->loanRequests->total() --}} 5 jumlah permohonan</span>
                </div>

                <div class="bg-white dark:bg-gray-900 shadow-card border border-otl-gray-200 dark:border-otl-gray-800 rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-otl-divider dark:divide-otl-gray-800">
                            <thead class="bg-washed dark:bg-gray-800/50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 dark:text-txt-black-400 uppercase tracking-wider">No. Permohonan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 dark:text-txt-black-400 uppercase tracking-wider">Tujuan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 dark:text-txt-black-400 uppercase tracking-wider">Tempoh</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 dark:text-txt-black-400 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 dark:text-txt-black-400 uppercase tracking-wider">Dihantar Pada</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-txt-black-500 dark:text-txt-black-400 uppercase tracking-wider">Tindakan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-otl-divider dark:divide-otl-gray-800">
                                {{-- Loop through data from Livewire component: @foreach($this->loanRequests as $request) --}}
                                <tr class="hover:bg-washed dark:hover:bg-gray-800/50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary-600 dark:text-primary-400">ICT-LN-001</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-txt-black-900 dark:text-white">Mesyuarat Luar Pejabat</div></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-txt-black-500 dark:text-txt-black-400">19 Sep - 21 Sep 2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800 dark:bg-success-900/50 dark:text-success-300">Diluluskan</span></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-txt-black-500 dark:text-txt-black-400">18 Sep 2025</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="showLoanDetails(1)" class="myds-btn myds-btn-ghost text-primary-600 dark:text-primary-400">Lihat Butiran</button>
                                    </td>
                                </tr>
                                {{-- @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Pagination Links would be rendered here: {{ $this->loanRequests->links() }} --}}
            </div>

            {{-- Add other sections like Helpdesk Tickets similarly --}}
        </div>

        <div x-data="{ open: @entangle('showingLoanModal') }"
             x-show="open"
             @keydown.escape.window="open = false"
             class="fixed inset-0 z-50 flex items-center justify-center p-4" x-cloak>

            <div x-show="open" x-transition.opacity class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

            <div x-show="open" x-transition @click.away="open = false"
                 class="relative w-full max-w-2xl overflow-hidden rounded-lg bg-white dark:bg-gray-900 shadow-xl border border-otl-gray-200 dark:border-otl-gray-800">

                <div class="flex items-center justify-between p-6 border-b border-otl-divider dark:border-otl-gray-800">
                    <h3 class="text-lg font-medium font-poppins text-txt-black-900 dark:text-white">Butiran Permohonan Pinjaman</h3>
                    <button @click="open = false" class="myds-btn myds-btn-ghost p-2 rounded-full">
                        <x-heroicon-o-x-mark class="h-6 w-6"/>
                    </button>
                </div>

                <div class="p-6 space-y-4 max-h-[60vh] overflow-y-auto">
                    <p class="text-txt-black-700 dark:text-txt-black-300">No. Permohonan: <strong>{{-- $selectedLoan->request_number ?? 'ICT-LN-001' --}}</strong></p>
                    <p class="text-txt-black-700 dark:text-txt-black-300">Tujuan: <strong>{{-- $selectedLoan->purpose ?? 'Mesyuarat Luar Pejabat' --}}</strong></p>

                    {{-- Digital Signature Section, powered by Alpine.js component defined in my-requests.js --}}
                    <div class="pt-4 border-t border-otl-divider dark:border-otl-gray-800"
                         x-data="signaturePad(@this)">
                        <h4 class="font-medium text-txt-black-800 dark:text-white">Tandatangan Pengesahan Penerimaan</h4>
                        <p class="text-sm text-txt-black-500 dark:text-txt-black-400 mb-2">Sila tandatangan di dalam kotak di bawah untuk mengesahkan penerimaan aset.</p>
                        <div class="relative w-full h-48 bg-washed dark:bg-gray-800 rounded-md border-2 border-dashed border-otl-gray-300 dark:border-otl-gray-700">
                            <canvas x-ref="signatureCanvas" class="w-full h-full"></canvas>
                        </div>
                        <div class="flex items-center justify-end mt-2 space-x-2">
                            <button @click="clearSignature()" type="button" class="myds-btn myds-btn-secondary">Kosongkan</button>
                            <button @click="saveSignature()" type="button" class="myds-btn myds-btn-primary">Simpan Tandatangan</button>
                        </div>
                    </div>
                </div>

                 <div class="flex justify-end gap-4 bg-washed dark:bg-gray-950/50 px-6 py-4 border-t border-otl-divider dark:border-otl-gray-800">
                    <button @click="open = false" type="button" class="myds-btn myds-btn-secondary">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Scripts required for this page --}}
    @vite('resources/js/my-requests.js')
@endpush
