<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-indigo-900">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Penugasan & Eskalasi Tiket / Ticket Assignment & Escalation
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        Tiket: {{ $ticket->ticket_number }} - {{ $ticket->title }}
                    </p>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('helpdesk.index-enhanced') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-lg text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali / Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Ticket Information Card -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                        Maklumat Tiket / Ticket Information
                    </h2>

                    <!-- Status & Priority -->
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                       {{ $ticket->status->code === 'new' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' :
                                          ($ticket->status->code === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' :
                                          ($ticket->status->code === 'resolved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' :
                                           'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300')) }}">
                                {{ $ticket->status->name }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Keutamaan / Priority:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                       {{ $ticket->priority === 'critical' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300' :
                                          ($ticket->priority === 'high' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300' :
                                          ($ticket->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' :
                                           'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300')) }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Kategori / Category:</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ $ticket->category->name }}</span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Pemohon / Requester:</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ $ticket->user->name }}</span>
                        </div>

                        @if($ticket->assignedToUser)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Ditugaskan / Assigned To:</span>
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center">
                                        <span class="text-xs font-medium text-white">
                                            {{ substr($ticket->assignedToUser->name, 0, 1) }}
                                        </span>
                                    </div>
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $ticket->assignedToUser->name }}</span>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Dicipta / Created:</span>
                            <span class="text-sm text-gray-900 dark:text-white">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                        </div>

                        @if($ticket->due_at)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Tarikh Akhir / Due Date:</span>
                                <span class="text-sm {{ $ticket->isOverdue() ? 'text-red-600 dark:text-red-400 font-medium' : 'text-gray-900 dark:text-white' }}">
                                    {{ $ticket->due_at->format('d/m/Y H:i') }}
                                    @if($ticket->isOverdue())
                                        <span class="text-xs">(Overdue)</span>
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Quick Actions -->
                    <div class="mt-6 space-y-2">
                        @if(!$ticket->assignedToUser || $ticket->assignedToUser->id !== auth()->id())
                            <button wire:click="reassignToSelf"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-blue-300 dark:border-blue-600 text-sm font-medium rounded-lg text-blue-700 dark:text-blue-300 bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/40 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Tugaskan kepada saya / Assign to me
                            </button>
                        @endif

                        <!-- Status Update Dropdown -->
                        <div class="relative">
                            <select wire:model="statusUpdate"
                                    wire:change="updateStatus"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Kemaskini Status / Update Status</option>
                                @foreach($statuses as $status)
                                    @if($status->id !== $ticket->status_id)
                                        <option value="{{ $status->code }}">{{ $status->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Tab Navigation -->
                <div class="bg-white dark:bg-gray-800 rounded-t-xl shadow-sm border border-gray-200 dark:border-gray-700 border-b-0">
                    <nav class="flex space-x-8 px-6 py-4" aria-label="Tabs">
                        <button wire:click="$set('activeTab', 'assignment')"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors
                                       {{ $activeTab === 'assignment' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Penugasan / Assignment
                        </button>
                        <button wire:click="$set('activeTab', 'escalation')"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors
                                       {{ $activeTab === 'escalation' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Eskalasi / Escalation
                        </button>
                        <button wire:click="$set('activeTab', 'comments')"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors
                                       {{ $activeTab === 'comments' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Komen / Comments
                        </button>
                        <button wire:click="$set('activeTab', 'history')"
                                class="py-2 px-1 border-b-2 font-medium text-sm transition-colors
                                       {{ $activeTab === 'history' ? 'border-blue-500 text-blue-600 dark:text-blue-400' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                            Sejarah / History
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="bg-white dark:bg-gray-800 rounded-b-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <!-- Assignment Tab -->
                    @if($activeTab === 'assignment')
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Tugaskan Tiket / Assign Ticket
                            </h3>

                            <form wire:submit="assignTicket">
                                <!-- Technician Selection -->
                                <div class="mb-6">
                                    <label for="selectedTechnician" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Pilih Juruteknik / Select Technician <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="selectedTechnician"
                                            id="selectedTechnician"
                                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Pilih juruteknik / Select technician</option>
                                        @foreach($technicians as $tech)
                                            <option value="{{ $tech['id'] }}">
                                                {{ $tech['name'] }} ({{ ucfirst($tech['role']) }})
                                                @if(isset($tech['department'])) - {{ $tech['department'] }}@endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('selectedTechnician')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Priority Update -->
                                <div class="mb-6">
                                    <label for="priority" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Keutamaan / Priority
                                    </label>
                                    <select wire:model="priority"
                                            id="priority"
                                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="low">Rendah / Low</option>
                                        <option value="medium">Sederhana / Medium</option>
                                        <option value="high">Tinggi / High</option>
                                        <option value="critical">Kritikal / Critical</option>
                                    </select>
                                </div>

                                <!-- Due Date -->
                                <div class="mb-6">
                                    <label for="dueDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Tarikh Akhir / Due Date
                                    </label>
                                    <input type="datetime-local"
                                           wire:model="dueDate"
                                           id="dueDate"
                                           min="{{ now()->format('Y-m-d\TH:i') }}"
                                           class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>

                                <!-- Assignment Note -->
                                <div class="mb-6">
                                    <label for="assignmentNote" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Nota Penugasan / Assignment Note <span class="text-red-500">*</span>
                                    </label>
                                    <textarea wire:model="assignmentNote"
                                              id="assignmentNote"
                                              rows="3"
                                              maxlength="500"
                                              class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                              placeholder="Berikan arahan atau nota tambahan untuk juruteknik / Provide instructions or additional notes for the technician"></textarea>
                                    <div class="flex justify-between mt-1">
                                        @error('assignmentNote')
                                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @else
                                            <span></span>
                                        @enderror
                                        <span class="text-xs text-gray-500">{{ strlen($assignmentNote) }}/500</span>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                        wire:loading.attr="disabled"
                                        wire:target="assignTicket"
                                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 transition-all">
                                    <span wire:loading.remove wire:target="assignTicket">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        Tugaskan Tiket / Assign Ticket
                                    </span>
                                    <span wire:loading wire:target="assignTicket" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Menugaskan... / Assigning...
                                    </span>
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Escalation Tab -->
                    @if($activeTab === 'escalation')
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Eskalasi Tiket / Escalate Ticket
                            </h3>

                            <form wire:submit="escalateTicket">
                                <!-- Escalation Level -->
                                <div class="mb-6">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Tahap Eskalasi / Escalation Level
                                    </label>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <input type="radio"
                                                   wire:model="escalationLevel"
                                                   value="supervisor"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Penyelia / Supervisor</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">Standard escalation</div>
                                            </div>
                                        </label>
                                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <input type="radio"
                                                   wire:model="escalationLevel"
                                                   value="manager"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Pengurus / Manager</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">High priority escalation</div>
                                            </div>
                                        </label>
                                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            <input type="radio"
                                                   wire:model="escalationLevel"
                                                   value="external"
                                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700">
                                            <div class="ml-3">
                                                <div class="text-sm font-medium text-gray-900 dark:text-white">Luaran / External</div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">Vendor or specialist</div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                <!-- Escalate To -->
                                <div class="mb-6">
                                    <label for="escalateTo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Eskalasi kepada / Escalate to <span class="text-red-500">*</span>
                                    </label>
                                    <select wire:model="escalateTo"
                                            id="escalateTo"
                                            class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Pilih penerima eskalasi / Select escalation recipient</option>
                                        @foreach($technicians as $tech)
                                            @if(in_array($tech['role'], ['supervisor', 'ict_admin']))
                                                <option value="{{ $tech['id'] }}">
                                                    {{ $tech['name'] }} ({{ ucfirst($tech['role']) }})
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('escalateTo')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Escalation Reason -->
                                <div class="mb-6">
                                    <label for="escalationReason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Sebab Eskalasi / Escalation Reason <span class="text-red-500">*</span>
                                    </label>
                                    <textarea wire:model="escalationReason"
                                              id="escalationReason"
                                              rows="4"
                                              maxlength="500"
                                              class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:bg-gray-700 dark:text-white"
                                              placeholder="Jelaskan mengapa tiket ini perlu dieskalasi / Explain why this ticket needs to be escalated"></textarea>
                                    <div class="flex justify-between mt-1">
                                        @error('escalationReason')
                                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @else
                                            <span></span>
                                        @enderror
                                        <span class="text-xs text-gray-500">{{ strlen($escalationReason) }}/500</span>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                        wire:loading.attr="disabled"
                                        wire:target="escalateTicket"
                                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-gradient-to-r from-orange-600 to-red-600 hover:from-orange-700 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 transition-all">
                                    <span wire:loading.remove wire:target="escalateTicket">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Eskalasi Tiket / Escalate Ticket
                                    </span>
                                    <span wire:loading wire:target="escalateTicket" class="flex items-center">
                                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Mengeskalasi... / Escalating...
                                    </span>
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Comments Tab -->
                    @if($activeTab === 'comments')
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Komen & Kemaskini / Comments & Updates
                            </h3>

                            <!-- Add Comment Form -->
                            <form wire:submit="addComment" class="space-y-4">
                                <div>
                                    <label for="newComment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Tambah Komen / Add Comment
                                    </label>
                                    <textarea wire:model="newComment"
                                              id="newComment"
                                              rows="3"
                                              maxlength="1000"
                                              class="block w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                              placeholder="Tambah komen atau kemaskini / Add comment or update"></textarea>
                                    <div class="flex justify-between mt-1">
                                        @error('newComment')
                                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @else
                                            <span></span>
                                        @enderror
                                        <span class="text-xs text-gray-500">{{ strlen($newComment) }}/1000</span>
                                    </div>
                                </div>

                                <button type="submit"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Komen / Add Comment
                                </button>
                            </form>

                            <!-- Comments List -->
                            <div class="space-y-4">
                                @if(empty($comments))
                                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <p>Tiada komen lagi / No comments yet</p>
                                    </div>
                                @else
                                    @foreach($comments as $comment)
                                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                            <div class="flex items-start space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center">
                                                        <span class="text-sm font-medium text-white">
                                                            {{ substr($comment['user']['name'] ?? 'U', 0, 1) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <div class="flex items-center space-x-2">
                                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $comment['user']['name'] ?? 'Unknown User' }}
                                                        </h4>
                                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $comment['created_at'] ?? now()->format('d/m/Y H:i') }}
                                                        </span>
                                                    </div>
                                                    <p class="mt-1 text-sm text-gray-700 dark:text-gray-300">
                                                        {{ $comment['content'] ?? 'No content' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- History Tab -->
                    @if($activeTab === 'history')
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Sejarah Tiket / Ticket History
                            </h3>

                            <div class="space-y-4">
                                @if(empty($escalationHistory))
                                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <p>Tiada sejarah aktiviti lagi / No activity history yet</p>
                                    </div>
                                @else
                                    @foreach($escalationHistory as $history)
                                        <div class="relative pl-8 pb-4">
                                            <div class="absolute left-0 top-1 w-2 h-2 bg-blue-500 rounded-full"></div>
                                            <div class="absolute left-1 top-3 w-px h-full bg-gray-200 dark:bg-gray-600"></div>

                                            <div class="bg-white dark:bg-gray-700 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-600">
                                                <div class="flex items-center justify-between mb-2">
                                                    <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $history['action'] ?? 'Unknown Action' }}
                                                    </h4>
                                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $history['created_at'] ?? now()->format('d/m/Y H:i') }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                    {{ $history['description'] ?? 'No description available' }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Messages -->
    @if (session('success'))
        <div class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg"
             x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 5000)">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg"
             x-data="{ show: true }"
             x-show="show"
             x-transition
             x-init="setTimeout(() => show = false, 5000)">
            {{ session('error') }}
        </div>
    @endif
</div>
