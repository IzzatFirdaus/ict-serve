@extends('layouts.public')

@section('title', 'Track Request Status - ICT Serve')

@section('content')
  <div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="text-center mb-8">
      <h1 class="text-3xl font-bold text-primary-700 mb-2">
        {{ __('Track Request Status') }}
      </h1>
      <p class="text-gray-600 max-w-2xl mx-auto">
        {{ __('Enter your request number or ticket number to check the current status and progress of your submission.') }}
      </p>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
      <form
        action="{{ route('public.track') }}"
        method="POST"
        class="space-y-4"
      >
        @csrf
        <div class="flex flex-col md:flex-row gap-4">
          <div class="flex-1">
            <x-myds.label for="tracking_number">
              {{ __('Request/Ticket Number') }}
            </x-myds.label>
            <x-myds.input
              id="tracking_number"
              name="tracking_number"
              :value="request('tracking_number') ?? old('tracking_number')"
              placeholder="{{ __('e.g., REQ-20241210-ABC123 or TKT-20241210-XYZ456') }}"
              required
            />
            @error('tracking_number')
              <x-myds.callout type="danger" class="mt-2">
                {{ $message }}
              </x-myds.callout>
            @enderror
          </div>
          <div class="flex items-end">
            <x-myds.button
              type="submit"
              variant="primary"
              class="whitespace-nowrap"
            >
              <x-myds.icon
                name="search"
                size="16"
                class="mr-2 inline"
                aria-hidden="true"
              />
              {{ __('Track Status') }}
            </x-myds.button>
          </div>
        </div>
      </form>

      <!-- Info Alert -->
      <x-alert type="info" class="mt-4">
        <p class="text-sm">
          <span class="font-medium">{{ __('Tips:') }}</span>
          {{ __('Request numbers start with "REQ-" and ticket numbers start with "TKT-". You can find these in your confirmation email.') }}
        </p>
      </x-alert>
    </div>

    @if (session('error'))
      <x-alert type="danger" class="mb-8">
        {{ session('error') }}
      </x-alert>
    @endif

    <!-- Quick Access Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
      <div class="bg-white rounded-lg shadow p-6 text-center">
        <div
          class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-4"
        >
          <svg
            class="w-6 h-6 text-primary-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
          </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
          {{ __('Equipment Loan Request') }}
        </h3>
        <p class="text-gray-600 text-sm mb-4">
          {{ __('Need equipment for your work? Submit a loan request with no login required.') }}
        </p>
        <x-myds.button
          as="a"
          href="{{ route('public.loan-requests.create') }}"
          variant="primary"
          class="inline-flex items-center"
        >
          {{ __('Submit Loan Request') }}
          <x-myds.icon
            name="arrow-right"
            size="16"
            class="ml-2"
            aria-hidden="true"
          />
        </x-myds.button>
      </div>

      <div class="bg-white rounded-lg shadow p-6 text-center">
        <div
          class="w-12 h-12 bg-warning-100 rounded-full flex items-center justify-center mx-auto mb-4"
        >
          <svg
            class="w-6 h-6 text-warning-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 3v6m0 6v6m6-12h-6m-6 0h6"
            />
          </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">
          {{ __('ICT Support Ticket') }}
        </h3>
        <p class="text-gray-600 text-sm mb-4">
          {{ __('Experiencing technical issues? Report them and get professional support.') }}
        </p>
        <x-myds.button
          as="a"
          href="{{ route('public.helpdesk.create') }}"
          variant="warning"
          class="inline-flex items-center"
        >
          {{ __('Report Issue') }}
          <x-myds.icon
            name="arrow-right"
            size="16"
            class="ml-2"
            aria-hidden="true"
          />
        </x-myds.button>
      </div>
    </div>

    <!-- Status Legends -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Loan Request Status Legend -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
          <svg
            class="w-5 h-5 text-primary-600 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
          </svg>
          {{ __('Loan Request Status') }}
        </h3>
        <div class="space-y-3">
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 w-20 justify-center"
            >
              {{ __('Pending') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Awaiting review and approval') }}
            </span>
          </div>
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-success-100 text-success-800 w-20 justify-center"
            >
              {{ __('Approved') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Approved, ready for collection') }}
            </span>
          </div>
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800 w-20 justify-center"
            >
              {{ __('Active') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Equipment currently on loan') }}
            </span>
          </div>
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 w-20 justify-center"
            >
              {{ __('Returned') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Equipment returned successfully') }}
            </span>
          </div>
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-danger-100 text-danger-800 w-20 justify-center"
            >
              {{ __('Rejected') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Request declined with reason') }}
            </span>
          </div>
        </div>
      </div>

      <!-- Helpdesk Ticket Status Legend -->
      <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
          <svg
            class="w-5 h-5 text-warning-600 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 3v6m0 6v6m6-12h-6m-6 0h6"
            />
          </svg>
          {{ __('Support Ticket Status') }}
        </h3>
        <div class="space-y-3">
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 w-20 justify-center"
            >
              {{ __('New') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Recently submitted, awaiting assignment') }}
            </span>
          </div>
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 w-20 justify-center"
            >
              {{ __('Open') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Assigned to technician, work in progress') }}
            </span>
          </div>
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 w-20 justify-center"
            >
              {{ __('In Progress') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Actively being worked on') }}
            </span>
          </div>
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 w-20 justify-center"
            >
              {{ __('Waiting') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Waiting for user response or action') }}
            </span>
          </div>
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-success-100 text-success-800 w-20 justify-center"
            >
              {{ __('Resolved') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Issue resolved, awaiting confirmation') }}
            </span>
          </div>
          <div class="flex items-center">
            <span
              class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 w-20 justify-center"
            >
              {{ __('Closed') }}
            </span>
            <span class="ml-3 text-sm text-gray-600">
              {{ __('Ticket closed and archived') }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
