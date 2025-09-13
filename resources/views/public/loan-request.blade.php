@extends('layouts.app')

@section('title', 'Equipment Loan Request')

@section('content')
<div class="bg-bg-white">
    <!-- Header Section -->
    <div class="bg-bg-primary-600 text-txt-white py-8">
        <div class="myds-container">
            <h1 class="myds-heading-md text-txt-white mb-2">Equipment Loan Request</h1>
            <p class="myds-body-lg text-txt-white opacity-80">Submit a request to borrow ICT equipment for official use</p>
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

        <form method="POST" action="{{ route('public.loan-request.store') }}" class="space-y-8">
            @csrf

            <!-- Applicant Information -->
            <div class="bg-bg-gray-50 rounded-[var(--radius-m)] p-6">
                <h2 class="myds-heading-xs text-txt-black-900 mb-4">Applicant Information</h2>
                <div class="myds-grid-12">
                    <div class="col-span-full md:col-span-6">
                        <label class="block myds-body-sm font-medium text-txt-black-700">Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly class="mt-1 block w-full bg-bg-gray-50 border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2">
                    </div>
                    <div class="col-span-full md:col-span-6">
                        <label class="block myds-body-sm font-medium text-txt-black-700">Position</label>
                        <input type="text" value="{{ auth()->user()->position ?? 'N/A' }}" readonly class="mt-1 block w-full bg-bg-gray-50 border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2">
                    </div>
                    <div class="col-span-full md:col-span-6">
                        <label class="block myds-body-sm font-medium text-txt-black-700">Department</label>
                        <input type="text" value="{{ auth()->user()->department ?? 'N/A' }}" readonly class="mt-1 block w-full bg-bg-gray-50 border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2">
                    </div>
                    <div class="col-span-full md:col-span-6">
                        <label class="block myds-body-sm font-medium text-txt-black-700">Phone</label>
                        <input type="text" value="{{ auth()->user()->phone ?? 'N/A' }}" readonly class="mt-1 block w-full bg-bg-gray-50 border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2">
                    </div>
                </div>
            </div>

            <!-- Request Details -->
            <div class="bg-bg-white border border-otl-gray-200 rounded-[var(--radius-m)] p-6">
                <h2 class="myds-heading-xs text-txt-black-900 mb-4">Request Details</h2>
                <div class="space-y-4">
                    <div>
                        <label for="purpose" class="block myds-body-sm font-medium text-txt-black-700">Purpose of Loan <span class="text-txt-danger">*</span></label>
                        <textarea id="purpose" name="purpose" rows="3" required class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary" placeholder="Describe the purpose for borrowing this equipment...">{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block myds-body-sm font-medium text-txt-black-700">Usage Location <span class="text-txt-danger">*</span></label>
                        <input type="text" id="location" name="location" required value="{{ old('location') }}" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary" placeholder="Where will the equipment be used?">
                        @error('location')
                            <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="myds-grid-12">
                        <div class="col-span-full md:col-span-6">
                            <label for="requested_from" class="block myds-body-sm font-medium text-txt-black-700">From Date <span class="text-txt-danger">*</span></label>
                            <input type="date" id="requested_from" name="requested_from" required value="{{ old('requested_from') }}" min="{{ date('Y-m-d') }}" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary">
                            @error('requested_from')
                                <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-span-full md:col-span-6">
                            <label for="requested_to" class="block myds-body-sm font-medium text-txt-black-700">To Date <span class="text-txt-danger">*</span></label>
                            <input type="date" id="requested_to" name="requested_to" required value="{{ old('requested_to') }}" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary">
                            @error('requested_to')
                                <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipment Selection -->
            <div class="bg-bg-white border border-otl-gray-200 rounded-[var(--radius-m)] p-6">
                <h2 class="myds-heading-xs text-txt-black-900 mb-4">Equipment Requests</h2>
                <div id="equipment-requests" class="space-y-4">
                    <div class="equipment-request border border-otl-gray-200 rounded-[var(--radius-m)] p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="myds-body-lg font-medium">Equipment #1</h3>
                            <button type="button" class="remove-equipment text-txt-danger hover:text-txt-danger" x-cloak>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="myds-grid-12">
                            <div class="col-span-full md:col-span-8">
                                <label class="block myds-body-sm font-medium text-txt-black-700">Equipment <span class="text-txt-danger">*</span></label>
                                <select name="equipment_requests[0][equipment_id]" required class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary">
                                    <option value="">Select equipment...</option>
                                    @foreach($categories as $category)
                                        <optgroup label="{{ $category->name }}">
                                            @foreach($category->equipmentItems as $item)
                                                <option value="{{ $item->id }}">{{ $item->brand }} {{ $item->model }} ({{ $item->asset_number }})</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-full md:col-span-4">
                                <label class="block myds-body-sm font-medium text-txt-black-700">Quantity <span class="text-txt-danger">*</span></label>
                                <input type="number" name="equipment_requests[0][quantity]" min="1" value="1" required class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block myds-body-sm font-medium text-txt-black-700">Notes</label>
                            <textarea name="equipment_requests[0][notes]" rows="2" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary" placeholder="Additional notes for this equipment..."></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-equipment" class="mt-4 inline-flex items-center px-4 py-2 border border-otl-primary-200 rounded-[var(--radius-m)] myds-body-sm font-medium text-txt-primary hover:bg-bg-primary-50">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Add Another Equipment
                </button>
            </div>

            <!-- Responsible Officer -->
            <div class="bg-bg-white border border-otl-gray-200 rounded-[var(--radius-m)] p-6">
                <h2 class="myds-heading-xs text-txt-black-900 mb-4">Responsible Officer</h2>
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="same_as_applicant" value="1" class="rounded border-otl-gray-200 text-txt-primary focus:ring-fr-primary">
                        <span class="ml-2 myds-body-sm text-txt-black-700">Same as applicant</span>
                    </label>
                </div>
                <div class="myds-grid-12">
                    <div class="col-span-full md:col-span-4">
                        <label for="responsible_officer_name" class="block myds-body-sm font-medium text-txt-black-700">Name <span class="text-txt-danger">*</span></label>
                        <input type="text" id="responsible_officer_name" name="responsible_officer_name" required value="{{ old('responsible_officer_name') }}" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary">
                        @error('responsible_officer_name')
                            <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-full md:col-span-4">
                        <label for="responsible_officer_position" class="block myds-body-sm font-medium text-txt-black-700">Position <span class="text-txt-danger">*</span></label>
                        <input type="text" id="responsible_officer_position" name="responsible_officer_position" required value="{{ old('responsible_officer_position') }}" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary">
                        @error('responsible_officer_position')
                            <p class="mt-1 myds-body-sm text-txt-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="col-span-full md:col-span-4">
                        <label for="responsible_officer_phone" class="block myds-body-sm font-medium text-txt-black-700">Phone <span class="text-txt-danger">*</span></label>
                        <input type="text" id="responsible_officer_phone" name="responsible_officer_phone" required value="{{ old('responsible_officer_phone') }}" class="mt-1 block w-full border border-otl-gray-200 rounded-[var(--radius-m)] px-3 py-2 focus:ring-fr-primary">
                        @error('responsible_officer_phone')
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
                    <button type="submit" class="px-6 py-3 bg-bg-primary-600 text-txt-white rounded-[var(--radius-m)] myds-body-sm font-medium hover:bg-bg-primary-700 focus:outline-none focus:ring-fr-primary">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Pass user data to JavaScript
    window.authUserData = {
        name: '{{ auth()->user()->name }}',
        position: '{{ auth()->user()->position ?? "" }}',
        phone: '{{ auth()->user()->phone ?? "" }}'
    };
</script>
@vite(['resources/js/loan-request.js'])
@endpush
@endsection
