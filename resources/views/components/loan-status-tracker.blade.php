{{--
  ICTServe (iServe) Loan Status Tracker Component
  MYDS & MyGovEA Compliance:
    - Grid: 12-8-4 responsive, container spacing per MYDS spacing system.
    - Colour: All backgrounds, borders, text use MYDS tokens (see MYDS-Colour-Reference.md).
    - Typography: Inter (body), Poppins (headings, if applicable).
    - Icons: Only MYDS icon set, 20x20, 1.5px stroke (see MYDS-Icons-Overview.md).
    - Accessibility: Semantic headings, ARIA roles, visible focus states, status indicators use icon + colour.
    - Minimal, feedback-oriented, actionable, citizen-centric (prinsip-reka-bentuk-mygovea.md).
--}}

@props([
    'loanRequest',
    'showProgress' => true,
    'showTimeline' => true,
    'polling' => false,
    'pollInterval' => '5s'
])

<div class="loan-status-tracker bg-bg-white rounded-lg shadow-card border border-otl-divider p-6"
     @if($polling) wire:poll.{{ $pollInterval }}="refreshStatus" @endif>

    <!-- Status Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-txt-black-900 font-poppins">Request Status</h3>
            <p class="text-sm text-txt-black-500">{{ $loanRequest->request_number }}</p>
        </div>

        <div class="flex items-center space-x-3">
            @php
                $statusConfig = match($loanRequest->loanStatus->code ?? 'pending') {
                    'pending_supervisor' => [
                        'bg' => 'bg-warning-100',
                        'text' => 'text-warning-700',
                        'icon' => 'clock',
                        'pulse' => true
                    ],
                    'approved_supervisor' => [
                        'bg' => 'bg-primary-100',
                        'text' => 'text-txt-primary',
                        'icon' => 'check-circle',
                        'pulse' => false
                    ],
                    'pending_ict' => [
                        'bg' => 'bg-warning-100',
                        'text' => 'text-warning-700',
                        'icon' => 'clock',
                        'pulse' => true
                    ],
                    'approved_ict' => [
                        'bg' => 'bg-success-100',
                        'text' => 'text-success-700',
                        'icon' => 'check-circle',
                        'pulse' => false
                    ],
                    'equipment_assigned' => [
                        'bg' => 'bg-primary-100',
                        'text' => 'text-txt-primary',
                        'icon' => 'clipboard-list',
                        'pulse' => false
                    ],
                    'ready_pickup' => [
                        'bg' => 'bg-success-100',
                        'text' => 'text-success-700',
                        'icon' => 'cube',
                        'pulse' => true
                    ],
                    'in_use' => [
                        'bg' => 'bg-success-100',
                        'text' => 'text-success-700',
                        'icon' => 'check-circle',
                        'pulse' => false
                    ],
                    'overdue' => [
                        'bg' => 'bg-danger-100',
                        'text' => 'text-danger-700',
                        'icon' => 'exclamation-triangle',
                        'pulse' => true
                    ],
                    'returned' => [
                        'bg' => 'bg-black-100',
                        'text' => 'text-txt-black-700',
                        'icon' => 'check-circle',
                        'pulse' => false
                    ],
                    'rejected' => [
                        'bg' => 'bg-danger-100',
                        'text' => 'text-txt-danger',
                        'icon' => 'x-circle',
                        'pulse' => false
                    ],
                    default => [
                        'bg' => 'bg-black-100',
                        'text' => 'text-txt-black-700',
                        'icon' => 'clock',
                        'pulse' => false
                    ]
                };
            @endphp

            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                @if($statusConfig['pulse'])
                    <span class="flex h-2 w-2 mr-2">
                        <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full {{ str_replace('100','400',$statusConfig['bg']) }} opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 {{ str_replace('100','500',$statusConfig['bg']) }}"></span>
                    </span>
                @else
                    @include('components.icon', ['name' => $statusConfig['icon'], 'class' => 'w-4 h-4 mr-2'])
                @endif
                <span>{{ $loanRequest->loanStatus->name ?? 'Pending' }}</span>
            </span>

            @if($polling)
                <div class="text-txt-black-500" title="Auto-refreshing every {{ $pollInterval }}">
                    @include('components.icon', ['name' => 'refresh', 'class' => 'w-4 h-4 animate-spin'])
                </div>
            @endif
        </div>
    </div>

    @if($showProgress)
    <!-- Progress Bar -->
    <div class="mb-8">
        @php
            $progressSteps = [
                ['key' => 'submitted', 'label' => 'Submitted', 'completed' => true],
                ['key' => 'supervisor_review', 'label' => 'Supervisor Review', 'completed' => in_array($loanRequest->loanStatus->code ?? '', ['approved_supervisor', 'pending_ict', 'approved_ict', 'equipment_assigned', 'ready_pickup', 'in_use', 'returned'])],
                ['key' => 'ict_review', 'label' => 'ICT Review', 'completed' => in_array($loanRequest->loanStatus->code ?? '', ['approved_ict', 'equipment_assigned', 'ready_pickup', 'in_use', 'returned'])],
                ['key' => 'equipment_ready', 'label' => 'Equipment Ready', 'completed' => in_array($loanRequest->loanStatus->code ?? '', ['ready_pickup', 'in_use', 'returned'])],
                ['key' => 'in_use', 'label' => 'In Use', 'completed' => in_array($loanRequest->loanStatus->code ?? '', ['in_use', 'returned'])],
                ['key' => 'returned', 'label' => 'Returned', 'completed' => $loanRequest->loanStatus->code === 'returned'],
            ];

            $currentStep = 0;
            foreach($progressSteps as $index => $step) {
                if ($step['completed']) {
                    $currentStep = $index + 1;
                }
            }
        @endphp

        <div class="flex items-center space-x-4">
            @foreach($progressSteps as $index => $step)
                <div class="flex items-center @if(!$loop->last) flex-1 @endif">
                    @php
                        if ($step['completed']) {
                            $circleClass = 'bg-success-500 border-success-500 text-txt-white';
                            $inner = "@include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4'])";
                        } elseif ($index === $currentStep) {
                            $circleClass = 'bg-primary-500 border-otl-primary-300 text-txt-white animate-pulse';
                            $inner = '<span class="w-3 h-3 bg-bg-white rounded-full animate-pulse"></span>';
                        } else {
                            $circleClass = 'bg-black-200 border-otl-divider text-txt-black-500';
                            $inner = '<span class="text-xs font-semibold">'.($index + 1).'</span>';
                        }
                    @endphp
                    <div class="flex items-center justify-center w-8 h-8 rounded-full border-2 {{ $circleClass }}">
                        {!! $inner !!}
                    </div>
                    <span class="ml-2 text-sm font-medium
                                @if($step['completed']) text-success-700
                                @elseif($index === $currentStep) text-txt-primary
                                @else text-txt-black-500 @endif">
                        {{ $step['label'] }}
                    </span>
                    @if(!$loop->last)
                        <div class="flex-1 h-0.5 mx-4
                                    @if($index < $currentStep) bg-success-500
                                    @else bg-otl-divider @endif"></div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($showTimeline)
    <!-- Timeline -->
    <div class="space-y-4">
        <h4 class="text-sm font-semibold text-txt-black-900 uppercase tracking-wide font-poppins">Activity Timeline</h4>
        <div class="flow-root">
            <ul class="-mb-8">
                <!-- Submission -->
                <li class="relative pb-8">
                    <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-otl-divider"></div>
                    <div class="relative flex space-x-3">
                        <div class="h-8 w-8 rounded-full bg-success-500 flex items-center justify-center ring-8 ring-bg-white">
                            @include('components.icon', ['name' => 'plus', 'class' => 'w-4 h-4 text-txt-white'])
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-txt-black-900">Request submitted by <span class="font-medium">{{ $loanRequest->user->name }}</span></p>
                                <p class="text-xs text-txt-black-500">{{ $loanRequest->purpose }}</p>
                            </div>
                            <div class="text-right text-sm whitespace-nowrap text-txt-black-500">
                                {{ $loanRequest->created_at->format('M j, Y') }}
                                <br>
                                <span class="text-xs">{{ $loanRequest->created_at->format('g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                <!-- Supervisor Approval -->
                @if($loanRequest->supervisor_approved_at)
                <li class="relative pb-8">
                    <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-otl-divider"></div>
                    <div class="relative flex space-x-3">
                        <div class="h-8 w-8 rounded-full bg-primary-500 flex items-center justify-center ring-8 ring-bg-white">
                            @include('components.icon', ['name' => 'check', 'class' => 'w-4 h-4 text-txt-white'])
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-txt-black-900">Approved by supervisor <span class="font-medium">{{ $loanRequest->supervisor->name ?? 'N/A' }}</span></p>
                                @if($loanRequest->supervisor_notes)
                                    <p class="text-xs text-txt-black-500">{{ $loanRequest->supervisor_notes }}</p>
                                @endif
                            </div>
                            <div class="text-right text-sm whitespace-nowrap text-txt-black-500">
                                {{ $loanRequest->supervisor_approved_at->format('M j, Y') }}
                                <br>
                                <span class="text-xs">{{ $loanRequest->supervisor_approved_at->format('g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
                <!-- ICT Approval -->
                @if($loanRequest->ict_approved_at)
                <li class="relative pb-8">
                    <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-otl-divider"></div>
                    <div class="relative flex space-x-3">
                        <div class="h-8 w-8 rounded-full bg-success-500 flex items-center justify-center ring-8 ring-bg-white">
                            @include('components.icon', ['name' => 'check-circle', 'class' => 'w-4 h-4 text-txt-white'])
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-txt-black-900">Approved by ICT admin <span class="font-medium">{{ $loanRequest->ictAdmin->name ?? 'N/A' }}</span></p>
                                @if($loanRequest->ict_notes)
                                    <p class="text-xs text-txt-black-500">{{ $loanRequest->ict_notes }}</p>
                                @endif
                            </div>
                            <div class="text-right text-sm whitespace-nowrap text-txt-black-500">
                                {{ $loanRequest->ict_approved_at->format('M j, Y') }}
                                <br>
                                <span class="text-xs">{{ $loanRequest->ict_approved_at->format('g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
                <!-- Equipment Issued -->
                @if($loanRequest->issued_at)
                <li class="relative pb-8">
                    <div class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-otl-divider"></div>
                    <div class="relative flex space-x-3">
                        <div class="h-8 w-8 rounded-full bg-primary-500 flex items-center justify-center ring-8 ring-bg-white">
                            @include('components.icon', ['name' => 'cube', 'class' => 'w-4 h-4 text-txt-white'])
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-txt-black-900">Equipment issued by <span class="font-medium">{{ $loanRequest->issuedBy->name ?? 'N/A' }}</span></p>
                                <p class="text-xs text-txt-black-500">Equipment ready for pickup</p>
                            </div>
                            <div class="text-right text-sm whitespace-nowrap text-txt-black-500">
                                {{ $loanRequest->issued_at->format('M j, Y') }}
                                <br>
                                <span class="text-xs">{{ $loanRequest->issued_at->format('g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
                <!-- Equipment Returned -->
                @if($loanRequest->returned_at)
                <li class="relative">
                    <div class="relative flex space-x-3">
                        <div class="h-8 w-8 rounded-full bg-black-500 flex items-center justify-center ring-8 ring-bg-white">
                            @include('components.icon', ['name' => 'check-circle', 'class' => 'w-4 h-4 text-txt-white'])
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-txt-black-900">Equipment returned</p>
                                @if($loanRequest->return_condition_notes)
                                    <p class="text-xs text-txt-black-500">{{ $loanRequest->return_condition_notes }}</p>
                                @endif
                            </div>
                            <div class="text-right text-sm whitespace-nowrap text-txt-black-500">
                                {{ $loanRequest->returned_at->format('M j, Y') }}
                                <br>
                                <span class="text-xs">{{ $loanRequest->returned_at->format('g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
                <!-- Rejection -->
                @if($loanRequest->rejection_reason)
                <li class="relative">
                    <div class="relative flex space-x-3">
                        <div class="h-8 w-8 rounded-full bg-danger-500 flex items-center justify-center ring-8 ring-bg-white">
                            @include('components.icon', ['name' => 'x-circle', 'class' => 'w-4 h-4 text-txt-white'])
                        </div>
                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                            <div>
                                <p class="text-sm text-txt-black-900">Request rejected</p>
                                <p class="text-xs text-txt-black-500">{{ $loanRequest->rejection_reason }}</p>
                            </div>
                            <div class="text-right text-sm whitespace-nowrap text-txt-black-500">
                                {{ $loanRequest->updated_at->format('M j, Y') }}
                                <br>
                                <span class="text-xs">{{ $loanRequest->updated_at->format('g:i A') }}</span>
                            </div>
                        </div>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
    @endif

    <!-- Next Actions (Callout) -->
    @php
        $nextActions = [];
        $currentStatus = $loanRequest->loanStatus->code ?? 'pending';

        switch($currentStatus) {
            case 'pending_supervisor':
                $nextActions[] = ['text' => 'Awaiting supervisor approval', 'type' => 'info'];
                break;
            case 'pending_ict':
                $nextActions[] = ['text' => 'Awaiting ICT admin review', 'type' => 'info'];
                break;
            case 'approved_ict':
                $nextActions[] = ['text' => 'Equipment being prepared', 'type' => 'info'];
                break;
            case 'ready_pickup':
                $nextActions[] = ['text' => 'Ready for pickup - visit BPM office', 'type' => 'success'];
                break;
            case 'in_use':
                if($loanRequest->requested_to < now()) {
                    $nextActions[] = ['text' => 'Overdue - please return equipment', 'type' => 'danger'];
                } else {
                    $nextActions[] = ['text' => 'Equipment in use - due ' . $loanRequest->requested_to->format('M j, Y'), 'type' => 'success'];
                }
                break;
        }
    @endphp

    @if(!empty($nextActions))
    <div class="mt-6 pt-6 border-t border-otl-divider">
        <h4 class="text-sm font-semibold text-txt-black-900 mb-3 font-poppins">Next Steps</h4>
        <div class="space-y-2">
            @foreach($nextActions as $action)
                @php
                    $actionClasses = match($action['type']) {
                        'success' => 'bg-success-50 border-otl-success-200 text-success-700',
                        'danger' => 'bg-danger-50 border-otl-danger-200 text-danger-700',
                        'info' => 'bg-primary-50 border-otl-primary-300 text-txt-primary',
                        default => 'bg-black-100 border-otl-divider text-txt-black-700'
                    };
                @endphp
                <div class="p-3 rounded-md border {{ $actionClasses }}">
                    <p class="text-sm font-medium">{{ $action['text'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
