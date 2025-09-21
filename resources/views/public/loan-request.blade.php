@extends('layouts.app')

@section('title', 'Equipment Loan Request')

@section('content')
  <x-myds.container>
    <x-myds.card>
      <div class="bg-primary-600 rounded-t-lg px-8 py-8">
        <x-myds.heading level="1" size="lg" class="text-txt-white">
          Equipment Loan Request
        </x-myds.heading>
        <div class="text-lg text-txt-white opacity-80">
          Submit a request to borrow ICT equipment for official use
        </div>
      </div>
      <div class="p-8">
        @if (session('success'))
          <x-myds.callout variant="success">
            <x-slot name="icon">
              <x-myds.icon name="check-circle" size="20" />
            </x-slot>
            {{ session('success') }}
          </x-myds.callout>
        @endif

        <form
          method="POST"
          action="{{ route('public.loan-request.store') }}"
          autocomplete="on"
        >
          @csrf
          <x-myds.grid columns="12" gap="8">
            <x-myds.grid-item span="6">
              <x-myds.card>
                <x-myds.heading level="2" size="md">
                  Applicant Information
                </x-myds.heading>
                <x-myds.grid columns="2" gap="4">
                  <x-myds.grid-item span="1">
                    <x-myds.form-input
                      label="Name"
                      name="name"
                      value="{{ auth()->user()->name }}"
                      readonly
                    />
                  </x-myds.grid-item>
                  <x-myds.grid-item span="1">
                    <x-myds.form-input
                      label="Position"
                      name="position"
                      value="{{ auth()->user()->position ?? 'N/A' }}"
                      readonly
                    />
                  </x-myds.grid-item>
                  <x-myds.grid-item span="1">
                    <x-myds.form-input
                      label="Department"
                      name="department"
                      value="{{ auth()->user()->department ?? 'N/A' }}"
                      readonly
                    />
                  </x-myds.grid-item>
                  <x-myds.grid-item span="1">
                    <x-myds.form-input
                      label="Phone"
                      name="phone"
                      value="{{ auth()->user()->phone ?? 'N/A' }}"
                      readonly
                    />
                  </x-myds.grid-item>
                </x-myds.grid>
              </x-myds.card>

              <x-myds.card>
                <x-myds.heading level="2" size="md">
                  Request Details
                </x-myds.heading>
                <x-myds.form-textarea
                  label="Purpose of Loan"
                  name="purpose"
                  value="{{ old('purpose') }}"
                  placeholder="Describe the purpose for borrowing this equipment..."
                  required
                  rows="3"
                  error="{{ $errors->first('purpose') }}"
                />
                <x-myds.form-input
                  label="Usage Location"
                  name="location"
                  value="{{ old('location') }}"
                  placeholder="Where will the equipment be used?"
                  required
                  error="{{ $errors->first('location') }}"
                />
                <x-myds.grid columns="2" gap="4">
                  <x-myds.grid-item span="1">
                    <x-myds.form-input
                      type="date"
                      label="From Date"
                      name="requested_from"
                      value="{{ old('requested_from') }}"
                      required
                      error="{{ $errors->first('requested_from') }}"
                      min="{{ date('Y-m-d') }}"
                    />
                  </x-myds.grid-item>
                  <x-myds.grid-item span="1">
                    <x-myds.form-input
                      type="date"
                      label="To Date"
                      name="requested_to"
                      value="{{ old('requested_to') }}"
                      required
                      error="{{ $errors->first('requested_to') }}"
                    />
                  </x-myds.grid-item>
                </x-myds.grid>
              </x-myds.card>

              <x-myds.card>
                <x-myds.heading level="2" size="md">
                  Equipment Requests
                </x-myds.heading>
                <div id="equipment-requests">
                  <x-myds.card>
                    <div class="flex justify-between items-center">
                      <x-myds.heading level="3" size="sm">
                        Equipment #1
                      </x-myds.heading>
                      <x-myds.button
                        type="button"
                        variant="danger"
                        size="sm"
                        class="remove-equipment"
                        x-cloak
                      >
                        <x-myds.icon name="x" size="16" />
                      </x-myds.button>
                    </div>
                    <x-myds.grid columns="3" gap="4">
                      <x-myds.grid-item span="2">
                        @php
                          $equipmentOptions = [];
                          foreach ($categories as $category) {
                            foreach ($category->equipmentItems as $equipment) {
                              $equipmentOptions[$equipment->id] = $category->name . ' - ' . $equipment->name;
                            }
                          }
                        @endphp

                        <x-myds.form-select
                          label="Equipment"
                          name="equipment_requests[0][equipment_id]"
                          :options="$equipmentOptions"
                          placeholder="Select equipment..."
                          required
                        />
                      </x-myds.grid-item>
                      <x-myds.grid-item span="1">
                        <x-myds.form-input
                          type="number"
                          label="Quantity"
                          name="equipment_requests[0][quantity]"
                          value="1"
                          min="1"
                          required
                        />
                      </x-myds.grid-item>
                    </x-myds.grid>
                    <x-myds.form-textarea
                      label="Notes"
                      name="equipment_requests[0][notes]"
                      placeholder="Additional notes for this equipment..."
                      rows="2"
                    />
                  </x-myds.card>
                </div>
                <x-myds.button
                  type="button"
                  id="add-equipment"
                  variant="outline"
                >
                  <x-myds.icon name="plus" size="16" class="mr-2" />
                  Add Another Equipment
                </x-myds.button>
              </x-myds.card>

              <x-myds.card>
                <x-myds.heading level="2" size="md">
                  Responsible Officer
                </x-myds.heading>
                <x-myds.checkbox
                  name="same_as_applicant"
                  value="1"
                  label="Same as applicant"
                />
                <x-myds.grid columns="3" gap="4">
                  <x-myds.grid-item span="1">
                    <x-myds.form-input
                      label="Name"
                      name="responsible_officer_name"
                      value="{{ old('responsible_officer_name') }}"
                      required
                      error="{{ $errors->first('responsible_officer_name') }}"
                    />
                  </x-myds.grid-item>
                  <x-myds.grid-item span="1">
                    <x-myds.form-input
                      label="Position"
                      name="responsible_officer_position"
                      value="{{ old('responsible_officer_position') }}"
                      required
                      error="{{ $errors->first('responsible_officer_position') }}"
                    />
                  </x-myds.grid-item>
                  <x-myds.grid-item span="1">
                    <x-myds.form-input
                      label="Phone"
                      name="responsible_officer_phone"
                      value="{{ old('responsible_officer_phone') }}"
                      required
                      error="{{ $errors->first('responsible_officer_phone') }}"
                    />
                  </x-myds.grid-item>
                </x-myds.grid>
              </x-myds.card>

              <x-myds.grid columns="2" gap="4" class="justify-end">
                <x-myds.grid-item span="1">
                  <x-myds.button
                    onclick="window.location='{{ route('public.my-requests') }}'"
                    variant="secondary"
                  >
                    Cancel
                  </x-myds.button>
                </x-myds.grid-item>
                <x-myds.grid-item span="1">
                  <x-myds.button type="submit" variant="primary">
                    Submit Request
                  </x-myds.button>
                </x-myds.grid-item>
              </x-myds.grid>
            </x-myds.grid-item>
          </x-myds.grid>
        </form>
      </div>
    </x-myds.card>
  </x-myds.container>

  @push('scripts')
    @vite(['resources/js/public/loan-request.js'])
  @endpush
@endsection
