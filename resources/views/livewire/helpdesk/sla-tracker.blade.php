<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
  <!-- Header -->
  <div
    class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Penjejakan SLA / SLA Tracker
          </h1>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Pantau prestasi SLA untuk tiket helpdesk / Monitor SLA performance
            for helpdesk tickets
          </p>
        </div>

        <!-- Filters -->
        <div class="flex items-center gap-4">
          <!-- Date Range Filter -->
          <select
            wire:model.live="dateRange"
            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm"
          >
            <option value="7">7 Hari Terakhir / Last 7 Days</option>
            <option value="30">30 Hari Terakhir / Last 30 Days</option>
            <option value="90">90 Hari Terakhir / Last 90 Days</option>
          </select>

          <!-- Category Filter -->
          <select
            wire:model.live="categoryFilter"
            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm"
          >
            <option value="all">Semua Kategori / All Categories</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id }}">
                {{ $category->name }}
              </option>
            @endforeach
          </select>

          <!-- Status Filter -->
          <select
            wire:model.live="statusFilter"
            class="rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white text-sm"
          >
            <option value="all">Semua Status / All Statuses</option>
            @foreach ($statuses as $status)
              <option value="{{ $status->code }}">{{ $status->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- SLA Metrics Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <!-- Total Tickets -->
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
      >
        <div class="p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div
                class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center"
              >
                <svg
                  class="w-5 h-5 text-white"
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
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt
                  class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate"
                >
                  Jumlah Tiket / Total Tickets
                </dt>
                <dd class="text-2xl font-bold text-gray-900 dark:text-white">
                  {{ number_format($slaMetrics["total"] ?? 0) }}
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- SLA Met -->
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
      >
        <div class="p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div
                class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center"
              >
                <svg
                  class="w-5 h-5 text-white"
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
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt
                  class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate"
                >
                  SLA Dipenuhi / SLA Met
                </dt>
                <dd class="flex items-baseline">
                  <span
                    class="text-2xl font-bold text-green-600 dark:text-green-400"
                  >
                    {{ number_format($slaMetrics["met"] ?? 0) }}
                  </span>
                  <span
                    class="ml-2 text-sm font-medium text-green-600 dark:text-green-400"
                  >
                    ({{ $slaMetrics["met_percentage"] ?? 0 }}%)
                  </span>
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- SLA Breached -->
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
      >
        <div class="p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div
                class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center"
              >
                <svg
                  class="w-5 h-5 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"
                  ></path>
                </svg>
              </div>
            </div>
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt
                  class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate"
                >
                  SLA Dilanggar / SLA Breached
                </dt>
                <dd class="flex items-baseline">
                  <span
                    class="text-2xl font-bold text-red-600 dark:text-red-400"
                  >
                    {{ number_format($slaMetrics["breached"] ?? 0) }}
                  </span>
                  <span
                    class="ml-2 text-sm font-medium text-red-600 dark:text-red-400"
                  >
                    ({{ $slaMetrics["breached_percentage"] ?? 0 }}%)
                  </span>
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>

      <!-- At Risk -->
      <div
        class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
      >
        <div class="p-6">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div
                class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center"
              >
                <svg
                  class="w-5 h-5 text-white"
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
            <div class="ml-5 w-0 flex-1">
              <dl>
                <dt
                  class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate"
                >
                  Berisiko / At Risk
                </dt>
                <dd
                  class="text-2xl font-bold text-yellow-600 dark:text-yellow-400"
                >
                  {{ number_format($slaMetrics["at_risk"] ?? 0) }}
                </dd>
              </dl>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- SLA Progress Chart -->
    @if (! empty($slaMetrics) && $slaMetrics["total"] > 0)
      <div
        class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 mb-8"
      >
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <h3 class="text-lg font-medium text-gray-900 dark:text-white">
            Prestasi SLA Keseluruhan / Overall SLA Performance
          </h3>
        </div>
        <div class="p-6">
          <div class="relative pt-1">
            <div class="flex mb-2 items-center justify-between">
              <div>
                <span
                  class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 dark:text-green-400 bg-green-200 dark:bg-green-800"
                >
                  SLA Met
                </span>
              </div>
              <div class="text-right">
                <span
                  class="text-xs font-semibold inline-block text-green-600 dark:text-green-400"
                >
                  {{ $slaMetrics["met_percentage"] }}%
                </span>
              </div>
            </div>
            <div
              class="overflow-hidden h-4 mb-4 text-xs flex rounded bg-green-200 dark:bg-green-800"
            >
              <div
                style="width: {{ $slaMetrics["met_percentage"] }}%"
                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"
              ></div>
            </div>
          </div>

          <div class="relative pt-1">
            <div class="flex mb-2 items-center justify-between">
              <div>
                <span
                  class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 dark:text-red-400 bg-red-200 dark:bg-red-800"
                >
                  SLA Breached
                </span>
              </div>
              <div class="text-right">
                <span
                  class="text-xs font-semibold inline-block text-red-600 dark:text-red-400"
                >
                  {{ $slaMetrics["breached_percentage"] }}%
                </span>
              </div>
            </div>
            <div
              class="overflow-hidden h-4 mb-4 text-xs flex rounded bg-red-200 dark:bg-red-800"
            >
              <div
                style="width: {{ $slaMetrics["breached_percentage"] }}%"
                class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500"
              ></div>
            </div>
          </div>
        </div>
      </div>
    @endif

    <!-- Category Breakdown -->
    @if (! empty($categoryBreakdown))
      <div
        class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 mb-8"
      >
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <h3 class="text-lg font-medium text-gray-900 dark:text-white">
            Pecahan Mengikut Kategori / Breakdown by Category
          </h3>
        </div>
        <div class="overflow-x-auto">
          <table
            class="min-w-full divide-y divide-gray-200 dark:divide-gray-700"
          >
            <thead class="bg-gray-50 dark:bg-gray-900">
              <tr>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
                >
                  Kategori / Category
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
                >
                  Jumlah / Total
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
                >
                  SLA Dipenuhi / Met
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
                >
                  SLA Dilanggar / Breached
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
                >
                  Peratusan / Percentage
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
                >
                  SLA Default
                </th>
              </tr>
            </thead>
            <tbody
              class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
            >
              @foreach ($categoryBreakdown as $category)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                  <td
                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white"
                  >
                    {{ $category["name"] }}
                  </td>
                  <td
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                  >
                    {{ number_format($category["total"]) }}
                  </td>
                  <td
                    class="px-6 py-4 whitespace-nowrap text-sm text-green-600 dark:text-green-400"
                  >
                    {{ number_format($category["met_sla"]) }}
                  </td>
                  <td
                    class="px-6 py-4 whitespace-nowrap text-sm text-red-600 dark:text-red-400"
                  >
                    {{ number_format($category["breached_sla"]) }}
                  </td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center">
                      <div
                        class="flex-1 bg-gray-200 dark:bg-gray-600 rounded-full h-2 mr-2"
                      >
                        <div
                          class="bg-green-500 h-2 rounded-full"
                          style="width: {{ $category["met_percentage"] }}%"
                        ></div>
                      </div>
                      <span
                        class="text-sm text-gray-600 dark:text-gray-400 min-w-[3rem] text-right"
                      >
                        {{ $category["met_percentage"] }}%
                      </span>
                    </div>
                  </td>
                  <td
                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                  >
                    {{ $category["default_sla_hours"] }} jam/hours
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <!-- At Risk Tickets -->
      <div
        class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
      >
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <h3 class="text-lg font-medium text-gray-900 dark:text-white">
            Tiket Berisiko / At Risk Tickets
          </h3>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            Tiket yang akan melanggar SLA dalam 24 jam / Tickets due to breach
            SLA within 24 hours
          </p>
        </div>
        <div
          class="divide-y divide-gray-200 dark:divide-gray-700 max-h-96 overflow-y-auto"
        >
          @forelse ($atRiskTickets as $ticket)
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700">
              <div class="flex items-center justify-between">
                <div class="flex-1 min-w-0">
                  <div class="flex items-center gap-2 mb-2">
                    <span
                      class="text-sm font-medium text-gray-900 dark:text-white"
                    >
                      #{{ $ticket["ticket_number"] }}
                    </span>
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @if ($ticket["risk_level"] === "critical")
                          bg-red-100
                          text-red-800
                          dark:bg-red-800
                          dark:text-red-200
                      @elseif ($ticket["risk_level"] === "high")
                          bg-orange-100
                          text-orange-800
                          dark:bg-orange-800
                          dark:text-orange-200
                      @elseif ($ticket["risk_level"] === "medium")
                          bg-yellow-100
                          text-yellow-800
                          dark:bg-yellow-800
                          dark:text-yellow-200
                      @else
                          bg-green-100
                          text-green-800
                          dark:bg-green-800
                          dark:text-green-200
                      @endif"
                    >
                      {{ ucfirst(is_object($ticket["risk_level"]) && method_exists($ticket["risk_level"], "value") ? (string) $ticket["risk_level"]->value : (string) $ticket["risk_level"]) }}
                    </span>
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @if ($ticket["priority"] === "critical")
                          bg-red-100
                          text-red-800
                          dark:bg-red-800
                          dark:text-red-200
                      @elseif ($ticket["priority"] === "high")
                          bg-orange-100
                          text-orange-800
                          dark:bg-orange-800
                          dark:text-orange-200
                      @elseif ($ticket["priority"] === "medium")
                          bg-yellow-100
                          text-yellow-800
                          dark:bg-yellow-800
                          dark:text-yellow-200
                      @else
                          bg-green-100
                          text-green-800
                          dark:bg-green-800
                          dark:text-green-200
                      @endif"
                    >
                      {{ ucfirst(is_object($ticket["priority"]) && method_exists($ticket["priority"], "value") ? (string) $ticket["priority"]->value : (string) $ticket["priority"]) }}
                    </span>
                  </div>
                  <p
                    class="text-sm text-gray-900 dark:text-white font-medium truncate"
                  >
                    {{ $ticket["title"] }}
                  </p>
                  <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    <span>{{ $ticket["category"] }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $ticket["user"] }}</span>
                    @if ($ticket["assigned_to"])
                      <span class="mx-2">•</span>
                      <span>
                        Ditugaskan kepada / Assigned to:
                        {{ $ticket["assigned_to"] }}
                      </span>
                    @endif
                  </div>
                  <div class="mt-2 text-xs">
                    <span
                      class="text-yellow-600 dark:text-yellow-400 font-medium"
                    >
                      {{ $ticket["time_remaining"]["value"] }}
                      {{ $ticket["time_remaining"]["unit"] }} /
                      {{ $ticket["time_remaining"]["unit_en"] }}
                      tersisa/remaining
                    </span>
                  </div>
                </div>
                <div class="ml-4 flex-shrink-0">
                  <button
                    wire:click="escalateAtRiskTicket({{ $ticket["id"] }})"
                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                  >
                    Eskalasi / Escalate
                  </button>
                </div>
              </div>
            </div>
          @empty
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
              <svg
                class="mx-auto h-12 w-12 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              <h3
                class="mt-2 text-sm font-medium text-gray-900 dark:text-white"
              >
                Tiada tiket berisiko / No at-risk tickets
              </h3>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Semua tiket dalam jadual yang selamat / All tickets are on safe
                schedule
              </p>
            </div>
          @endforelse
        </div>
      </div>

      <!-- Recent SLA Breaches -->
      <div
        class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
      >
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
          <h3 class="text-lg font-medium text-gray-900 dark:text-white">
            SLA Terkini Dilanggar / Recent SLA Breaches
          </h3>
          <p class="text-sm text-gray-600 dark:text-gray-400">
            Tiket yang telah melanggar SLA / Tickets that have breached SLA
          </p>
        </div>
        <div
          class="divide-y divide-gray-200 dark:divide-gray-700 max-h-96 overflow-y-auto"
        >
          @forelse ($recentBreaches as $ticket)
            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700">
              <div class="flex items-start justify-between">
                <div class="flex-1 min-w-0">
                  <div class="flex items-center gap-2 mb-2">
                    <span
                      class="text-sm font-medium text-gray-900 dark:text-white"
                    >
                      #{{ $ticket["ticket_number"] }}
                    </span>
                    @if ($ticket["is_resolved"])
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200"
                      >
                        Selesai / Resolved
                      </span>
                    @else
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200"
                      >
                        Aktif / Active
                      </span>
                    @endif
                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium @if ($ticket["priority"] === "critical")
                          bg-red-100
                          text-red-800
                          dark:bg-red-800
                          dark:text-red-200
                      @elseif ($ticket["priority"] === "high")
                          bg-orange-100
                          text-orange-800
                          dark:bg-orange-800
                          dark:text-orange-200
                      @elseif ($ticket["priority"] === "medium")
                          bg-yellow-100
                          text-yellow-800
                          dark:bg-yellow-800
                          dark:text-yellow-200
                      @else
                          bg-green-100
                          text-green-800
                          dark:bg-green-800
                          dark:text-green-200
                      @endif"
                    >
                      {{ ucfirst(is_object($ticket["priority"]) && method_exists($ticket["priority"], "value") ? (string) $ticket["priority"]->value : (string) $ticket["priority"]) }}
                    </span>
                  </div>
                  <p
                    class="text-sm text-gray-900 dark:text-white font-medium truncate"
                  >
                    {{ $ticket["title"] }}
                  </p>
                  <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    <span>{{ $ticket["category"] }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ $ticket["user"] }}</span>
                    @if ($ticket["assigned_to"])
                      <span class="mx-2">•</span>
                      <span>
                        Ditugaskan kepada / Assigned to:
                        {{ $ticket["assigned_to"] }}
                      </span>
                    @endif
                  </div>
                  <div class="mt-2 text-xs">
                    <span class="text-red-600 dark:text-red-400 font-medium">
                      Dilanggar sebanyak / Breached by:
                      {{ $ticket["breach_duration"]["value"] }}
                      {{ $ticket["breach_duration"]["unit"] }} /
                      {{ $ticket["breach_duration"]["unit_en"] }}
                    </span>
                  </div>
                  <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Tarikh akhir / Due:
                    {{ $ticket["due_at"]->format("d/m/Y H:i") }}
                    @if ($ticket["resolved_at"])
                      <span class="mx-2">•</span>
                      Selesai / Resolved:
                      {{ $ticket["resolved_at"]->format("d/m/Y H:i") }}
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
              <svg
                class="mx-auto h-12 w-12 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
              </svg>
              <h3
                class="mt-2 text-sm font-medium text-gray-900 dark:text-white"
              >
                Tiada pelanggaran SLA / No SLA breaches
              </h3>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Prestasi SLA yang cemerlang! / Excellent SLA performance!
              </p>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
