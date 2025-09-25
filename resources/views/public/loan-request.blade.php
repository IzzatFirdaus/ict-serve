@extends('layouts.app')

@section('title', 'Equipment Loan Request')

@section('content')
  <div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow-lg">
      <div class="bg-primary-600 rounded-t-lg px-8 py-8">
        <h1 class="text-2xl font-bold text-white">Equipment Loan Request</h1>
        <div class="text-lg text-white opacity-80">
          Submit a request to borrow ICT equipment for official use
        </div>
      </div>
  <div class="p-8">
        @if (session('success'))
          <div class="p-4 mb-4 text-green-800 bg-green-100 rounded-lg">
            {{ session('success') }}
          </div>
        @endif

        <form method="POST" action="{{ route('public.loan-request.store') }}" autocomplete="on">
          @csrf
          <!-- Replace MYDS grid and card with divs and Tailwind classes -->
          <div class="grid grid-cols-12 gap-8">
            <div class="col-span-12 md:col-span-6">
              <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h2 class="text-lg font-semibold mb-4">Applicant Information</h2>
                <div class="grid grid-cols-2 gap-4">
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Position</label>
                    <input type="text" name="position" value="{{ auth()->user()->position ?? 'N/A' }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Department</label>
                    <input type="text" name="department" value="{{ auth()->user()->department ?? 'N/A' }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                  </div>
                  <div>
                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                    <input type="text" name="phone" value="{{ auth()->user()->phone ?? 'N/A' }}" readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                  </div>
                </div>
              </div>

              <x-ictserve.card>
                <x-ictserve.heading level="2" size="md">
                  Request Details
                </x-ictserve.heading>
                <x-ictserve.form-textarea
                  label="Purpose of Loan"
                  name="purpose"
                  value="{{ old('purpose') }}"
                  placeholder="Describe the purpose for borrowing this equipment..."
                  required
                  rows="3"
                  error="{{ $errors->first('purpose') }}"
                />
                <x-ictserve.form-input
                  label="Usage Location"
                  name="location"
                  value="{{ old('location') }}"
                  placeholder="Where will the equipment be used?"
                  required
                  error="{{ $errors->first('location') }}"
                />
                <x-ictserve.grid columns="2" gap="4">
                  <x-ictserve.grid-item span="1">
                    <x-ictserve.form-input
                      type="date"
                      label="From Date"
                      name="requested_from"
                      value="{{ old('requested_from') }}"
                      required
                      error="{{ $errors->first('requested_from') }}"
                      min="{{ date('Y-m-d') }}"
                    />
                  </x-ictserve.grid-item>
                  <x-ictserve.grid-item span="1">
                    <x-ictserve.form-input
                      type="date"
                      label="To Date"
                      name="requested_to"
                      value="{{ old('requested_to') }}"
                      required
                      error="{{ $errors->first('requested_to') }}"
                    />
                  </x-ictserve.grid-item>
                </x-ictserve.grid>
              </x-ictserve.card>

              <x-ictserve.card>
                <x-ictserve.heading level="2" size="md">
                  Equipment Requests
                </x-ictserve.heading>
                <div id="equipment-requests">
                  <x-ictserve.card>
                    <div class="flex justify-between items-center">
                      <x-ictserve.heading level="3" size="sm">
                        Equipment #1
                      </x-ictserve.heading>
                      <x-ictserve.button
                        type="button"
                        variant="danger"
                        size="sm"
                        class="remove-equipment"
                        x-cloak
                      >
                        <x-ictserve.icon name="x" size="16" />
                      </x-ictserve.button>
                    </div>
                    <x-ictserve.grid columns="3" gap="4">
                      <x-ictserve.grid-item span="2">
                        @php
                          $equipmentOptions = [];
                          foreach ($categories as $category) {
                            foreach ($category->equipmentItems as $equipment) {
                              $equipmentOptions[$equipment->id] = $category->name . ' - ' . $equipment->name;
                            }
                          }
                        @endphp

                        <x-ictserve.form-select
                          label="Equipment"
                          name="equipment_requests[0][equipment_id]"
                          :options="$equipmentOptions"
                          placeholder="Select equipment..."
                          required
                        />
                      </x-ictserve.grid-item>
                      <x-ictserve.grid-item span="1">
                        <x-ictserve.form-input
                          type="number"
                          label="Quantity"
                          name="equipment_requests[0][quantity]"
                          value="1"
                          min="1"
                          required
                        />
                      </x-ictserve.grid-item>
                    </x-ictserve.grid>
                    <x-ictserve.form-textarea
                      label="Notes"
                      name="equipment_requests[0][notes]"
                      placeholder="Additional notes for this equipment..."
                      rows="2"
                    />
                  </x-ictserve.card>
                </div>
                <x-ictserve.button
                  type="button"
                  id="add-equipment"
                  variant="outline"
                >
                  <x-ictserve.icon name="plus" size="16" class="mr-2" />
                  Add Another Equipment
                </x-ictserve.button>
              </x-ictserve.card>

              <x-ictserve.card>
                <x-ictserve.heading level="2" size="md">
                  Responsible Officer
                </x-ictserve.heading>
                <x-ictserve.checkbox
                  name="same_as_applicant"
                  value="1"
                  label="Same as applicant"
                />
                <x-ictserve.grid columns="3" gap="4">
                  <x-ictserve.grid-item span="1">
                    <x-ictserve.form-input
                      label="Name"
                      name="responsible_officer_name"
                      value="{{ old('responsible_officer_name') }}"
                      required
                      error="{{ $errors->first('responsible_officer_name') }}"
                    />
                  </x-ictserve.grid-item>
                  <x-ictserve.grid-item span="1">
                    <x-ictserve.form-input
                      label="Position"
                      name="responsible_officer_position"
                      value="{{ old('responsible_officer_position') }}"
                      required
                      error="{{ $errors->first('responsible_officer_position') }}"
                    />
                  </x-ictserve.grid-item>
                  <x-ictserve.grid-item span="1">
                    <x-ictserve.form-input
                      label="Phone"
                      name="responsible_officer_phone"
                      value="{{ old('responsible_officer_phone') }}"
                      required
                      error="{{ $errors->first('responsible_officer_phone') }}"
                    />
                  </x-ictserve.grid-item>
                </x-ictserve.grid>
              </x-ictserve.card>

              <x-ictserve.grid columns="2" gap="4" class="justify-end">
                <x-ictserve.grid-item span="1">
                  <x-ictserve.button
                    onclick="window.location='{{ route('public.my-requests') }}'"
                    variant="secondary"
                  >
                    Cancel
                  </x-myds.button>
                </x-myds.grid-item>
                <x-ictserve.grid-item span="1">
                  <x-ictserve.button type="submit" variant="primary">
                    Submit Request
                  </x-myds.button>
                </x-myds.grid-item>
              </x-myds.grid>
            </x-myds.grid-item>
          </x-myds.grid>
        </form>
      </div>
    </x-myds.card>
  </x-ictserve.container>

  @push('scripts')
    @vite(['resources/js/public/loan-request.js'])
  @endpush
@endsection
