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
                        <x-myds.input
                            label="Name"
                            name="name"
                            value="{{ auth()->user()->name }}"
                            readonly
                        />
                    </div>
                    <div class="col-span-full md:col-span-6">
                        <x-myds.input
                            label="Position"
                            name="position"
                            value="{{ auth()->user()->position ?? 'N/A' }}"
                            readonly
                        />
                    </div>
                    <div class="col-span-full md:col-span-6">
                        <x-myds.input
                            label="Department"
                            name="department"
                            value="{{ auth()->user()->department ?? 'N/A' }}"
                            readonly
                        />
                    </div>
                    <div class="col-span-full md:col-span-6">
                        <x-myds.input
                            label="Phone"
                            name="phone"
                            value="{{ auth()->user()->phone ?? 'N/A' }}"
                            readonly
                        />
                    </div>
                </div>
            </div>

            <!-- Request Details -->
            <div class="bg-bg-white border border-otl-gray-200 rounded-[var(--radius-m)] p-6">
                <h2 class="myds-heading-xs text-txt-black-900 mb-4">Request Details</h2>
                <div class="space-y-4">
                    <x-myds.textarea
                        label="Purpose of Loan"
                        name="purpose"
                        value="{{ old('purpose') }}"
                        placeholder="Describe the purpose for borrowing this equipment..."
                        required
                        rows="3"
                        error="{{ $errors->first('purpose') }}"
                    />

                    <x-myds.input
                        label="Usage Location"
                        name="location"
                        value="{{ old('location') }}"
                        placeholder="Where will the equipment be used?"
                        required
                        error="{{ $errors->first('location') }}"
                    />

                    <div class="myds-grid-12">
                        <div class="col-span-full md:col-span-6">
                            <x-myds.input
                                type="date"
                                label="From Date"
                                name="requested_from"
                                value="{{ old('requested_from') }}"
                                required
                                error="{{ $errors->first('requested_from') }}"
                                min="{{ date('Y-m-d') }}"
                            />
                        </div>
                        <div class="col-span-full md:col-span-6">
                            <x-myds.input
                                type="date"
                                label="To Date"
                                name="requested_to"
                                value="{{ old('requested_to') }}"
                                required
                                error="{{ $errors->first('requested_to') }}"
                            />
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
                            <x-myds.button
                                type="button"
                                variant="danger"
                                size="sm"
                                class="remove-equipment"
                                x-cloak
                            >
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </x-myds.button>
                        </div>
                        <div class="myds-grid-12">
                            <div class="col-span-full md:col-span-8">
                                @php
                                    $equipmentOptions = [];
                                    foreach($categories as $category) {
                                        foreach($category->equipments as $equipment) {
                                            $equipmentOptions[$equipment->id] = $category->name . ' - ' . $equipment->name;
                                        }
                                    }
                                @endphp
                                <x-myds.select
                                    label="Equipment"
                                    name="equipment_requests[0][equipment_id]"
                                    :options="$equipmentOptions"
                                    placeholder="Select equipment..."
                                    required
                                />
                            </div>
                            <div class="col-span-full md:col-span-4">
                                <x-myds.input
                                    type="number"
                                    label="Quantity"
                                    name="equipment_requests[0][quantity]"
                                    value="1"
                                    min="1"
                                    required
                                />
                            </div>
                        </div>
                        <div class="mt-4">
                            <x-myds.textarea
                                label="Notes"
                                name="equipment_requests[0][notes]"
                                placeholder="Additional notes for this equipment..."
                                rows="2"
                            />
                        </div>
                    </div>
                </div>
                <x-myds.button
                    type="button"
                    id="add-equipment"
                    variant="outline"
                    class="mt-4"
                >
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Add Another Equipment
                </x-myds.button>
            </div>

            <!-- Responsible Officer -->
            <div class="bg-bg-white border border-otl-gray-200 rounded-[var(--radius-m)] p-6">
                <h2 class="myds-heading-xs text-txt-black-900 mb-4">Responsible Officer</h2>
                <div class="mb-4">
                    <x-myds.checkbox
                        name="same_as_applicant"
                        value="1"
                        label="Same as applicant"
                    />
                </div>
                <div class="myds-grid-12">
                    <div class="col-span-full md:col-span-4">
                        <x-myds.input
                            label="Name"
                            name="responsible_officer_name"
                            value="{{ old('responsible_officer_name') }}"
                            required
                            error="{{ $errors->first('responsible_officer_name') }}"
                        />
                    </div>
                    <div class="col-span-full md:col-span-4">
                        <x-myds.input
                            label="Position"
                            name="responsible_officer_position"
                            value="{{ old('responsible_officer_position') }}"
                            required
                            error="{{ $errors->first('responsible_officer_position') }}"
                        />
                    </div>
                    <div class="col-span-full md:col-span-4">
                        <x-myds.input
                            label="Phone"
                            name="responsible_officer_phone"
                            value="{{ old('responsible_officer_phone') }}"
                            required
                            error="{{ $errors->first('responsible_officer_phone') }}"
                        />
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('public.my-requests') }}" class="myds-button myds-button-secondary px-6 py-3">
                    Cancel
                </a>
                <x-myds.button
                    type="submit"
                    variant="primary"
                >
                    Submit Request
                </x-myds.button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
@vite(['resources/js/public/loan-request.js'])
@endpush
@endsection
