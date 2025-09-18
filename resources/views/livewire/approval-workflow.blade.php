<div class="bg-bg-white rounded-lg shadow-sm border border-otl-gray-200">
    {{-- Header --}}
    <div class="px-6 py-4 border-b border-otl-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-txt-black-900">
                    Status Permohonan Pinjaman
                </h3>
                <p class="text-sm text-txt-black-600 mt-1">
                    Rujukan: {{ $loanRequest->reference_number ?? 'N/A' }}
                </p>
            </div>
            @if($loanRequest)
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        @if($loanRequest->status === 'approved') bg-success-100 text-success-800
                        @elseif($loanRequest->status === 'rejected') bg-danger-100 text-danger-800
                        @elseif($loanRequest->status === 'pending') bg-warning-100 text-warning-800
                        @elseif($loanRequest->status === 'collected') bg-success-100 text-success-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ ucfirst(str_replace('_', ' ', $loanRequest->status)) }}
                    </span>
                </div>
            @endif
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('message'))
        <div class="mx-6 mt-4 p-4 bg-success-50 border border-success-200 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-icon name="check-circle" class="h-5 w-5 text-success-400" />
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-success-800">
                        {{ session('message') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mx-6 mt-4 p-4 bg-danger-50 border border-danger-200 rounded-md">
            <div class="flex">
                <div class="flex-shrink-0">
                    <x-icon name="x-circle" class="h-5 w-5 text-danger-400" />
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-danger-800">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    {{-- Workflow Progress --}}
    <div class="px-6 py-6">
        <div class="relative">
            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-txt-white bg-bg-warning-600 hover:bg-bg-warning-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-warning">
            </div>
            <div class="relative flex justify-between">
                @foreach($workflowSteps as $index => $step)
                    @php
                        $status = $this->getStepStatus($index);
                        $color = $this->getStepColor($index);
                    @endphp

                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-txt-white bg-bg-success-600 hover:bg-bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-success">
                        <div class="relative flex items-center justify-center w-10 h-10 rounded-full border-2 bg-bg-white
                            @if($status === 'completed') border-success-500 bg-success-500
                            @elseif($status === 'current') border-otl-primary-300 bg-primary-500
                            @elseif($status === 'rejected') border-danger-500 bg-danger-500
                            @else border-otl-gray-200 bg-bg-white
                            @endif">

                            @if($status === 'completed')
                              <x-icon name="check" class="w-5 h-5 text-txt-white" />
                            @elseif($status === 'rejected')
                              <x-icon name="x" class="w-5 h-5 text-txt-white" />
                            @else
                              <x-icon name="{{ $step['icon'] }}" class="w-5 h-5 {{ $status === 'current' ? 'text-txt-white' : 'text-txt-black-500' }}" />
                            @endif
                        </div>

                        <div class="mt-3 text-center max-w-24">
                            <p class="text-xs font-medium
                                @if($status === 'completed') text-success-600
                                @elseif($status === 'current') text-txt-primary
                                @elseif($status === 'rejected') text-danger-600
                                @else text-txt-black-500
                                @endif">
                                {{ $step['title'] }}
                            </p>
                            <p class="text-xs text-txt-black-500 mt-1 hidden group-hover:block">
                                {{ $step['description'] }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Action Buttons --}}
    @if($loanRequest && auth()->user()->hasRole(['admin', 'bpm_officer']))
    <div class="px-6 py-4 bg-gray-50 border-t border-otl-gray-200 rounded-b-lg">
            <div class="flex flex-wrap gap-3">
                {{-- Approval Actions --}}
                @if($this->canApprove())
                    <button wire:click="showApprovalModalAction('approve')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-txt-white bg-bg-success-600 hover:bg-bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-success">
                        <x-icon name="check" class="w-4 h-4 mr-2" />
                        Luluskan
                    </button>

                    <button wire:click="showApprovalModalAction('reject')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-txt-white bg-bg-danger-600 hover:bg-bg-danger-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-danger">
                        <x-icon name="x" class="w-4 h-4 mr-2" />
                        Tolak
                    </button>

                    <button wire:click="showApprovalModalAction('return')"
                            class="inline-flex items-center px-4 py-2 border border-otl-gray-200 text-sm font-medium rounded-md text-txt-black-700 bg-bg-white hover:bg-gray-50 focus:outline-none focus:ring-fr-primary">
                        <x-icon name="arrow-left" class="w-4 h-4 mr-2" />
                        Kembalikan
                    </button>
                @endif

                {{-- Equipment Preparation --}}
                @if($this->canPrepareEquipment())
                    <button wire:click="markEquipmentPrepared"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-txt-white bg-bg-warning-600 hover:bg-bg-warning-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-warning">
                        <x-icon name="cog" class="w-4 h-4 mr-2" />
                        Tandakan Peralatan Disediakan
                    </button>
                @endif

                {{-- Ready for Collection --}}
                @if($this->canMarkReadyForCollection())
                    <button wire:click="markReadyForCollection"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-txt-white bg-bg-primary-600 hover:bg-bg-primary-700 focus:outline-none focus:ring-fr-primary">
                        <x-icon name="bell" class="w-4 h-4 mr-2" />
                        Sedia Untuk Dipungut
                    </button>
                @endif

                {{-- Confirm Collection --}}
                @if($this->canConfirmCollection())
                    <button wire:click="markCollected"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-txt-white bg-bg-success-600 hover:bg-bg-success-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-success">
                        <x-icon name="check" class="w-4 h-4 mr-2" />
                        Sahkan Dipungut
                    </button>
                @endif
            </div>
        </div>
    @endif

    {{-- Approval Modal --}}
    @if($showApprovalModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeApprovalModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full
                                @if($approvalAction === 'approve') bg-success-100
                                @elseif($approvalAction === 'reject') bg-danger-100
                                @else bg-warning-100
                                @endif sm:mx-0 sm:h-10 sm:w-10">
                                @if($approvalAction === 'approve')
                                    <x-icon name="check" class="h-6 w-6 text-success-600" />
                                @elseif($approvalAction === 'reject')
                                    <x-icon name="x" class="h-6 w-6 text-danger-600" />
                                @else
                                    <x-icon name="arrow-left" class="h-6 w-6 text-warning-600" />
                                @endif
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-txt-black-900" id="modal-title">
                                    @if($approvalAction === 'approve') Luluskan Permohonan
                                    @elseif($approvalAction === 'reject') Tolak Permohonan
                                    @else Kembalikan Permohonan
                                    @endif
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-txt-black-500">
                                        @if($approvalAction === 'approve')
                                            Sila masukkan komen untuk keputusan meluluskan permohonan ini.
                                        @elseif($approvalAction === 'reject')
                                            Sila nyatakan sebab penolakan permohonan ini.
                                        @else
                                            Sila nyatakan sebab mengapa permohonan ini perlu dikembalikan untuk pembetulan.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <label for="approval-comment" class="block text-sm font-medium text-txt-black-700">
                                Komen / Sebab
                            </label>
                            <div class="mt-1">
                                <textarea wire:model.defer="approvalComment"
                                         id="approval-comment"
                                         rows="4"
                                         class="shadow-sm focus:ring-fr-primary block w-full sm:text-sm border-otl-gray-200 rounded-md"
                                         placeholder="Masukkan komen anda di sini..."></textarea>
                            </div>
                            @error('approvalComment')
                                <p class="mt-2 text-sm text-danger-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="processApproval"
                                type="button"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 text-base font-medium text-txt-white focus:outline-none focus:ring-2 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm
                                    @if($approvalAction === 'approve') bg-bg-success-600 hover:bg-bg-success-700 focus:ring-fr-success
                                    @elseif($approvalAction === 'reject') bg-bg-danger-600 hover:bg-bg-danger-700 focus:ring-fr-danger
                                    @else bg-bg-warning-600 hover:bg-bg-warning-700 focus:ring-fr-warning
                                @endif">
                            @if($approvalAction === 'approve') Luluskan
                            @elseif($approvalAction === 'reject') Tolak
                            @else Kembalikan
                            @endif
                        </button>
                        <button wire:click="closeApprovalModal"
                                type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-otl-gray-200 shadow-sm px-4 py-2 bg-bg-white text-base font-medium text-txt-black-700 hover:bg-gray-50 focus:outline-none focus:ring-fr-primary sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Approval History --}}
    @if($loanRequest && $loanRequest->approvals->count() > 0)
        <div class="px-6 py-4 border-t border-otl-gray-200">
            <h4 class="text-sm font-medium text-txt-black-900 mb-3">Sejarah Keputusan</h4>
            <div class="space-y-3">
                @foreach($loanRequest->approvals as $approval)
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            @if($approval->status === 'approve')
                                <x-icon name="check-circle" class="h-5 w-5 text-success-500" />
                            @elseif($approval->status === 'reject')
                                <x-icon name="x-circle" class="h-5 w-5 text-danger-500" />
                            @else
                                <x-icon name="arrow-left" class="h-5 w-5 text-warning-500" />
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm">
                                <span class="font-medium text-txt-black-900">
                                    {{ $approval->approver->name ?? 'Unknown' }}
                                </span>
                                <span class="text-txt-black-500">
                                    {{ $approval->status === 'approve' ? 'meluluskan' : ($approval->status === 'reject' ? 'menolak' : 'mengembalikan') }}
                                    permohonan
                                </span>
                            </div>
                            <div class="mt-1 text-sm text-txt-black-500">
                                {{ $approval->comments }}
                            </div>
                            <div class="mt-1 text-xs text-txt-black-500">
                                {{ $approval->approved_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
