<div class="myds-container mx-auto px-4 py-8 max-w-2xl">
    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Create Support Ticket</h1>
        <p class="text-gray-600">Submit a request for ICT support and assistance</p>
    </div>

    {{-- Success Message --}}
    @if (session()->has('success'))
        <div class="mb-6 bg-success-50 border border-success-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-success-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-success-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form wire:submit="submit" class="space-y-6">
        {{-- Category Selection --}}
        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                Category <span class="text-danger-500">*</span>
            </label>
            <select wire:model.live="category_id" id="category_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-300 focus:border-primary-600 bg-white">
                <option value="">Select a category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Title --}}
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                Issue Title <span class="text-danger-500">*</span>
            </label>
            <input type="text" wire:model="title" id="title"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-300 focus:border-primary-600"
                   placeholder="Brief description of the issue">
            @error('title')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Description --}}
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Detailed Description <span class="text-danger-500">*</span>
            </label>
            <textarea wire:model="description" id="description" rows="4"
                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-300 focus:border-primary-600"
                      placeholder="Please provide detailed information about the issue"></textarea>
            @error('description')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Priority and Urgency Row --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Priority --}}
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                    Priority <span class="text-danger-500">*</span>
                </label>
                <select wire:model.live="priority" id="priority"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-300 focus:border-primary-600 bg-white">
                    <option value="">Select priority</option>
                    @foreach(\App\Enums\TicketPriority::cases() as $priorityOption)
                        <option value="{{ $priorityOption->value }}">
                            {{ $priorityOption->label() }}
                        </option>
                    @endforeach
                </select>
                @if($priority)
                    <p class="mt-1 text-xs text-gray-500">
                        {{ \App\Enums\TicketPriority::from($priority)->description() }}
                    </p>
                @endif
                @error('priority')
                    <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Urgency --}}
            <div>
                <label for="urgency" class="block text-sm font-medium text-gray-700 mb-2">
                    Urgency <span class="text-danger-500">*</span>
                </label>
                <select wire:model.live="urgency" id="urgency"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-300 focus:border-primary-600 bg-white">
                    <option value="">Select urgency</option>
                    @foreach(\App\Enums\TicketUrgency::cases() as $urgencyOption)
                        <option value="{{ $urgencyOption->value }}">
                            {{ $urgencyOption->label() }}
                        </option>
                    @endforeach
                </select>
                @if($urgency)
                    <p class="mt-1 text-xs text-gray-500">
                        {{ \App\Enums\TicketUrgency::from($urgency)->description() }}
                    </p>
                @endif
                @error('urgency')
                    <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Equipment Selection --}}
        @if(!empty($equipmentItems))
            <div>
                <label for="equipment_item_id" class="block text-sm font-medium text-gray-700 mb-2">
                    Related Equipment (Optional)
                </label>
                <select wire:model="equipment_item_id" id="equipment_item_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-300 focus:border-primary-600 bg-white">
                    <option value="">No specific equipment</option>
                    @foreach($equipmentItems as $equipment)
                        <option value="{{ $equipment->id }}">
                            {{ $equipment->name }} ({{ $equipment->serial_number }})
                        </option>
                    @endforeach
                </select>
                @error('equipment_item_id')
                    <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                @enderror
            </div>
        @endif

        {{-- Location --}}
        <div>
            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">
                Location <span class="text-danger-500">*</span>
            </label>
            <input type="text" wire:model="location" id="location"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-300 focus:border-primary-600"
                   placeholder="Building, floor, room number">
            @error('location')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- Contact Phone --}}
        <div>
            <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                Contact Phone <span class="text-danger-500">*</span>
            </label>
            <input type="tel" wire:model="contact_phone" id="contact_phone"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-300 focus:border-primary-600"
                   placeholder="Your contact phone number">
            @error('contact_phone')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- File Attachments --}}
        <div>
            <label for="attachments" class="block text-sm font-medium text-gray-700 mb-2">
                Attachments (Optional)
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-primary-400 transition-colors">
                <input type="file" wire:model="attachments" id="attachments" multiple
                       accept="image/*,.pdf,.doc,.docx,.txt"
                       class="hidden">
                <label for="attachments" class="cursor-pointer">
                    <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <span class="text-gray-600">Click to upload files or drag and drop</span>
                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, PDF, DOC up to 10MB each</p>
                </label>
            </div>

            {{-- Show selected files --}}
            @if($attachments)
                <div class="mt-2 space-y-2">
                    @foreach($attachments as $index => $attachment)
                        <div class="flex items-center justify-between bg-gray-50 p-2 rounded">
                            <span class="text-sm text-gray-700">{{ $attachment->getClientOriginalName() }}</span>
                            <button type="button" wire:click="removeAttachment({{ $index }})"
                                    class="text-danger-500 hover:text-danger-700">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif

            @error('attachments.*')
                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
            @enderror
        </div>

        {{-- SLA Information --}}
        @if($priority && $urgency)
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <h4 class="font-medium text-blue-900 mb-2">Service Level Agreement</h4>
                <p class="text-sm text-blue-800">
                    Based on your selected priority and urgency, this ticket will be resolved within
                    <strong>{{ $this->getSlaHours() }} hours</strong> during business hours.
                </p>
            </div>
        @endif

        {{-- Submit Button --}}
        <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
            <button type="button" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button type="submit"
                    class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 focus:ring-2 focus:ring-primary-300 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                <span wire:loading.remove>Submit Ticket</span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Submitting...
                </span>
            </button>
        </div>
    </form>

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="submitTicket"
         class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full mx-4">
            <div class="flex items-center space-x-3">
                <svg class="animate-spin h-5 w-5 text-primary-600" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-900">Creating your ticket...</span>
            </div>
        </div>
    </div>
</div>
