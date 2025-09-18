{{--
  ICTServe (iServe) Loan Detail View Component
  MYDS & MyGovEA Compliance:
    - Structure: Uses 12-8-4 grid, consistent spacing (MYDS-Design-Overview.md: Grid, Spacing).
    - Colour: All backgrounds, borders, text, icons use MYDS tokens (MYDS-Colour-Reference.md).
    - Typography: Inter for body, Poppins for headings (MYDS-Develop-Overview.md).
    - Icons: Only MYDS icon set, 20x20, stroke 1.5px (MYDS-Icons-Overview.md).
    - Accessibility: Semantic headings, clear focus states, ARIA where needed, status indicators never use colour alone.
    - Minimalism, clarity, actionable feedback, citizen-centric (prinsip-reka-bentuk-mygovea.md).
--}}

@props(['loanRequest'])

<div class="loan-detail-view max-w-6xl mx-auto space-y-8">
    <!-- Header Section -->
    <div class="bg-bg-white rounded-lg shadow-card border border-otl-divider p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-bold text-txt-black-900 font-poppins">{{ $loanRequest->request_number }}</h1>
                <p class="text-sm text-txt-black-500 mt-1">
                    Submitted on {{ $loanRequest->created_at->format('F j, Y \a\t g:i A') }}
                </p>
            </div>

            <div class="flex items-center space-x-3">
                <!-- Status Badge -->
                @php
                    $statusConfig = match($loanRequest->loanStatus->code ?? 'pending') {
                        'pending_supervisor' => ['bg' => 'bg-warning-100', 'text' => 'text-warning-700', 'icon' => 'clock'],
                        'approved_supervisor' => ['bg' => 'bg-primary-100', 'text' => 'text-txt-primary', 'icon' => 'check-circle'],
                        'pending_ict' => ['bg' => 'bg-warning-100', 'text' => 'text-warning-700', 'icon' => 'clock'],
                        'approved_ict' => ['bg' => 'bg-success-100', 'text' => 'text-success-700', 'icon' => 'check-circle'],
                        'equipment_assigned' => ['bg' => 'bg-primary-100', 'text' => 'text-txt-primary', 'icon' => 'clipboard-list'],
                        'ready_pickup' => ['bg' => 'bg-success-100', 'text' => 'text-success-700', 'icon' => 'cube'],
                        'in_use' => ['bg' => 'bg-success-100', 'text' => 'text-success-700', 'icon' => 'check-circle'],
                        'overdue' => ['bg' => 'bg-danger-100', 'text' => 'text-danger-700', 'icon' => 'exclamation-triangle'],
                        'returned' => ['bg' => 'bg-black-100', 'text' => 'text-txt-black-700', 'icon' => 'check-circle'],
                        'rejected' => ['bg' => 'bg-danger-100', 'text' => 'text-txt-danger', 'icon' => 'x-circle'],
                        default => ['bg' => 'bg-black-100', 'text' => 'text-txt-black-700', 'icon' => 'clock']
                    };
                @endphp

                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                    @include('components.icon', ['name' => $statusConfig['icon'], 'class' => 'w-4 h-4 mr-2'])
                    <span>{{ $loanRequest->loanStatus->name ?? 'Pending' }}</span>
                </span>

                <!-- Action Menu -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            type="button"
                            class="myds-button myds-button-secondary myds-btn-outline myds-btn-sm focus-visible:ring-2 focus-visible:ring-fr-primary"
                            aria-haspopup="menu" aria-expanded="open"
                    >
                        @include('components.icon', ['name' => 'dots-vertical', 'class' => 'w-4 h-4'])
                        <span class="sr-only">Open actions</span>
                    </button>

                    <div x-show="open"
                        @click.away="open = false"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-48 bg-bg-white rounded-md shadow-context-menu border border-otl-divider z-10"
                        x-cloak
                        role="menu"
                        aria-orientation="vertical"
                        tabindex="-1"
                    >
                        <div class="py-1">
                            @if($loanRequest->canBeEdited())
                                <a href="#" class="block px-4 py-2 text-sm text-txt-black-700 hover:bg-bg-gray-50 focus:bg-bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded-md transition-colors duration-100" role="menuitem" tabindex="0">
                                    @include('components.icon', ['name' => 'edit', 'class' => 'w-4 h-4 mr-2 inline'])
                                    Edit Request
                                </a>
                            @endif

                            <a href="#" class="block px-4 py-2 text-sm text-txt-black-700 hover:bg-bg-gray-50 focus:bg-bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded-md transition-colors duration-100" role="menuitem" tabindex="0">
                                @include('components.icon', ['name' => 'download', 'class' => 'w-4 h-4 mr-2 inline'])
                                Download PDF
                            </a>

                            <a href="#" class="block px-4 py-2 text-sm text-txt-black-700 hover:bg-bg-gray-50 focus:bg-bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded-md transition-colors duration-100" role="menuitem" tabindex="0">
                                @include('components.icon', ['name' => 'share', 'class' => 'w-4 h-4 mr-2 inline'])
                                Share
                            </a>

                            @if($loanRequest->canBeCancelled())
                                <hr class="my-1 border-otl-divider">
                                <a href="#" class="block px-4 py-2 text-sm text-txt-danger hover:bg-warning-50 focus:bg-warning-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-fr-danger rounded-md transition-colors duration-100" role="menuitem" tabindex="0">
                                    @include('components.icon', ['name' => 'x-circle', 'class' => 'w-4 h-4 mr-2 inline'])
                                    Cancel Request
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Tracker -->
    <x-loan-status-tracker :loan-request="$loanRequest" :polling="true" />

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column - Request Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Request Information -->
            <div class="bg-bg-white rounded-lg shadow-card border border-otl-divider p-6">
                <h3 class="text-lg font-semibold text-txt-black-900 mb-4 font-poppins">Request Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-txt-black-500">Purpose</label>
                        <p class="text-sm text-txt-black-900 mt-1">{{ $loanRequest->purpose }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-txt-black-500">Location</label>
                        <p class="text-sm text-txt-black-900 mt-1">{{ $loanRequest->location ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-txt-black-500">Requested Period</label>
                        <p class="text-sm text-txt-black-900 mt-1">
                            {{ $loanRequest->requested_from->format('M j, Y') }} -
                            {{ $loanRequest->requested_to->format('M j, Y') }}
                            <span class="text-txt-black-500">({{ $loanRequest->loan_duration }} days)</span>
                        </p>
                    </div>
                    @if($loanRequest->actual_from && $loanRequest->actual_to)
                    <div>
                        <label class="text-sm font-medium text-txt-black-500">Actual Period</label>
                        <p class="text-sm text-txt-black-900 mt-1">
                            {{ $loanRequest->actual_from->format('M j, Y') }} -
                            {{ $loanRequest->actual_to->format('M j, Y') }}
                        </p>
                    </div>
                    @endif
                </div>
                @if($loanRequest->notes)
                <div class="mt-4">
                    <label class="text-sm font-medium text-txt-black-500">Additional Notes</label>
                    <p class="text-sm text-txt-black-900 mt-1">{{ $loanRequest->notes }}</p>
                </div>
                @endif
            </div>

            <!-- Equipment Details -->
            @if($loanRequest->equipment_requests)
            <div class="bg-bg-white rounded-lg shadow-card border border-otl-divider p-6">
                <h3 class="text-lg font-semibold text-txt-black-900 mb-4 font-poppins">Equipment Requested</h3>
                <div class="space-y-4">
                    @foreach($loanRequest->equipment_requests as $equipment)
                    <div class="flex items-center justify-between p-4 bg-bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                                @include('components.icon', ['name' => 'desktop-computer', 'class' => 'w-6 h-6 text-txt-primary'])
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-txt-black-900">{{ $equipment['name'] ?? 'Equipment' }}</h4>
                                <p class="text-sm text-txt-black-500">{{ $equipment['description'] ?? 'No description' }}</p>
                                @if(isset($equipment['specifications']))
                                    <p class="text-xs text-txt-black-500 mt-1">{{ $equipment['specifications'] }}</p>
                                @endif
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-medium text-txt-black-900">Qty: {{ $equipment['quantity'] ?? 1 }}</span>
                            @if(isset($equipment['status']))
                                <p class="text-xs text-txt-black-500">{{ ucfirst($equipment['status']) }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Loan Items (Assigned Equipment) -->
            @if($loanRequest->loanItems && $loanRequest->loanItems->count() > 0)
            <div class="bg-bg-white rounded-lg shadow-card border border-otl-divider p-6">
                <h3 class="text-lg font-semibold text-txt-black-900 mb-4 font-poppins">Assigned Equipment</h3>
                <div class="space-y-4">
                    @foreach($loanRequest->loanItems as $item)
                    <div class="flex items-center justify-between p-4 border border-otl-divider rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center">
                                @include('components.icon', ['name' => 'cube', 'class' => 'w-6 h-6 text-success-600'])
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-txt-black-900">{{ $item->equipmentItem->name }}</h4>
                                <p class="text-sm text-txt-black-500">{{ $item->equipmentItem->description }}</p>
                                <p class="text-xs text-txt-black-500">Serial: {{ $item->equipmentItem->serial_number }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-sm font-medium text-txt-black-900">Qty: {{ $item->quantity }}</span>
                            @if($item->condition_out)
                                <p class="text-xs text-txt-black-500">Condition: {{ ucfirst($item->condition_out) }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Signatures -->
            @if($loanRequest->pickup_signature_path || $loanRequest->return_signature_path)
            <div class="bg-bg-white rounded-lg shadow-card border border-otl-divider p-6">
                <h3 class="text-lg font-semibold text-txt-black-900 mb-4 font-poppins">Digital Signatures</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($loanRequest->pickup_signature_path)
                    <div>
                        <h4 class="text-sm font-medium text-txt-black-900 mb-2">Pickup Signature</h4>
                        <div class="border border-otl-divider rounded-lg p-4 bg-bg-gray-50">
                            <img src="{{ Storage::url($loanRequest->pickup_signature_path) }}"
                                 alt="Pickup Signature"
                                 class="max-w-full h-auto">
                        </div>
                        <p class="text-xs text-txt-black-500 mt-2">
                            Signed on {{ $loanRequest->issued_at->format('M j, Y \a\t g:i A') }}
                        </p>
                    </div>
                    @endif
                    @if($loanRequest->return_signature_path)
                    <div>
                        <h4 class="text-sm font-medium text-txt-black-900 mb-2">Return Signature</h4>
                        <div class="border border-otl-divider rounded-lg p-4 bg-bg-gray-50">
                            <img src="{{ Storage::url($loanRequest->return_signature_path) }}"
                                 alt="Return Signature"
                                 class="max-w-full h-auto">
                        </div>
                        <p class="text-xs text-txt-black-500 mt-2">
                            Signed on {{ $loanRequest->returned_at->format('M j, Y \a\t g:i A') }}
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Sidebar -->
        <div class="space-y-6">
            <!-- Applicant Information -->
            <div class="bg-bg-white rounded-lg shadow-card border border-otl-divider p-6">
                <h3 class="text-lg font-semibold text-txt-black-900 mb-4 font-poppins">Applicant</h3>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                            @include('components.icon', ['name' => 'user', 'class' => 'w-5 h-5 text-txt-primary'])
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-txt-black-900">{{ $loanRequest->user->name }}</p>
                        <p class="text-sm text-txt-black-500">{{ $loanRequest->user->email }}</p>
                    </div>
                </div>
                <div class="space-y-3 text-sm">
                    @if($loanRequest->user->division)
                    <div class="flex justify-between">
                        <span class="text-txt-black-500">Division:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->user->division }}</span>
                    </div>
                    @endif
                    @if($loanRequest->user->position)
                    <div class="flex justify-between">
                        <span class="text-txt-black-500">Position:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->user->position }}</span>
                    </div>
                    @endif
                    @if($loanRequest->user->phone)
                    <div class="flex justify-between">
                        <span class="text-txt-black-500">Phone:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->user->phone }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Responsible Officer -->
            @if($loanRequest->responsible_officer_name)
            <div class="bg-bg-white rounded-lg shadow-card border border-otl-divider p-6">
                <h3 class="text-lg font-semibold text-txt-black-900 mb-4 font-poppins">Responsible Officer</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-txt-black-500">Name:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->responsible_officer_name }}</span>
                    </div>
                    @if($loanRequest->responsible_officer_position)
                    <div class="flex justify-between">
                        <span class="text-txt-black-500">Position:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->responsible_officer_position }}</span>
                    </div>
                    @endif
                    @if($loanRequest->responsible_officer_phone)
                    <div class="flex justify-between">
                        <span class="text-txt-black-500">Phone:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->responsible_officer_phone }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Approvals -->
            <div class="bg-bg-white rounded-lg shadow-card border border-otl-divider p-6">
                <h3 class="text-lg font-semibold text-txt-black-900 mb-4 font-poppins">Approvals</h3>
                <div class="space-y-4">
                    <!-- Supervisor Approval -->
                    <div class="flex items-start space-x-3">
                        @if($loanRequest->supervisor_approved_at)
                            <div class="flex-shrink-0 w-6 h-6 bg-success-100 rounded-full flex items-center justify-center">
                                @include('components.icon', ['name' => 'check', 'class' => 'w-3 h-3 text-success-600'])
                            </div>
                        @else
                            <div class="flex-shrink-0 w-6 h-6 bg-black-100 rounded-full flex items-center justify-center">
                                @include('components.icon', ['name' => 'clock', 'class' => 'w-3 h-3 text-txt-black-500'])
                            </div>
                        @endif
                        <div class="flex-1">
                            <p class="text-sm font-medium text-txt-black-900">Supervisor Approval</p>
                            @if($loanRequest->supervisor_approved_at)
                                <p class="text-xs text-txt-black-500">
                                    Approved by {{ $loanRequest->supervisor->name ?? 'N/A' }}
                                    <br>
                                    {{ $loanRequest->supervisor_approved_at->format('M j, Y \a\t g:i A') }}
                                </p>
                                @if($loanRequest->supervisor_notes)
                                    <p class="text-xs text-txt-black-500 mt-1 italic">{{ $loanRequest->supervisor_notes }}</p>
                                @endif
                            @else
                                <p class="text-xs text-txt-black-500">Pending approval</p>
                            @endif
                        </div>
                    </div>
                    <!-- ICT Approval -->
                    <div class="flex items-start space-x-3">
                        @if($loanRequest->ict_approved_at)
                            <div class="flex-shrink-0 w-6 h-6 bg-success-100 rounded-full flex items-center justify-center">
                                @include('components.icon', ['name' => 'check', 'class' => 'w-3 h-3 text-success-600'])
                            </div>
                        @else
                            <div class="flex-shrink-0 w-6 h-6 bg-black-100 rounded-full flex items-center justify-center">
                                @include('components.icon', ['name' => 'clock', 'class' => 'w-3 h-3 text-txt-black-500'])
                            </div>
                        @endif
                        <div class="flex-1">
                            <p class="text-sm font-medium text-txt-black-900">ICT Admin Approval</p>
                            @if($loanRequest->ict_approved_at)
                                <p class="text-xs text-txt-black-500">
                                    Approved by {{ $loanRequest->ictAdmin->name ?? 'N/A' }}
                                    <br>
                                    {{ $loanRequest->ict_approved_at->format('M j, Y \a\t g:i A') }}
                                </p>
                                @if($loanRequest->ict_notes)
                                    <p class="text-xs text-txt-black-500 mt-1 italic">{{ $loanRequest->ict_notes }}</p>
                                @endif
                            @else
                                <p class="text-xs text-txt-black-500">Pending approval</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-bg-white rounded-lg shadow-card border border-otl-divider p-6">
                <h3 class="text-lg font-semibold text-txt-black-900 mb-4 font-poppins">Quick Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-txt-black-500">Created:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->created_at->diffForHumans() }}</span>
                    </div>
                    @if($loanRequest->supervisor_approved_at)
                    <div class="flex justify-between text-sm">
                        <span class="text-txt-black-500">Supervisor approval:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->supervisor_approved_at->diffForHumans() }}</span>
                    </div>
                    @endif
                    @if($loanRequest->ict_approved_at)
                    <div class="flex justify-between text-sm">
                        <span class="text-txt-black-500">ICT approval:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->ict_approved_at->diffForHumans() }}</span>
                    </div>
                    @endif
                    @if($loanRequest->issued_at)
                    <div class="flex justify-between text-sm">
                        <span class="text-txt-black-500">Equipment issued:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->issued_at->diffForHumans() }}</span>
                    </div>
                    @endif
                    @if($loanRequest->returned_at)
                    <div class="flex justify-between text-sm">
                        <span class="text-txt-black-500">Returned:</span>
                        <span class="text-txt-black-900">{{ $loanRequest->returned_at->diffForHumans() }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
