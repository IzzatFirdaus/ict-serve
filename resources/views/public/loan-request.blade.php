@extends('layouts.app')

@section('title', 'Equipment Loan Request')

@section('content')
<div class="bg-white">
    <!-- Header Section -->
    <div class="bg-primary-600 text-white py-8">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">Equipment Loan Request</h1>
            <p class="text-primary-100">Submit a request to borrow ICT equipment for official use</p>
        </div>
    </div>

    <!-- Form Section -->
    <div class="max-w-4xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-success-50 border border-success-300 text-success-800 px-4 py-3 rounded-lg mb-6">
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
            <div class="bg-gray-50 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Applicant Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Position</label>
                        <input type="text" value="{{ auth()->user()->position ?? 'N/A' }}" readonly class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Department</label>
                        <input type="text" value="{{ auth()->user()->department ?? 'N/A' }}" readonly class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Phone</label>
                        <input type="text" value="{{ auth()->user()->phone ?? 'N/A' }}" readonly class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>
            </div>

            <!-- Request Details -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Request Details</h2>
                <div class="space-y-4">
                    <div>
                        <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose of Loan <span class="text-danger-600">*</span></label>
                        <textarea id="purpose" name="purpose" rows="3" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Describe the purpose for borrowing this equipment...">{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Usage Location <span class="text-danger-600">*</span></label>
                        <input type="text" id="location" name="location" required value="{{ old('location') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Where will the equipment be used?">
                        @error('location')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="requested_from" class="block text-sm font-medium text-gray-700">From Date <span class="text-danger-600">*</span></label>
                            <input type="date" id="requested_from" name="requested_from" required value="{{ old('requested_from') }}" min="{{ date('Y-m-d') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('requested_from')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="requested_to" class="block text-sm font-medium text-gray-700">To Date <span class="text-danger-600">*</span></label>
                            <input type="date" id="requested_to" name="requested_to" required value="{{ old('requested_to') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
                            @error('requested_to')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipment Selection -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Equipment Requests</h2>
                <div id="equipment-requests" class="space-y-4">
                    <div class="equipment-request border border-gray-300 rounded-md p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium">Equipment #1</h3>
                            <button type="button" class="remove-equipment text-danger-600 hover:text-danger-800" style="display: none;">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Equipment <span class="text-danger-600">*</span></label>
                                <select name="equipment_requests[0][equipment_id]" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
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
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Quantity <span class="text-danger-600">*</span></label>
                                <input type="number" name="equipment_requests[0][quantity]" min="1" value="1" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
                            </div>
                        </div>
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="equipment_requests[0][notes]" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Additional notes for this equipment..."></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" id="add-equipment" class="mt-4 inline-flex items-center px-4 py-2 border border-primary-600 rounded-md text-sm font-medium text-primary-600 hover:bg-primary-50">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Add Another Equipment
                </button>
            </div>

            <!-- Responsible Officer -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Responsible Officer</h2>
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="same_as_applicant" value="1" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">Same as applicant</span>
                    </label>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="responsible_officer_name" class="block text-sm font-medium text-gray-700">Name <span class="text-danger-600">*</span></label>
                        <input type="text" id="responsible_officer_name" name="responsible_officer_name" required value="{{ old('responsible_officer_name') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('responsible_officer_name')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="responsible_officer_position" class="block text-sm font-medium text-gray-700">Position <span class="text-danger-600">*</span></label>
                        <input type="text" id="responsible_officer_position" name="responsible_officer_position" required value="{{ old('responsible_officer_position') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('responsible_officer_position')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="responsible_officer_phone" class="block text-sm font-medium text-gray-700">Phone <span class="text-danger-600">*</span></label>
                        <input type="text" id="responsible_officer_phone" name="responsible_officer_phone" required value="{{ old('responsible_officer_phone') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
                        @error('responsible_officer_phone')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('public.my-requests') }}" class="px-6 py-3 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-md text-sm font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                    Submit Request
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let equipmentCount = 1;
    const addButton = document.getElementById('add-equipment');
    const container = document.getElementById('equipment-requests');

    // Equipment template
    const equipmentTemplate = `
        <div class="equipment-request border border-gray-300 rounded-md p-4">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Equipment #__INDEX__</h3>
                <button type="button" class="remove-equipment text-danger-600 hover:text-danger-800">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Equipment <span class="text-danger-600">*</span></label>
                    <select name="equipment_requests[__COUNT__][equipment_id]" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
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
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quantity <span class="text-danger-600">*</span></label>
                    <input type="number" name="equipment_requests[__COUNT__][quantity]" min="1" value="1" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500">
                </div>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="equipment_requests[__COUNT__][notes]" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-primary-500 focus:border-primary-500" placeholder="Additional notes for this equipment..."></textarea>
            </div>
        </div>
    `;

    // Add equipment
    addButton.addEventListener('click', function() {
        equipmentCount++;
        const newEquipment = equipmentTemplate
            .replace(/__COUNT__/g, equipmentCount - 1)
            .replace(/__INDEX__/g, equipmentCount);

        container.insertAdjacentHTML('beforeend', newEquipment);
        updateRemoveButtons();
    });

    // Remove equipment
    container.addEventListener('click', function(e) {
        if (e.target.closest('.remove-equipment')) {
            e.target.closest('.equipment-request').remove();
            updateIndexes();
            updateRemoveButtons();
        }
    });

    // Update remove button visibility
    function updateRemoveButtons() {
        const requests = container.querySelectorAll('.equipment-request');
        requests.forEach((request, index) => {
            const removeBtn = request.querySelector('.remove-equipment');
            removeBtn.style.display = requests.length > 1 ? 'block' : 'none';
        });
    }

    // Update equipment indexes
    function updateIndexes() {
        const requests = container.querySelectorAll('.equipment-request');
        requests.forEach((request, index) => {
            const title = request.querySelector('h3');
            title.textContent = `Equipment #${index + 1}`;

            // Update form field names
            const fields = request.querySelectorAll('[name^="equipment_requests"]');
            fields.forEach(field => {
                const name = field.getAttribute('name');
                field.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
            });
        });
    }

    // Same as applicant checkbox
    const sameAsApplicantCheckbox = document.querySelector('input[name="same_as_applicant"]');
    const responsibleOfficerFields = [
        document.getElementById('responsible_officer_name'),
        document.getElementById('responsible_officer_position'),
        document.getElementById('responsible_officer_phone')
    ];

    sameAsApplicantCheckbox.addEventListener('change', function() {
        if (this.checked) {
            responsibleOfficerFields[0].value = '{{ auth()->user()->name }}';
            responsibleOfficerFields[1].value = '{{ auth()->user()->position ?? "" }}';
            responsibleOfficerFields[2].value = '{{ auth()->user()->phone ?? "" }}';
            responsibleOfficerFields.forEach(field => field.readOnly = true);
            responsibleOfficerFields.forEach(field => field.classList.add('bg-gray-100'));
        } else {
            responsibleOfficerFields.forEach(field => {
                field.value = '';
                field.readOnly = false;
                field.classList.remove('bg-gray-100');
            });
        }
    });

    // Date validation
    const fromDate = document.getElementById('requested_from');
    const toDate = document.getElementById('requested_to');

    fromDate.addEventListener('change', function() {
        toDate.min = this.value;
        if (toDate.value && toDate.value <= this.value) {
            toDate.value = '';
        }
    });

    // Initialize
    updateRemoveButtons();
});
</script>
@endsection
