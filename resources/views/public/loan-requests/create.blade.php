@extends('layouts.public')

@section('title', 'Equipment Loan Request - ICT Serve')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-primary-700 mb-2">
            {{ __('Equipment Loan Request') }}
        </h1>
        <p class="text-gray-600 max-w-2xl mx-auto">
            {{ __('Submit your equipment loan request. No login required - you will receive email updates about your request status.') }}
        </p>
    </div>

    <!-- Instructions Alert -->
    <x-alert type="info" class="mb-6">
        <p class="font-medium mb-2">{{ __('Before submitting your request:') }}</p>
        <ul class="list-disc list-inside space-y-1 text-sm">
            <li>{{ __('Ensure all information is accurate and complete') }}</li>
            <li>{{ __('Check equipment availability for your requested dates') }}</li>
            <li>{{ __('You will receive an email confirmation with tracking details') }}</li>
            <li>{{ __('Approval notifications will be sent to your email address') }}</li>
        </ul>
    </x-alert>

    <!-- Main Form -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form action="{{ route('public.loan-requests.store') }}" method="POST" id="loan-request-form">
            @csrf

            <!-- Personal Information -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">
                    {{ __('Personal Information') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="borrower_name" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Full Name') }} <span class="text-danger-500">*</span>
                        </label>
                        <input type="text"
                            <script src="{{ asset('js/myds/loan-request-create.js') }}" defer></script>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
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

            <!-- Equipment Selection -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">
                    {{ __('Equipment Selection') }}
                </h2>

                <!-- Equipment Category Filter -->
                <div class="mb-4">
                    <label for="category-filter" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ __('Filter by Category') }}
                    </label>
                    <select id="category-filter" class="w-full md:w-1/3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <option value="">{{ __('All Categories') }}</option>
                        @foreach($equipment->keys() as $categoryName)
                            <option value="{{ $categoryName }}">{{ $categoryName }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Equipment Items -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($equipment as $categoryName => $items)
                        @foreach($items as $item)
                            <div class="equipment-item border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow duration-200"
                                 data-category="{{ $categoryName }}"
                                 data-available="{{ $item->is_available ? 'true' : 'false' }}">
                                <div class="flex items-start space-x-3">
                                    <input type="checkbox"
                                           id="item_{{ $item->id }}"
                                           name="equipment_items[]"
                                           value="{{ $item->id }}"
                                           {{ $item->is_available ? '' : 'disabled' }}
                                           {{ in_array($item->id, old('equipment_items', [])) ? 'checked' : '' }}
                                           class="mt-1 h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded">
                                    <div class="flex-1 min-w-0">
                                        <label for="item_{{ $item->id }}" class="block text-sm font-medium text-gray-900 cursor-pointer">
                                            {{ $item->brand }} {{ $item->model }}
                                        </label>
                                        <p class="text-xs text-gray-600 mt-1">{{ $categoryName }}</p>
                                        @if($item->serial_number)
                                            <p class="text-xs text-gray-500">{{ __('S/N: :serial', ['serial' => $item->serial_number]) }}</p>
                                        @endif
                                        <div class="mt-2">
                                            @if($item->is_available)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-success-100 text-success-800">
                                                    {{ __('Available') }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-danger-100 text-danger-800">
                                                    {{ __('Not Available') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>

                @error('equipment_items')
                    <p class="text-sm text-danger-500 mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Loan Details -->
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 pb-2 border-b">
                    {{ __('Loan Details') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="loan_start_date" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('Start Date') }} <span class="text-danger-500">*</span>
                        </label>
                        <input type="date"
                               id="loan_start_date"
                               name="loan_start_date"
                               value="{{ old('loan_start_date') }}"
                               min="{{ date('Y-m-d') }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('loan_start_date') border-danger-500 @enderror">
                        @error('loan_start_date')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="loan_end_date" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ __('End Date') }} <span class="text-danger-500">*</span>
                        </label>
                        <input type="date"
                               id="loan_end_date"
                               name="loan_end_date"
                               value="{{ old('loan_end_date') }}"
                               min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('loan_end_date') border-danger-500 @enderror">
                        @error('loan_end_date')
                            <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="purpose" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Purpose of Loan') }} <span class="text-danger-500">*</span>
                    </label>
                    <textarea id="purpose"
                              name="purpose"
                              rows="3"
                              required
                              placeholder="{{ __('Please describe the purpose and intended use of the equipment...') }}"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('purpose') border-danger-500 @enderror">{{ old('purpose') }}</textarea>
                    @error('purpose')
                        <p class="text-sm text-danger-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6">
                    <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                        {{ __('Usage Location') }} <span class="text-danger-500">*</span>
                    </label>
                    <input type="text"
                           id="location"
                           name="location"
                           value="{{ old('location') }}"
                           required
                           placeholder="{{ __('Where will the equipment be used?') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('location') border-danger-500 @enderror">
                    @error('location')
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
                            {{ __('I consent to the collection, processing, and storage of my personal data for the purpose of equipment loan management. This data will be used to process my loan request, send notifications about loan status, and maintain equipment usage records in accordance with applicable data protection regulations.') }}
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
                    <span class="submit-text">{{ __('Submit Request') }}</span>
                    <span class="loading-text hidden">{{ __('Processing...') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
