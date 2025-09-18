{{--
    ICTServe (iServe) - Ticket Assignment & Escalation
    MYDS & MyGovEA compliant: accessible, responsive, clear, and citizen-centric
--}}

<x-myds.skiplink href="#main-content">
    <span>Skip to main content</span>
</x-myds.skiplink>

<x-myds.masthead>
    <x-myds.masthead-header>
        <x-myds.masthead-title>Penugasan & Eskalasi Tiket / Ticket Assignment & Escalation</x-myds.masthead-title>
    </x-myds.masthead-header>
    <x-myds.masthead-content>
        <x-myds.masthead-section :title="'Tiket: #' . $ticket->ticket_number" icon="clipboard-list">
            {{ $ticket->title }}
        </x-myds.masthead-section>
    </x-myds.masthead-content>
</x-myds.masthead>

<main id="main-content" tabindex="0" class="myds-container max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-start gap-8">
        {{-- Ticket Information Sidebar --}}
        <aside class="md:w-1/3 w-full">
            <x-myds.card>
                <x-myds.card-header>
                    <span class="text-heading-xs font-semibold text-txt-black-900 flex items-center gap-2">
                        <x-myds.icon name="information-circle" class="w-5 h-5" />
                        Maklumat Tiket / Ticket Information
                    </span>
                </x-myds.card-header>
                <x-myds.card-body>
                    <dl class="myds-summary-list">
                        <div class="flex items-center justify-between mb-2">
                            <dt class="text-body-sm text-txt-black-700">Status</dt>
                            <dd>
                                @php
                                    $statusColour = match($ticket->status->code) {
                                        'new' => 'warning',
                                        'in_progress' => 'primary',
                                        'resolved' => 'success',
                                        default => 'default'
                                    };
                                @endphp
                                <x-myds.tag :variant="$statusColour" size="small" dot="true" mode="pill">
                                    {{ $ticket->status->name }}
                                </x-myds.tag>
                            </dd>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <dt class="text-body-sm text-txt-black-700">Keutamaan / Priority</dt>
                            <dd>
                                @php
                                    $priorityColour = match($ticket->priority) {
                                        'critical' => 'danger',
                                        'high' => 'warning',
                                        'medium' => 'primary',
                                        default => 'success'
                                    };
                                @endphp
                                <x-myds.tag :variant="$priorityColour" size="small" dot="true" mode="pill">
                                    {{ ucfirst($ticket->priority) }}
                                </x-myds.tag>
                            </dd>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <dt class="text-body-sm text-txt-black-700">Kategori / Category</dt>
                            <dd class="text-body-sm text-txt-black-900">{{ $ticket->category->name }}</dd>
                        </div>
                        <div class="flex items-center justify-between mb-2">
                            <dt class="text-body-sm text-txt-black-700">Pemohon / Requester</dt>
                            <dd class="text-body-sm text-txt-black-900">{{ $ticket->user->name }}</dd>
                        </div>
                        @if($ticket->assignedToUser)
                        <div class="flex items-center justify-between mb-2">
                            <dt class="text-body-sm text-txt-black-700">Ditugaskan / Assigned To</dt>
                            <dd class="flex items-center gap-2 text-body-sm text-txt-black-900">
                                <x-myds.avatar :name="$ticket->assignedToUser->name" size="xs" />
                                {{ $ticket->assignedToUser->name }}
                            </dd>
                        </div>
                        @endif
                        <div class="flex items-center justify-between mb-2">
                            <dt class="text-body-sm text-txt-black-700">Dicipta / Created</dt>
                            <dd class="text-body-sm text-txt-black-900">{{ $ticket->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        @if($ticket->due_at)
                        <div class="flex items-center justify-between mb-2">
                            <dt class="text-body-sm text-txt-black-700">Tarikh Akhir / Due Date</dt>
                            <dd class="text-body-sm {{ $ticket->isOverdue() ? 'text-danger-600 font-semibold' : 'text-txt-black-900' }}">
                                {{ $ticket->due_at->format('d/m/Y H:i') }}
                                @if($ticket->isOverdue())
                                    <x-myds.icon name="exclamation-triangle" class="w-4 h-4 text-danger-600 inline" />
                                    <span class="ml-1 text-xs">(Lewat Tempoh / Overdue)</span>
                                @endif
                            </dd>
                        </div>
                        @endif
                    </dl>

                    <div class="mt-6 flex flex-col gap-2">
                        @if(!$ticket->assignedToUser || $ticket->assignedToUser->id !== auth()->id())
                            <x-myds.button type="button" variant="primary" size="sm" wire:click="reassignToSelf" class="w-full">
                                <x-myds.button-icon>
                                    <x-myds.icon name="user-plus" class="w-4 h-4" />
                                </x-myds.button-icon>
                                Tugaskan kepada saya / Assign to me
                            </x-myds.button>
                        @endif
                        <x-myds.select wire:model="statusUpdate" wire:change="updateStatus" label="Kemaskini Status / Update Status" class="w-full" size="small">
                            <option value="">Kemaskini Status / Update Status</option>
                            @foreach($statuses as $status)
                                @if($status->id !== $ticket->status_id)
                                <option value="{{ $status->code }}">{{ $status->name }}</option>
                                @endif
                            @endforeach
                        </x-myds.select>
                    </div>
                </x-myds.card-body>
            </x-myds.card>
        </aside>

        {{-- Main Content with Tabs --}}
        <div class="md:w-2/3 w-full">
            <x-myds.tabs variant="line" size="medium">
                <x-myds.tabs-list>
                    <x-myds.tabs-trigger value="assignment" :active="$activeTab === 'assignment'" wire:click="$set('activeTab', 'assignment')">
                        <x-myds.tabs-icon><x-myds.icon name="user-cog" class="w-4 h-4" /></x-myds.tabs-icon>
                        Penugasan / Assignment
                    </x-myds.tabs-trigger>
                    <x-myds.tabs-trigger value="escalation" :active="$activeTab === 'escalation'" wire:click="$set('activeTab', 'escalation')">
                        <x-myds.tabs-icon><x-myds.icon name="arrow-trending-up" class="w-4 h-4" /></x-myds.tabs-icon>
                        Eskalasi / Escalation
                    </x-myds.tabs-trigger>
                    <x-myds.tabs-trigger value="comments" :active="$activeTab === 'comments'" wire:click="$set('activeTab', 'comments')">
                        <x-myds.tabs-icon><x-myds.icon name="chat-bubble" class="w-4 h-4" /></x-myds.tabs-icon>
                        Komen / Comments
                    </x-myds.tabs-trigger>
                    <x-myds.tabs-trigger value="history" :active="$activeTab === 'history'" wire:click="$set('activeTab', 'history')">
                        <x-myds.tabs-icon><x-myds.icon name="clock" class="w-4 h-4" /></x-myds.tabs-icon>
                        Sejarah / History
                    </x-myds.tabs-trigger>
                </x-myds.tabs-list>

                {{-- Assignment Tab --}}
                @if($activeTab === 'assignment')
                <x-myds.tabs-content value="assignment">
                    <h3 class="text-heading-xs font-semibold text-txt-black-900 mb-4">
                        <x-myds.icon name="user-cog" class="w-5 h-5 mr-2" />
                        Tugaskan Tiket / Assign Ticket
                    </h3>
                    <form wire:submit.prevent="assignTicket" class="space-y-6">
                        {{-- Technician Selection --}}
                        <x-myds.select
                            id="selectedTechnician"
                            label="Pilih Juruteknik / Select Technician"
                            wire:model="selectedTechnician"
                            required
                            size="medium"
                            :invalid="$errors->has('selectedTechnician')"
                        >
                            <option value="">Pilih juruteknik / Select technician</option>
                            @foreach($technicians as $tech)
                                <option value="{{ $tech['id'] }}">
                                    {{ $tech['name'] }} ({{ ucfirst($tech['role']) }})
                                    @if(isset($tech['department'])) - {{ $tech['department'] }}@endif
                                </option>
                            @endforeach
                        </x-myds.select>
                        @error('selectedTechnician')
                            <x-myds.input-error>{{ $message }}</x-myds.input-error>
                        @enderror

                        {{-- Priority --}}
                        <x-myds.select
                            id="priority"
                            label="Keutamaan / Priority"
                            wire:model="priority"
                            size="medium"
                        >
                            <option value="low">Rendah / Low</option>
                            <option value="medium">Sederhana / Medium</option>
                            <option value="high">Tinggi / High</option>
                            <option value="critical">Kritikal / Critical</option>
                        </x-myds.select>

                        {{-- Due Date --}}
                        <x-myds.input
                            id="dueDate"
                            label="Tarikh Akhir / Due Date"
                            type="datetime-local"
                            wire:model="dueDate"
                            min="{{ now()->format('Y-m-d\TH:i') }}"
                            size="medium"
                        />

                        {{-- Assignment Note --}}
                        <x-myds.textarea
                            id="assignmentNote"
                            label="Nota Penugasan / Assignment Note"
                            wire:model="assignmentNote"
                            rows="3"
                            maxlength="500"
                            required
                            :invalid="$errors->has('assignmentNote')"
                            hint="Berikan arahan atau nota tambahan untuk juruteknik. / Provide instructions or additional notes for the technician."
                        />
                        <div class="flex justify-between">
                            @error('assignmentNote')
                                <x-myds.input-error>{{ $message }}</x-myds.input-error>
                            @else
                                <span></span>
                            @enderror
                            <span class="text-xs text-txt-black-500">{{ strlen($assignmentNote) }}/500</span>
                        </div>

                        <x-myds.button
                            type="submit"
                            variant="primary"
                            wire:loading.attr="disabled"
                            wire:target="assignTicket"
                        >
                            <span wire:loading.remove wire:target="assignTicket">
                                <x-myds.button-icon>
                                    <x-myds.icon name="user-plus" class="w-4 h-4" />
                                </x-myds.button-icon>
                                Tugaskan Tiket / Assign Ticket
                            </span>
                            <span wire:loading wire:target="assignTicket">
                                <x-myds.spinner color="white" size="small" class="mr-2" />
                                Menugaskan... / Assigning...
                            </span>
                        </x-myds.button>
                    </form>
                </x-myds.tabs-content>
                @endif

                {{-- Escalation Tab --}}
                @if($activeTab === 'escalation')
                <x-myds.tabs-content value="escalation">
                    <h3 class="text-heading-xs font-semibold text-txt-black-900 mb-4">
                        <x-myds.icon name="arrow-trending-up" class="w-5 h-5 mr-2" />
                        Eskalasi Tiket / Escalate Ticket
                    </h3>
                    <form wire:submit.prevent="escalateTicket" class="space-y-6">
                        <x-myds.radio
                            id="escalationLevel"
                            label="Tahap Eskalasi / Escalation Level"
                            name="escalationLevel"
                            wire:model="escalationLevel"
                            size="medium"
                            :options="[
                                ['label' => 'Penyelia / Supervisor', 'value' => 'supervisor', 'hint' => 'Standard escalation'],
                                ['label' => 'Pengurus / Manager', 'value' => 'manager', 'hint' => 'High priority escalation'],
                                ['label' => 'Luaran / External', 'value' => 'external', 'hint' => 'Vendor or specialist'],
                            ]"
                        />

                        <x-myds.select
                            id="escalateTo"
                            label="Eskalasi kepada / Escalate to"
                            wire:model="escalateTo"
                            required
                            size="medium"
                            :invalid="$errors->has('escalateTo')"
                        >
                            <option value="">Pilih penerima eskalasi / Select escalation recipient</option>
                            @foreach($technicians as $tech)
                                @if(in_array($tech['role'], ['supervisor', 'ict_admin']))
                                    <option value="{{ $tech['id'] }}">
                                        {{ $tech['name'] }} ({{ ucfirst($tech['role']) }})
                                    </option>
                                @endif
                            @endforeach
                        </x-myds.select>
                        @error('escalateTo')
                            <x-myds.input-error>{{ $message }}</x-myds.input-error>
                        @enderror

                        <x-myds.textarea
                            id="escalationReason"
                            label="Sebab Eskalasi / Escalation Reason"
                            wire:model="escalationReason"
                            rows="4"
                            maxlength="500"
                            required
                            :invalid="$errors->has('escalationReason')"
                            hint="Jelaskan mengapa tiket ini perlu dieskalasi. / Explain why this ticket needs to be escalated."
                        />
                        <div class="flex justify-between">
                            @error('escalationReason')
                                <x-myds.input-error>{{ $message }}</x-myds.input-error>
                            @else
                                <span></span>
                            @enderror
                            <span class="text-xs text-txt-black-500">{{ strlen($escalationReason) }}/500</span>
                        </div>

                        <x-myds.button
                            type="submit"
                            variant="danger"
                            wire:loading.attr="disabled"
                            wire:target="escalateTicket"
                        >
                            <span wire:loading.remove wire:target="escalateTicket">
                                <x-myds.button-icon>
                                    <x-myds.icon name="arrow-trending-up" class="w-4 h-4" />
                                </x-myds.button-icon>
                                Eskalasi Tiket / Escalate Ticket
                            </span>
                            <span wire:loading wire:target="escalateTicket">
                                <x-myds.spinner color="white" size="small" class="mr-2" />
                                Mengeskalasi... / Escalating...
                            </span>
                        </x-myds.button>
                    </form>
                </x-myds.tabs-content>
                @endif

                {{-- Comments Tab --}}
                @if($activeTab === 'comments')
                <x-myds.tabs-content value="comments">
                    <h3 class="text-heading-xs font-semibold text-txt-black-900 mb-4">
                        <x-myds.icon name="chat-bubble" class="w-5 h-5 mr-2" />
                        Komen & Kemaskini / Comments & Updates
                    </h3>
                    <form wire:submit.prevent="addComment" class="space-y-4">
                        <x-myds.textarea
                            id="newComment"
                            label="Tambah Komen / Add Comment"
                            wire:model="newComment"
                            rows="3"
                            maxlength="1000"
                            :invalid="$errors->has('newComment')"
                            hint="Tambah komen atau kemaskini / Add comment or update"
                        />
                        <div class="flex justify-between">
                            @error('newComment')
                                <x-myds.input-error>{{ $message }}</x-myds.input-error>
                            @else
                                <span></span>
                            @enderror
                            <span class="text-xs text-txt-black-500">{{ strlen($newComment) }}/1000</span>
                        </div>
                        <x-myds.button type="submit" variant="primary">
                            <x-myds.button-icon>
                                <x-myds.icon name="plus" class="w-4 h-4" />
                            </x-myds.button-icon>
                            Tambah Komen / Add Comment
                        </x-myds.button>
                    </form>
                    <div class="space-y-4 mt-6">
                        @if(empty($comments))
                            <div class="text-center py-8 text-txt-black-500">
                                <x-myds.icon name="chat-bubble" class="w-12 h-12 mx-auto mb-4 text-txt-black-400" />
                                <p>Tiada komen lagi / No comments yet</p>
                            </div>
                        @else
                            @foreach($comments as $comment)
                                <x-myds.card>
                                    <x-myds.card-body>
                                        <div class="flex items-start gap-3">
                                            <x-myds.avatar :name="$comment['user']['name'] ?? 'U'" size="sm" />
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-body-sm font-medium text-txt-black-900">
                                                        {{ $comment['user']['name'] ?? 'Unknown User' }}
                                                    </span>
                                                    <span class="text-xs text-txt-black-500">
                                                        {{ $comment['created_at'] ?? now()->format('d/m/Y H:i') }}
                                                    </span>
                                                </div>
                                                <div class="mt-1 text-body-sm text-txt-black-700">
                                                    {{ $comment['content'] ?? 'No content' }}
                                                </div>
                                            </div>
                                        </div>
                                    </x-myds.card-body>
                                </x-myds.card>
                            @endforeach
                        @endif
                    </div>
                </x-myds.tabs-content>
                @endif

                {{-- History Tab --}}
                @if($activeTab === 'history')
                <x-myds.tabs-content value="history">
                    <h3 class="text-heading-xs font-semibold text-txt-black-900 mb-4">
                        <x-myds.icon name="clock" class="w-5 h-5 mr-2" />
                        Sejarah Tiket / Ticket History
                    </h3>
                    <div class="space-y-4">
                        @if(empty($escalationHistory))
                            <div class="text-center py-8 text-txt-black-500">
                                <x-myds.icon name="clock" class="w-12 h-12 mx-auto mb-4 text-txt-black-400" />
                                <p>Tiada sejarah aktiviti lagi / No activity history yet</p>
                            </div>
                        @else
                            @foreach($escalationHistory as $history)
                                <div class="relative pl-8 pb-4">
                                    <div class="absolute left-0 top-3 w-2 h-2 bg-primary-500 rounded-full"></div>
                                    <div class="absolute left-1 top-7 w-px h-full bg-otl-gray-200"></div>
                                    <x-myds.card class="ml-2">
                                        <x-myds.card-body>
                                            <div class="flex items-center justify-between mb-1">
                                                <span class="text-body-sm font-semibold text-txt-black-900">
                                                    {{ $history['action'] ?? 'Unknown Action' }}
                                                </span>
                                                <span class="text-xs text-txt-black-500">
                                                    {{ $history['created_at'] ?? now()->format('d/m/Y H:i') }}
                                                </span>
                                            </div>
                                            <div class="text-body-sm text-txt-black-700">
                                                {{ $history['description'] ?? 'No description available' }}
                                            </div>
                                        </x-myds.card-body>
                                    </x-myds.card>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </x-myds.tabs-content>
                @endif
            </x-myds.tabs>
        </div>
    </div>

    {{-- Toast messages --}}
    @if (session('success'))
        <x-myds.toast variant="success" :show="true">
            {{ session('success') }}
        </x-myds.toast>
    @endif
    @if (session('error'))
        <x-myds.toast variant="danger" :show="true">
            {{ session('error') }}
        </x-myds.toast>
    @endif
</main>

<x-myds.footer>
    <x-myds.footer-section>
        <x-myds.site-info>
            <x-myds.footer-logo logoTitle="Bahagian Pengurusan Maklumat (BPM)" />
            Aras 13, 14 &amp; 15, Blok Menara, Menara Usahawan, No. 18, Persiaran Perdana, Presint 2, 62000 Putrajaya, Malaysia
            <div class="mt-2">© 2025 BPM, Kementerian Pelancongan, Seni dan Budaya Malaysia.</div>
            <div class="mt-2 flex gap-3">
                <a href="#" aria-label="Facebook" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="facebook" class="w-5 h-5" /></a>
                <a href="#" aria-label="Twitter" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="twitter" class="w-5 h-5" /></a>
                <a href="#" aria-label="Instagram" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="instagram" class="w-5 h-5" /></a>
                <a href="#" aria-label="YouTube" class="text-txt-black-700 hover:text-primary-600"><x-myds.icon name="youtube" class="w-5 h-5" /></a>
            </div>
        </x-myds.site-info>
    </x-myds.footer-section>
</x-myds.footer>
