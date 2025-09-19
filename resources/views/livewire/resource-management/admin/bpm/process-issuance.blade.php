<div class="bg-background-light dark:bg-background-dark min-h-screen">
  <div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <x-myds.header>
      <h1
        class="font-poppins text-2xl font-semibold text-black-900 dark:text-white"
      >
        Proses Pengeluaran Peralatan
      </h1>
      <p class="font-inter text-sm text-black-500 dark:text-black-400 mt-2">
        Keluarkan peralatan ICT untuk permohonan yang telah diluluskan
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Approved Loans List -->
      <div class="lg:col-span-2">
        <div
          class="bg-white dark:bg-dialog rounded-lg shadow-sm border border-divider"
        >
          <div class="px-6 py-4 border-b border-divider">
            <div class="flex justify-between items-center">
              <h2
                class="font-poppins text-lg font-medium text-black-900 dark:text-white"
              >
                Permohonan Diluluskan
              </h2>
              <div class="w-64">
                <x-myds.input
                  type="text"
                  wire:model.live.debounce.300ms="search"
                  placeholder="Cari permohonan..."
                  class="w-full"
                />
              </div>
            </div>
          </div>

          @if ($approvedLoans->count() > 0)
            <div class="divide-y divide-divider">
              @foreach ($approvedLoans as $loan)
                <div class="px-6 py-4 hover:bg-washed dark:hover:bg-black-100">
                  <div class="flex justify-between items-start">
                    <div class="flex-1">
                      <div class="flex items-center space-x-3 mb-2">
                        <h3
                          class="font-inter text-sm font-medium text-black-900 dark:text-white"
                        >
                          {{ $loan->request_number }}
                        </h3>
                        <span
                          class="inline-flex px-2 py-1 text-xs font-medium rounded-full bg-success-100 text-success-700"
                        >
                          Diluluskan
                        </span>
                      </div>

                      <p
                        class="font-inter text-sm text-black-600 dark:text-black-400 mb-1"
                      >
                        {{ $loan->user->name }} - {{ $loan->purpose }}
                      </p>

                      <div
                        class="flex items-center text-xs text-black-500 dark:text-black-400 space-x-4"
                      >
                        <span>
                          <x-myds.icon
                            name="calendar"
                            size="12"
                            class="inline mr-1"
                          />
                          {{ $loan->requested_from ? \Carbon\Carbon::parse($loan->requested_from)->format('d/m/Y') : '-' }}
                        </span>
                        <span>
                          <x-myds.icon
                            name="list"
                            size="12"
                            class="inline mr-1"
                          />
                          {{ $loan->loanItems->count() }} item(s)
                        </span>
                      </div>
                    </div>

                    <x-myds.button
                      variant="primary"
                      size="small"
                      wire:click="selectLoan({{ $loan->id }})"
                    >
                      <x-myds.icon
                        name="arrow-forward"
                        size="14"
                        class="mr-1"
                      />
                      Proses
                    </x-myds.button>
                  </div>
                </div>
              @endforeach
            </div>

            <div class="px-6 py-4 border-t border-divider">
              {{ $approvedLoans->links() }}
            </div>
          @else
            <div class="px-6 py-12 text-center">
              <x-myds.icon
                name="document"
                size="48"
                class="text-black-300 dark:text-black-600 mx-auto mb-4"
              />
              <p class="font-inter text-sm text-black-500 dark:text-black-400">
                Tiada permohonan diluluskan ditemui.
              </p>
            </div>
          @endif
        </div>
      </div>

      <!-- Issuance Form -->
      <div class="lg:col-span-1">
        @if ($selectedLoan)
          <div
            class="bg-white dark:bg-dialog rounded-lg shadow-sm border border-divider"
          >
            <div class="px-6 py-4 border-b border-divider">
              <div class="flex justify-between items-center">
                <h3
                  class="font-poppins text-lg font-medium text-black-900 dark:text-white"
                >
                  Keluarkan Peralatan
                </h3>
                <x-myds.button
                  variant="secondary"
                  size="small"
                  wire:click="cancelSelection"
                >
                  <x-myds.icon name="cross" size="14" />
                </x-myds.button>
              </div>
            </div>

            <div class="px-6 py-4 space-y-4">
              <!-- Loan Details -->
              <div class="bg-washed dark:bg-black-100 rounded-lg p-4">
                <h4
                  class="font-inter text-sm font-medium text-black-900 dark:text-white mb-2"
                >
                  Maklumat Permohonan
                </h4>
                <div class="space-y-1 text-xs">
                  <p>
                    <strong>Rujukan:</strong>
                    {{ $selectedLoan->request_number }}
                  </p>
                  <p>
                    <strong>Pemohon:</strong>
                    {{ $selectedLoan->user->name }}
                  </p>
                  <p>
                    <strong>Tujuan:</strong>
                    {{ $selectedLoan->purpose }}
                  </p>
                  <p>
                    <strong>Lokasi:</strong>
                    {{ $selectedLoan->location ?? '-' }}
                  </p>
                </div>
              </div>

              <!-- Equipment Selection -->
              <div>
                <label
                  class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
                >
                  Peralatan untuk Dikeluarkan
                </label>
                <div class="space-y-2">
                  @foreach ($selectedLoan->loanItems as $item)
                    @if ($item->equipmentItem)
                      <div class="flex items-center space-x-3">
                        <x-myds.checkbox
                          id="equipment_{{ $item->equipmentItem->id }}"
                          wire:model.live="selectedEquipment"
                          value="{{ $item->equipmentItem->id }}"
                          :disabled="$item->equipmentItem->status !== 'available'"
                        />
                        <label
                          for="equipment_{{ $item->equipmentItem->id }}"
                          class="font-inter text-xs text-black-700 dark:text-black-300 cursor-pointer"
                        >
                          {{ $item->equipmentItem->equipment->name ?? 'N/A' }}
                          <span
                            class="block text-black-500 dark:text-black-400"
                          >
                            S/N: {{ $item->equipmentItem->serial_number }}
                            @if ($item->equipmentItem->status !== 'available')
                              <span class="text-danger-600">
                                ({{ ucfirst($item->equipmentItem->status) }})
                              </span>
                            @endif
                          </span>
                        </label>
                      </div>
                    @endif
                  @endforeach
                </div>
              </div>

              <!-- Accessories Checklist -->
              <div>
                <label
                  class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
                >
                  Senarai Aksesori Disertakan
                </label>
                <div class="space-y-2">
                  @php
                    $commonAccessories = [
                      'power_adapter' => 'Penyesuai Kuasa',
                      'power_cable' => 'Kabel Kuasa',
                      'carrying_bag' => 'Beg Pembawa',
                      'mouse' => 'Tetikus',
                      'keyboard' => 'Papan Kekunci',
                      'manual' => 'Manual Pengguna',
                    ];
                  @endphp

                  @foreach ($commonAccessories as $key => $label)
                    <div class="flex items-center space-x-3">
                      <x-myds.checkbox
                        id="accessory_{{ $key }}"
                        wire:model.live="accessoriesChecklist.{{ $key }}"
                      />
                      <label
                        for="accessory_{{ $key }}"
                        class="font-inter text-xs text-black-700 dark:text-black-300 cursor-pointer"
                      >
                        {{ $label }}
                      </label>
                    </div>
                  @endforeach
                </div>
              </div>

              <!-- Issue Notes -->
              <div>
                <label
                  for="issue_notes"
                  class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2"
                >
                  Catatan Pengeluaran
                </label>
                <textarea
                  id="issue_notes"
                  wire:model.live="issueNotes"
                  rows="3"
                  placeholder="Sebarang catatan mengenai keadaan peralatan atau arahan khas..."
                  class="font-inter text-sm w-full px-3 py-2 border border-divider rounded-lg bg-white dark:bg-dialog focus:ring focus:ring-primary-300 dark:focus:ring-primary-700 focus:border-primary-600 dark:focus:border-primary-400 resize-none"
                ></textarea>
              </div>

              <!-- Submit Button -->
              <x-myds.button
                variant="primary"
                wire:click="processIssuance"
                :disabled="$processing || empty($selectedEquipment)"
                wire:loading.attr="disabled"
                class="w-full"
              >
                <x-myds.icon
                  name="arrow-outgoing"
                  size="16"
                  class="mr-2"
                  wire:loading.remove
                />
                <x-myds.icon
                  name="refresh"
                  size="16"
                  class="mr-2 animate-spin"
                  wire:loading
                />
                <span wire:loading.remove>Keluarkan Peralatan</span>
                <span wire:loading>Memproses...</span>
              </x-myds.button>
            </div>
          </div>
        @else
          <div
            class="bg-white dark:bg-dialog rounded-lg shadow-sm border border-divider"
          >
            <div class="px-6 py-12 text-center">
              <x-myds.icon
                name="cursor"
                size="48"
                class="text-black-300 dark:text-black-600 mx-auto mb-4"
              />
              <p class="font-inter text-sm text-black-500 dark:text-black-400">
                Pilih permohonan untuk mula proses pengeluaran peralatan.
              </p>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
