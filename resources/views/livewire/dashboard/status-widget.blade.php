{{-- Status Widget - MYDS Compliant --}}
<div class="bg-white rounded-lg border border-divider p-6">
  <h3
    class="font-poppins text-lg font-medium text-black-900 mb-4 flex items-center gap-2"
  >
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path
        stroke-linecap="round"
        stroke-linejoin="round"
        stroke-width="2"
        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
      />
    </svg>
    Status Ringkasan
  </h3>

  <div class="space-y-4">
    {{-- Pending Loans Status --}}
    <div
      class="flex items-center justify-between p-3 bg-warning-50 rounded-md border border-warning-200"
    >
      <div class="flex items-center gap-3">
        <svg
          class="w-5 h-5 text-warning-600"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
          />
        </svg>
        <span class="font-inter text-sm text-warning-700">
          Pinjaman Menunggu
        </span>
      </div>
      <span
        class="bg-warning-600 text-white px-2 py-1 rounded-full text-xs font-medium"
      >
        {{ $pendingLoans }}
      </span>
    </div>

    {{-- Open Tickets Status --}}
    <div
      class="flex items-center justify-between p-3 bg-danger-50 rounded-md border border-danger-200"
    >
      <div class="flex items-center gap-3">
        <svg
          class="w-5 h-5 text-danger-600"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
          />
        </svg>
        <span class="font-inter text-sm text-danger-700">Tiket Terbuka</span>
      </div>
      <span
        class="bg-danger-600 text-white px-2 py-1 rounded-full text-xs font-medium"
      >
        {{ $openTickets }}
      </span>
    </div>

    {{-- Notifications Status --}}
    <div
      class="flex items-center justify-between p-3 bg-primary-50 rounded-md border border-primary-200"
    >
      <div class="flex items-center gap-3">
        <svg
          class="w-5 h-5 text-primary-600"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M15 17h5l-5 5v-5zM4 6h16M4 12h16m-7 6h7"
          />
        </svg>
        <span class="font-inter text-sm text-primary-700">
          Notifikasi Baharu
        </span>
      </div>
      <span
        class="bg-primary-600 text-white px-2 py-1 rounded-full text-xs font-medium"
      >
        {{ $notifications }}
      </span>
    </div>
  </div>
</div>
