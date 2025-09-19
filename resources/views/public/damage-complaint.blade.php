@extends('layouts.app')

@section('title', 'Damage Complaint')

@section('content')
  <div class="bg-bg-white">
    <!-- Header Section -->
    <div class="bg-bg-danger-600 text-txt-white py-8">
      <div class="myds-container">
        <h1 class="myds-heading-md text-txt-white mb-2">Damage Complaint</h1>
        <p class="myds-body-lg text-txt-white opacity-80">
          Report damaged equipment or technical issues
        </p>
      </div>
    </div>

    <!-- Form Section -->
    <div class="myds-container py-8">
      @if (session('success'))
        <div
          class="bg-bg-success-50 border border-otl-success-200 text-txt-success px-4 py-3 rounded-[var(--radius-m)] mb-6"
        >
          <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path
                fill-rule="evenodd"
                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                clip-rule="evenodd"
              ></path>
            </svg>
            {{ session('success') }}
          </div>
        </div>
      @endif

      <form
        method="POST"
        action="{{ route('public.damage-complaint.store') }}"
        enctype="multipart/form-data"
        class="space-y-8"
      >
        @csrf

        <!-- Reporter Information -->
        <div class="bg-bg-gray-50 rounded-[var(--radius-m)] p-6">
          <h2 class="myds-heading-xs text-txt-black-900 mb-4">
            Reporter Information
          </h2>
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
                label="Department"
                name="department"
                value="{{ auth()->user()->department ?? 'N/A' }}"
                readonly
              />
            </div>
            <div class="col-span-full md:col-span-6">
              <x-myds.input
                label="Contact Phone"
                name="contact_phone"
                value="{{ old('contact_phone', auth()->user()->phone) }}"
                required
                error="{{ $errors->first('contact_phone') }}"
              />
            </div>
            <div class="col-span-full md:col-span-6">
              <x-myds.input
                label="Location"
                name="location"
                value="{{ old('location') }}"
                placeholder="Where is the damaged equipment located?"
                required
                error="{{ $errors->first('location') }}"
              />
            </div>
          </div>
        </div>

        <!-- Issue Details -->
        <div
          class="bg-bg-white border border-otl-gray-200 rounded-[var(--radius-m)] p-6"
        >
          <h2 class="myds-heading-xs text-txt-black-900 mb-4">Issue Details</h2>
          <div class="space-y-4">
            <x-myds.input
              label="Issue Title"
              name="title"
              value="{{ old('title') }}"
              placeholder="Brief description of the issue"
              required
              error="{{ $errors->first('title') }}"
            />

            <x-myds.textarea
              label="Detailed Description"
              name="description"
              value="{{ old('description') }}"
              placeholder="Describe the damage or issue in detail. Include what happened, when it occurred, and any error messages..."
              required
              rows="5"
              error="{{ $errors->first('description') }}"
            />

            <div class="myds-grid-12">
              <div class="col-span-full md:col-span-6">
                @php
                  $equipmentOptions = ['Select equipment (if known)...'];
                  foreach ($categories as $category) {
                    foreach ($category->equipmentItems as $item) {
                      $equipmentOptions[$item->id] = $item->brand . ' ' . $item->model . ' (' . $item->asset_number . ')';
                    }
                  }
                @endphp

                <x-myds.select
                  label="Affected Equipment (if applicable)"
                  name="equipment_item_id"
                  :options="$equipmentOptions"
                  value="{{ old('equipment_item_id') }}"
                  placeholder="Select equipment (if known)..."
                  error="{{ $errors->first('equipment_item_id') }}"
                />
              </div>
              <div class="col-span-full md:col-span-6">
                @php
                  $damageTypeOptions = [
                    'hardware_failure' => 'Hardware Failure',
                    'software_issue' => 'Software Issue',
                    'physical_damage' => 'Physical Damage',
                    'network_connectivity' => 'Network Connectivity',
                    'performance_issue' => 'Performance Issue',
                    'other' => 'Other',
                  ];
                @endphp

                <x-myds.select
                  label="Damage Type"
                  name="damage_type"
                  :options="$damageTypeOptions"
                  value="{{ old('damage_type') }}"
                  placeholder="Select damage type..."
                  required
                  error="{{ $errors->first('damage_type') }}"
                />
              </div>
            </div>

            @php
              $priorityOptions = [
                'low' => 'Low - Minor issue, no work disruption',
                'medium' => 'Medium - Some work disruption',
                'high' => 'High - Significant work disruption',
                'critical' => 'Critical - Complete work stoppage',
              ];
            @endphp

            <x-myds.select
              label="Priority Level"
              name="priority"
              :options="$priorityOptions"
              value="{{ old('priority') }}"
              placeholder="Select priority level..."
              required
              error="{{ $errors->first('priority') }}"
            />
          </div>
        </div>

        <!-- Attachments -->
        <div
          class="bg-bg-white border border-otl-gray-200 rounded-[var(--radius-m)] p-6"
        >
          <h2 class="myds-heading-xs text-txt-black-900 mb-4">Attachments</h2>
          <div class="space-y-4">
            <div>
              <label
                for="attachments"
                class="block myds-body-sm font-medium text-txt-black-700"
              >
                Photos or Documents
              </label>
              <div
                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-otl-gray-200 border-dashed rounded-[var(--radius-m)] hover:border-otl-gray-300"
              >
                <div class="space-y-1 text-center">
                  <svg
                    class="mx-auto h-12 w-12 text-txt-black-400"
                    stroke="currentColor"
                    fill="none"
                    viewBox="0 0 48 48"
                  >
                    <path
                      d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                      stroke-width="2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                    ></path>
                  </svg>
                  <div class="flex myds-body-sm text-txt-black-600">
                    <label
                      for="attachments"
                      class="relative cursor-pointer bg-bg-white rounded-[var(--radius-m)] font-medium text-txt-danger hover:text-txt-danger focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-fr-danger"
                    >
                      <span>Upload files</span>
                      <input
                        id="attachments"
                        name="attachments[]"
                        type="file"
                        class="sr-only"
                        multiple
                        accept=".jpg,.jpeg,.png,.pdf"
                      />
                    </label>
                    <p class="pl-1">or drag and drop</p>
                  </div>
                  <p class="myds-body-xs text-txt-black-500">
                    PNG, JPG, PDF up to 5MB each
                  </p>
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
          <a
            href="{{ route('public.my-requests') }}"
            class="myds-button myds-button-secondary px-6 py-3"
          >
            Cancel
          </a>
          <x-myds.button type="submit" variant="danger">
            Submit Complaint
          </x-myds.button>
        </div>
      </form>
    </div>
  </div>

  @push('scripts')
    @vite(['resources/js/damage-complaint.js'])
  @endpush
@endsection
