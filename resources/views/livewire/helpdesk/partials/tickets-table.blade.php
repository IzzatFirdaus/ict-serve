<!-- Tickets Table View -->
<div class="overflow-x-auto">
  <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
    <thead class="bg-gray-50 dark:bg-gray-700">
      <tr>
        <!-- Select All Checkbox -->
        <th
          class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
        >
          <input
            type="checkbox"
            wire:model.live="selectAll"
            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
          />
        </th>

        <!-- Ticket Number -->
        <th
          class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer"
          wire:click="sortBy('ticket_number')"
        >
          <div class="flex items-center space-x-1">
            <span>Nombor Tiket / Ticket Number</span>
            @if ($sortBy === 'ticket_number')
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"
                ></path>
              </svg>
            @endif
          </div>
        </th>

        <!-- Title -->
        <th
          class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer"
          wire:click="sortBy('title')"
        >
          <div class="flex items-center space-x-1">
            <span>Tajuk / Title</span>
            @if ($sortBy === 'title')
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"
                ></path>
              </svg>
            @endif
          </div>
        </th>

        <!-- Status -->
        <th
          class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
        >
          Status
        </th>

        <!-- Priority -->
        <th
          class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer"
          wire:click="sortBy('priority')"
        >
          <div class="flex items-center space-x-1">
            <span>Keutamaan / Priority</span>
            @if ($sortBy === 'priority')
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"
                ></path>
              </svg>
            @endif
          </div>
        </th>

        <!-- Assigned To -->
        <th
          class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
        >
          Ditugaskan / Assigned To
        </th>

        <!-- Created Date -->
        <th
          class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider cursor-pointer"
          wire:click="sortBy('created_at')"
        >
          <div class="flex items-center space-x-1">
            <span>Dicipta / Created</span>
            @if ($sortBy === 'created_at')
              <svg
                class="w-4 h-4"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="{{ $sortDirection === 'asc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}"
                ></path>
              </svg>
            @endif
          </div>
        </th>

        <!-- Actions -->
        <th
          class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"
        >
          Tindakan / Actions
        </th>
      </tr>
    </thead>
    <tbody
      class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
    >
      @forelse ($tickets as $ticket)
        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
          <!-- Checkbox -->
          <td class="px-6 py-4 whitespace-nowrap">
            <input
              type="checkbox"
              wire:model.live="selectedTickets"
              value="{{ $ticket->id }}"
              class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700"
            />
          </td>

          <!-- Ticket Number -->
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                @if ($ticket->isOverdue())
                  <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                @elseif ($ticket->isNew())
                  <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                @else
                  <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                @endif
              </div>
              <div class="ml-3">
                <div class="text-sm font-medium text-gray-900 dark:text-white">
                  {{ $ticket->ticket_number }}
                </div>
              </div>
            </div>
          </td>

          <!-- Title -->
          <td class="px-6 py-4">
            <div class="max-w-xs">
              <div
                class="text-sm font-medium text-gray-900 dark:text-white truncate"
              >
                {{ $ticket->title }}
              </div>
              <div class="text-sm text-gray-500 dark:text-gray-400 truncate">
                {{ Str::limit($ticket->description, 60) }}
              </div>
            </div>
          </td>

          <!-- Status -->
          <td class="px-6 py-4 whitespace-nowrap">
            <span
              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{
                $ticket->status->code === 'new'
                  ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'
                  : ($ticket->status->code === 'in_progress'
                    ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300'
                    : ($ticket->status->code === 'resolved'
                      ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'
                      : 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300'))
              }}"
            >
              {{ $ticket->status->name }}
            </span>
          </td>

          <!-- Priority -->
          <td class="px-6 py-4 whitespace-nowrap">
            <span
              class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{
                $ticket->priority === 'critical'
                  ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                  : ($ticket->priority === 'high'
                    ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300'
                    : ($ticket->priority === 'medium'
                      ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300'
                      : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300'))
              }}"
            >
              {{ ucfirst($ticket->priority) }}
            </span>
          </td>

          <!-- Assigned To -->
          <td class="px-6 py-4 whitespace-nowrap">
            @if ($ticket->assignedToUser)
              <div class="flex items-center">
                <div class="flex-shrink-0 h-8 w-8">
                  <div
                    class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center"
                  >
                    <span class="text-sm font-medium text-white">
                      {{ substr($ticket->assignedToUser->name, 0, 1) }}
                    </span>
                  </div>
                </div>
                <div class="ml-3">
                  <div
                    class="text-sm font-medium text-gray-900 dark:text-white"
                  >
                    {{ $ticket->assignedToUser->name }}
                  </div>
                </div>
              </div>
            @else
              <span class="text-sm text-gray-500 dark:text-gray-400 italic">
                Belum ditugaskan / Unassigned
              </span>
            @endif
          </td>

          <!-- Created Date -->
          <td class="px-6 py-4 whitespace-nowrap">
            <div class="text-sm text-gray-900 dark:text-white">
              {{ $ticket->created_at->format('d/m/Y') }}
            </div>
            <div class="text-sm text-gray-500 dark:text-gray-400">
              {{ $ticket->created_at->format('H:i') }}
            </div>
          </td>

          <!-- Actions -->
          <td
            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
          >
            <div class="flex items-center justify-end space-x-2">
              <!-- View Details -->
              <button
                class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 transition-colors"
              >
                <svg
                  class="w-4 h-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                  ></path>
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                  ></path>
                </svg>
              </button>

              <!-- Attachments -->
              <a
                href="{{ route('helpdesk.attachments', $ticket->id) }}"
                class="text-purple-600 dark:text-purple-400 hover:text-purple-900 dark:hover:text-purple-300 transition-colors relative"
              >
                <svg
                  class="w-4 h-4"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.586-6.586a4 4 0 00-5.656-5.656l-6.586 6.586a6 6 0 108.486 8.486L20.5 13"
                  ></path>
                </svg>
                @if (! empty($ticket->file_attachments))
                  <span
                    class="absolute -top-2 -right-2 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full"
                  >
                    {{ count($ticket->file_attachments) }}
                  </span>
                @endif
              </a>

              <!-- Assignment -->
              @if (in_array(Auth::user()->role, ['ict_admin', 'supervisor']))
                <a
                  href="{{ route('helpdesk.assign', $ticket->id) }}"
                  class="text-orange-600 dark:text-orange-400 hover:text-orange-900 dark:hover:text-orange-300 transition-colors"
                >
                  <svg
                    class="w-4 h-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    ></path>
                  </svg>
                </a>
              @endif

              <!-- Quick Status Change -->
              @if (! $ticket->isClosed())
                <div class="relative" x-data="{ open: false }">
                  <button
                    @click="open = !open"
                    class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 transition-colors"
                  >
                    <svg
                      class="w-4 h-4"
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
                  </button>

                  <div
                    x-show="open"
                    x-transition
                    @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-20 border border-gray-200 dark:border-gray-700"
                  >
                    @foreach ($statuses as $status)
                      <button
                        wire:click="updateTicketStatus({{ $ticket->id }}, '{{ $status->code }}')"
                        @click="open = false"
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                      >
                        {{ $status->name }}
                      </button>
                    @endforeach
                  </div>
                </div>
              @endif

              <!-- Assign Technician -->
              @if (auth()->user()->role === 'ict_admin' || auth()->user()->role === 'supervisor')
                <div class="relative" x-data="{ open: false }">
                  <button
                    @click="open = !open"
                    class="text-green-600 dark:text-green-400 hover:text-green-900 dark:hover:text-green-300 transition-colors"
                  >
                    <svg
                      class="w-4 h-4"
                      fill="none"
                      stroke="currentColor"
                      viewBox="0 0 24 24"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                      ></path>
                    </svg>
                  </button>

                  <div
                    x-show="open"
                    x-transition
                    @click.away="open = false"
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg z-20 border border-gray-200 dark:border-gray-700"
                  >
                    @foreach ($technicians as $tech)
                      <button
                        wire:click="assignTicket({{ $ticket->id }}, {{ $tech->id }})"
                        @click="open = false"
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"
                      >
                        {{ $tech->name }}
                      </button>
                    @endforeach
                  </div>
                </div>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="8" class="px-6 py-12 text-center">
            <div class="flex flex-col items-center">
              <svg
                class="w-12 h-12 text-gray-400 mb-4"
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
              <h3
                class="text-sm font-medium text-gray-900 dark:text-white mb-2"
              >
                Tiada tiket ditemui / No tickets found
              </h3>
              <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
                Cuba ubah penapis atau cipta tiket baharu / Try changing filters
                or create a new ticket
              </p>
              <a
                href="{{ route('helpdesk.create-enhanced') }}"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
              >
                Cipta Tiket / Create Ticket
              </a>
            </div>
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>
