@extends('layouts.public')

@section('title', 'Report ICT Issue - ICT Serve')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-primary-700 mb-2">
              {{ __('help_panel.title') }}
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto">
              {{ __('help_panel.processing_time') }}
        </p>
    </div>

    <!-- Emergency Alert -->
    <x-alert type="warning" class="mb-6">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-warning-500 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
                <p class="font-medium mb-1">{{ __('For Emergency ICT Issues:') }}</p>
                <p class="text-sm">{{ __('If you are experiencing critical system outages, security incidents, or urgent issues affecting operations, please call our emergency hotline: +60 3-xxxx xxxx (24/7)') }}</p>
            </div>
        </div>
    </x-alert>

    <!-- Main Form -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('public.helpdesk.store') }}" method="POST" enctype="multipart/form-data" id="helpdesk-form">
            @csrf

            <!-- Reporter Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">
                    {{ __('Reporter Information') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="reporter_name" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Full Name') }} <span class="text-danger-500">*</span>
                        </label>
                        <input type="text"
                               id="reporter_name"
                               name="reporter_name"
                               value="{{ old('reporter_name') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('reporter_name') border-danger-500 @enderror">
                        @error('reporter_name')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="reporter_email" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Email Address') }} <span class="text-danger-500">*</span>
                        </label>
                        <input type="email"
                               id="reporter_email"
                               name="reporter_email"
                               value="{{ old('reporter_email') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('reporter_email') border-danger-500 @enderror">
                        @error('reporter_email')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="reporter_phone" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Phone Number') }}
                        </label>
                        <input type="tel"
                               id="reporter_phone"
                               name="reporter_phone"
                               value="{{ old('reporter_phone') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('reporter_phone') border-danger-500 @enderror">
                        @error('reporter_phone')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Contact Phone (if different)') }}
                        </label>
                        <input type="tel"
                               id="contact_phone"
                               name="contact_phone"
                               value="{{ old('contact_phone') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('contact_phone') border-danger-500 @enderror">
                        @error('contact_phone')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                    <div>
                        <label for="staff_id" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Staff ID') }} <span class="text-danger-500">*</span>
                        </label>
                        <input type="text"
                               id="staff_id"
                               name="staff_id"
                               value="{{ old('staff_id') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('staff_id') border-danger-500 @enderror">
                        @error('staff_id')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="department" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Department') }} <span class="text-danger-500">*</span>
                        </label>
                        <input type="text"
                               id="department"
                               name="department"
                               value="{{ old('department') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('department') border-danger-500 @enderror">
                        @error('department')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="division" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Division') }} <span class="text-danger-500">*</span>
                        </label>
                        <input type="text"
                               id="division"
                               name="division"
                               value="{{ old('division') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('division') border-danger-500 @enderror">
                        @error('division')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="position" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Position') }} <span class="text-danger-500">*</span>
                        </label>
                        <input type="text"
                               id="position"
                               name="position"
                               value="{{ old('position') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('position') border-danger-500 @enderror">
                        @error('position')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Issue Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">
                    {{ __('Issue Information') }}
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Issue Category') }} <span class="text-danger-500">*</span>
                        </label>
                        <select id="category_id"
                                name="category_id"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('category_id') border-danger-500 @enderror">
                            <option value="">{{ __('Select a category...') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Priority Level') }} <span class="text-danger-500">*</span>
                        </label>
                        <select id="priority"
                                name="priority"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('priority') border-danger-500 @enderror">
                            <option value="">{{ __('Select priority level...') }}</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>
                                {{ __('Low - Can wait, not blocking work') }}
                            </option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>
                                {{ __('Medium - Some impact on work') }}
                            </option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>
                                {{ __('High - Significantly affecting work') }}
                            </option>
                            <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>
                                {{ __('Urgent - Critical issue, work stopped') }}
                            </option>
                        </select>
                        @error('priority')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Issue Title') }} <span class="text-danger-500">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           value="{{ old('title') }}"
                           required
                           placeholder="{{ __('Brief description of the issue...') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('title') border-danger-500 @enderror">
                    @error('title')
                        <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Detailed Description') }} <span class="text-danger-500">*</span>
                    </label>
                    <textarea id="description"
                              name="description"
                              rows="6"
                              required
                              placeholder="{{ __('Please provide detailed information about the issue:
• What happened?
• When did it start occurring?
• What were you trying to do?
• Have you tried any solutions?
• Any error messages received?') }}"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-danger-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Location') }} <span class="text-danger-500">*</span>
                        </label>
                        <input type="text"
                               id="location"
                               name="location"
                               value="{{ old('location') }}"
                               required
                               placeholder="{{ __('Building, Floor, Room number...') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('location') border-danger-500 @enderror">
                        @error('location')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="equipment_item_id" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Related Equipment (if applicable)') }}
                        </label>
                        <select id="equipment_item_id"
                                name="equipment_item_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('equipment_item_id') border-danger-500 @enderror">
                            <option value="">{{ __('None / Not applicable') }}</option>
                            @foreach($equipment as $categoryName => $items)
                                <optgroup label="{{ $categoryName }}">
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}"
                                                {{ old('equipment_item_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->brand }} {{ $item->model }}
                                            @if($item->serial_number) ({{ $item->serial_number }}) @endif
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        @error('equipment_item_id')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- File Attachments -->
                <div class="mb-6">
                    <label for="attachments" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Attachments') }}
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="attachments" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                    <span>{{ __('Upload files') }}</span>
                                    <input id="attachments" name="attachments[]" type="file" class="sr-only" multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt">
                                </label>
                                <p class="pl-1">{{ __('or drag and drop') }}</p>
                            </div>
                            <p class="text-xs text-gray-500">{{ __('Screenshots, documents, error messages (Max 5 files, 10MB each)') }}</p>
                            <p class="text-xs text-gray-500">{{ __('Supported: JPG, PNG, PDF, DOC, DOCX, TXT') }}</p>
                        </div>
                    </div>
                    <div id="file-list" class="mt-2 space-y-2"></div>
                    @error('attachments')
                        <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                    @enderror
                    @error('attachments.*')
                        <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Data Consent -->
            <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                <div class="flex items-start">
                    <input type="checkbox"
                           id="data_consent"
                           name="data_consent"
                           value="1"
                           {{ old('data_consent') ? 'checked' : '' }}
                           required
                           class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                    <label for="data_consent" class="ml-3 text-sm text-gray-700 cursor-pointer">
                        <span class="font-medium">{{ __('Data Processing Consent') }} <span class="text-danger-500">*</span></span>
                        <p class="mt-1">
                            {{ __('I consent to the collection, processing, and storage of my personal data for the purpose of ICT support ticket management. This data will be used to process my support request, send notifications about ticket status, and maintain support records in accordance with applicable data protection regulations.') }}
                        </p>
                    </label>
                </div>
                @error('data_consent')
                    <p class="text-sm text-danger-500 mt-2 ml-7">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ url('/') }}"
                   class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-primary-600 text-white rounded-md text-sm font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        id="submit-btn">
                    <span class="submit-text">{{ __('Submit Report') }}</span>
                    <span class="loading-text hidden">{{ __('Processing...') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@vite('resources/js/public/helpdesk-create.js')
@endpush
@endsection
