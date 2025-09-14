<div class="bg-white border border-divider rounded-lg">
    {{-- Header --}}
    <div class="px-4 py-3 border-b border-divider">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-medium text-black-900 font-poppins">Log Aktiviti</h3>
            <div class="flex items-center space-x-2">
                <x-myds.button wire:click="toggleFilters" variant="secondary" size="small">
                    <x-myds.icon name="filter" size="16" class="mr-1" />
                    Tapis
                </x-myds.button>
                <x-myds.button wire:click="resetFilters" variant="secondary" size="small">
                    <x-myds.icon name="refresh" size="16" class="mr-1" />
                    Set Semula
                </x-myds.button>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    @if($showFilters)
        <div class="px-4 py-3 bg-washed border-b border-divider">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Activity Types --}}
                <div>
                    <label class="block text-xs font-medium text-black-700 mb-2 font-inter">
                        Jenis Aktiviti <span class="text-danger-600">*</span>
                    </label>
                    <div class="space-y-2 max-h-32 overflow-y-auto">
                        @foreach($activityTypes as $type)
                            <label class="flex items-center">
                                <input
                                    type="checkbox"
                                    wire:model.live="selectedTypes"
                                    value="{{ $type }}"
                                    class="rounded border-divider text-primary-600 focus:ring-primary-500"
                                >
                                <span class="ml-2 text-sm text-black-700 font-inter">
                                    {{ $this->getActivityTypeLabel($type) }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Date From --}}
                <div>
                    <label class="block text-xs font-medium text-black-700 mb-2 font-inter">
                        Dari Tarikh
                    </label>
                    <x-myds.input
                        type="date"
                        wire:model.live="dateFrom"
                        class="w-full"
                    />
                </div>

                {{-- Date To --}}
                <div>
                    <label class="block text-xs font-medium text-black-700 mb-2 font-inter">
                        Hingga Tarikh
                    </label>
                    <x-myds.input
                        type="date"
                        wire:model.live="dateTo"
                        class="w-full"
                    />
                </div>
            </div>

            <div class="mt-4 flex justify-end">
                <x-myds.button wire:click="applyFilters" variant="primary" size="small">
                    Terapkan Penapis
                </x-myds.button>
            </div>
        </div>
    @endif

    {{-- Activity List --}}
    <div class="divide-y divide-divider">
        @forelse($activities as $activity)
            <div class="px-4 py-3 hover:bg-washed transition-colors duration-150" wire:key="activity-{{ $activity->id }}">
                <div class="flex items-start space-x-3">
                    {{-- Icon --}}
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 rounded-full {{ $this->getActivityColor($activity->log_name) === 'primary' ? 'bg-primary-100' : ($this->getActivityColor($activity->log_name) === 'success' ? 'bg-success-100' : ($this->getActivityColor($activity->log_name) === 'warning' ? 'bg-warning-100' : 'bg-black-100')) }} flex items-center justify-center">
                            <x-myds.icon
                                :name="$this->getActivityIcon($activity->log_name)"
                                size="16"
                                class="{{ $this->getActivityColor($activity->log_name) === 'primary' ? 'text-primary-600' : ($this->getActivityColor($activity->log_name) === 'success' ? 'text-success-600' : ($this->getActivityColor($activity->log_name) === 'warning' ? 'text-warning-600' : 'text-black-600')) }}"
                            />
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-black-900 font-inter">
                                {{ $this->getActivityTypeLabel($activity->log_name) }}
                            </p>
                            <time class="text-xs text-black-500 font-inter">
                                {{ $activity->created_at->diffForHumans() }}
                            </time>
                        </div>

                        <p class="text-sm text-black-600 font-inter mt-1">
                            {{ $activity->description }}
                        </p>

                        @if($activity->properties && $activity->properties->count() > 0)
                            <div class="mt-2">
                                <details class="group">
                                    <summary class="text-xs text-primary-600 cursor-pointer hover:text-primary-700 font-inter">
                                        Lihat Butiran
                                    </summary>
                                    <div class="mt-2 text-xs text-black-500 bg-black-50 rounded p-2 font-inter">
                                        @foreach($activity->properties as $key => $value)
                                            <div class="flex justify-between py-1">
                                                <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                <span>{{ is_array($value) ? json_encode($value) : $value }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </details>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="px-4 py-8 text-center">
                <x-myds.icon name="document" size="32" class="mx-auto text-black-300 mb-2" />
                <p class="text-sm text-black-500 font-inter">Tiada aktiviti dijumpai.</p>
                @if($this->selectedTypes !== $this->getAllActivityTypes() || $this->dateFrom || $this->dateTo)
                    <x-myds.button wire:click="resetFilters" variant="secondary" size="small" class="mt-2">
                        Kosongkan Penapis
                    </x-myds.button>
                @endif
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    @if($activities->hasPages())
        <div class="px-4 py-3 border-t border-divider">
            {{ $activities->links() }}
        </div>
    @endif
</div>
