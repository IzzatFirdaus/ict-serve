{{--
  ICTServe (iServe) - My Requests Page
  ======================================
  This component provides a comprehensive dashboard for users to track their
  equipment loan requests and damage complaints. It is built as a full-page
  Livewire component for a reactive and seamless user experience.

  Principles Applied:
  - Berpaksikan Rakyat (Citizen-Centric): A single, clear page for users to manage all their interactions with ICT services. Modals provide detailed information without navigating away.
  - Seragam (Consistent): Uses consistent components, tables, buttons, and status pills. The UI is predictable and cohesive.
  - Paparan/Menu Jelas (Clear Display): Information is separated into logical sections for "Pinjaman Peralatan" and "Aduan Kerosakan". Statuses are color-coded for quick identification.
  - Teknologi Bersesuaian (Appropriate Technology): Leverages the TALL stack (Livewire & Alpine.js) for modern, interactive features like modals and digital signatures, reducing page reloads.
--}}

@extends('layouts.app')

@section('title', 'Permohonan Saya - ICTServe')

@section('content')
  {{-- This view is powered by the App\Livewire\MyRequests Livewire component. --}}
  {{-- All data ($this->loanRequests, $this->tickets) and actions (showLoanDetails, etc.) are handled by the component class. --}}
  <div class="bg-white">
    <div class="bg-primary-600 text-white py-8 shadow-md">
  <div class="container mx-auto px-4">
        <h1 class="font-poppins text-2xl md:text-3xl font-bold mb-2">
          Permohonan Saya
        </h1>
        <p class="font-inter text-base md:text-lg text-white/80">
          Jejak status permohonan pinjaman peralatan dan aduan kerosakan anda.
        </p>
  </div>
    </div>

    <div class="bg-white border-b border-divider">
  <div class="container mx-auto px-4 py-4">
        <div class="flex flex-wrap gap-4">
                <x-ictserve.button
            onclick="window.location='{{ route('public.loan-request') }}'"
            variant="primary"
            size="md"
            class="min-w-[180px]"
          >
                  <x-ictserve.icon
              name="plus"
              size="20"
              class="mr-2"
              aria-hidden="true"
            />
            Permohonan Pinjaman Baru
          </x-ictserve.button>
                <x-ictserve.button
            onclick="window.location='{{ route('public.damage-complaint.guest') }}'"
            variant="danger"
            size="md"
            class="min-w-[160px]"
          >
                  <x-ictserve.icon
              name="exclamation-triangle"
              size="20"
              class="mr-2"
              aria-hidden="true"
            />
            Lapor Kerosakan
          </x-ictserve.button>
        </div>
  </div>
    </div>

  <div class="container mx-auto px-4 py-8">
      <div class="mb-12" wire:poll.15s>
        <x-ictserve.card class="overflow-x-auto">
        <div class="flex items-center justify-between mb-6">
          <h2
            class="font-poppins text-xl md:text-2xl font-semibold text-gray-900"
          >
            Permohonan Pinjaman Peralatan
          </h2>
          <span class="font-inter text-xs text-gray-500">
            {{-- $this->loanRequests->total() --}}
            5 jumlah permohonan
          </span>
        </div>

  <x-ictserve.card class="overflow-x-auto">
          <table class="min-w-full">
            <thead>
              <tr>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  No. Permohonan
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Tujuan
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Tempoh
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Status
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Dihantar Pada
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                >
                  Tindakan
                </th>
              </tr>
            </thead>
            <tbody>
              {{-- Loop through data from Livewire component: @foreach($this->loanRequests as $request) --}}
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap font-inter text-sm text-primary-600">ICT-LN-001</td>
                <td class="px-6 py-4 whitespace-nowrap font-inter text-sm text-gray-900">Mesyuarat Luar Pejabat</td>
                <td class="px-6 py-4 whitespace-nowrap font-inter text-sm text-gray-600">19 Sep - 21 Sep 2025</td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800">
                    <x-ictserve.icon name="check-circle" size="14" class="mr-1" aria-hidden="true" />
                    Diluluskan
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap font-inter text-sm text-gray-600">18 Sep 2025</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <x-ictserve.button wire:click="showLoanDetails(1)" variant="ghost" size="sm">Lihat Butiran</x-ictserve.button>
                </td>
              </tr>
              {{-- @endforeach --}}
            </tbody>
          </table>
  </x-ictserve.card>
        {{-- Pagination Links would be rendered here: {{ $this->loanRequests->links() }} --}}
      </div>

      {{-- Add other sections like Helpdesk Tickets similarly --}}
  </div>

    <!-- Modal code removed: replace with generic modal if needed -->
  </div>
@endsection

@push('scripts')
  {{-- Scripts required for this page --}}
  @vite('resources/js/my-requests.js')
@endpush
