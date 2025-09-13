@extends('layouts.app')

@section('title', 'Damage Complaint')

@section('content')
<div class="bg-bg-white">
    <!-- Header Section -->
    <div class="bg-bg-danger-600 text-txt-white py-8">
        <div class="myds-container">
            <h1 class="myds-heading-md text-txt-white mb-2">Damage Complaint</h1>
            <p class="myds-body-lg text-txt-white opacity-80">Report damaged equipment or technical issues</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="myds-container py-8">
        @if(session('success'))
            <div class="bg-bg-success-50 border border-otl-success-200 text-txt-success px-4 py-3 rounded-[var(--radius-m)] mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('public.damage-complaint.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Reporter Information -->
            <div class="bg-bg-gray-50 rounded-[var(--radius-m)] p-6">
                <h2 class="myds-heading-xs text-txt-black-900 mb-4">Reporter Information</h2>
                <div class="myds-grid-12">
                    <div class="col-span-full md:col-span-6">
                        <label class="block myds-body-sm font-medium text-txt-black-700">Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly class="mt-1 block w-full bg-bg-gray-50 border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2">
                    </div>
                    <div class="col-span-full md:col-span-6">
                        <label class="block myds-body-sm font-medium text-txt-black-700">Department</label>
                        <input type="text" value="{{ auth()->user()->department ?? 'N/A' }}" readonly class="mt-1 block w-full bg-bg-gray-50 border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2">
                    </div>
                    <div class="col-span-full md:col-span-6">
                        <label for="contact_phone" class="block myds-body-sm font-medium text-txt-black-700">Contact Phone <span class="text-txt-danger">*</span></label>
                        <input type="text" id="contact_phone" name="contact_phone" required value="{{ old('contact_phone', auth()->user()->phone) }}" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-danger">
                        @error('contact_phone')
                            <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-full md:col-span-6">
                        <label for="location" class="block myds-body-sm font-medium text-txt-black-700">Location <span class="text-txt-danger">*</span></label>
                        <input type="text" id="location" name="location" required value="{{ old('location') }}" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-danger" placeholder="Where is the damaged equipment located?">
                        @error('location')
                            <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Issue Details -->
            <div class="bg-bg-white border border-otl-gray-200 rounded-[var(--radius-m)] p-6">
                <h2 class="myds-heading-xs text-txt-black-900 mb-4">Issue Details</h2>
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block myds-body-sm font-medium text-txt-black-700">Issue Title <span class="text-txt-danger">*</span></label>
                        <input type="text" id="title" name="title" required value="{{ old('title') }}" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-danger" placeholder="Brief description of the issue">
                        @error('title')
                            <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block myds-body-sm font-medium text-txt-black-700">Detailed Description <span class="text-txt-danger">*</span></label>
                        <textarea id="description" name="description" rows="5" required class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-danger" placeholder="Describe the damage or issue in detail. Include what happened, when it occurred, and any error messages...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="myds-grid-12">
                        <div class="col-span-full md:col-span-6">
                            <label for="equipment_item_id" class="block myds-body-sm font-medium text-txt-black-700">Affected Equipment (if applicable)</label>
                            <select id="equipment_item_id" name="equipment_item_id" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-danger">
                                <option value="">Select equipment (if known)...</option>
                                @foreach($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach($category->equipmentItems as $item)
                                            <option value="{{ $item->id }}" {{ old('equipment_item_id') == $item->id ? 'selected' : '' }}>
                                                {{ $item->brand }} {{ $item->model }} ({{ $item->asset_number }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('equipment_item_id')
                                <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-full md:col-span-6">
                            <label for="damage_type" class="block myds-body-sm font-medium text-txt-black-700">Damage Type <span class="text-txt-danger">*</span></label>
                            <select id="damage_type" name="damage_type" required class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-danger">
                                <option value="">Select damage type...</option>
                                <option value="hardware_failure" {{ old('damage_type') == 'hardware_failure' ? 'selected' : '' }}>Hardware Failure</option>
                                <option value="software_issue" {{ old('damage_type') == 'software_issue' ? 'selected' : '' }}>Software Issue</option>
                                <option value="physical_damage" {{ old('damage_type') == 'physical_damage' ? 'selected' : '' }}>Physical Damage</option>
                                <option value="network_connectivity" {{ old('damage_type') == 'network_connectivity' ? 'selected' : '' }}>Network Connectivity</option>
                                <option value="performance_issue" {{ old('damage_type') == 'performance_issue' ? 'selected' : '' }}>Performance Issue</option>
                                <option value="other" {{ old('damage_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('damage_type')
                                <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="priority" class="block myds-body-sm font-medium text-txt-black-700">Priority Level <span class="text-txt-danger">*</span></label>
                        <select id="priority" name="priority" required class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-danger">
                            <option value="">Select priority level...</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low - Minor issue, no work disruption</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium - Some work disruption</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High - Significant work disruption</option>
                            <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Critical - Complete work stoppage</option>
                        </select>
                        @error('priority')
                            <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Attachments -->
            <div class="bg-bg-white border border-otl-gray-200 rounded-[var(--radius-m)] p-6">
                <h2 class="myds-heading-xs text-txt-black-900 mb-4">Attachments</h2>
                <div class="space-y-4">
                    <div>
                        <label for="attachments" class="block myds-body-sm font-medium text-txt-black-700">Photos or Documents</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-otl-gray-200 border-dashed rounded-[var(--radius-m)] hover:border-otl-gray-300">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-txt-black-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <div class="flex myds-body-sm text-txt-black-600">
                                    <label for="attachments" class="relative cursor-pointer bg-bg-white rounded-[var(--radius-m)] font-medium text-txt-danger hover:text-txt-danger focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-fr-danger">
                                        <span>Upload files</span>
                                        <input id="attachments" name="attachments[]" type="file" class="sr-only" multiple accept=".jpg,.jpeg,.png,.pdf">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="myds-body-xs text-txt-black-500">PNG, JPG, PDF up to 5MB each</p>
                            </div>
                        </div>
                        <div id="file-list" class="mt-4 space-y-2"></div>
                        @error('attachments.*')
                            <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('public.my-requests') }}" class="px-6 py-3 border border-otl-gray-200 rounded-[var(--radius-m)] myds-body-sm font-medium text-txt-black-700 hover:bg-bg-gray-50">
                    Cancel
                </a>
                    <button type="submit" class="px-6 py-3 bg-bg-danger-600 text-txt-white rounded-[var(--radius-m)] myds-body-sm font-medium hover:bg-bg-danger-700 focus:outline-none focus:ring-fr-danger">
                    Submit Complaint
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    @vite(['resources/js/damage-complaint.js'])
@endpush
@endsection
