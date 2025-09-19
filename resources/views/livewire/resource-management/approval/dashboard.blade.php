<div class="bg-background-light dark:bg-background-dark min-h-screen">
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <x-myds.header>
      <h1
        class="font-poppins text-2xl font-semibold text-black-900 dark:text-white"
      >
        Dashboard Kelulusan Pinjaman
      </h1>
      <p class="font-inter text-sm text-black-500 dark:text-black-400 mt-2">
        Urus dan luluskan permohonan pinjaman peralatan ICT
      </p>
    </x-myds.header>

    <!-- Flash Messages -->
    @if (session('success'))
      <x-myds.callout variant="success" class="mb-6">
        <x-myds.icon name="check-circle" size="20" class="flex-shrink-0" />
        <div>
          <p class="font-inter text-sm text-success-700 dark:text-success-500">
            {{ session('success') }}
          </p>
        </div>
      </x-myds.callout>
    @endif

    @if (session('error'))
      <x-myds.callout variant="danger" class="mb-6">
        <x-myds.icon name="warning-circle" size="20" class="flex-shrink-0" />
        <div>
          <p class="font-inter text-sm text-danger-700 dark:text-danger-400">
            {{ session('error') }}
          </p>
        </div>
      </x-myds.callout>
    @endif

    <!-- Status Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
      <div class="bg-white dark:bg-dialog rounded-lg p-4 border border-divider">
        <div class="flex items-center justify-between">
          <div>
            <p class="font-inter text-xs text-black-500 dark:text-black-400">
              Menunggu Kelulusan
            </p>
            <p class="font-poppins text-2xl font-semibold text-warning-600">
              {{ $statusCounts['pending_support'] }}
            </p>
          </div>
          <x-myds.icon name="clock" size="24" class="text-warning-500" />
        </div>
      </div>

      <div class="bg-white dark:bg-dialog rounded-lg p-4 border border-divider">
        <div class="flex items-center justify-between">
          <div>
            <p class="font-inter text-xs text-black-500 dark:text-black-400">
              Diluluskan
            </p>
            <p class="font-poppins text-2xl font-semibold text-success-600">
              {{ $statusCounts['approved'] }}
            </p>
          </div>
          <x-myds.icon name="check-circle" size="24" class="text-success-500" />
        </div>
      </div>

      <div class="bg-white dark:bg-dialog rounded-lg p-4 border border-divider">
        <div class="flex items-center justify-between">
          <div>
            <p class="font-inter text-xs text-black-500 dark:text-black-400">
              Ditolak
            </p>
            <p class="font-poppins text-2xl font-semibold text-danger-600">
              {{ $statusCounts['rejected'] }}
            </p>
          </div>
          <x-myds.icon name="cross-circle" size="24" class="text-danger-500" />
        </div>
      </div>

      <div class="bg-white dark:bg-dialog rounded-lg p-4 border border-divider">
        <div class="flex items-center justify-between">
          <div>
            <p class="font-inter text-xs text-black-500 dark:text-black-400">
              Dikeluarkan
            </p>
            <p class="font-poppins text-2xl font-semibold text-primary-600">
              {{ $statusCounts['issued'] }}
            </p>
          </div>
          <x-myds.icon
            name="arrow-outgoing"
            size="24"
            class="text-primary-500"
          />
        </div>
      </div>

      <div class="bg-white dark:bg-dialog rounded-lg p-4 border border-divider">
        <div class="flex items-center justify-between">
          <div>
            <p class="font-inter text-xs text-black-500 dark:text-black-400">
              Selesai
            </p>
            <p
              class="font-poppins text-2xl font-semibold text-black-600 dark:text-black-400"
            >
              {{ $statusCounts['completed'] }}
            </p>
          </div>
          <x-myds.icon name="check" size="24" class="text-black-500" />
        </div>
      </div>
    </div>

    <!-- Filters and Search -->
    <div
      class="bg-white dark:bg-dialog rounded-lg shadow-sm border border-divider mb-6"
    >
      <div class="px-6 py-4 border-b border-divider">
        <h2
          class="font-poppins text-lg font-medium text-black-900 dark:text-white"
        >
          Permohonan Pinjaman
        </h2>
      </div>

      <div class="px-6 py-4 bg-washed dark:bg-black-100">
        <div class="flex flex-col md:flex-row gap-4">
          <!-- Status Filter -->
          <div class="flex-1">
            <label
              for="status_filter"
              class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
            >
              Status
            </label>
            <x-myds.select wire:model.live="status_filter" id="status_filter">
              <option value="pending_support">Menunggu Kelulusan</option>
              <option value="approved">Diluluskan</option>
              <option value="rejected">Ditolak</option>
              <option value="issued">Dikeluarkan</option>
              <option value="completed">Selesai</option>
            </x-myds.select>
          </div>

          <!-- Search -->
          <div class="flex-2">
            <label
              for="search"
              class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
            >
              Cari
            </label>
            <x-myds.input
              type="text"
              id="search"
              wire:model.live.debounce.300ms="search"
              placeholder="Cari mengikut nombor rujukan, tujuan, atau nama pemohon..."
              class="w-full"
            />
          </div>
        </div>
      </div>
    </div>

    <!-- Applications Table -->
    <div
      class="bg-white dark:bg-dialog rounded-lg shadow-sm border border-divider"
    >
      @if ($loans->count() > 0)
        <div class="overflow-x-auto">
          <table class="w-full">
            <thead class="bg-washed dark:bg-black-100">
              <tr>
                <th
                  class="px-6 py-3 text-left font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider"
                >
                  Permohonan
                </th>
                <th
                  class="px-6 py-3 text-left font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider"
                >
                  Pemohon
                </th>
                <th
                  class="px-6 py-3 text-left font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider"
                >
                  Peralatan
                </th>
                <th
                  class="px-6 py-3 text-left font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider"
                >
                  Tarikh
                </th>
                <th
                  class="px-6 py-3 text-left font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider"
                >
                  Status
                </th>
                @if ($status_filter === 'pending_support')
                  <th
                    class="px-6 py-3 text-right font-inter text-xs font-medium text-black-700 dark:text-black-300 uppercase tracking-wider"
                  >
                    Tindakan
                  </th>
                @endif
              </tr>
            </thead>
            <tbody class="divide-y divide-divider">
              @foreach ($loans as $loan)
                <tr class="hover:bg-washed dark:hover:bg-black-100">
                  <td class="px-6 py-4">
                    <div>
                      <p
                        class="font-inter text-sm font-medium text-black-900 dark:text-white"
                      >
                        {{ $loan->request_number }}
                      </p>
                      <p
                        class="font-inter text-xs text-black-500 dark:text-black-400"
                      >
                        {{ $loan->purpose }}
                      </p>
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div>
                      <p
                        class="font-inter text-sm font-medium text-black-900 dark:text-white"
                      >
                        {{ $loan->user->name }}
                      </p>
                      <p
                        class="font-inter text-xs text-black-500 dark:text-black-400"
                      >
                        {{ $loan->user->email }}
                      </p>
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div class="space-y-1">
                      @foreach ($loan->loanItems as $item)
                        <p
                          class="font-inter text-xs text-black-600 dark:text-black-400"
                        >
                          {{ $item->equipmentItem->equipment->name ?? 'N/A' }}
                        </p>
                      @endforeach
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    <div>
                      <p
                        class="font-inter text-sm text-black-900 dark:text-white"
                      >
                        {{ $loan->requested_from ? \Carbon\Carbon::parse($loan->requested_from)->format('d/m/Y') : '-' }}
                      </p>
                      <p
                        class="font-inter text-xs text-black-500 dark:text-black-400"
                      >
                        {{ $loan->requested_to ? 'hingga ' . \Carbon\Carbon::parse($loan->requested_to)->format('d/m/Y') : '' }}
                      </p>
                    </div>
                  </td>

                  <td class="px-6 py-4">
                    @php
                      $statusConfig = [
                        'pending_support' => ['bg-warning-100', 'text-warning-700', 'Menunggu Kelulusan'],
                        'approved' => ['bg-success-100', 'text-success-700', 'Diluluskan'],
                        'rejected' => ['bg-danger-100', 'text-danger-700', 'Ditolak'],
                        'issued' => ['bg-primary-100', 'text-primary-700', 'Dikeluarkan'],
                        'completed' => ['bg-black-100', 'text-black-700', 'Selesai'],
                      ];
                      $config = $statusConfig[$loan->status->code] ?? ['bg-black-100', 'text-black-700', $loan->status->name];
                    @endphp

                    <span
                      class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $config[0] }} {{ $config[1] }}"
                    >
                      {{ $config[2] }}
                    </span>
                  </td>

                  @if ($status_filter === 'pending_support')
                    <td class="px-6 py-4 text-right">
                      <div class="flex justify-end space-x-2">
                        <x-myds.button
                          variant="success"
                          size="small"
                          wire:click="approve({{ $loan->id }})"
                          wire:confirm="Adakah anda pasti ingin meluluskan permohonan ini?"
                        >
                          <x-myds.icon name="check" size="14" class="mr-1" />
                          Lulus
                        </x-myds.button>

                        <x-myds.button
                          variant="danger"
                          size="small"
                          wire:click="$dispatch('open-reject-modal', { loan_id: {{ $loan->id }} })"
                        >
                          <x-myds.icon name="cross" size="14" class="mr-1" />
                          Tolak
                        </x-myds.button>
                      </div>
                    </td>
                  @endif
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-divider">
          {{ $loans->links() }}
        </div>
      @else
        <div class="px-6 py-12 text-center">
          <x-myds.icon
            name="document"
            size="48"
            class="text-black-300 dark:text-black-600 mx-auto mb-4"
          />
          <p class="font-inter text-sm text-black-500 dark:text-black-400">
            Tiada permohonan
            {{ $status_filter === 'pending_support' ? 'menunggu kelulusan' : '' }}
            ditemui.
          </p>
        </div>
      @endif
    </div>
  </div>

  <!-- Reject Modal (Placeholder - you would implement this as a separate Livewire component) -->
  <div
    x-data="{ open: false }"
    x-on:open-reject-modal.window="
      open = true
      $wire.set('rejectLoanId', $event.detail.loan_id)
    "
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 overflow-y-auto"
  >
    <!-- Modal backdrop and content would go here -->
  </div>
</div>
