<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Tiket Saya / My Tickets</h1>
                        <p class="text-gray-600 mt-2">Lihat dan urusan tiket kerosakan anda / View and manage your issue tickets</p>
                    </div>
                    <a href="{{ route('helpdesk.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Lapor Kerosakan Baharu / New Issue Report
                    </a>
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
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari / Search</label>
                    <input type="text"
                           wire:model.live="search"
                           id="search"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                           placeholder="Nombor tiket, tajuk atau deskripsi...">
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select wire:model.live="statusFilter"
                            id="statusFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="all">Semua Status / All Status</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status->name }}">{{ $status->name_my }} / {{ $status->name_en }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="categoryFilter" class="block text-sm font-medium text-gray-700 mb-2">Kategori / Category</label>
                    <select wire:model.live="categoryFilter"
                            id="categoryFilter"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        <option value="all">Semua Kategori / All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}">{{ $category->name_my }} / {{ $category->name_en }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div wire:loading.delay wire:target="search,statusFilter,categoryFilter"
             class="text-center py-4">
            <div class="inline-flex items-center px-4 py-2 text-sm text-gray-600">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memuatkan... / Loading...
            </div>
        </div>

        <!-- Tickets List -->
        <div wire:loading.remove wire:target="search,statusFilter,categoryFilter">
            @if($tickets->count() > 0)
                <div class="space-y-4">
                    @foreach($tickets as $ticket)
                        <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow">
                            <div class="p-6">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <h3 class="text-lg font-medium text-gray-900">
                                                <a href="{{ route('helpdesk.show', $ticket) }}" class="hover:text-red-600">
                                                    {{ $ticket->title }}
                                                </a>
                                            </h3>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticket->priority === 'High' ? 'bg-red-100 text-red-800' : ($ticket->priority === 'Medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                {{ $ticket->priority }}
                                            </span>
                                        </div>

                                        <div class="mt-2 flex items-center text-sm text-gray-600 space-x-4">
                                            <span class="inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                                {{ $ticket->ticket_number }}
                                            </span>

                                            <span class="inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                                {{ $ticket->category->name_my }}
                                            </span>

                                            <span class="inline-flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $ticket->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        </div>

                                        <p class="mt-3 text-gray-700 line-clamp-2">
                                            {{ Str::limit($ticket->description, 200) }}
                                        </p>
                                    </div>

                                    <div class="ml-6 flex-shrink-0">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $ticket->status->name === 'Open' ? 'bg-blue-100 text-blue-800' : ($ticket->status->name === 'In Progress' ? 'bg-yellow-100 text-yellow-800' : ($ticket->status->name === 'Resolved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                            {{ $ticket->status->name_my }}
                                        </span>
                                    </div>
                                </div>

                                @if($ticket->equipment_item)
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                        </svg>
                                        <strong>Peralatan / Equipment:</strong>
                                        <span class="ml-1">{{ $ticket->equipment_item->name }} ({{ $ticket->equipment_item->asset_tag }})</span>
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
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Tiada tiket dijumpai / No tickets found</h3>
                    <p class="mt-2 text-gray-600">
                        @if($this->search || $this->statusFilter !== 'all' || $this->categoryFilter !== 'all')
                            Cuba laras carian atau penapis anda / Try adjusting your search or filters
                        @else
                            Anda belum melaporkan sebarang isu lagi / You haven't reported any issues yet
                        @endif
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('helpdesk.create') }}"
                           class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Lapor Kerosakan Pertama / Report First Issue
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
