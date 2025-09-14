@section('title', "Tiket {$ticket->ticket_number} - ICTServe")

<div class="bg-background-light dark:bg-background-dark min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Header -->
        <x-myds.header>
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="flex items-center space-x-4 mb-2">
                        <x-myds.button variant="secondary" size="small" onclick="window.history.back()">
                            <x-myds.icon name="arrow-left" size="14" class="mr-2" />
                            Kembali ke Senarai Tiket
                        </x-myds.button>
                    </div>
                    <h1 class="font-poppins text-2xl font-semibold text-black-900 dark:text-white mb-2">
                        Tiket #{{ $ticket->ticket_number }}
                    </h1>
                    <p class="font-inter text-sm text-black-600 dark:text-black-400">{{ $ticket->title }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    @php
                        $statusColor = $ticket->ticketStatus->color ?? 'gray';
                        $statusColorClass = match($statusColor) {
                            'blue' => 'bg-primary-100 text-primary-700 dark:bg-primary-900 dark:text-primary-300',
                            'yellow' => 'bg-warning-100 text-warning-700 dark:bg-warning-900 dark:text-warning-300',
                            'green' => 'bg-success-100 text-success-700 dark:bg-success-900 dark:text-success-300',
                            'red' => 'bg-danger-100 text-danger-700 dark:bg-danger-900 dark:text-danger-300',
                            default => 'bg-black-100 text-black-700 dark:bg-black-800 dark:text-black-300'
                        };
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full font-inter text-sm font-medium {{ $statusColorClass }}">
                        {{ $ticket->ticketStatus->name ?? 'Unknown' }}
                    </span>
                </div>
            </div>
        </x-myds.header>

        <!-- Status Progress -->
        <div class="bg-white dark:bg-dialog border border-divider rounded-lg p-6 mb-6">
            <h3 class="font-poppins text-lg font-medium text-black-900 dark:text-white mb-4">
                Kemajuan Tiket
            </h3>
            <div class="relative">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-inter text-sm font-medium text-black-700 dark:text-black-300">Kemajuan</span>
                    <span class="font-inter text-sm text-black-500 dark:text-black-400">
                        {{ $statusProgress['current'] }} daripada {{ $statusProgress['total'] }} langkah
                    </span>
                </div>
                <div class="w-full bg-black-200 dark:bg-black-700 rounded-full h-2">
                    <div
                        class="bg-primary-600 h-2 rounded-full transition-all duration-300"
                        style="width: {{ $statusProgress['percentage'] }}%"
                    ></div>
                </div>
                <div class="flex justify-between mt-2 font-inter text-xs text-black-500 dark:text-black-400">
                    <span>Terbuka</span>
                    <span>Diberikan</span>
                    <span>Dalam Proses</span>
                    <span>Selesai</span>
                    <span>Ditutup</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Description -->
                <div class="bg-white dark:bg-dialog border border-divider rounded-lg p-6">
                    <h3 class="font-poppins text-lg font-medium text-black-900 dark:text-white mb-4">
                        Huraian
                    </h3>
                    <div class="prose prose-sm max-w-none">
                        @if($showFullDescription || strlen($ticket->description) <= 300)
                            <p class="font-inter text-sm text-black-700 dark:text-black-300 whitespace-pre-wrap">
                                {{ $ticket->description }}
                            </p>
                        @else
                            <p class="font-inter text-sm text-black-700 dark:text-black-300 whitespace-pre-wrap">
                                {{ substr($ticket->description, 0, 300) }}...
                            </p>
                            <x-myds.button
                                variant="secondary"
                                size="small"
                                class="mt-2"
                                wire:click="toggleDescription"
                            >
                                Tunjuk Lagi
                            </x-myds.button>
                        @endif

                        @if($showFullDescription && strlen($ticket->description) > 300)
                            <x-myds.button
                                variant="secondary"
                                size="small"
                                class="mt-2"
                                wire:click="toggleDescription"
                            >
                                Tunjuk Kurang
                            </x-myds.button>
                        @endif
                    </div>
                </div>

                <!-- Attachments -->
                @if($ticket->attachments && count($ticket->attachments) > 0)
                    <div class="bg-white dark:bg-dialog border border-divider rounded-lg p-6">
                        <h3 class="font-poppins text-lg font-medium text-black-900 dark:text-white mb-4">
                            Lampiran
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($ticket->attachments as $attachment)
                                <div class="flex items-center p-3 bg-washed dark:bg-black-100 rounded-lg">
                                    <div class="flex-shrink-0">
                                        @php
                                            $extension = pathinfo($attachment, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                        @endphp

                                        @if($isImage)
                                            <x-myds.icon name="image" size="32" class="text-primary-500" />
                                        @else
                                            <x-myds.icon name="document" size="32" class="text-black-500" />
                                        @endif
                                    </div>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <p class="font-inter text-sm font-medium text-black-900 dark:text-white truncate">
                                            {{ $attachment }}
                                        </p>
                                        <p class="font-inter text-sm text-black-500 dark:text-black-400">
                                            Fail {{ strtoupper($extension) }}
                                        </p>
                                    </div>
                                    <div class="ml-3">
                                        <x-myds.button
                                            variant="secondary"
                                            size="small"
                                            wire:click="downloadAttachment('{{ $attachment }}')"
                                        >
                                            <x-myds.icon name="download" size="14" class="mr-1" />
                                            Muat Turun
                                        </x-myds.button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Resolution (if resolved) -->
                @if($ticket->resolved_at)
                    <x-myds.callout variant="success">
                        <x-myds.icon name="check-circle" size="20" class="flex-shrink-0" />
                        <div>
                            <h4 class="font-inter text-sm font-medium text-success-700 dark:text-success-500 mb-2">
                                Penyelesaian
                            </h4>
                            @if($ticket->resolution)
                                <p class="font-inter text-sm text-success-700 dark:text-success-500 mb-2">
                                    {{ $ticket->resolution }}
                                </p>
                            @endif
                            @if($ticket->resolution_notes)
                                <div class="font-inter text-sm text-success-700 dark:text-success-500 mb-2">
                                    <strong>Nota:</strong> {{ $ticket->resolution_notes }}
                                </div>
                            @endif
                            <div class="font-inter text-sm text-success-600 dark:text-success-400">
                                Diselesaikan pada {{ $ticket->resolved_at->format('j F Y \p\a\d\a g:i A') }}
                                @if($ticket->resolvedBy)
                                    oleh {{ $ticket->resolvedBy->name }}
                                @endif
                            </div>
                        </div>
                    </x-myds.callout>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Ticket Details -->
                <div class="bg-white dark:bg-dialog border border-divider rounded-lg p-6">
                    <h3 class="font-poppins text-lg font-medium text-black-900 dark:text-white mb-4">
                        Butiran Tiket
                    </h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="font-inter text-sm font-medium text-black-500 dark:text-black-400">Dicipta</dt>
                            <dd class="font-inter text-sm text-black-900 dark:text-white">
                                {{ $ticket->created_at->format('j F Y \p\a\d\a g:i A') }}
                            </dd>
                        </div>

                        <div>
                            <dt class="font-inter text-sm font-medium text-black-500 dark:text-black-400">Kategori</dt>
                            <dd class="font-inter text-sm text-black-900 dark:text-white">
                                {{ $ticket->category->name ?? 'N/A' }}
                            </dd>
                        </div>

                        <div>
                            <dt class="font-inter text-sm font-medium text-black-500 dark:text-black-400">Keutamaan</dt>
                            <dd>
                                @php
                                    $priorityColors = [
                                        'low' => 'bg-success-100 text-success-700 dark:bg-success-900 dark:text-success-300',
                                        'medium' => 'bg-warning-100 text-warning-700 dark:bg-warning-900 dark:text-warning-300',
                                        'high' => 'bg-danger-100 text-danger-700 dark:bg-danger-900 dark:text-danger-300',
                                        'critical' => 'bg-danger-200 text-danger-800 dark:bg-danger-800 dark:text-danger-200'
                                    ];
                                    $priorityColorClass = $priorityColors[$ticket->priority->value] ?? 'bg-black-100 text-black-700 dark:bg-black-800 dark:text-black-300';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-inter text-xs font-medium {{ $priorityColorClass }}">
                                    {{ $ticket->priority->label() }}
                                </span>
                            </dd>
                        </div>

                        <div>
                            <dt class="font-inter text-sm font-medium text-black-500 dark:text-black-400">Kecemasan</dt>
                            <dd>
                                @php
                                    $urgencyColors = [
                                        'low' => 'bg-success-100 text-success-700 dark:bg-success-900 dark:text-success-300',
                                        'medium' => 'bg-warning-100 text-warning-700 dark:bg-warning-900 dark:text-warning-300',
                                        'high' => 'bg-danger-100 text-danger-700 dark:bg-danger-900 dark:text-danger-300',
                                        'critical' => 'bg-danger-200 text-danger-800 dark:bg-danger-800 dark:text-danger-200'
                                    ];
                                    $urgencyColorClass = $urgencyColors[$ticket->urgency->value] ?? 'bg-black-100 text-black-700 dark:bg-black-800 dark:text-black-300';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full font-inter text-xs font-medium {{ $urgencyColorClass }}">
                                    {{ $ticket->urgency->label() }}
                                </span>
                            </dd>
                        </div>

                        @if($ticket->equipmentItem)
                            <div>
                                <dt class="font-inter text-sm font-medium text-black-500 dark:text-black-400">Peralatan</dt>
                                <dd class="font-inter text-sm text-black-900 dark:text-white">
                                    {{ $ticket->equipmentItem->name }}
                                    @if($ticket->equipmentItem->serial_number)
                                        <br><span class="text-black-500 dark:text-black-400">S/N: {{ $ticket->equipmentItem->serial_number }}</span>
                                    @endif
                                </dd>
                            </div>
                        @endif

                        <div>
                            <dt class="font-inter text-sm font-medium text-black-500 dark:text-black-400">Lokasi</dt>
                            <dd class="font-inter text-sm text-black-900 dark:text-white">{{ $ticket->location }}</dd>
                        </div>

                        <div>
                            <dt class="font-inter text-sm font-medium text-black-500 dark:text-black-400">Telefon Hubungan</dt>
                            <dd class="font-inter text-sm text-black-900 dark:text-white">{{ $ticket->contact_phone }}</dd>
                        </div>

                        @if($ticket->due_at)
                            <div>
                                <dt class="font-inter text-sm font-medium text-black-500 dark:text-black-400">Tarikh Tamat</dt>
                                <dd class="font-inter text-sm {{ $ticket->isOverdue() ? 'text-danger-600 font-medium' : 'text-black-900 dark:text-white' }}">
                                    {{ $ticket->due_at->format('j F Y \p\a\d\a g:i A') }}
                                    @if($ticket->isOverdue())
                                        <span class="text-xs text-danger-500">(Tertunggak)</span>
                                    @endif
                                </dd>
                            </div>
                        @endif

                        @if($ticket->assignedTo)
                            <div>
                                <dt class="font-inter text-sm font-medium text-black-500 dark:text-black-400">Diberikan Kepada</dt>
                                <dd class="font-inter text-sm text-black-900 dark:text-white">{{ $ticket->assignedTo->name }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- SLA Information -->
                <x-myds.callout variant="info">
                    <x-myds.icon name="info" size="20" class="flex-shrink-0" />
                    <div>
                        <h4 class="font-inter text-sm font-medium text-primary-700 dark:text-primary-400 mb-2">
                            Perjanjian Tahap Perkhidmatan
                        </h4>
                        <p class="font-inter text-sm text-primary-700 dark:text-primary-400 mb-2">
                            Sasaran masa respons berdasarkan keutamaan: <strong>{{ $ticket->priority->label() }}</strong>
                        </p>
                        @if($ticket->response_time)
                            <p class="font-inter text-sm text-primary-600 dark:text-primary-300">
                                Masa respons: <strong>{{ number_format($ticket->response_time, 1) }} jam</strong>
                            </p>
                        @endif
                        @if($ticket->resolution_time)
                            <p class="font-inter text-sm text-primary-600 dark:text-primary-300">
                                Masa penyelesaian: <strong>{{ number_format($ticket->resolution_time, 1) }} jam</strong>
                            </p>
                        @endif
                    </div>
                </x-myds.callout>

                <!-- Actions -->
                <div class="bg-white dark:bg-dialog border border-divider rounded-lg p-6">
                    <h3 class="font-poppins text-lg font-medium text-black-900 dark:text-white mb-4">
                        Tindakan
                    </h3>
                    <div class="space-y-2">
                        <x-myds.button
                            variant="secondary"
                            class="w-full justify-center"
                            onclick="window.history.back()"
                        >
                            <x-myds.icon name="list" size="16" class="mr-2" />
                            Lihat Semua Tiket
                        </x-myds.button>

                        <x-myds.button variant="primary" class="w-full justify-center">
                            <x-myds.icon name="plus" size="16" class="mr-2" />
                            Cipta Tiket Baharu
                        </x-myds.button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
