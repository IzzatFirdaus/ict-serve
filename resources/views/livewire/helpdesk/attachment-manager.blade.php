{{--
    ICTServe (iServe) Ticket Attachments Manager
    - MYDS standards: grid, colour, icon, typography, accessible by default
    - MyGovEA: citizen-centric, clear, error-preventive, consistent
--}}

<x-myds.skiplink href="#main-content">
    <span>Skip to main content</span>
</x-myds.skiplink>

<x-myds.masthead>
    <x-myds.masthead-header>
        <x-myds.masthead-title>Lampiran Tiket / Ticket Attachments</x-myds.masthead-title>
    </x-myds.masthead-header>
    <x-myds.masthead-content>
        <x-myds.masthead-section
            :title="'Tiket #' . $ticket->ticket_number"
            icon="paper-clip"
        >
            {{ $ticket->title }}
        </x-myds.masthead-section>
    </x-myds.masthead-content>
</x-myds.masthead>

<main id="main-content" tabindex="0" class="myds-container max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-heading-m font-semibold text-txt-black-900 flex items-center gap-2">
                <x-myds.icon name="paper-clip" class="w-6 h-6 text-primary-600" />
                Lampiran Tiket / Ticket Attachments
            </h1>
            <div class="text-body-sm text-txt-black-700 mt-1">
                #{{ $ticket->ticket_number }} – {{ $ticket->title }}
            </div>
        </div>
        <div>
            <x-myds.button :href="route('helpdesk.index')" variant="secondary" size="sm">
                <x-myds.button-icon>
                    <x-myds.icon name="arrow-left" class="w-4 h-4" />
                </x-myds.button-icon>
                Kembali / Back
            </x-myds.button>
        </div>
    </div>

    <section class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Upload Section --}}
        @if($canUpload)
        <div class="lg:col-span-1">
            <x-myds.card class="mb-8">
                <x-myds.card-header>
                    <span class="text-heading-xs font-semibold text-txt-black-900 flex items-center gap-2">
                        <x-myds.icon name="cloud-upload" class="w-5 h-5" />
                        Muat Naik Lampiran / Upload Attachments
                    </span>
                </x-myds.card-header>
                <x-myds.card-body>
                    <form wire:submit.prevent="uploadFiles" class="space-y-5" aria-label="Upload Files">
                        <div>
                            <x-myds.file-upload
                                id="file-upload"
                                wire:model="files"
                                :multiple="true"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.xlsx,.txt,.zip"
                                label="Pilih Fail / Select Files"
                                hint="PDF, DOC, DOCX, JPG, PNG, GIF, XLSX, TXT, ZIP. Maksimum 5MB setiap fail."
                                :invalid="$errors->has('files.*')"
                            />
                            @error('files.*')
                                <x-myds.input-error>{{ $message }}</x-myds.input-error>
                            @enderror
                        </div>
                        @if(!empty($files))
                        <div>
                            <label class="myds-label mb-2">Fail Dipilih / Selected Files</label>
                            <ul class="myds-list myds-list-bordered">
                                @foreach($files as $index => $file)
                                <li class="flex items-center justify-between p-2">
                                    <div class="flex items-center gap-2">
                                        <x-myds.icon name="document" class="w-4 h-4 text-txt-black-500" />
                                        <span class="text-body-sm text-txt-black-900">{{ $file->getClientOriginalName() }}</span>
                                    </div>
                                    <span class="text-xs text-txt-black-500">{{ number_format($file->getSize() / 1024, 1) }} KB</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div>
                            <x-myds.textarea
                                id="attachmentDescription"
                                wire:model="attachmentDescription"
                                label="Keterangan (Pilihan) / Description (Optional)"
                                rows="3"
                                maxlength="255"
                                hint="Huraikan fail yang dimuat naik (pilihan) / Describe the uploaded files (optional)"
                                :invalid="$errors->has('attachmentDescription')"
                            />
                            @error('attachmentDescription')
                                <x-myds.input-error>{{ $message }}</x-myds.input-error>
                            @enderror
                        </div>
                        <div>
                            <x-myds.button type="submit" variant="primary" size="md" class="w-full"
                                :disabled="empty($files)"
                                wire:loading.attr="disabled"
                                wire:target="uploadFiles"
                            >
                                <span wire:loading.remove wire:target="uploadFiles">
                                    <x-myds.button-icon>
                                        <x-myds.icon name="cloud-upload" class="w-4 h-4" />
                                    </x-myds.button-icon>
                                    Muat Naik / Upload
                                </span>
                                <span wire:loading wire:target="uploadFiles">
                                    <x-myds.spinner color="white" size="small" class="mr-2" />
                                    Memuat naik... / Uploading...
                                </span>
                            </x-myds.button>
                        </div>
                    </form>
                </x-myds.card-body>
            </x-myds.card>
        </div>
        @endif

        {{-- Attachments List Section --}}
        <div class="{{ $canUpload ? 'lg:col-span-2' : 'lg:col-span-3' }}">
            <x-myds.card>
                <x-myds.card-header>
                    <span class="text-heading-xs font-semibold text-txt-black-900 flex items-center gap-2">
                        <x-myds.icon name="folder-open" class="w-5 h-5" />
                        Lampiran Sedia Ada / Existing Attachments
                        <span class="ml-2 text-body-xs text-txt-black-500">({{ count($attachments) }} fail dilampirkan / files attached)</span>
                    </span>
                </x-myds.card-header>
                <x-myds.card-body>
                    @if(empty($attachments))
                        <div class="text-center py-10">
                            <x-myds.icon name="inbox" class="mx-auto h-12 w-12 text-txt-black-400 mb-4" />
                            <div class="text-heading-xs font-medium text-txt-black-900 mb-1">
                                Tiada lampiran / No attachments
                            </div>
                            <div class="text-body-sm text-txt-black-500">
                                Belum ada fail yang dilampirkan pada tiket ini.<br>No files have been attached to this ticket yet.
                            </div>
                        </div>
                    @else
                        <ul class="myds-list myds-list-divided">
                            @foreach($attachments as $attachment)
                            <li class="py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-2 md:gap-0 hover:bg-bg-washed dark:hover:bg-bg-washed transition-colors rounded-md">
                                <div class="flex items-center gap-3 flex-1 min-w-0">
                                    <div class="flex-shrink-0">
                                        @php
                                            $icon = $this->getFileIcon($attachment['mime_type']);
                                        @endphp
                                        <x-myds.icon :name="$icon" class="w-8 h-8 text-primary-400" />
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="text-body-sm font-medium text-txt-black-900 truncate">
                                            {{ $attachment['original_name'] }}
                                        </div>
                                        <div class="flex flex-wrap items-center text-xs text-txt-black-500 gap-2">
                                            <span>{{ $this->formatFileSize($attachment['size']) }}</span>
                                            <span>•</span>
                                            <span>{{ $attachment['uploaded_by_name'] ?? 'Unknown' }}</span>
                                            <span>•</span>
                                            <span>{{ \Carbon\Carbon::parse($attachment['uploaded_at'])->format('d/m/Y H:i') }}</span>
                                        </div>
                                        @if($attachment['description'])
                                        <div class="text-xs text-txt-black-700 mt-1">
                                            {{ $attachment['description'] }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 mt-2 md:mt-0">
                                    <x-myds.button
                                        type="button"
                                        variant="secondary"
                                        size="sm"
                                        wire:click="downloadFile('{{ $attachment['id'] }}')"
                                        aria-label="Muat turun / Download {{ $attachment['original_name'] }}"
                                    >
                                        <x-myds.button-icon>
                                            <x-myds.icon name="download" class="w-4 h-4" />
                                        </x-myds.button-icon>
                                    </x-myds.button>
                                    @php
                                        $user = Auth::user();
                                        $canDelete = $user->id === (int) $attachment['uploaded_by']
                                            || in_array($user->role, ['ict_admin', 'supervisor'])
                                            || $user->id === $ticket->user_id;
                                    @endphp
                                    @if($canDelete)
                                    <x-myds.button
                                        type="button"
                                        variant="danger"
                                        size="sm"
                                        wire:click="deleteFile('{{ $attachment['id'] }}')"
                                        x-data
                                        x-on:click.prevent="if(!confirm('Adakah anda pasti ingin memadam fail ini? / Are you sure you want to delete this file?')) return false;"
                                        aria-label="Padam / Delete {{ $attachment['original_name'] }}"
                                    >
                                        <x-myds.button-icon>
                                            <x-myds.icon name="trash" class="w-4 h-4" />
                                        </x-myds.button-icon>
                                    </x-myds.button>
                                    @endif
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @endif
                </x-myds.card-body>
            </x-myds.card>
        </div>
    </section>

    {{-- Toast on Success/Error --}}
    @if(session('success'))
        <x-myds.toast variant="success" :show="true">
            {{ session('success') }}
        </x-myds.toast>
    @endif
    @if(session('error'))
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
