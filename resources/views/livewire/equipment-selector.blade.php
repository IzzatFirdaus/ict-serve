<div>
    <!-- Equipment Selector Component -->
    <div class="bg-white rounded-[var(--radius-xl)] border border-otl-gray-200 shadow-md p-6">
        
        <!-- Header with Search and View Controls -->
        <div class="mb-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-4">
                <div class="flex-1">
                    <h3 class="myds-heading-2xs text-txt-black-900 mb-2">Pilih Peralatan ICT</h3>
                    <p class="text-sm text-txt-black-600">
                        Pilih peralatan yang diperlukan untuk permohonan anda. Anda boleh memilih lebih dari satu item.
                    </p>
                </div>
                
                <!-- View Mode Toggle -->
                <div class="flex items-center gap-2">
                    <x-myds.button
                        type="button"
                        variant="{{ $viewMode === 'grid' ? 'primary' : 'outline' }}"
                        size="sm"
                        wire:click="$set('viewMode', 'grid')"
                    >
                        <x-icon name="view-grid" class="w-4 h-4" />
                    </x-myds.button>
                    <x-myds.button
                        type="button"
                        variant="{{ $viewMode === 'list' ? 'primary' : 'outline' }}"
                        size="sm"
                        wire:click="$set('viewMode', 'list')"
                    >
                        <x-icon name="view-list" class="w-4 h-4" />
                    </x-myds.button>
                </div>
            </div>
            
            <!-- Search and Filters -->
            <div class="flex flex-col lg:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <x-myds.form.input
                        name="search"
                        wire:model.live.debounce.300ms="search"
                        placeholder="Cari peralatan (nama, tag, jenama, model)..."
                        class="w-full"
                    />
                </div>
                
                <!-- Filter Toggle -->
                <x-myds.button
                    type="button"
                    variant="outline"
                    wire:click="$toggle('showFilters')"
                >
                    <x-icon name="filter" class="w-4 h-4 mr-2" />
                    Filter
                    @if($selectedCategory || $availabilityFilter !== 'available')
                        <span class="ml-2 px-2 py-1 bg-primary-100 text-primary-700 rounded-full text-xs">
                            Aktif
                        </span>
                    @endif
                </x-myds.button>
            </div>
            
            <!-- Advanced Filters -->
            @if($showFilters)
                <div class="mt-4 p-4 bg-gray-50 rounded-[var(--radius-m)] border border-otl-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Category Filter -->
                        <x-myds.form.select
                            label="Kategori"
                            name="selectedCategory"
                            wire:model.live="selectedCategory"
                            placeholder="Semua Kategori"
                        >
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }} ({{ $category->equipment_items_count }})
                                </option>
                            @endforeach
                        </x-myds.form.select>
                        
                        <!-- Availability Filter -->
                        <x-myds.form.select
                            label="Ketersediaan"
                            name="availabilityFilter"
                            wire:model.live="availabilityFilter"
                        >
                            @foreach($availabilityOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-myds.form.select>
                        
                        <!-- Sort Options -->
                        <x-myds.form.select
                            label="Susun mengikut"
                            name="sortBy"
                            wire:model.live="sortBy"
                        >
                            @foreach($sortOptions as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </x-myds.form.select>
                    </div>
                    
                    <!-- Filter Actions -->
                    <div class="flex justify-end gap-2 mt-4">
                        <x-myds.button
                            type="button"
                            variant="outline"
                            size="sm"
                            wire:click="resetFilters"
                        >
                            Reset Filter
                        </x-myds.button>
                    </div>
                </div>
            @endif
        </div>
        
        <!-- Selected Items Summary -->
        @if(count($selectedItems) > 0)
            <div class="mb-6 p-4 bg-primary-50 border border-otl-primary-200 rounded-[var(--radius-m)]">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-txt-primary mb-1">
                            {{ $totalSelected }} item dipilih
                        </h4>
                        <p class="text-xs text-txt-primary">
                            Jumlah kuantiti: {{ array_sum($quantities) }}
                        </p>
                    </div>
                    <x-myds.button
                        type="button"
                        variant="outline"
                        size="sm"
                        wire:click="clearSelection"
                        wire:confirm="Adakah anda pasti untuk mengosongkan semua pilihan?"
                    >
                        Kosongkan Semua
                    </x-myds.button>
                </div>
            </div>
        @endif
        
        <!-- Equipment Grid/List -->
        <div class="mb-6">
            @if($equipment->count() > 0)
                @if($viewMode === 'grid')
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($equipment as $item)
                            <div class="border border-otl-gray-200 rounded-[var(--radius-m)] p-4 hover:shadow-md transition-shadow
                                        {{ in_array($item->id, $selectedItems) ? 'ring-2 ring-primary-500 bg-primary-50' : '' }}">
                                
                                <!-- Equipment Card Header -->
                                <div class="flex items-start justify-between mb-3">
                                    <div class="flex-1">
                                        <h5 class="font-semibold text-txt-black-900 text-sm mb-1">
                                            {{ $item->name }}
                                        </h5>
                                        <p class="text-xs text-txt-black-500">
                                            {{ $item->brand }} {{ $item->model }}
                                        </p>
                                        <p class="text-xs text-txt-black-500">
                                            Tag: {{ $item->asset_tag }}
                                        </p>
                                    </div>
                                    
                                    <!-- Selection Checkbox -->
                                    <x-myds.form.checkbox
                                        name="selected_{{ $item->id }}"
                                        wire:click="toggleItem({{ $item->id }})"
                                        :checked="in_array($item->id, $selectedItems)"
                                        class="ml-2"
                                    />
                                </div>
                                
                                <!-- Equipment Details -->
                                <div class="space-y-2">
                                    <!-- Category -->
                                    <div class="flex items-center text-xs">
                                        <span class="text-txt-black-500">Kategori:</span>
                                        <span class="ml-1 text-txt-black-700">{{ $item->category->name ?? 'N/A' }}</span>
                                    </div>
                                    
                                    <!-- Status -->
                                    <div class="flex items-center">
                                        <span class="text-xs text-txt-black-500 mr-2">Status:</span>
                                        <span class="text-xs px-2 py-1 rounded-full 
                                                   {{ $item->status === 'available' ? 'bg-success-100 text-success-700' : 
                                                      ($item->status === 'on_loan' ? 'bg-warning-100 text-warning-700' : 
                                                       'bg-gray-100 text-gray-700') }}">
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                    </div>
                                    
                                    @if($item->description)
                                        <p class="text-xs text-txt-black-600 mt-2">
                                            {{ Str::limit($item->description, 80) }}
                                        </p>
                                    @endif
                                </div>
                                
                                <!-- Selection Controls -->
                                @if(in_array($item->id, $selectedItems))
                                    <div class="mt-4 pt-3 border-t border-otl-gray-200 space-y-3">
                                        <!-- Quantity -->
                                        <div>
                                            <label class="block text-xs font-medium text-txt-black-700 mb-1">
                                                Kuantiti
                                            </label>
                                            <x-myds.form.input
                                                type="number"
                                                name="quantity_{{ $item->id }}"
                                                wire:model.blur="quantities.{{ $item->id }}"
                                                wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                                                min="1"
                                                max="10"
                                                class="w-full text-xs"
                                            />
                                        </div>
                                        
                                        <!-- Notes -->
                                        <div>
                                            <label class="block text-xs font-medium text-txt-black-700 mb-1">
                                                Catatan (opsional)
                                            </label>
                                            <x-myds.form.input
                                                name="notes_{{ $item->id }}"
                                                wire:model.blur="notes.{{ $item->id }}"
                                                wire:change="updateNotes({{ $item->id }}, $event.target.value)"
                                                placeholder="Spesifikasi khusus..."
                                                class="w-full text-xs"
                                            />
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- List View -->
                    <div class="space-y-2">
                        @foreach($equipment as $item)
                            <div class="border border-otl-gray-200 rounded-[var(--radius-s)] p-4 
                                        {{ in_array($item->id, $selectedItems) ? 'ring-2 ring-primary-500 bg-primary-50' : '' }}">
                                <div class="flex items-center gap-4">
                                    <!-- Selection Checkbox -->
                                    <x-myds.form.checkbox
                                        name="selected_{{ $item->id }}"
                                        wire:click="toggleItem({{ $item->id }})"
                                        :checked="in_array($item->id, $selectedItems)"
                                    />
                                    
                                    <!-- Equipment Info -->
                                    <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-4">
                                        <div>
                                            <h5 class="font-semibold text-txt-black-900 text-sm">
                                                {{ $item->name }}
                                            </h5>
                                            <p class="text-xs text-txt-black-500">
                                                {{ $item->asset_tag }}
                                            </p>
                                        </div>
                                        
                                        <div>
                                            <p class="text-sm text-txt-black-700">
                                                {{ $item->brand }} {{ $item->model }}
                                            </p>
                                            <p class="text-xs text-txt-black-500">
                                                {{ $item->category->name ?? 'N/A' }}
                                            </p>
                                        </div>
                                        
                                        <div>
                                            <span class="text-xs px-2 py-1 rounded-full 
                                                       {{ $item->status === 'available' ? 'bg-success-100 text-success-700' : 
                                                          ($item->status === 'on_loan' ? 'bg-warning-100 text-warning-700' : 
                                                           'bg-gray-100 text-gray-700') }}">
                                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                            </span>
                                        </div>
                                        
                                        @if(in_array($item->id, $selectedItems))
                                            <div class="flex gap-2">
                                                <x-myds.form.input
                                                    type="number"
                                                    name="quantity_{{ $item->id }}"
                                                    wire:model.blur="quantities.{{ $item->id }}"
                                                    wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                                                    min="1"
                                                    max="10"
                                                    placeholder="Qty"
                                                    class="w-16 text-xs"
                                                />
                                                <x-myds.form.input
                                                    name="notes_{{ $item->id }}"
                                                    wire:model.blur="notes.{{ $item->id }}"
                                                    wire:change="updateNotes({{ $item->id }}, $event.target.value)"
                                                    placeholder="Catatan..."
                                                    class="flex-1 text-xs"
                                                />
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <!-- No Equipment Found -->
                <div class="text-center py-12">
                    <x-icon name="desktop-computer" class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                    <h3 class="text-lg font-medium text-txt-black-900 mb-2">Tiada peralatan dijumpai</h3>
                    <p class="text-txt-black-600 mb-4">
                        @if($search)
                            Tiada peralatan yang sepadan dengan carian "{{ $search }}".
                        @else
                            Tiada peralatan tersedia pada masa ini.
                        @endif
                    </p>
                    @if($search || $selectedCategory || $availabilityFilter !== 'available')
                        <x-myds.button
                            type="button"
                            variant="outline"
                            wire:click="resetFilters"
                        >
                            Reset Filter
                        </x-myds.button>
                    @endif
                </div>
            @endif
        </div>
        
        <!-- Pagination -->
        @if($equipment->hasPages())
            <div class="border-t border-otl-gray-200 pt-4">
                {{ $equipment->links() }}
            </div>
        @endif
    </div>
    
    <!-- Selected Equipment Summary (if any selected) -->
    @if(count($selectedEquipmentDetails) > 0)
        <div class="mt-6 bg-white rounded-[var(--radius-xl)] border border-otl-gray-200 shadow-md p-6">
            <h4 class="myds-heading-2xs text-txt-black-900 mb-4">Ringkasan Pilihan</h4>
            
            <div class="space-y-3">
                @foreach($selectedEquipmentDetails as $detail)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-[var(--radius-s)]">
                        <div class="flex-1">
                            <h5 class="font-medium text-txt-black-900 text-sm">
                                {{ $detail['equipment']->name }}
                            </h5>
                            <p class="text-xs text-txt-black-500">
                                {{ $detail['equipment']->brand }} {{ $detail['equipment']->model }} 
                                • {{ $detail['equipment']->asset_tag }}
                            </p>
                            @if($detail['notes'])
                                <p class="text-xs text-txt-black-600 mt-1">
                                    <strong>Catatan:</strong> {{ $detail['notes'] }}
                                </p>
                            @endif
                        </div>
                        
                        <div class="text-right ml-4">
                            <span class="text-sm font-semibold text-txt-black-900">
                                Qty: {{ $detail['quantity'] }}
                            </span>
                            <br>
                            <x-myds.button
                                type="button"
                                variant="danger"
                                size="sm"
                                wire:click="removeItem({{ $detail['equipment']->id }})"
                                class="mt-1"
                            >
                                Buang
                            </x-myds.button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
