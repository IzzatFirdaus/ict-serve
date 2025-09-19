<div class="container mx-auto px-4 py-6">
  {{-- Header --}}
  <div class="mb-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-semibold font-poppins text-black-900">
          Pengurusan Tiket Helpdesk
        </h1>
        <p class="text-sm text-black-500 font-inter mt-1">
          Urus dan pantau semua tiket sokongan ICT
        </p>
      </div>
      <div class="flex items-center space-x-3">
        <x-myds.button
          wire:click="clearFilters"
          variant="secondary"
          size="medium"
        >
          <x-myds.icon name="refresh" size="16" class="mr-2" />
          Muat Semula
        </x-myds.button>
      </div>
    </div>
  </div>

  {{-- Statistics Cards --}}
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white border border-divider rounded-lg p-4">
      <div class="flex items-center">
        <div class="p-2 bg-primary-100 rounded-lg">
          <x-myds.icon name="document" size="20" class="text-primary-600" />
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-black-500">Jumlah Tiket</p>
          <p class="text-2xl font-semibold text-black-900">
            {{ number_format($counts['total']) }}
          </p>
        </div>
      </div>
    </div>

    <div class="bg-white border border-divider rounded-lg p-4">
      <div class="flex items-center">
        <div class="p-2 bg-success-100 rounded-lg">
          <x-myds.icon name="clock" size="20" class="text-success-600" />
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-black-500">Tiket Terbuka</p>
          <p class="text-2xl font-semibold text-black-900">
            {{ number_format($counts['open']) }}
          </p>
        </div>
      </div>
    </div>

    <div class="bg-white border border-divider rounded-lg p-4">
      <div class="flex items-center">
        <div class="p-2 bg-warning-100 rounded-lg">
          <x-myds.icon name="user" size="20" class="text-warning-600" />
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-black-500">Telah Diberikan</p>
          <p class="text-2xl font-semibold text-black-900">
            {{ number_format($counts['assigned']) }}
          </p>
        </div>
      </div>
    </div>

    <div class="bg-white border border-divider rounded-lg p-4">
      <div class="flex items-center">
        <div class="p-2 bg-danger-100 rounded-lg">
          <x-myds.icon name="warning" size="20" class="text-danger-600" />
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-black-500">Tertunggak</p>
          <p class="text-2xl font-semibold text-black-900">
            {{ number_format($counts['overdue']) }}
          </p>
        </div>
      </div>
    </div>
  </div>

  {{-- Search and Filters --}}
  <div class="bg-white border border-divider rounded-lg p-4 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
      {{-- Search Input --}}
      <div class="lg:col-span-2">
        <x-myds.input
          type="text"
          wire:model.live.debounce.300ms="search"
          placeholder="Cari tiket, nombor tiket, tajuk..."
          class="w-full"
        />
      </div>

      {{-- Status Filter --}}
      <div>
        <x-myds.select wire:model.live="filterStatus" class="w-full">
          <option value="">Semua Status</option>
          @foreach ($statuses as $status)
            <option value="{{ $status->id }}">{{ $status->name }}</option>
          @endforeach
        </x-myds.select>
      </div>

      {{-- Category Filter --}}
      <div>
        <x-myds.select wire:model.live="filterCategory" class="w-full">
          <option value="">Semua Kategori</option>
          @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </x-myds.select>
      </div>

      {{-- Priority Filter --}}
      <div>
        <x-myds.select wire:model.live="filterPriority" class="w-full">
          <option value="">Semua Keutamaan</option>
          @foreach ($priorities as $priority)
            <option value="{{ $priority->value }}">
              {{ $priority->label() }}
            </option>
          @endforeach
        </x-myds.select>
      </div>

      {{-- Assignee Filter --}}
      <div>
        <x-myds.select wire:model.live="filterAssignee" class="w-full">
          <option value="">Semua Petugas</option>
          <option value="unassigned">Belum Diberikan</option>
          @foreach ($agents as $agent)
            <option value="{{ $agent->id }}">{{ $agent->name }}</option>
          @endforeach
        </x-myds.select>
      </div>
    </div>
  </div>

  {{-- Tickets Table --}}
  <div class="bg-white border border-divider rounded-lg overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-divider">
        <thead class="bg-washed">
          <tr>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider cursor-pointer"
              wire:click="sortBy('ticket_number')"
            >
              No. Tiket
              @if ($sortField === 'ticket_number')
                <x-myds.icon
                  name="chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"
                  size="12"
                  class="inline ml-1"
                />
              @endif
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider cursor-pointer"
              wire:click="sortBy('title')"
            >
              Tajuk
              @if ($sortField === 'title')
                <x-myds.icon
                  name="chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"
                  size="12"
                  class="inline ml-1"
                />
              @endif
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider"
            >
              Pemohon
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider"
            >
              Status
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider cursor-pointer"
              wire:click="sortBy('priority')"
            >
              Keutamaan
              @if ($sortField === 'priority')
                <x-myds.icon
                  name="chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"
                  size="12"
                  class="inline ml-1"
                />
              @endif
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider"
            >
              Petugas
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-left text-xs font-medium text-black-500 uppercase tracking-wider cursor-pointer"
              wire:click="sortBy('created_at')"
            >
              Tarikh Dicipta
              @if ($sortField === 'created_at')
                <x-myds.icon
                  name="chevron-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"
                  size="12"
                  class="inline ml-1"
                />
              @endif
            </th>
            <th
              scope="col"
              class="px-6 py-3 text-center text-xs font-medium text-black-500 uppercase tracking-wider"
            >
              Tindakan
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-divider">
          @forelse ($tickets as $ticket)
            <tr class="hover:bg-washed transition-colors duration-200">
              <td
                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-primary-600"
              >
                <a
                  href="{{ route('helpdesk.tickets.show', $ticket) }}"
                  class="hover:underline"
                >
                  {{ $ticket->ticket_number }}
                </a>
              </td>
              <td class="px-6 py-4 text-sm text-black-900">
                <div class="max-w-xs truncate">{{ $ticket->title }}</div>
                <div class="text-xs text-black-500">
                  {{ $ticket->category->name ?? 'Tiada Kategori' }}
                </div>
              </td>
              <td class="px-6 py-4 text-sm text-black-900">
                <div>{{ $ticket->user->name }}</div>
                <div class="text-xs text-black-500">
                  {{ $ticket->user->email }}
                </div>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                @php
                  $statusColors = [
                    'open' => 'bg-warning-100 text-warning-700',
                    'in_progress' => 'bg-primary-100 text-primary-700',
                    'pending' => 'bg-warning-100 text-warning-700',
                    'resolved' => 'bg-success-100 text-success-700',
                    'closed' => 'bg-black-100 text-black-700',
                  ];
                  $statusColor = $statusColors[$ticket->ticketStatus->code ?? 'open'] ?? 'bg-black-100 text-black-700';
                @endphp

                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}"
                >
                  {{ $ticket->ticketStatus->name ?? 'Terbuka' }}
                </span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                @php
                  $priorityColors = [
                    'low' => 'bg-success-100 text-success-700',
                    'medium' => 'bg-warning-100 text-warning-700',
                    'high' => 'bg-danger-100 text-danger-700',
                    'urgent' => 'bg-danger-100 text-danger-700',
                  ];
                  $priorityColor = $priorityColors[$ticket->priority] ?? 'bg-black-100 text-black-700';
                @endphp

                <span
                  class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityColor }}"
                >
                  {{ ucfirst($ticket->priority) }}
                </span>
              </td>
              <td class="px-6 py-4 text-sm text-black-900">
                @if ($ticket->assignedTo)
                  <div>{{ $ticket->assignedTo->name }}</div>
                  <div class="text-xs text-black-500">
                    {{ $ticket->assigned_at?->format('d/m/Y H:i') }}
                  </div>
                @else
                  <span class="text-black-400">Belum Diberikan</span>
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-black-900">
                {{ $ticket->created_at->format('d/m/Y H:i') }}
              </td>
              <td
                class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium"
              >
                <div class="flex items-center justify-center space-x-2">
                  {{-- View Button --}}
                  <x-myds.button
                    variant="secondary"
                    size="small"
                    onclick="window.location.href='{{ route('helpdesk.tickets.show', $ticket) }}'"
                  >
                    <x-myds.icon name="eye" size="12" />
                  </x-myds.button>

                  {{-- Assign Button --}}
                  @if (! $ticket->assignedTo)
                    <x-myds.button
                      variant="primary"
                      size="small"
                      wire:click="openAssignmentModal({{ $ticket->id }})"
                    >
                      <x-myds.icon name="user-plus" size="12" />
                    </x-myds.button>
                  @endif

                  {{-- Status Update Button --}}
                  <x-myds.button
                    variant="warning"
                    size="small"
                    wire:click="openStatusModal({{ $ticket->id }})"
                  >
                    <x-myds.icon name="edit" size="12" />
                  </x-myds.button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="px-6 py-12 text-center">
                <x-myds.icon
                  name="document"
                  size="48"
                  class="mx-auto text-black-300 mb-4"
                />
                <h3 class="text-lg font-medium text-black-900 mb-2">
                  Tiada tiket ditemui
                </h3>
                <p class="text-black-500">
                  Cuba ubah kriteria carian atau penapis anda.
                </p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if ($tickets->hasPages())
      <div class="px-6 py-3 border-t border-divider">
        {{ $tickets->links() }}
      </div>
    @endif
  </div>

  {{-- Assignment Modal --}}
  @if ($showAssignmentModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
      <div
        class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
      >
        <div
          class="fixed inset-0 transition-opacity bg-black-500 bg-opacity-75"
          wire:click="closeAssignmentModal"
        ></div>

        <div
          class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
        >
          <div>
            <div
              class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-primary-100"
            >
              <x-myds.icon
                name="user-plus"
                size="24"
                class="text-primary-600"
              />
            </div>
            <div class="mt-3 text-center sm:mt-5">
              <h3 class="text-lg leading-6 font-medium text-black-900">
                Berikan Tiket kepada Petugas
              </h3>
              <div class="mt-2">
                <p class="text-sm text-black-500">
                  Pilih petugas untuk mengendalikan tiket ini.
                </p>
              </div>
            </div>
          </div>

          <div class="mt-6">
            <x-myds.select wire:model="assignedUserId" class="w-full">
              <option value="">Pilih Petugas</option>
              @foreach ($agents as $agent)
                <option value="{{ $agent->id }}">
                  {{ $agent->name }} ({{ $agent->email }})
                </option>
              @endforeach
            </x-myds.select>
          </div>

          <div
            class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense"
          >
            <x-myds.button
              type="button"
              variant="primary"
              class="w-full sm:col-start-2"
              wire:click="assignTicket"
              :disabled="!$assignedUserId"
            >
              Berikan Tiket
            </x-myds.button>
            <x-myds.button
              type="button"
              variant="secondary"
              class="mt-3 w-full sm:mt-0 sm:col-start-1"
              wire:click="closeAssignmentModal"
            >
              Batal
            </x-myds.button>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Status Update Modal --}}
  @if ($showStatusModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
      <div
        class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
      >
        <div
          class="fixed inset-0 transition-opacity bg-black-500 bg-opacity-75"
          wire:click="closeStatusModal"
        ></div>

        <div
          class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6"
        >
          <div>
            <div
              class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-warning-100"
            >
              <x-myds.icon name="edit" size="24" class="text-warning-600" />
            </div>
            <div class="mt-3 text-center sm:mt-5">
              <h3 class="text-lg leading-6 font-medium text-black-900">
                Kemaskini Status Tiket
              </h3>
              <div class="mt-2">
                <p class="text-sm text-black-500">
                  Pilih status baharu untuk tiket ini.
                </p>
              </div>
            </div>
          </div>

          <div class="mt-6 space-y-4">
            <div>
              <label class="block text-sm font-medium text-black-700 mb-2">
                Status Baharu
                <span class="text-danger-600">*</span>
              </label>
              <x-myds.select wire:model="newStatusId" class="w-full">
                <option value="">Pilih Status</option>
                @foreach ($statuses as $status)
                  <option value="{{ $status->id }}">
                    {{ $status->name }}
                  </option>
                @endforeach
              </x-myds.select>
            </div>

            <div>
              <label class="block text-sm font-medium text-black-700 mb-2">
                Nota Penyelesaian
              </label>
              <textarea
                wire:model="resolutionNotes"
                rows="3"
                class="w-full border border-divider rounded-md px-3 py-2 text-sm focus:ring focus:ring-primary-300 focus:border-primary-600"
                placeholder="Catatan penyelesaian atau tindakan yang diambil..."
              ></textarea>
            </div>
          </div>

          <div
            class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense"
          >
            <x-myds.button
              type="button"
              variant="primary"
              class="w-full sm:col-start-2"
              wire:click="updateTicketStatus"
              :disabled="!$newStatusId"
            >
              Kemaskini Status
            </x-myds.button>
            <x-myds.button
              type="button"
              variant="secondary"
              class="mt-3 w-full sm:mt-0 sm:col-start-1"
              wire:click="closeStatusModal"
            >
              Batal
            </x-myds.button>
          </div>
        </div>
      </div>
    </div>
  @endif

  {{-- Flash Messages --}}
  @if (session()->has('success'))
    <x-myds.callout variant="success" class="fixed top-4 right-4 z-50 max-w-md">
      {{ session('success') }}
    </x-myds.callout>
  @endif

  @if (session()->has('error'))
    <x-myds.callout variant="danger" class="fixed top-4 right-4 z-50 max-w-md">
      {{ session('error') }}
    </x-myds.callout>
  @endif
</div>
