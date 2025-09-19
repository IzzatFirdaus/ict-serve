{{-- MYDS Dashboard Layout - Citizen-Centric Design --}}
<div class="max-w-7xl mx-auto">
  {{-- Welcome Section --}}
  <div class="mb-8">
    <div
      class="bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg p-6 text-white"
    >
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold mb-2">
            Selamat datang ke ICT Serve (iServe)
          </h1>
          <p class="text-blue-100 mb-1">
            Sistem Bersepadu Perkhidmatan ICT MOTAC
          </p>
          <p class="text-blue-200 text-sm">
            {{ auth()->user()->name }} ({{ auth()->user()->staff_id }}) -
            {{ auth()->user()->division }}
          </p>
        </div>
        <div class="hidden md:block">
          <svg
            class="w-16 h-16 text-blue-200"
            fill="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              d="M12 2L2 7v10c0 5.55 3.84 9.74 9 11 5.16-1.26 9-5.45 9-11V7l-10-5z"
            />
          </svg>
        </div>
      </div>
    </div>
  </div>

  {{-- Quick Actions - MYDS Button Components --}}
  <div class="mb-8">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">
      Tindakan Pantas / Quick Actions
    </h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      @foreach ($quickActions as $action)
        <a
          href="{{ route($action["route"]) }}"
          class="group relative bg-white rounded-lg border border-gray-200 p-6 hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-{{ $action["color"] }}-500 focus:ring-offset-2"
          aria-describedby="action-{{ $loop->index }}-desc"
        >
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div
                class="w-10 h-10 bg-{{ $action["color"] }}-100 rounded-lg flex items-center justify-center group-hover:bg-{{ $action["color"] }}-200 transition-colors"
              >
                @switch($action["icon"])
                  @case("plus-circle")
                    <svg
                      class="w-6 h-6 text-{{ $action["color"] }}-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"
                      ></path>
                    </svg>

                    @break
                  @case("exclamation-triangle")
                    <svg
                      class="w-6 h-6 text-{{ $action["color"] }}-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"
                      ></path>
                    </svg>

                    @break
                  @case("clipboard-list")
                    <svg
                      class="w-6 h-6 text-{{ $action["color"] }}-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                      ></path>
                    </svg>

                    @break
                  @case("support")
                    <svg
                      class="w-6 h-6 text-{{ $action["color"] }}-600"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.5a9.5 9.5 0 100 19 9.5 9.5 0 000-19z"
                      ></path>
                    </svg>

                    @break
                @endswitch
              </div>
            </div>
            <div class="ml-4 flex-1">
              <h3
                class="text-sm font-medium text-gray-900 group-hover:text-{{ $action["color"] }}-700"
              >
                {{ $action["title"] }}
              </h3>
              <p
                id="action-{{ $loop->index }}-desc"
                class="text-xs text-gray-500 mt-1"
              >
                {{ $action["description"] }}
              </p>
            </div>
          </div>
        </a>
      @endforeach
    </div>
  </div>

  {{-- Statistics Overview --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    {{-- Loan Statistics --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">
          Statistik Pinjaman / Loan Statistics
        </h2>
        <div
          class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center"
        >
          <svg
            class="w-5 h-5 text-green-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            ></path>
          </svg>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="text-center p-4 bg-gray-50 rounded-lg">
          <div class="text-2xl font-bold text-gray-900">
            {{ $loanStats["total"] ?? 0 }}
          </div>
          <div class="text-sm text-gray-600">Jumlah / Total</div>
        </div>
        <div class="text-center p-4 bg-green-50 rounded-lg">
          <div class="text-2xl font-bold text-green-600">
            {{ $loanStats["active"] ?? 0 }}
          </div>
          <div class="text-sm text-gray-600">Aktif / Active</div>
        </div>
        <div class="text-center p-4 bg-yellow-50 rounded-lg">
          <div class="text-2xl font-bold text-yellow-600">
            {{ $loanStats["pending_approval"] ?? 0 }}
          </div>
          <div class="text-sm text-gray-600">Menunggu / Pending</div>
        </div>
        <div class="text-center p-4 bg-red-50 rounded-lg">
          <div class="text-2xl font-bold text-red-600">
            {{ $loanStats["overdue"] ?? 0 }}
          </div>
          <div class="text-sm text-gray-600">Lewat Tempoh / Overdue</div>
        </div>
      </div>
    </div>

    {{-- Ticket Statistics --}}
    <div class="bg-white rounded-lg border border-gray-200 p-6">
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-900">
          Statistik Tiket / Ticket Statistics
        </h2>
        <div
          class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center"
        >
          <svg
            class="w-5 h-5 text-red-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
            ></path>
          </svg>
        </div>
      </div>
      <div class="grid grid-cols-2 gap-4">
        <div class="text-center p-4 bg-gray-50 rounded-lg">
          <div class="text-2xl font-bold text-gray-900">
            {{ $ticketStats["total"] ?? 0 }}
          </div>
          <div class="text-sm text-gray-600">Jumlah / Total</div>
        </div>
        <div class="text-center p-4 bg-red-50 rounded-lg">
          <div class="text-2xl font-bold text-red-600">
            {{ $ticketStats["open"] ?? 0 }}
          </div>
          <div class="text-sm text-gray-600">Terbuka / Open</div>
        </div>
        <div class="text-center p-4 bg-blue-50 rounded-lg">
          <div class="text-2xl font-bold text-blue-600">
            {{ $ticketStats["in_progress"] ?? 0 }}
          </div>
          <div class="text-sm text-gray-600">Dalam Proses / In Progress</div>
        </div>
        <div class="text-center p-4 bg-green-50 rounded-lg">
          <div class="text-2xl font-bold text-green-600">
            {{ $ticketStats["resolved_today"] ?? 0 }}
          </div>
          <div class="text-sm text-gray-600">
            Selesai Hari Ini / Resolved Today
          </div>
        </div>
      </div>
    </div>
  </div>

  {{-- Recent Activities --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    {{-- Recent Loans --}}
    <div class="bg-white rounded-lg border border-gray-200">
      <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-semibold text-gray-900">
            Pinjaman Terkini / Recent Loans
          </h2>
          <a
            href="{{ route("loan.index") }}"
            class="text-sm text-blue-600 hover:text-blue-800"
          >
            Lihat Semua / View All
          </a>
        </div>
      </div>
      <div class="divide-y divide-gray-200">
        @forelse ($recentLoans as $loan)
          <div class="p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="font-medium text-gray-900">
                  {{ $loan->request_number }}
                </p>
                <p class="text-sm text-gray-600">{{ $loan->purpose }}</p>
                <p class="text-xs text-gray-500">
                  {{ $loan->created_at->format("d M Y, H:i") }}
                </p>
              </div>
              <div>
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @if ($loan->status->code === "approved")
                      bg-green-100
                      text-green-800
                  @elseif ($loan->status->code === "pending")
                      bg-yellow-100
                      text-yellow-800
                  @elseif ($loan->status->code === "rejected")
                      bg-red-100
                      text-red-800
                  @else
                      bg-gray-100
                      text-gray-800
                  @endif"
                >
                  {{ $loan->status->name_bm ?? $loan->status->name }}
                </span>
              </div>
            </div>
          </div>
        @empty
          <div class="p-6 text-center">
            <svg
              class="mx-auto h-12 w-12 text-gray-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
              ></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">
              Tiada pinjaman
            </h3>
            <p class="mt-1 text-sm text-gray-500">
              Belum ada permohonan pinjaman dibuat.
            </p>
            <div class="mt-6">
              <a
                href="{{ route("loan.create") }}"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
              >
                <svg
                  class="-ml-1 mr-2 h-5 w-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 4v16m8-8H4"
                  ></path>
                </svg>
                Mohon Pinjaman
              </a>
            </div>
          </div>
        @endforelse
      </div>
    </div>

    {{-- Recent Tickets --}}
    <div class="bg-white rounded-lg border border-gray-200">
      <div class="p-6 border-b border-gray-200">
        <div class="flex items-center justify-between">
          <h2 class="text-lg font-semibold text-gray-900">
            Tiket Terkini / Recent Tickets
          </h2>
          <a
            href="{{ route("helpdesk.index") }}"
            class="text-sm text-blue-600 hover:text-blue-800"
          >
            Lihat Semua / View All
          </a>
        </div>
      </div>
      <div class="divide-y divide-gray-200">
        @forelse ($recentTickets as $ticket)
          <div class="p-6">
            <div class="flex items-center justify-between">
              <div>
                <p class="font-medium text-gray-900">
                  {{ $ticket->ticket_number }}
                </p>
                <p class="text-sm text-gray-600">{{ $ticket->title }}</p>
                <p class="text-xs text-gray-500">
                  {{ $ticket->created_at->format("d M Y, H:i") }}
                </p>
              </div>
              <div class="text-right">
                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @if ($ticket->priority === "high")
                      bg-red-100
                      text-red-800
                  @elseif ($ticket->priority === "medium")
                      bg-yellow-100
                      text-yellow-800
                  @else
                      bg-green-100
                      text-green-800
                  @endif"
                >
                  {{ ucfirst($ticket->priority) }}
                </span>
                <div class="mt-1">
                  <span
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @if ($ticket->status->code === "resolved")
                        bg-green-100
                        text-green-800
                    @elseif ($ticket->status->code === "in_progress")
                        bg-blue-100
                        text-blue-800
                    @elseif ($ticket->status->code === "open")
                        bg-yellow-100
                        text-yellow-800
                    @else
                        bg-gray-100
                        text-gray-800
                    @endif"
                  >
                    {{ $ticket->status->name_bm ?? $ticket->status->name }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="p-6 text-center">
            <svg
              class="mx-auto h-12 w-12 text-gray-400"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
              ></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tiada tiket</h3>
            <p class="mt-1 text-sm text-gray-500">
              Belum ada laporan masalah dibuat.
            </p>
            <div class="mt-6">
              <a
                href="{{ route("helpdesk.create") }}"
                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
              >
                <svg
                  class="-ml-1 mr-2 h-5 w-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"
                  ></path>
                </svg>
                Lapor Kerosakan
              </a>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </div>
</div>
