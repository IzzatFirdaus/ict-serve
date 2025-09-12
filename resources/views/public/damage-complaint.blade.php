@extends('layouts.app')

@section('title', 'Damage Complaint')

@section('content')
<div class="bg-white">
    <!-- Header Section -->
    <div class="bg-danger-600 text-white py-8">
        <div class="max-w-6xl mx-auto px-4">
            <h1 class="text-3xl font-bold mb-2">Damage Complaint</h1>
            <p class="text-danger-100">Report damaged equipment or technical issues</p>
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

        <form method="POST" action="{{ route('public.damage-complaint.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Reporter Information -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Reporter Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Department</label>
                        <input type="text" value="{{ auth()->user()->department ?? 'N/A' }}" readonly class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700">Contact Phone <span class="text-danger-600">*</span></label>
                        <input type="text" id="contact_phone" name="contact_phone" required value="{{ old('contact_phone', auth()->user()->phone) }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danger-500 focus:border-danger-500">
                        @error('contact_phone')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location <span class="text-danger-600">*</span></label>
                        <input type="text" id="location" name="location" required value="{{ old('location') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danger-500 focus:border-danger-500" placeholder="Where is the damaged equipment located?">
                        @error('location')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Issue Details -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Issue Details</h2>
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Issue Title <span class="text-danger-600">*</span></label>
                        <input type="text" id="title" name="title" required value="{{ old('title') }}" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danger-500 focus:border-danger-500" placeholder="Brief description of the issue">
                        @error('title')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Detailed Description <span class="text-danger-600">*</span></label>
                        <textarea id="description" name="description" rows="5" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danger-500 focus:border-danger-500" placeholder="Describe the damage or issue in detail. Include what happened, when it occurred, and any error messages...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="equipment_item_id" class="block text-sm font-medium text-gray-700">Affected Equipment (if applicable)</label>
                            <select id="equipment_item_id" name="equipment_item_id" class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danger-500 focus:border-danger-500">
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
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="damage_type" class="block text-sm font-medium text-gray-700">Damage Type <span class="text-danger-600">*</span></label>
                            <select id="damage_type" name="damage_type" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danger-500 focus:border-danger-500">
                                <option value="">Select damage type...</option>
                                <option value="hardware_failure" {{ old('damage_type') == 'hardware_failure' ? 'selected' : '' }}>Hardware Failure</option>
                                <option value="software_issue" {{ old('damage_type') == 'software_issue' ? 'selected' : '' }}>Software Issue</option>
                                <option value="physical_damage" {{ old('damage_type') == 'physical_damage' ? 'selected' : '' }}>Physical Damage</option>
                                <option value="network_connectivity" {{ old('damage_type') == 'network_connectivity' ? 'selected' : '' }}>Network Connectivity</option>
                                <option value="performance_issue" {{ old('damage_type') == 'performance_issue' ? 'selected' : '' }}>Performance Issue</option>
                                <option value="other" {{ old('damage_type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('damage_type')
                                <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="priority" class="block text-sm font-medium text-gray-700">Priority Level <span class="text-danger-600">*</span></label>
                        <select id="priority" name="priority" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-danger-500 focus:border-danger-500">
                            <option value="">Select priority level...</option>
                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low - Minor issue, no work disruption</option>
                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium - Some work disruption</option>
                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High - Significant work disruption</option>
                            <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Critical - Complete work stoppage</option>
                        </select>
                        @error('priority')
                            <p class="mt-1 text-sm text-danger-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Attachments -->
            <div class="bg-white border border-gray-200 rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Attachments</h2>
                <div class="space-y-4">
                    <div>
                        <label for="attachments" class="block text-sm font-medium text-gray-700">Photos or Documents</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="attachments" class="relative cursor-pointer bg-white rounded-md font-medium text-danger-600 hover:text-danger-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-danger-500">
                                        <span>Upload files</span>
                                        <input id="attachments" name="attachments[]" type="file" class="sr-only" multiple accept=".jpg,.jpeg,.png,.pdf">
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, PDF up to 5MB each</p>
                            </div>
                        </div>
                        <div id="file-list" class="mt-4 space-y-2"></div>
                        @error('attachments.*')
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
                <button type="submit" class="px-6 py-3 bg-danger-600 text-white rounded-md text-sm font-medium hover:bg-danger-700 focus:outline-none focus:ring-2 focus:ring-danger-500">
                    Submit Complaint
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('attachments');
    const fileList = document.getElementById('file-list');
    let selectedFiles = [];

    // File selection handler
    fileInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        selectedFiles = files;
        displayFiles();
    });

    // Display selected files
    function displayFiles() {
        fileList.innerHTML = '';
        selectedFiles.forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'flex items-center justify-between p-2 bg-gray-50 rounded-md';

            const fileInfo = document.createElement('div');
            fileInfo.className = 'flex items-center space-x-2';

            const fileIcon = getFileIcon(file.type);
            const fileName = document.createElement('span');
            fileName.className = 'text-sm text-gray-700';
            fileName.textContent = file.name;

            const fileSize = document.createElement('span');
            fileSize.className = 'text-xs text-gray-500';
            fileSize.textContent = formatFileSize(file.size);

            fileInfo.appendChild(fileIcon);
            fileInfo.appendChild(fileName);
            fileInfo.appendChild(fileSize);

            const removeButton = document.createElement('button');
            removeButton.type = 'button';
            removeButton.className = 'text-danger-600 hover:text-danger-800';
            removeButton.innerHTML = `
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            `;

            removeButton.addEventListener('click', function() {
                selectedFiles.splice(index, 1);
                updateFileInput();
                displayFiles();
            });

            fileItem.appendChild(fileInfo);
            fileItem.appendChild(removeButton);
            fileList.appendChild(fileItem);
        });
    }

    // Update file input with remaining files
    function updateFileInput() {
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        fileInput.files = dt.files;
    }

    // Get file icon based on file type
    function getFileIcon(fileType) {
        const icon = document.createElement('svg');
        icon.className = 'w-4 h-4 text-gray-400';
        icon.fill = 'currentColor';
        icon.viewBox = '0 0 20 20';

        if (fileType.startsWith('image/')) {
            icon.innerHTML = `<path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>`;
        } else if (fileType === 'application/pdf') {
            icon.innerHTML = `<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>`;
        } else {
            icon.innerHTML = `<path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"></path>`;
        }

        return icon;
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Drag and drop functionality
    const dropZone = fileInput.closest('.border-dashed');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    dropZone.addEventListener('drop', handleDrop, false);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight(e) {
        dropZone.classList.add('border-danger-400', 'bg-danger-50');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-danger-400', 'bg-danger-50');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        selectedFiles = Array.from(files);
        updateFileInput();
        displayFiles();
    }
});
</script>
@endsection
