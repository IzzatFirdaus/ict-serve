@extends("layouts.public")

@section("title", "Request Status - ICT Serve")

@section("content")
  <div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900 mb-1">
            @if (isset($request))
              {{ __("Equipment Loan Request Status") }}
            @elseif (isset($ticket))
              {{ __("Support Ticket Status") }}
            @endif
          </h1>
          <p class="text-gray-600">
            {{ __("Current status and progress of your submission") }}
          </p>
        </div>
        <a
          href="{{ route("public.track") }}"
          class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
        >
          <svg
            class="w-4 h-4 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            />
          </svg>
          {{ __("Track Another") }}
        </a>
      </div>
    </div>

    @if (isset($request))
      <!-- Loan Request Details -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <!-- Header Section -->
        <div class="bg-primary-50 px-6 py-4 border-b">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-primary-900">
                {{ $request->request_number }}
              </h2>
              <p class="text-sm text-primary-700">
                {{ __("Submitted on :date", ["date" => $request->created_at->format('F j, Y \a\t g:i A')]) }}
              </p>
            </div>
            <div class="text-right">
              <span
                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium @if ($request->status->code === "pending")
                    bg-yellow-100
                    text-yellow-800
                @elseif ($request->status->code === "approved")
                    bg-success-100
                    text-success-800
                @elseif ($request->status->code === "active")
                    bg-primary-100
                    text-primary-800
                @elseif ($request->status->code === "returned")
                    bg-gray-100
                    text-gray-800
                @elseif ($request->status->code === "rejected")
                    bg-danger-100
                    text-danger-800
                @else
                    bg-gray-100
                    text-gray-800
                @endif"
              >
                {{ $request->status->name }}
              </span>
              @if ($request->priority)
                <p class="text-xs text-gray-600 mt-1">
                  {{ __("Priority: :priority", ["priority" => ucfirst(is_object($request->priority) && method_exists($request->priority, "value") ? (string) $request->priority->value : (string) $request->priority)]) }}
                </p>
              @endif
            </div>
          </div>
        </div>

        <!-- Content Section -->
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Borrower Information -->
            <div>
              <h3 class="text-sm font-semibold text-gray-900 mb-3">
                {{ __("Borrower Information") }}
              </h3>
              <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">{{ __("Name:") }}</dt>
                  <dd class="text-gray-900">{{ $request->user->name }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">{{ __("Email:") }}</dt>
                  <dd class="text-gray-900">{{ $request->user->email }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">
                    {{ __("Department:") }}
                  </dt>
                  <dd class="text-gray-900">
                    {{ $request->user->department }}
                  </dd>
                </div>
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">
                    {{ __("Division:") }}
                  </dt>
                  <dd class="text-gray-900">{{ $request->user->division }}</dd>
                </div>
              </dl>
            </div>

            <!-- Loan Details -->
            <div>
              <h3 class="text-sm font-semibold text-gray-900 mb-3">
                {{ __("Loan Details") }}
              </h3>
              <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">
                    {{ __("Start Date:") }}
                  </dt>
                  <dd class="text-gray-900">
                    {{ $request->loan_start_date->format("F j, Y") }}
                  </dd>
                </div>
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">
                    {{ __("End Date:") }}
                  </dt>
                  <dd class="text-gray-900">
                    {{ $request->loan_end_date->format("F j, Y") }}
                  </dd>
                </div>
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">
                    {{ __("Duration:") }}
                  </dt>
                  <dd class="text-gray-900">
                    {{ $request->loan_start_date->diffInDays($request->loan_end_date) }}
                    {{ __("days") }}
                  </dd>
                </div>
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">
                    {{ __("Location:") }}
                  </dt>
                  <dd class="text-gray-900">{{ $request->location }}</dd>
                </div>
              </dl>
            </div>
          </div>

          <!-- Purpose -->
          <div class="mt-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-2">
              {{ __("Purpose") }}
            </h3>
            <p class="text-sm text-gray-700 bg-gray-50 p-3 rounded-md">
              {{ $request->purpose }}
            </p>
          </div>

          <!-- Equipment Items -->
          <div class="mt-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-3">
              {{ __("Requested Equipment") }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
              @foreach ($request->loanItems as $loanItem)
                <div class="border border-gray-200 rounded-lg p-3">
                  <h4 class="font-medium text-gray-900">
                    {{ $loanItem->equipmentItem->brand }}
                    {{ $loanItem->equipmentItem->model }}
                  </h4>
                  <p class="text-xs text-gray-600">
                    {{ $loanItem->equipmentItem->category->name }}
                  </p>
                  @if ($loanItem->equipmentItem->serial_number)
                    <p class="text-xs text-gray-500 mt-1">
                      {{ __("S/N: :serial", ["serial" => $loanItem->equipmentItem->serial_number]) }}
                    </p>
                  @endif

                  <div class="mt-2">
                    <span
                      class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium @if ($loanItem->status === "pending")
                          bg-yellow-100
                          text-yellow-800
                      @elseif ($loanItem->status === "approved")
                          bg-success-100
                          text-success-800
                      @elseif ($loanItem->status === "active")
                          bg-primary-100
                          text-primary-800
                      @elseif ($loanItem->status === "returned")
                          bg-gray-100
                          text-gray-800
                      @elseif ($loanItem->status === "rejected")
                          bg-danger-100
                          text-danger-800
                      @else
                          bg-gray-100
                          text-gray-800
                      @endif"
                    >
                      {{ ucfirst(is_object($loanItem->status) && method_exists($loanItem->status, "value") ? (string) $loanItem->status->value : (string) $loanItem->status) }}
                    </span>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <!-- Status Updates/Notes -->
          @if ($request->notes)
            <div class="mt-6">
              <h3 class="text-sm font-semibold text-gray-900 mb-2">
                {{ __("Notes/Updates") }}
              </h3>
              <p
                class="text-sm text-gray-700 bg-blue-50 p-3 rounded-md border border-blue-200"
              >
                {{ $request->notes }}
              </p>
            </div>
          @endif

          <!-- Action Buttons -->
          @if ($request->status->code === "approved")
            <x-alert type="success" class="mt-6">
              <p class="font-medium">
                {{ __("Your request has been approved!") }}
              </p>
              <p class="text-sm mt-1">
                {{ __("Please contact our ICT office to arrange equipment collection.") }}
              </p>
            </x-alert>
          @elseif ($request->status->code === "rejected")
            <x-alert type="danger" class="mt-6">
              <p class="font-medium">
                {{ __("Your request has been declined.") }}
              </p>
              @if ($request->notes)
                <p class="text-sm mt-1">
                  {{ __("Reason: :reason", ["reason" => $request->notes]) }}
                </p>
              @endif

              <p class="text-sm mt-1">
                {{ __("You may submit a new request or contact our ICT team for assistance.") }}
              </p>
            </x-alert>
          @elseif ($request->status->code === "pending")
            <x-alert type="info" class="mt-6">
              <p class="font-medium">
                {{ __("Your request is being reviewed.") }}
              </p>
              <p class="text-sm mt-1">
                {{ __("You will receive an email notification once the review is complete.") }}
              </p>
            </x-alert>
          @endif
        </div>
      </div>
    @elseif (isset($ticket))
      <!-- Helpdesk Ticket Details -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-8">
        <!-- Header Section -->
        <div class="bg-warning-50 px-6 py-4 border-b">
          <div class="flex items-center justify-between">
            <div>
              <h2 class="text-lg font-semibold text-warning-900">
                {{ $ticket->ticket_number }}
              </h2>
              <p class="text-sm text-warning-700">
                {{ __("Submitted on :date", ["date" => $ticket->created_at->format('F j, Y \a\t g:i A')]) }}
              </p>
            </div>
            <div class="text-right">
              <span
                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium @if ($ticket->status->code === "new")
                    bg-blue-100
                    text-blue-800
                @elseif ($ticket->status->code === "open")
                    bg-yellow-100
                    text-yellow-800
                @elseif ($ticket->status->code === "in_progress")
                    bg-purple-100
                    text-purple-800
                @elseif ($ticket->status->code === "waiting")
                    bg-orange-100
                    text-orange-800
                @elseif ($ticket->status->code === "resolved")
                    bg-success-100
                    text-success-800
                @elseif ($ticket->status->code === "closed")
                    bg-gray-100
                    text-gray-800
                @else
                    bg-gray-100
                    text-gray-800
                @endif"
              >
                {{ $ticket->status->name }}
              </span>
              <p class="text-xs text-gray-600 mt-1">
                {{ __("Priority: :priority", ["priority" => ucfirst(is_object($ticket->priority) && method_exists($ticket->priority, "value") ? (string) $ticket->priority->value : (string) $ticket->priority)]) }}
              </p>
            </div>
          </div>
        </div>

        <!-- Content Section -->
        <div class="p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Reporter Information -->
            <div>
              <h3 class="text-sm font-semibold text-gray-900 mb-3">
                {{ __("Reporter Information") }}
              </h3>
              <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">{{ __("Name:") }}</dt>
                  <dd class="text-gray-900">{{ $ticket->user->name }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">{{ __("Email:") }}</dt>
                  <dd class="text-gray-900">{{ $ticket->user->email }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">
                    {{ __("Department:") }}
                  </dt>
                  <dd class="text-gray-900">
                    {{ $ticket->user->department }}
                  </dd>
                </div>
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">
                    {{ __("Location:") }}
                  </dt>
                  <dd class="text-gray-900">{{ $ticket->location }}</dd>
                </div>
              </dl>
            </div>

            <!-- Ticket Details -->
            <div>
              <h3 class="text-sm font-semibold text-gray-900 mb-3">
                {{ __("Ticket Details") }}
              </h3>
              <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">
                    {{ __("Category:") }}
                  </dt>
                  <dd class="text-gray-900">{{ $ticket->category->name }}</dd>
                </div>
                <div class="flex justify-between">
                  <dt class="font-medium text-gray-500">
                    {{ __("Priority:") }}
                  </dt>
                  <dd class="text-gray-900">
                    {{ ucfirst(is_object($ticket->priority) && method_exists($ticket->priority, "value") ? (string) $ticket->priority->value : (string) $ticket->priority) }}
                  </dd>
                </div>
                @if ($ticket->equipmentItem)
                  <div class="flex justify-between">
                    <dt class="font-medium text-gray-500">
                      {{ __("Equipment:") }}
                    </dt>
                    <dd class="text-gray-900">
                      {{ $ticket->equipmentItem->brand }}
                      {{ $ticket->equipmentItem->model }}
                    </dd>
                  </div>
                @endif

                @if ($ticket->due_at)
                  <div class="flex justify-between">
                    <dt class="font-medium text-gray-500">
                      {{ __("Due Date:") }}
                    </dt>
                    <dd class="text-gray-900">
                      {{ $ticket->due_at->format("F j, Y g:i A") }}
                    </dd>
                  </div>
                @endif
              </dl>
            </div>
          </div>

          <!-- Issue Title and Description -->
          <div class="mt-6">
            <h3 class="text-sm font-semibold text-gray-900 mb-2">
              {{ __("Issue Title") }}
            </h3>
            <p class="text-lg font-medium text-gray-900">
              {{ $ticket->title }}
            </p>
          </div>

          <div class="mt-4">
            <h3 class="text-sm font-semibold text-gray-900 mb-2">
              {{ __("Issue Description") }}
            </h3>
            <div class="text-sm text-gray-700 bg-gray-50 p-3 rounded-md">
              {!! nl2br(e($ticket->description)) !!}
            </div>
          </div>

          <!-- Attachments -->
          @if ($ticket->attachments && count($ticket->attachments) > 0)
            <div class="mt-6">
              <h3 class="text-sm font-semibold text-gray-900 mb-3">
                {{ __("Attachments") }}
              </h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach ($ticket->attachments as $attachment)
                  <div class="border border-gray-200 rounded-lg p-3">
                    <div class="flex items-center">
                      <svg
                        class="w-5 h-5 text-gray-400 mr-2"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                      >
                        <path
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"
                        />
                      </svg>
                      <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                          {{ $attachment["filename"] }}
                        </p>
                        <p class="text-xs text-gray-500">
                          {{ number_format($attachment["size"] / 1024, 2) }} KB
                        </p>
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endif

          <!-- Response Time Information -->
          @if ($ticket->status->code !== "closed")
            <div class="mt-6">
              <h3 class="text-sm font-semibold text-gray-900 mb-2">
                {{ __("Expected Response Time") }}
              </h3>
              <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                <p class="text-sm text-blue-800">
                  @if ($ticket->priority === "urgent")
                    {{ __("Urgent tickets are typically responded to within 2-4 hours during business hours.") }}
                  @elseif ($ticket->priority === "high")
                    {{ __("High priority tickets are typically responded to within 8-12 hours during business hours.") }}
                  @elseif ($ticket->priority === "medium")
                    {{ __("Medium priority tickets are typically responded to within 1-2 business days.") }}
                  @else
                    {{ __("Low priority tickets are typically responded to within 3-5 business days.") }}
                  @endif
                </p>
              </div>
            </div>
          @endif

          <!-- Status-specific messages -->
          @if ($ticket->status->code === "new")
            <x-alert type="info" class="mt-6">
              <p class="font-medium">
                {{ __("Your ticket has been submitted successfully.") }}
              </p>
              <p class="text-sm mt-1">
                {{ __("A technician will be assigned shortly and you will receive an update.") }}
              </p>
            </x-alert>
          @elseif ($ticket->status->code === "open" || $ticket->status->code === "in_progress")
            <x-alert type="success" class="mt-6">
              <p class="font-medium">
                {{ __("Your ticket is being actively worked on.") }}
              </p>
              <p class="text-sm mt-1">
                {{ __("You will receive updates as progress is made on resolving your issue.") }}
              </p>
            </x-alert>
          @elseif ($ticket->status->code === "waiting")
            <x-alert type="warning" class="mt-6">
              <p class="font-medium">
                {{ __("Waiting for additional information.") }}
              </p>
              <p class="text-sm mt-1">
                {{ __("Please check your email for any requests for additional information from our support team.") }}
              </p>
            </x-alert>
          @elseif ($ticket->status->code === "resolved")
            <x-alert type="success" class="mt-6">
              <p class="font-medium">
                {{ __("Your issue has been resolved!") }}
              </p>
              <p class="text-sm mt-1">
                {{ __("Please verify that the issue is fixed. If not, reply to the resolution email to reopen the ticket.") }}
              </p>
            </x-alert>
          @elseif ($ticket->status->code === "closed")
            <x-alert type="info" class="mt-6">
              <p class="font-medium">
                {{ __("This ticket has been closed.") }}
              </p>
              <p class="text-sm mt-1">
                {{ __("If you experience the same issue again, please submit a new ticket.") }}
              </p>
            </x-alert>
          @endif
        </div>
      </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-3 justify-center">
      <a
        href="{{ route("public.track") }}"
        class="inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white rounded-md text-sm font-medium hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
      >
        <svg
          class="w-4 h-4 mr-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
          />
        </svg>
        {{ __("Track Another Request") }}
      </a>

      @if (isset($request))
        <a
          href="{{ route("public.loan-requests.create") }}"
          class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
        >
          <svg
            class="w-4 h-4 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 6v6m0 0v6m0-6h6m-6 0H6"
            />
          </svg>
          {{ __("Submit New Loan Request") }}
        </a>
      @elseif (isset($ticket))
        <a
          href="{{ route("public.helpdesk.create") }}"
          class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
        >
          <svg
            class="w-4 h-4 mr-2"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 6v6m0 0v6m0-6h6m-6 0H6"
            />
          </svg>
          {{ __("Report Another Issue") }}
        </a>
      @endif

      <a
        href="{{ url("/") }}"
        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-gray-700 rounded-md text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors duration-200"
      >
        <svg
          class="w-4 h-4 mr-2"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
          />
        </svg>
        {{ __("Back to Home") }}
      </a>
    </div>

    <!-- Contact Information -->
    <div class="mt-8 pt-6 border-t border-gray-200 text-center">
      <p class="text-sm text-gray-600 mb-2">
        {{ __("Need help or have questions?") }}
      </p>
      <div class="text-sm text-gray-700 space-y-1">
        <p>
          <span class="font-medium">{{ __("Email:") }}</span>
          ict-support@example.gov.my
        </p>
        <p>
          <span class="font-medium">{{ __("Phone:") }}</span>
          +60 3-xxxx xxxx
        </p>
        <p>
          <span class="font-medium">{{ __("Emergency Hotline:") }}</span>
          +60 3-xxxx xxxx (24/7)
        </p>
        <p>
          <span class="font-medium">{{ __("Office Hours:") }}</span>
          {{ __("Monday - Friday, 8:00 AM - 5:00 PM") }}
        </p>
      </div>
    </div>
  </div>
@endsection
