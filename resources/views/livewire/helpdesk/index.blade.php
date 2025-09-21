<div class="min-h-screen bg-gray-50">
  <!-- Header -->
  <div class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="py-6">
        <div class="flex it            </x-myds.button>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>between">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">
              Tiket Saya / My Tickets
            </h1>
            <p class="text-gray-600 mt-2">
              Lihat dan urusan tiket kerosakan anda / View and manage your issue
              tickets
            </p>
          </div>
          <x-myds.button
            href="{{ route('helpdesk.create') }}"
            variant="primary"
            iconLeading="plus"
          >
            Lapor Kerosakan Baharu / New Issue Report
          </x-myds.button>
        </div>
      </div>
    </div>
  </div>

  <!-- Filters -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <div class="bg-white rounded-lg shadow-sm border p-6 mb-6">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Search -->
        <div>
          <label
            for="search"
            class="block text-sm font-medium text-gray-700 mb-2"
          >
            Cari / Search
          </label>
          <input
            type="text"
            wire:model.live="search"
            id="search"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            placeholder="Nombor tiket, tajuk atau deskripsi..."
          />
        </div>

        <!-- Status Filter -->
        <div>
          <label
            for="statusFilter"
            class="block text-sm font-medium text-gray-700 mb-2"
          >
            Status
          </label>
          <select
            wire:model.live="statusFilter"
            id="statusFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
          >
            <option value="all">Semua Status / All Status</option>
            @foreach ($statuses as $status)
              <option value="{{ $status->name }}">
                {{ $status->name_my }} / {{ $status->name_en }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Category Filter -->
        <div>
          <label
            for="categoryFilter"
            class="block text-sm font-medium text-gray-700 mb-2"
          >
            Kategori / Category
          </label>
          <select
            wire:model.live="categoryFilter"
            id="categoryFilter"
            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
          >
            <option value="all">Semua Kategori / All Categories</option>
            @foreach ($categories as $category)
              <option value="{{ $category->name }}">
                {{ $category->name_my }} / {{ $category->name_en }}
              </option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    <!-- Loading State -->
    <div
      wire:loading.delay
      wire:target="search,statusFilter,categoryFilter"
      class="text-center py-4"
    >
      <div class="inline-flex items-center px-4 py-2 text-sm text-gray-600">
        <x-myds.icon name="refresh" class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-600" />
        Memuatkan... / Loading...
      </div>
    </div>

    <!-- Tickets List -->
    <div wire:loading.remove wire:target="search,statusFilter,categoryFilter">
      @if ($tickets->count() > 0)
        <div class="space-y-4">
          @foreach ($tickets as $ticket)
            <div
              class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow"
            >
              <div class="p-6">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <div class="flex items-center space-x-3">
                      <h3 class="text-lg font-medium text-gray-900">
                                              <a
                        href="{{ route('helpdesk.ticket.detail', $ticket) }}"
                        class="hover:text-primary-600"
                      >
                        {{ $ticket->title }}
                      </a>
                      </h3>
                      <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->priority === 'High' ? 'bg-red-100 text-red-800' : ($ticket->priority === 'Medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}"
                      >
                        {{ $ticket->priority }}
                      </span>
                    </div>

                    <div
                      class="mt-2 flex items-center text-sm text-gray-600 space-x-4"
                    >
                    <span class="inline-flex items-center">
                      <x-myds.icon name="tag" class="w-4 h-4 mr-1" />
                      {{ $ticket->ticket_number }}
                    </span>

                    <span class="inline-flex items-center">
                      <x-myds.icon name="folder" class="w-4 h-4 mr-1" />
                      {{ $ticket->category->name_my }}
                    </span>

                    <span class="inline-flex items-center">
                      <x-myds.icon name="clock" class="w-4 h-4 mr-1" />
                      {{ $ticket->created_at->format('d/m/Y H:i') }}
                    </span>
                    </div>

                    <p class="mt-3 text-gray-700 line-clamp-2">
                      {{ Str::limit($ticket->description, 200) }}
                    </p>
                  </div>

                  <div class="ml-6 flex-shrink-0">
                    <span
                      class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $ticket->status->name === 'Open' ? 'bg-blue-100 text-blue-800' : ($ticket->status->name === 'In Progress' ? 'bg-yellow-100 text-yellow-800' : ($ticket->status->name === 'Resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}"
                    >
                      {{ $ticket->status->name_my }}
                    </span>
                  </div>
                </div>

                @if ($ticket->equipment_item)
                  <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center text-sm text-gray-600">
                      <x-myds.icon name="desktop-computer" class="w-4 h-4 mr-2" />
                      <strong>Peralatan / Equipment:</strong>
                      <span class="ml-1">
                        {{ $ticket->equipment_item->name }}
                        ({{ $ticket->equipment_item->asset_tag }})
                      </span>
                    </div>
                  </div>
                @endif
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
          {{ $tickets->links() }}
        </div>
      @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border text-center py-12">
          <x-myds.icon name="document" class="mx-auto h-12 w-12 text-gray-400" />
          <h3 class="mt-4 text-lg font-medium text-gray-900">
            Tiada tiket dijumpai / No tickets found
          </h3>
          <p class="mt-2 text-gray-600">
            @if ($this->search || $this->statusFilter !== 'all' || $this->categoryFilter !== 'all')
              Cuba laras carian atau penapis anda / Try adjusting your search or filters
            @else
                Anda belum melaporkan sebarang isu lagi / You haven't reported
                any issues yet
            @endif
          </p>
          <div class="mt-6">
            <x-myds.button
              href="{{ route('helpdesk.create') }}"
              variant="primary"
              iconLeading="plus"
            >
              Lapor Kerosakan Baharu / New Issue Report
            </x-myds.button>
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
              Lapor Kerosakan Pertama / Report First Issue
            </a>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
