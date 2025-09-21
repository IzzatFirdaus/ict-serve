<div
  class="bg-white min-h-screen"
  @if($autoRefresh) wire:poll.10s="refreshRequests" @endif
>
  <!-- Header Section -->
  <div class="bg-bg-primary-600 text-white py-8">
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold mb-2">
            {{ __("my_requests.title") }}
          </h1>
          <p class="text-bg-primary-                    <div class="flex items-center">
                      <x-myds.icon name="clock" size="16" class="mr-1">
                      {{ $request->created_at->diffForHumans() }}
                    </div>
                  </div>{{ __("my_requests.subtitle") }}</p>
        </div>

        <!-- Auto-refresh Toggle -->
        <div class="flex items-center space-x-4">
          @if ($autoRefresh)
            <div class="flex items-center space-x-2 text-bg-primary-100">
              <div
                class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"
              ></div>
              <span class="text-sm">
                {{ __("my_requests.auto_refreshing") }}
              </span>
            </div>
          @endif

          <x-myds.button
            wire:click="toggleAutoRefresh"
            variant="outline"
            size="sm"
            class="text-white border-white hover:bg-white hover:text-primary-600"
          >
            @if ($autoRefresh)
              <x-myds.icon name="pause" size="16" class="mr-1">
              {{ __("my_requests.stop_auto_refresh") }}
            @else
              <x-myds.icon name="refresh" size="16" class="mr-1">
              {{ __("my_requests.enable_auto_refresh") }}
            @endif
          </x-myds.button>

          <x-myds.button
            wire:click="refreshRequests"
            variant="outline"
            size="sm"
            iconOnly
            class="text-white border-white hover:bg-white hover:text-primary-600"
          >
            <x-myds.icon name="refresh" size="16">
          </x-myds.button>
        </div>
      </div>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="bg-gray-50 border-b">
    <div class="max-w-6xl mx-auto px-4 py-4">
        <div class="flex flex-wrap gap-4">
        <x-myds.button
          as="a"
          href="{{ route('public.loan-request') }}"
          variant="primary"
          size="sm"
          class="inline-flex items-center gap-2"
        >
          <x-myds.icon name="plus" size="16" class="mr-1" />
          {{ __("my_requests.new_loan_request") }}
        </x-myds.button>

        <x-myds.button
          as="a"
          href="{{ route('public.damage-complaint.guest') }}"
          variant="danger"
          size="sm"
          class="inline-flex items-center gap-2"
        >
          <x-myds.icon name="exclamation-triangle" size="16" class="mr-1" />
          {{ __("my_requests.report_damage") }}
        </x-myds.button>
      </div>
    </div>
  </div>

  <!-- Tabs and Filters -->
  <div class="max-w-6xl mx-auto px-4 py-6">
    <!-- Tab Navigation -->
    <div class="flex items-center justify-between mb-6">
      <div class="flex space-x-8">
        <button
          wire:click="setActiveTab('loans')"
          class="pb-2 text-sm font-medium border-b-2 transition-colors @if ($activeTab === "loans")
              border-otl-primary-300
              text-txt-primary
          @else
              border-transparent
              text-gray-500
              hover:text-gray-700
              hover:border-gray-300
          @endif"
        >
          {{ __("my_requests.tabs.loans") }}
          <span
            class="ml-1 px-2 py-0.5 text-xs rounded-full @if ($activeTab === "loans")
                bg-bg-primary-100
                text-txt-primary
            @else
                bg-gray-100
                text-gray-600
            @endif"
          >
            {{ $loanRequests->total() }}
          </span>
        </button>

        <button
          wire:click="setActiveTab('tickets')"
          class="pb-2 text-sm font-medium border-b-2 transition-colors @if ($activeTab === "tickets")
              border-otl-primary-300
              text-txt-primary
          @else
              border-transparent
              text-gray-500
              hover:text-gray-700
              hover:border-gray-300
          @endif"
        >
          {{ __("my_requests.tabs.tickets") }}
          <span
            class="ml-1 px-2 py-0.5 text-xs rounded-full @if ($activeTab === "tickets")
                bg-bg-primary-100
                text-txt-primary
            @else
                bg-gray-100
                text-gray-600
            @endif"
          >
            {{ $tickets->total() }}
          </span>
        </button>
      </div>

      <!-- Search -->
      <div class="flex items-center space-x-4">
        <div class="relative">
          <x-myds.form-input
            wire:model.live.debounce.300ms="search"
            type="text"
            placeholder="{{ __("my_requests.search_placeholder") }}"
            size="sm"
            class="pl-8 w-64"
            icon="<x-myds.icon name='search' size='16' class='text-gray-400'>"
          />
        </div>
      </div>
    </div>

    <!-- Status Filters -->
    <div class="mb-6">
      @if ($activeTab === "loans")
        <div class="flex flex-wrap gap-2">
          <x-myds.button
            wire:click="$set('loanStatus', '')"
            size="sm"
            :variant="($loanStatus === '') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.all_statuses") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('loanStatus', 'pending_supervisor')"
            size="sm"
            :variant="($loanStatus === 'pending_supervisor') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.pending_supervisor") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('loanStatus', 'approved_supervisor')"
            size="sm"
            :variant="($loanStatus === 'approved_supervisor') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.approved_supervisor") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('loanStatus', 'pending_ict')"
            size="sm"
            :variant="($loanStatus === 'pending_ict') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.pending_ict") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('loanStatus', 'approved_ict')"
            size="sm"
            :variant="($loanStatus === 'approved_ict') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.approved_ict") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('loanStatus', 'ready_pickup')"
            size="sm"
            :variant="($loanStatus === 'ready_pickup') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.ready_pickup") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('loanStatus', 'in_use')"
            size="sm"
            :variant="($loanStatus === 'in_use') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.in_use") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('loanStatus', 'returned')"
            size="sm"
            :variant="($loanStatus === 'returned') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.returned") }}
          </x-myds.button>
        </div>
      @else
        <div class="flex flex-wrap gap-2">
          <x-myds.button
            wire:click="$set('ticketStatus', '')"
            size="sm"
            :variant="($ticketStatus === '') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.all_statuses") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('ticketStatus', 'pending')"
            size="sm"
            :variant="($ticketStatus === 'pending') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.pending") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('ticketStatus', 'in_progress')"
            size="sm"
            :variant="($ticketStatus === 'in_progress') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.in_progress") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('ticketStatus', 'resolved')"
            size="sm"
            :variant="($ticketStatus === 'resolved') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.resolved") }}
          </x-myds.button>

          <x-myds.button
            wire:click="$set('ticketStatus', 'closed')"
            size="sm"
            :variant="($ticketStatus === 'closed') ? 'primary' : 'outline'"
          >
            {{ __("my_requests.filters.closed") }}
          </x-myds.button>
        </div>
      @endif
    </div>

    <!-- Content -->
    @if ($activeTab === "loans")
      <!-- Loan Requests -->
      @if ($loanRequests->count() > 0)
        <div class="space-y-4">
          @foreach ($loanRequests as $request)
            <div
              class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow"
            >
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="flex items-center space-x-3 mb-2">
                    <h3 class="text-lg font-semibold text-txt-primary">
                      {{ $request->request_number }}
                    </h3>

                    @php
            $statusConfig = match ($request->loanStatus->code ?? "pending_supervisor") {
              "pending_supervisor" => ["bg" => "bg-warning-100", "text" => "text-warning-800", "pulse" => true],
              "approved_supervisor" => ["bg" => "bg-bg-primary-100", "text" => "text-txt-primary", "pulse" => false],
              "pending_ict" => ["bg" => "bg-warning-100", "text" => "text-warning-800", "pulse" => true],
              "approved_ict" => ["bg" => "bg-success-100", "text" => "text-success-800", "pulse" => false],
              "ready_pickup" => ["bg" => "bg-success-100", "text" => "text-success-800", "pulse" => true],
              "in_use" => ["bg" => "bg-success-100", "text" => "text-success-800", "pulse" => false],
              "overdue" => ["bg" => "bg-danger-100", "text" => "text-danger-800", "pulse" => true],
              "returned" => ["bg" => "bg-gray-100", "text" => "text-gray-800", "pulse" => false],
              "rejected" => ["bg" => "bg-danger-100", "text" => "text-danger-800", "pulse" => false],
              "cancelled" => ["bg" => "bg-gray-200", "text" => "text-gray-600", "pulse" => false],
              default => ["bg" => "bg-gray-100", "text" => "text-gray-800", "pulse" => false],
            };
                    @endphp

                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusConfig["bg"] }} {{ $statusConfig["text"] }}"
                    >
                      @if ($statusConfig["pulse"])
                        <span class="flex h-2 w-2 mr-1">
                          <span
                            class="animate-ping absolute inline-flex h-2 w-2 rounded-full {{ str_replace("100", "400", $statusConfig["bg"]) }} opacity-75"
                          ></span>
                          <span
                            class="relative inline-flex rounded-full h-2 w-2 {{ str_replace("100", "500", $statusConfig["bg"]) }}"
                          ></span>
                        </span>
                      @endif

                      {{ $request->loanStatus->name ?? "Pending" }}
                    </span>
                  </div>

                  <p class="text-gray-900 mb-2">
                    {{ Str::limit($request->purpose, 100) }}
                  </p>

                  <div
                    class="flex items-center space-x-6 text-sm text-gray-500"
                  >
                    <div class="flex items-center">
                      <x-myds.icon name="calendar" size="16" class="mr-1">
                      {{ $request->requested_from->format("M j") }} -
                      {{ $request->requested_to->format("M j, Y") }}
                      <span class="ml-1">
                        ({{ $request->loan_duration }} days)
                      </span>
                    </div>

                    <div class="flex items-center">
                      <x-myds.icon name="clock" size="16" class="mr-1">
                      {{ $request->created_at->diffForHumans() }}
                    </div>

                    @if ($request->isOverdue())
                      <div class="flex items-center text-danger-600">
                        <x-myds.icon name="exclamation-triangle" size="16" class="mr-1">
                        {{ __("my_requests.status.overdue") }}
                      </div>
                    @endif
                  </div>
                </div>

                <div class="flex items-center space-x-2">
                  <x-myds.button
                    wire:click="showLoanDetails({{ $request->id }})"
                    variant="outline"
                    size="small"
                  >
                    {{ __("my_requests.view_details") }}
                  </x-myds.button>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
          {{ $loanRequests->links() }}
        </div>
      @else
        <!-- Empty State -->
        <div class="text-center py-12 bg-gray-50 rounded-lg">
          <x-myds.icon name="clipboard-list" size="48" class="mx-auto text-gray-400 mb-4">
          <h3 class="text-lg font-medium text-gray-900 mb-2">
            {{ __("my_requests.empty_loans.title") }}
          </h3>
          <p class="text-gray-500 mb-6">
            @if ($search || $loanStatus)
              {{ __("my_requests.empty_loans.filters_no_match") }}
            @else
              {{ __("my_requests.empty_loans.no_requests_yet") }}
            @endif
          </p>
          @if (! $search && ! $loanStatus)
            <a
              href="{{ route("public.loan-request") }}"
              class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors"
            >
              <x-myds.icon name="plus" size="16" class="mr-2">
              {{ __("my_requests.empty_loans.submit_new") }}
            </a>
          @endif
        </div>
      @endif
    @else
      <!-- Support Tickets -->
      @if ($tickets->count() > 0)
        <div class="space-y-4">
          @foreach ($tickets as $ticket)
            <div
              class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow"
            >
              <div class="flex items-start justify-between">
                <div class="flex-1">
                  <div class="flex items-center space-x-3 mb-2">
                    <h3 class="text-lg font-semibold text-danger-600">
                      {{ $ticket->ticket_number }}
                    </h3>

                    @php
                      $ticketStatusConfig = match ($ticket->status) {
                          "pending" => ["bg" => "bg-warning-100", "text" => "text-warning-800"],
                          "in_progress" => ["bg" => "bg-bg-primary-100", "text" => "text-txt-primary"],
                          "resolved" => ["bg" => "bg-success-100", "text" => "text-success-800"],
                          "closed" => ["bg" => "bg-gray-100", "text" => "text-gray-800"],
                          default => ["bg" => "bg-gray-100", "text" => "text-gray-800"],
                      };

                      $priorityConfig = match ($ticket->priority) {
                          "low" => ["bg" => "bg-success-100", "text" => "text-success-800"],
                          "medium" => ["bg" => "bg-warning-100", "text" => "text-warning-800"],
                          "high" => ["bg" => "bg-danger-100", "text" => "text-danger-800"],
                          "critical" => ["bg" => "bg-danger-200", "text" => "text-danger-900"],
                          default => ["bg" => "bg-gray-100", "text" => "text-gray-800"],
                      };
                    @endphp

                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $ticketStatusConfig["bg"] }} {{ $ticketStatusConfig["text"] }}"
                    >
                      {{ ucfirst(is_object($ticket->status) && method_exists($ticket->status, "value") ? (string) $ticket->status->value : (string) $ticket->status) }}
                    </span>

                    <span
                      class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityConfig["bg"] }} {{ $priorityConfig["text"] }}"
                    >
                      {{ ucfirst(is_object($ticket->priority) && method_exists($ticket->priority, "value") ? (string) $ticket->priority->value : (string) $ticket->priority) }}
                    </span>
                  </div>

                  <h4 class="text-gray-900 font-medium mb-2">
                    {{ $ticket->title }}
                  </h4>
                  <p class="text-gray-600 text-sm mb-2">
                    {{ Str::limit($ticket->description, 150) }}
                  </p>

                  <div
                    class="flex items-center space-x-6 text-sm text-gray-500"
                  >
                    <div class="flex items-center">
                      <x-myds.icon name="user" size="16" class="mr-1">
                      {{ $ticket->assignedTo?->name ?? "Unassigned" }}
                    </div>

                    <div class="flex items-center">
                      <x-myds.icon name="clock" size="16" class="mr-1">
                      {{ $ticket->created_at->diffForHumans() }}
                    </div>
                  </div>
                </div>

                <div class="flex items-center space-x-2">
                  <x-myds.button
                    wire:click="showTicketDetails({{ $ticket->id }})"
                    variant="outline"
                    size="small"
                  >
                    View Details
                  </x-myds.button>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
          {{ $tickets->links() }}
        </div>
      @else
        <!-- Empty State -->
        <div class="text-center py-12 bg-gray-50 rounded-lg">
          <x-myds.icon name="exclamation-triangle" size="48" class="mx-auto text-gray-400 mb-4">
          <h3 class="text-lg font-medium text-gray-900 mb-2">
            {{ __("my_requests.empty_tickets.title") }}
          </h3>
          <p class="text-gray-500 mb-6">
            @if ($search || $ticketStatus)
              {{ __("my_requests.empty_tickets.filters_no_match") }}
            @else
              {{ __("my_requests.empty_tickets.no_tickets_yet") }}
            @endif
          </p>
          @if (! $search && ! $ticketStatus)
            <a
              href="{{ route("public.damage-complaint.guest") }}"
              class="inline-flex items-center px-4 py-2 bg-danger-600 text-white rounded-md hover:bg-danger-700 transition-colors"
            >
              <x-myds.icon name="exclamation-triangle" size="16" class="mr-2">
              {{ __("my_requests.empty_tickets.report_issue") }}
            </a>
          @endif
        </div>
      @endif
    @endif
  </div>

  <!-- Loan Request Detail Modal -->
  @if ($showLoanModal && $selectedLoanRequest)
    <div
      class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
    >
      <div class="relative min-h-screen flex items-center justify-center p-4">
        <div
          class="relative bg-white rounded-lg shadow-xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
        >
          <div
            class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between"
          >
            <h3 class="text-lg font-semibold text-gray-900">
              Loan Request Details
            </h3>
            <x-myds.button
              wire:click="closeLoanModal"
              variant="ghost"
              class="text-txt-black-400 hover:text-txt-black-600"
            >
              <x-myds.icon name="x" size="24">
            </x-myds.button>
          </div>

          <div class="p-6">
            <livewire:loan-request-tracker
              :loan-request="$selectedLoanRequest"
              :key="'loan-tracker-' . $selectedLoanRequest->id"
              :polling="true"
              poll-interval="10s"
            />
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- Support Ticket Detail Modal -->
  @if ($showTicketModal && $selectedTicket)
    <div
      class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50"
    >
      <div class="relative min-h-screen flex items-center justify-center p-4">
        <div
          class="relative bg-white rounded-lg shadow-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto"
        >
          <div
            class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between"
          >
            <h3 class="text-lg font-semibold text-gray-900">Ticket Details</h3>
            <x-myds.button
              wire:click="closeTicketModal"
              variant="ghost"
              class="text-txt-black-400 hover:text-txt-black-600"
            >
              <x-myds.icon name="x" size="24">
            </x-myds.button>
          </div>

          <div class="p-6">
            <div class="space-y-6">
              <div>
                <h4 class="text-lg font-semibold text-gray-900">
                  {{ $selectedTicket->title }}
                </h4>
                <p class="text-sm text-gray-500 mt-1">
                  Ticket #{{ $selectedTicket->ticket_number }}
                </p>
              </div>

              <div class="prose prose-sm max-w-none">
                <p>{{ $selectedTicket->description }}</p>
              </div>

              <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                  <label class="font-medium text-gray-900">Status</label>
                  <p class="text-gray-600">
                    {{ ucfirst(is_object($selectedTicket->status) && method_exists($selectedTicket->status, "value") ? (string) $selectedTicket->status->value : (string) $selectedTicket->status) }}
                  </p>
                </div>
                <div>
                  <label class="font-medium text-gray-900">Priority</label>
                  <p class="text-gray-600">
                    {{ ucfirst(is_object($selectedTicket->priority) && method_exists($selectedTicket->priority, "value") ? (string) $selectedTicket->priority->value : (string) $selectedTicket->priority) }}
                  </p>
                </div>
                <div>
                  <label class="font-medium text-gray-900">Assigned To</label>
                  <p class="text-gray-600">
                    {{ $selectedTicket->assignedTo?->name ?? "Unassigned" }}
                  </p>
                </div>
                <div>
                  <label class="font-medium text-gray-900">Created</label>
                  <p class="text-gray-600">
                    {{ $selectedTicket->created_at->format('M j, Y \a\t g:i A') }}
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif

  <!-- Notifications -->
  <div
    x-data="{
        show: false,
        message: '',
        type: 'success',
        showNotification(message, type = 'success') {
            this.message = message
            this.type = type
            this.show = true
            setTimeout(() => {
                this.show = false
            }, 3000)
        },
    }"
    @auto-refresh-enabled.window="showNotification('Auto-refresh enabled', 'info')"
    @auto-refresh-disabled.window="showNotification('Auto-refresh disabled', 'info')"
    @requests-refreshed.window="showNotification('Requests updated', 'success')"
  >
    <div
      x-show="show"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 transform translate-y-2 scale-95"
      x-transition:enter-end="opacity-100 transform translate-y-0 scale-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="opacity-100 transform translate-y-0 scale-100"
      x-transition:leave-end="opacity-0 transform translate-y-2 scale-95"
      class="fixed bottom-4 right-4 z-50"
    >
      <div
        :class="{
                 'bg-bg-success-600': type === 'success',
                'bg-bg-primary-600': type === 'info',
                 'bg-bg-danger-600': type === 'error'
            }"
        class="text-txt-white px-4 py-3 rounded-lg shadow-lg max-w-sm"
      >
        <p class="text-sm font-medium" x-text="message"></p>
      </div>
    </div>
  </div>
</div>
