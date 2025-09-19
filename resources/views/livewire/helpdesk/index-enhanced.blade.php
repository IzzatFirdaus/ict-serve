<div
  class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-indigo-900"
>
  <!-- Header Section with Stats -->
  <div
    class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <!-- Page Title -->
      <div class="flex items-center justify-between mb-6">
        <div>
          <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            Senarai Tiket Bantuan / Helpdesk Tickets
          </h1>
          <p class="text-gray-600 dark:text-gray-400 mt-1">
            Urus dan pantau tiket bantuan / Manage and monitor helpdesk tickets
          </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center space-x-3">
          <a
            href="{{ route('helpdesk.sla-tracker') }}"
            class="inline-flex items-center px-4 py-2 border border-purple-600 text-sm font-medium rounded-lg shadow-sm text-purple-600 bg-white hover:bg-purple-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-all"
          >
            <svg
              class="w-4 h-4 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"
              ></path>
            </svg>
            SLA Tracker
          </a>

          <a
            href="{{ route('helpdesk.create-enhanced') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
          >
            <svg
              class="w-4 h-4 mr-2"
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
            Cipta Tiket / Create Ticket
          </a>

          <button
            wire:click="resetFilters"
            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all"
          >
            <svg
              class="w-4 h-4 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
              ></path>
            </svg>
            Reset
          </button>
        </div>
      </div>

      <!-- Stats Cards -->
      <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
        <div
          class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg p-4 text-white"
        >
          <div class="flex items-center justify-between">
            <div>
              <p class="text-blue-100 text-sm">Jumlah / Total</p>
              <p class="text-2xl font-bold">{{ $stats['total'] ?? 0 }}</p>
            </div>
            <svg
              class="w-8 h-8 text-blue-200"
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

        <div
          class="bg-gradient-to-r from-yellow-500 to-orange-500 rounded-lg p-4 text-white"
        >
          <div class="flex items-center justify-between">
            <div>
              <p class="text-yellow-100 text-sm">Baharu / New</p>
              <p class="text-2xl font-bold">{{ $stats['open'] ?? 0 }}</p>
            </div>
            <svg
              class="w-8 h-8 text-yellow-200"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
              ></path>
            </svg>
          </div>
        </div>

        <div
          class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg p-4 text-white"
        >
          <div class="flex items-center justify-between">
            <div>
              <p class="text-indigo-100 text-sm">Dalam Proses / In Progress</p>
              <p class="text-2xl font-bold">
                {{ $stats['in_progress'] ?? 0 }}
              </p>
            </div>
            <svg
              class="w-8 h-8 text-indigo-200"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M13 10V3L4 14h7v7l9-11h-7z"
              ></path>
            </svg>
          </div>
        </div>

        <div
          class="bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg p-4 text-white"
        >
          <div class="flex items-center justify-between">
            <div>
              <p class="text-green-100 text-sm">Selesai / Resolved</p>
              <p class="text-2xl font-bold">{{ $stats['resolved'] ?? 0 }}</p>
            </div>
            <svg
              class="w-8 h-8 text-green-200"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
              ></path>
            </svg>
          </div>
        </div>

        <div
          class="bg-gradient-to-r from-red-500 to-red-600 rounded-lg p-4 text-white"
        >
          <div class="flex items-center justify-between">
            <div>
              <p class="text-red-100 text-sm">Lewat Tempoh / Overdue</p>
              <p class="text-2xl font-bold">{{ $stats['overdue'] ?? 0 }}</p>
            </div>
            <svg
              class="w-8 h-8 text-red-200"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.882 16.5c-.77.833.192 2.5 1.732 2.5z"
              ></path>
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Filters Section -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div
      class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 mb-6"
    >
      <div class="p-6">
        <!-- Basic Filters -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
          <!-- Search -->
          <div class="md:col-span-2">
            <label
              class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
            >
              Cari / Search
            </label>
            <div class="relative">
              <input
                type="text"
                wire:model.live.debounce.300ms="search"
                class="block w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                placeholder="Cari mengikut nombor tiket, tajuk, atau penerangan / Search by ticket number, title, or description"
              />
              <div
                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
              >
                <svg
                  class="h-5 w-5 text-gray-400"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                  ></path>
                </svg>
              </div>
            </div>
          </div>

          <!-- Status Filter -->
          <div>
            <label
              class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
            >
              Status
            </label>
            <select
              wire:model.live="statusFilter"
              class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
            >
              <option value="all">Semua Status / All Status</option>
              @foreach ($statuses as $status)
                <option value="{{ $status->code }}">
                  {{ $status->name }}
                </option>
              @endforeach
            </select>
          </div>

          <!-- Category Filter -->
          <div>
            <label
              class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
            >
              Kategori / Category
            </label>
            <select
              wire:model.live="categoryFilter"
              class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
            >
              <option value="all">Semua Kategori / All Categories</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>

        <!-- Advanced Filters Toggle -->
        <div class="flex items-center justify-between">
          <button
            wire:click="toggleAdvancedFilters"
            class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
          >
            <svg
              class="w-4 h-4 mr-2 transform transition-transform {{ $showAdvancedFilters ? 'rotate-180' : '' }}"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              ></path>
            </svg>
            Penapis Lanjutan / Advanced Filters
          </button>

          <!-- View Mode Toggle -->
          <div class="flex items-center space-x-2">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300">
              Paparan / View:
            </label>
            <div class="flex bg-gray-100 dark:bg-gray-700 rounded-lg p-1">
              <button
                wire:click="$set('viewMode', 'list')"
                class="px-3 py-1 rounded text-sm {{ $viewMode === 'list' ? 'bg-white dark:bg-gray-800 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-600 dark:text-gray-400' }}"
              >
                Senarai / List
              </button>
              <button
                wire:click="$set('viewMode', 'card')"
                class="px-3 py-1 rounded text-sm {{ $viewMode === 'card' ? 'bg-white dark:bg-gray-800 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-gray-600 dark:text-gray-400' }}"
              >
                Kad / Card
              </button>
            </div>
          </div>
        </div>

        <!-- Advanced Filters -->
        @if ($showAdvancedFilters)
          <div class="border-t border-gray-200 dark:border-gray-600 mt-4 pt-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
              <!-- Priority Filter -->
              <div>
                <label
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                >
                  Keutamaan / Priority
                </label>
                <select
                  wire:model.live="priorityFilter"
                  class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                >
                  <option value="all">Semua / All</option>
                  <option value="low">Rendah / Low</option>
                  <option value="medium">Sederhana / Medium</option>
                  <option value="high">Tinggi / High</option>
                  <option value="critical">Kritikal / Critical</option>
                </select>
              </div>

              <!-- Assignee Filter -->
              <div>
                <label
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                >
                  Ditugaskan / Assigned To
                </label>
                <select
                  wire:model.live="assigneeFilter"
                  class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                >
                  <option value="all">Semua / All</option>
                  <option value="unassigned">
                    Belum Ditugaskan / Unassigned
                  </option>
                  @foreach ($technicians as $tech)
                    <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                  @endforeach
                </select>
              </div>

              <!-- Date Filter -->
              <div>
                <label
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                >
                  Tarikh / Date Range
                </label>
                <select
                  wire:model.live="dateFilter"
                  class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                >
                  <option value="all">Semua Tarikh / All Dates</option>
                  <option value="today">Hari Ini / Today</option>
                  <option value="week">Minggu Ini / This Week</option>
                  <option value="month">Bulan Ini / This Month</option>
                  <option value="overdue">Lewat Tempoh / Overdue</option>
                </select>
              </div>

              <!-- Per Page -->
              <div>
                <label
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                >
                  Item Per Halaman / Items Per Page
                </label>
                <select
                  wire:model.live="perPage"
                  class="block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                >
                  <option value="10">10</option>
                  <option value="15">15</option>
                  <option value="25">25</option>
                  <option value="50">50</option>
                </select>
              </div>
            </div>

            <!-- My Tickets Only Toggle -->
            <div class="mt-4">
              <label class="flex items-center cursor-pointer">
                <input
                  type="checkbox"
                  wire:model.live="myTicketsOnly"
                  class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 dark:border-gray-600 dark:bg-gray-700"
                />
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                  Hanya tiket saya sahaja / My tickets only
                </span>
              </label>
            </div>
          </div>
        @endif
      </div>
    </div>

    <!-- Bulk Actions -->
    @if (! empty($selectedTickets))
      <div
        class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6"
      >
        <div class="flex items-center justify-between">
          <div class="flex items-center space-x-4">
            <span class="text-sm font-medium text-blue-900 dark:text-blue-100">
              {{ count($selectedTickets) }} tiket dipilih / tickets selected
            </span>

            <select
              wire:model="bulkAction"
              class="px-3 py-1 border border-blue-300 dark:border-blue-600 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-blue-900 dark:text-white"
            >
              <option value="">Pilih tindakan / Select action</option>
              <option value="delete">Padam / Delete</option>
              <option value="update_status">
                Kemaskini Status / Update Status
              </option>
              <option value="update_priority">
                Kemaskini Keutamaan / Update Priority
              </option>
              <option value="assign">Tugaskan / Assign</option>
            </select>
          </div>

          <div class="flex items-center space-x-2">
            <button
              wire:click="executeBulkAction"
              class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors"
            >
              Jalankan / Execute
            </button>
            <button
              wire:click="$set('selectedTickets', [])"
              class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors"
            >
              Batal / Cancel
            </button>
          </div>
        </div>
      </div>
    @endif

    <!-- Tickets Content -->
    <div
      class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700"
    >
      @if ($viewMode === 'list')
        @include('livewire.helpdesk.partials.tickets-table', ['tickets' => $tickets])
      @else
        @include('livewire.helpdesk.partials.tickets-cards', ['tickets' => $tickets])
      @endif
    </div>

    <!-- Pagination -->
    <div class="mt-6">
      {{ $tickets->links() }}
    </div>
  </div>

  <!-- Toast Messages -->
  @if (session('success'))
    <div
      class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg"
      x-data="{ show: true }"
      x-show="show"
      x-transition
      x-init="setTimeout(() => (show = false), 5000)"
    >
      {{ session('success') }}
    </div>
  @endif

  @if (session('error'))
    <div
      class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg"
      x-data="{ show: true }"
      x-show="show"
      x-transition
      x-init="setTimeout(() => (show = false), 5000)"
    >
      {{ session('error') }}
    </div>
  @endif
</div>
