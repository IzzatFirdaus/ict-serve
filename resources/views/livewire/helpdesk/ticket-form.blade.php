<div class="bg-background-light dark:bg-background-dark min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <x-myds.header>
            <h1 class="font-poppins text-2xl font-semibold text-black-900 dark:text-white">
                Borang Aduan Helpdesk ICT
            </h1>
            <p class="font-inter text-sm text-black-500 dark:text-black-400 mt-2">
                Hantar permintaan untuk sokongan dan bantuan ICT
            </p>
        </x-myds.header>

        <div class="max-w-4xl mx-auto">
            <!-- Success Message -->
            @if(session('success'))
                <x-myds.callout variant="success" class="mb-6">
                    <x-myds.icon name="check-circle" size="20" class="flex-shrink-0" />
                    <div>
                        <h4 class="font-inter text-sm font-medium text-success-700 dark:text-success-500">
                            Aduan Berjaya Dihantar
                        </h4>
                        <p class="font-inter text-sm text-success-700 dark:text-success-500 mt-1">
                            {{ session('success') }}
                        </p>
                    </div>
                </x-myds.callout>
            @endif

            <!-- Error Message -->
            @if(session('error'))
                <x-myds.callout variant="danger" class="mb-6">
                    <x-myds.icon name="warning-circle" size="20" class="flex-shrink-0" />
                    <div>
                        <h4 class="font-inter text-sm font-medium text-danger-700 dark:text-danger-400">
                            Ralat Berlaku
                        </h4>
                        <p class="font-inter text-sm text-danger-700 dark:text-danger-400 mt-1">
                            {{ session('error') }}
                        </p>
                    </div>
                </x-myds.callout>
            @endif

            <!-- Ticket Form -->
            <form wire:submit="submit" class="bg-white dark:bg-dialog-active rounded-lg shadow-sm border border-divider">
                <!-- Form Header -->
                <div class="px-6 py-4 border-b border-divider">
                    <h2 class="font-poppins text-lg font-medium text-black-900 dark:text-white">
                        Maklumat Aduan
                    </h2>
                </div>

                <div class="px-6 py-6 space-y-6">
                    <!-- Category Selection -->
                    <div>
                        <label for="category_id" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                            Kategori <span class="text-danger-600">*</span>
                        </label>
                        <x-myds.select wire:model.live="category_id" id="category_id">
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-myds.select>
                        @error('category_id')
                            <p class="font-inter text-xs text-danger-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                            Tajuk Masalah <span class="text-danger-600">*</span>
                        </label>
                        <x-myds.input
                            type="text"
                            id="title"
                            wire:model.live="title"
                            placeholder="Huraian ringkas mengenai masalah"
                            class="w-full"
                        />
                        @error('title')
                            <p class="font-inter text-xs text-danger-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                            Huraian Terperinci <span class="text-danger-600">*</span>
                        </label>
                        <textarea
                            id="description"
                            wire:model.live="description"
                            rows="4"
                            placeholder="Sila berikan maklumat terperinci mengenai masalah yang dihadapi"
                            class="font-inter text-sm w-full px-3 py-2 border border-divider rounded-lg bg-white dark:bg-dialog focus:ring focus:ring-primary-300 dark:focus:ring-primary-700 focus:border-primary-600 dark:focus:border-primary-400 resize-none"
                        ></textarea>
                        @error('description')
                            <p class="font-inter text-xs text-danger-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Priority and Urgency Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Priority -->
                        <div>
                            <label for="priority" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                                Keutamaan <span class="text-danger-600">*</span>
                            </label>
                            <x-myds.select wire:model.live="priority" id="priority">
                                <option value="">Pilih keutamaan</option>
                                @foreach(\App\Enums\TicketPriority::cases() as $priorityOption)
                                    <option value="{{ $priorityOption->value }}">
                                        {{ $priorityOption->label() }}
                                    </option>
                                @endforeach
                            </x-myds.select>
                            @if($priority)
                                <p class="font-inter text-xs text-black-500 dark:text-black-400 mt-1">
                                    {{ \App\Enums\TicketPriority::from($priority)->description() }}
                                </p>
                            @endif
                            @error('priority')
                                <p class="font-inter text-xs text-danger-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Urgency -->
                        <div>
                            <label for="urgency" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                                Kecemasan <span class="text-danger-600">*</span>
                            </label>
                            <x-myds.select wire:model.live="urgency" id="urgency">
                                <option value="">Pilih tahap kecemasan</option>
                                @foreach(\App\Enums\TicketUrgency::cases() as $urgencyOption)
                                    <option value="{{ $urgencyOption->value }}">
                                        {{ $urgencyOption->label() }}
                                    </option>
                                @endforeach
                            </x-myds.select>
                            @if($urgency)
                                <p class="font-inter text-xs text-black-500 dark:text-black-400 mt-1">
                                    {{ \App\Enums\TicketUrgency::from($urgency)->description() }}
                                </p>
                            @endif
                            @error('urgency')
                                <p class="font-inter text-xs text-danger-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Equipment Selection -->
                    @if(!empty($equipmentItems))
                        <div>
                            <label for="equipment_item_id" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                                Peralatan Berkaitan (Pilihan)
                            </label>
                            <x-myds.select wire:model.live="equipment_item_id" id="equipment_item_id">
                                <option value="">Tiada peralatan khusus</option>
                                @foreach($equipmentItems as $equipment)
                                    <option value="{{ $equipment->id }}">
                                        {{ $equipment->name }} ({{ $equipment->serial_number ?? $equipment->asset_tag }})
                                    </option>
                                @endforeach
                            </x-myds.select>
                            @error('equipment_item_id')
                                <p class="font-inter text-xs text-danger-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    <!-- Location and Contact -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Location -->
                        <div>
                            <label for="location" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                                Lokasi <span class="text-danger-600">*</span>
                            </label>
                            <x-myds.input
                                type="text"
                                id="location"
                                wire:model.live="location"
                                placeholder="Bangunan, tingkat, nombor bilik"
                                class="w-full"
                            />
                            @error('location')
                                <p class="font-inter text-xs text-danger-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Contact Phone -->
                        <div>
                            <label for="contact_phone" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                                Nombor Telefon <span class="text-danger-600">*</span>
                            </label>
                            <x-myds.input
                                type="tel"
                                id="contact_phone"
                                wire:model.live="contact_phone"
                                placeholder="Nombor telefon untuk dihubungi"
                                class="w-full"
                            />
                            @error('contact_phone')
                                <p class="font-inter text-xs text-danger-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- File Attachments -->
                    <div>
                        <label for="attachments" class="font-inter text-xs font-medium text-black-700 dark:text-black-300 block mb-2">
                            Lampiran (Pilihan)
                        </label>
                        <div class="border-2 border-dashed border-divider rounded-lg p-6 text-center hover:border-primary-300 transition-colors">
                            <input type="file" wire:model="attachments" id="attachments" multiple
                                   accept="image/*,.pdf,.doc,.docx,.txt"
                                   class="hidden">
                            <label for="attachments" class="cursor-pointer">
                                <x-myds.icon name="upload" size="32" class="text-black-400 mx-auto mb-2" />
                                <span class="font-inter text-sm text-black-600 dark:text-black-400 block">
                                    Klik untuk muat naik fail atau seret dan lepas
                                </span>
                                <p class="font-inter text-xs text-black-500 dark:text-black-400 mt-1">
                                    PNG, JPG, PDF, DOC sehingga 10MB setiap satu
                                </p>
                            </label>
                        </div>

                        <!-- Show selected files -->
                        @if($attachments)
                            <div class="mt-4 space-y-2">
                                @foreach($attachments as $index => $attachment)
                                    <div class="flex items-center justify-between bg-washed dark:bg-black-100 p-3 rounded-lg">
                                        <div class="flex items-center space-x-3">
                                            <x-myds.icon name="attachment" size="16" class="text-black-500" />
                                            <span class="font-inter text-sm text-black-700 dark:text-black-300">
                                                {{ $attachment->getClientOriginalName() }}
                                            </span>
                                        </div>
                                        <x-myds.button
                                            variant="danger"
                                            size="small"
                                            wire:click="removeAttachment({{ $index }})"
                                        >
                                            <x-myds.icon name="cross" size="14" />
                                        </x-myds.button>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @error('attachments.*')
                            <p class="font-inter text-xs text-danger-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SLA Information -->
                    @if($priority && $urgency && method_exists($this, 'getSlaHours'))
                        <x-myds.callout variant="info">
                            <x-myds.icon name="info" size="20" class="flex-shrink-0" />
                            <div>
                                <h4 class="font-inter text-sm font-medium text-primary-700 dark:text-primary-400">
                                    Perjanjian Tahap Perkhidmatan
                                </h4>
                                <p class="font-inter text-sm text-primary-700 dark:text-primary-400 mt-1">
                                    Berdasarkan keutamaan dan kecemasan yang dipilih, aduan ini akan diselesaikan dalam
                                    <strong>{{ $this->getSlaHours() }} jam</strong> semasa waktu perniagaan.
                                </p>
                            </div>
                        </x-myds.callout>
                    @endif
                </div>

                <!-- Form Actions -->
                <div class="px-6 py-4 border-t border-divider bg-washed dark:bg-black-100 rounded-b-lg flex justify-end space-x-4">
                    <x-myds.button variant="secondary" type="button" onclick="window.history.back()">
                        <x-myds.icon name="arrow-left" size="16" class="mr-2" />
                        Batal
                    </x-myds.button>

                    <x-myds.button
                        variant="primary"
                        type="submit"
                        wire:loading.attr="disabled"
                    >
                        <x-myds.icon name="plus" size="16" class="mr-2" wire:loading.remove />
                        <x-myds.icon name="refresh" size="16" class="mr-2 animate-spin" wire:loading />
                        <span wire:loading.remove>Hantar Aduan</span>
                        <span wire:loading>Menghantar...</span>
                    </x-myds.button>
                </div>
            </form>
        </div>
    </div>
</div>
