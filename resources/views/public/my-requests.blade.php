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
  <div class="bg-white">
    <div class="bg-primary-600 text-white py-8 shadow-md">
      <x-myds.container>
        <h1 class="font-poppins text-2xl md:text-3xl font-bold mb-2">
          Permohonan Saya
        </h1>
        <p class="font-inter text-base md:text-lg text-white/80">
          Jejak status permohonan pinjaman peralatan dan aduan kerosakan anda.
        </p>
      </x-myds.container>
    </div>

    <div class="bg-white border-b border-divider">
      <x-myds.container class="py-4">
        <div class="flex flex-wrap gap-4">
          <x-myds.button
            onclick="window.location='{{ route('public.loan-request') }}'"
            variant="primary"
            size="md"
            class="min-w-[180px]"
          >
            <x-myds.icon
              name="plus"
              size="20"
              class="mr-2"
              aria-hidden="true"
            />
            Permohonan Pinjaman Baru
          </x-myds.button>
          <x-myds.button
            onclick="window.location='{{ route('public.damage-complaint.guest') }}'"
            variant="danger"
            size="md"
            class="min-w-[160px]"
          >
            <x-myds.icon
              name="exclamation-triangle"
              size="20"
              class="mr-2"
              aria-hidden="true"
            />
            Lapor Kerosakan
          </x-myds.button>
        </div>
      </x-myds.container>
    </div>

    <x-myds.container class="py-8">
      <div class="mb-12" wire:poll.15s>
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

        <x-myds.card class="overflow-x-auto">
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
                <td
                  class="px-6 py-4 whitespace-nowrap font-inter text-sm text-primary-600"
                >
                  ICT-LN-001
                </td>
                <td
                  class="px-6 py-4 whitespace-nowrap font-inter text-sm text-gray-900"
                >
                  Mesyuarat Luar Pejabat
                </td>
                <td
                  class="px-6 py-4 whitespace-nowrap font-inter text-sm text-gray-600"
                >
                  19 Sep - 21 Sep 2025
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-success-100 text-success-800"
                  >
                    <x-myds.icon
                      name="check-circle"
                      size="14"
                      class="mr-1"
                      aria-hidden="true"
                    />
                    Diluluskan
                  </span>
                </td>
                <td
                  class="px-6 py-4 whitespace-nowrap font-inter text-sm text-gray-600"
                >
                  18 Sep 2025
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <x-myds.button
                    wire:click="showLoanDetails(1)"
                    variant="ghost"
                    size="sm"
                  >
                    Lihat Butiran
                  </x-myds.button>
                </td>
              </tr>
              {{-- @endforeach --}}
            </tbody>
          </table>
        </x-myds.card>
        {{-- Pagination Links would be rendered here: {{ $this->loanRequests->links() }} --}}
      </div>

      {{-- Add other sections like Helpdesk Tickets similarly --}}
    </x-myds.container>

    <x-myds.modal
      :show="@entangle('showingLoanModal')"
      @close="showingLoanModal = false"
      aria-labelledby="loan-modal-title"
    >
      <x-slot name="title">
        <h3
          id="loan-modal-title"
          class="font-poppins text-lg font-medium text-gray-900"
        >
          Butiran Permohonan Pinjaman
        </h3>
      </x-slot>
      <x-slot name="content">
        <div class="space-y-4 max-h-[60vh] overflow-y-auto">
          <p class="text-gray-700">
            No. Permohonan:
            <strong>
              {{-- $selectedLoan->request_number ?? 'ICT-LN-001' --}}
            </strong>
          </p>
          <p class="text-gray-700">
            Tujuan:
            <strong>
              {{-- $selectedLoan->purpose ?? 'Mesyuarat Luar Pejabat' --}}
            </strong>
          </p>
          {{-- Digital Signature Section, powered by Alpine.js component defined in my-requests.js --}}
          <div
            class="pt-4 border-t border-divider"
            x-data="signaturePad(@this)"
          >
            <h4 class="font-poppins text-base font-medium text-gray-800">
              Tandatangan Pengesahan Penerimaan
            </h4>
            <p class="font-inter text-xs text-gray-500 mb-2">
              Sila tandatangan di dalam kotak di bawah untuk mengesahkan
              penerimaan aset.
            </p>
            <div
              class="relative w-full h-48 bg-washed rounded-md border-2 border-dashed border-divider"
              aria-label="Kanvas Tandatangan"
              role="region"
            >
              <canvas
                x-ref="signatureCanvas"
                class="w-full h-full"
                aria-label="Pad Tandatangan"
              ></canvas>
            </div>
            <div class="flex items-center justify-end mt-2 gap-2">
              <x-myds.button
                @click="clearSignature()"
                type="button"
                variant="secondary"
              >
                Kosongkan
              </x-myds.button>
              <x-myds.button
                @click="saveSignature()"
                type="button"
                variant="primary"
              >
                Simpan Tandatangan
              </x-myds.button>
            </div>
          </div>
        </div>
      </x-slot>
      <x-slot name="footer">
        <div
          class="flex justify-end gap-4 bg-washed px-6 py-4 border-t border-divider"
        >
          <x-myds.button
            @click="$dispatch('close')"
            type="button"
            variant="secondary"
          >
            Tutup
          </x-myds.button>
        </div>
      </x-slot>
    </x-myds.modal>
  </div>
@endsection

@push('scripts')
  {{-- Scripts required for this page --}}
  @vite('resources/js/my-requests.js')
@endpush
