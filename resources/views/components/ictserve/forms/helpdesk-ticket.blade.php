@props([
    'action' => null,
    'method' => 'POST',
    'ticket' => null,
    'categories' => [],
    'priorities' => ['low', 'medium', 'high', 'urgent'],
    'readonly' => false,
])

{{--
    ICTServe (iServe) Helpdesk Ticket Form
    - Compliant with MYDS (Malaysia Government Design System)
    - Upholds MyGovEA Citizen-Centric and Accessibility principles
    - Uses MYDS semantic tokens, grid, typography, icons, and error prevention strategies
    - Responsive: 12/8/4 grid, tested for all breakpoints
    - Accessibility: Labels, ARIA, keyboard navigation, focus states, non-colour status, clear error messaging
--}}

<div
    class="bg-white dark:bg-gray-900 shadow-card rounded-lg border border-otl-divider"
    {{ $attributes }}
    role="form"
    aria-labelledby="helpdesk-ticket-title"
>
    <form
        @if($action) action="{{ $action }}" @endif
        method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
        @if(!$readonly) wire:submit.prevent="submit" @endif
        enctype="multipart/form-data"
        class="divide-y divide-otl-divider"
    >
        @if($method !== 'GET' && $method !== 'POST')
            @method($method)
        @endif
        @csrf

        {{-- Header --}}
        <div class="px-6 py-4 bg-washed rounded-t-lg">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 id="helpdesk-ticket-title" class="font-poppins text-2xl md:text-3xl font-semibold text-txt-black-900 dark:text-txt-black-900 leading-tight">
                        {{ $readonly ? 'Maklumat Tiket Helpdesk' : 'Borang Aduan/Permintaan Sokongan ICT' }}
                    </h2>
                    <p class="text-sm text-txt-black-700 dark:text-txt-black-700 mt-1">
                        {{ $readonly ? 'Butiran lengkap tiket sokongan ICT' : 'Laporkan masalah ICT atau minta bantuan sokongan teknikal' }}
                    </p>
                </div>
                @if($ticket && isset($ticket['ticket_number']))
                    <div class="text-right">
                        <p class="text-sm font-medium text-txt-black-700">No. Tiket:</p>
                        <p class="text-lg font-bold text-txt-primary">{{ $ticket['ticket_number'] }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Section 1: Reporter Info --}}
        <section class="px-6 py-6 grid gap-6">
            <h3 class="font-poppins text-xl font-semibold text-txt-black-900 mb-4">
                1. Maklumat Pelapor
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Penuh --}}
                <div>
                    <x-myds.label for="reporter_name" required>Nama Penuh</x-myds.label>
                    <x-myds.input
                        type="text"
                        id="reporter_name"
                        name="reporter_name"
                        :value="$ticket['reporter_name'] ?? auth()->user()->name"
                        :readonly="$readonly"
                        wire:model.defer="ticket.reporter_name"
                        autocomplete="name"
                        placeholder="Nama penuh pelapor"
                        required
                    />
                    @error('ticket.reporter_name')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
                {{-- No. Kakitangan --}}
                <div>
                    <x-myds.label for="staff_id" required>No. Kakitangan</x-myds.label>
                    <x-myds.input
                        type="text"
                        id="staff_id"
                        name="staff_id"
                        :value="$ticket['staff_id'] ?? auth()->user()->staff_id"
                        :readonly="$readonly"
                        wire:model.defer="ticket.staff_id"
                        autocomplete="off"
                        placeholder="No. kakitangan"
                        required
                    />
                    @error('ticket.staff_id')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
                {{-- Jabatan/Unit --}}
                <div>
                    <x-myds.label for="department" required>Jabatan/Unit</x-myds.label>
                    <x-myds.input
                        type="text"
                        id="department"
                        name="department"
                        :value="$ticket['department'] ?? auth()->user()->department"
                        :readonly="$readonly"
                        wire:model.defer="ticket.department"
                        autocomplete="organization"
                        placeholder="Jabatan atau unit kerja"
                        required
                    />
                    @error('ticket.department')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
                {{-- Telefon --}}
                <div>
                    <x-myds.label for="phone" required>No. Telefon/Sambungan</x-myds.label>
                    <x-myds.input
                        type="tel"
                        id="phone"
                        name="phone"
                        :value="$ticket['phone'] ?? auth()->user()->phone"
                        :readonly="$readonly"
                        wire:model.defer="ticket.phone"
                        autocomplete="tel"
                        placeholder="012-345-6789 atau Ext: 1234"
                        required
                    />
                    @error('ticket.phone')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
                {{-- Email --}}
                <div>
                    <x-myds.label for="email" required>Alamat E-mel</x-myds.label>
                    <x-myds.input
                        type="email"
                        id="email"
                        name="email"
                        :value="$ticket['email'] ?? auth()->user()->email"
                        :readonly="$readonly"
                        wire:model.defer="ticket.email"
                        autocomplete="email"
                        placeholder="nama@motac.gov.my"
                        required
                    />
                    @error('ticket.email')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
                {{-- Lokasi --}}
                <div>
                    <x-myds.label for="location" required>Lokasi Kejadian</x-myds.label>
                    <x-myds.input
                        type="text"
                        id="location"
                        name="location"
                        :value="$ticket['location'] ?? ''"
                        :readonly="$readonly"
                        wire:model.defer="ticket.location"
                        autocomplete="off"
                        placeholder="Contoh: Bilik 301, Aras 3, Blok A"
                        required
                    />
                    @error('ticket.location')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
            </div>
        </section>

        {{-- Section 2: Issue Details --}}
        <section class="px-6 py-6 grid gap-6">
            <h3 class="font-poppins text-xl font-semibold text-txt-black-900 mb-4">
                2. Butiran Masalah/Permintaan
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Kategori Masalah --}}
                <div>
                    <x-myds.label for="category" required>Kategori Masalah</x-myds.label>
                    <x-myds.select
                        id="category"
                        name="category"
                        :disabled="$readonly"
                        wire:model.live="ticket.category"
                        required
                    >
                        <option value="">Pilih kategori masalah</option>
                        @foreach($categories as $category)
                            <option value="{{ $category['id'] }}" {{ ($ticket['category'] ?? '') === $category['id'] ? 'selected' : '' }}>
                                {{ $category['name'] }}
                            </option>
                        @endforeach
                    </x-myds.select>
                    @error('ticket.category')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
                {{-- Tahap Keutamaan --}}
                <div>
                    <x-myds.label for="priority" required>Tahap Keutamaan</x-myds.label>
                    <x-myds.select
                        id="priority"
                        name="priority"
                        :disabled="$readonly"
                        wire:model.defer="ticket.priority"
                        required
                    >
                        <option value="">Pilih tahap keutamaan</option>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority }}" {{ ($ticket['priority'] ?? '') === $priority ? 'selected' : '' }}>
                                {{ match($priority) {
                                    'low' => 'Rendah',
                                    'medium' => 'Sederhana',
                                    'high' => 'Tinggi',
                                    'urgent' => 'Kecemasan',
                                    default => ucfirst($priority)
                                } }}
                            </option>
                        @endforeach
                    </x-myds.select>
                    @error('ticket.priority')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
            </div>
            {{-- Tajuk Masalah --}}
            <div>
                <x-myds.label for="subject" required>Tajuk Masalah</x-myds.label>
                <x-myds.input
                    type="text"
                    id="subject"
                    name="subject"
                    :value="$ticket['subject'] ?? ''"
                    :readonly="$readonly"
                    wire:model.defer="ticket.subject"
                    autocomplete="off"
                    placeholder="Ringkasan masalah yang dihadapi"
                    required
                />
                @error('ticket.subject')
                    <x-myds.error>{{ $message }}</x-myds.error>
                @enderror
            </div>
            {{-- Penerangan Terperinci --}}
            <div>
                <x-myds.label for="description" required>Penerangan Terperinci</x-myds.label>
                <x-myds.textarea
                    id="description"
                    name="description"
                    :readonly="$readonly"
                    wire:model.defer="ticket.description"
                    rows="6"
                    placeholder="Terangkan masalah dengan lengkap termasuk:&#10;- Apakah yang berlaku?&#10;- Bila masalah mula berlaku?&#10;- Langkah-langkah yang telah diambil?&#10;- Mesej ralat (jika ada)?"
                    required
                >{{ $ticket['description'] ?? '' }}</x-myds.textarea>
                @error('ticket.description')
                    <x-myds.error>{{ $message }}</x-myds.error>
                @enderror
            </div>
            {{-- Aset/Peralatan --}}
            <div>
                <x-myds.label for="asset_details">Butiran Aset/Peralatan</x-myds.label>
                <x-myds.textarea
                    id="asset_details"
                    name="asset_details"
                    :readonly="$readonly"
                    wire:model.defer="ticket.asset_details"
                    rows="3"
                    placeholder="Nyatakan butiran peralatan:&#10;- Jenis (Komputer, Printer, dll)&#10;- Model/Brand&#10;- No. Siri/Aset&#10;- Umur (anggaran)"
                >{{ $ticket['asset_details'] ?? '' }}</x-myds.textarea>
                @error('ticket.asset_details')
                    <x-myds.error>{{ $message }}</x-myds.error>
                @enderror
            </div>
            {{-- Kesan Kepada Kerja --}}
            <div>
                <x-myds.label for="impact_assessment">Kesan Kepada Kerja</x-myds.label>
                <x-myds.select
                    id="impact_assessment"
                    name="impact_assessment"
                    :disabled="$readonly"
                    wire:model.defer="ticket.impact_assessment"
                >
                    <option value="">Pilih kesan kepada kerja</option>
                    <option value="no_impact" {{ ($ticket['impact_assessment'] ?? '') === 'no_impact' ? 'selected' : '' }}>
                        Tiada Kesan - Kerja dapat diteruskan seperti biasa
                    </option>
                    <option value="minor_impact" {{ ($ticket['impact_assessment'] ?? '') === 'minor_impact' ? 'selected' : '' }}>
                        Kesan Kecil - Sedikit gangguan tetapi kerja dapat diteruskan
                    </option>
                    <option value="moderate_impact" {{ ($ticket['impact_assessment'] ?? '') === 'moderate_impact' ? 'selected' : '' }}>
                        Kesan Sederhana - Kerja terganggu, perlu penyelesaian segera
                    </option>
                    <option value="major_impact" {{ ($ticket['impact_assessment'] ?? '') === 'major_impact' ? 'selected' : '' }}>
                        Kesan Besar - Kerja terhenti, perlu penyelesaian segera
                    </option>
                    <option value="critical_impact" {{ ($ticket['impact_assessment'] ?? '') === 'critical_impact' ? 'selected' : '' }}>
                        Kesan Kritikal - Kerja terhenti sepenuhnya, penyelesaian kecemasan diperlukan
                    </option>
                </x-myds.select>
                @error('ticket.impact_assessment')
                    <x-myds.error>{{ $message }}</x-myds.error>
                @enderror
            </div>
        </section>

        {{-- Section 3: Attachments (MYDS File Upload, Guidance Callout) --}}
        @if(!$readonly)
        <section class="px-6 py-6 grid gap-6">
            <h3 class="font-poppins text-xl font-semibold text-txt-black-900 mb-4">
                3. Lampiran (Jika Ada)
            </h3>
            <div class="space-y-4">
                {{-- File Upload --}}
                <div>
                    <x-myds.label for="attachments">Fail Lampiran</x-myds.label>
                    {{-- Use MYDS File Upload component if available; fallback to input --}}
                    <input
                        type="file"
                        id="attachments"
                        name="attachments[]"
                        wire:model="attachments"
                        multiple
                        accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                        class="block w-full text-sm text-txt-black-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
                        aria-describedby="attachments-description"
                    />
                    <p id="attachments-description" class="text-xs text-txt-black-500 mt-1">
                        Format disokong: JPG, PNG, PDF, DOC, DOCX, TXT. Maksimum 5 fail, 10MB setiap fail.
                    </p>
                    @error('attachments.*')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
                {{-- Guidance Callout (MYDS Callout style) --}}
                <div class="bg-info-50 border border-info-200 rounded-lg p-4 flex items-start gap-3">
                    <span class="inline-flex items-center justify-center rounded-full bg-info-100 text-info-600 w-6 h-6"
                          aria-hidden="true">
                        {{-- MYDS info icon, 20x20, 1.5px stroke --}}
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 20 20" aria-hidden="true">
                            <circle cx="10" cy="10" r="8"/>
                            <path d="M10 7v2m0 2v2"/>
                            <circle cx="10" cy="14.5" r="0.75" fill="currentColor"/>
                        </svg>
                    </span>
                    <span class="text-sm text-info-700">
                        <strong>Petua:</strong> Sertakan tangkapan skrin mesej ralat atau foto kerosakan untuk mempercepat diagnosis.
                    </span>
                </div>
            </div>
        </section>
        @endif

        {{-- Section 4: Previous Actions --}}
        <section class="px-6 py-6 grid gap-6">
            <h3 class="font-poppins text-xl font-semibold text-txt-black-900 mb-4">
                {{ $readonly ? '4. Langkah Yang Telah Diambil' : '4. Langkah Yang Telah Cuba Diambil' }}
            </h3>
            <div>
                <x-myds.label for="attempted_solutions">Langkah Penyelesaian</x-myds.label>
                <x-myds.textarea
                    id="attempted_solutions"
                    name="attempted_solutions"
                    :readonly="$readonly"
                    wire:model.defer="ticket.attempted_solutions"
                    rows="4"
                    placeholder="Nyatakan langkah-langkah yang telah cuba diambil untuk menyelesaikan masalah ini:&#10;- Restart komputer/perisian&#10;- Semak sambungan kabel&#10;- Hubungi pihak vendor&#10;- Lain-lain langkah..."
                >{{ $ticket['attempted_solutions'] ?? '' }}</x-myds.textarea>
                @error('ticket.attempted_solutions')
                    <x-myds.error>{{ $message }}</x-myds.error>
                @enderror
            </div>
        </section>

        {{-- Footer: Actions or Status --}}
        @if(!$readonly)
        <footer class="px-6 py-4 bg-washed flex flex-col md:flex-row items-center justify-between gap-3 rounded-b-lg">
            <div class="text-sm text-txt-black-600">
                <span class="text-danger-600">*</span> menandakan medan wajib diisi
            </div>
            <div class="flex flex-col md:flex-row gap-3">
                <x-myds.button
                    type="button"
                    variant="secondary"
                    wire:click="$parent.cancel"
                >
                    Batal
                </x-myds.button>
                <x-myds.button
                    type="submit"
                    variant="primary"
                    wire:loading.attr="disabled"
                    wire:target="submit"
                >
                    <span wire:loading.remove wire:target="submit">Hantar Tiket</span>
                    <span wire:loading wire:target="submit" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menghantar...
                    </span>
                </x-myds.button>
            </div>
        </footer>
        @else
        <footer class="px-6 py-4 bg-washed flex flex-col md:flex-row items-center justify-between gap-3 rounded-b-lg">
            <div class="text-sm text-txt-black-600">
                Tiket dibuat pada:
                <span class="font-medium">
                    {{ $ticket['created_at'] ? $ticket['created_at']->format('d/m/Y \p\a\d\a H:i') : 'Tidak diketahui' }}
                </span>
            </div>
            @if(isset($ticket['status']))
                <x-myds.badge
                    :variant="match($ticket['status']) {
                        'resolved', 'closed' => 'success',
                        'open', 'reopened' => 'info',
                        'in_progress' => 'warning',
                        'on_hold' => 'gray',
                        default => 'gray'
                    }"
                >
                    {{ match($ticket['status']) {
                        'open' => 'Terbuka',
                        'in_progress' => 'Dalam Proses',
                        'on_hold' => 'Ditangguhkan',
                        'resolved' => 'Diselesaikan',
                        'closed' => 'Ditutup',
                        'reopened' => 'Dibuka Semula',
                        default => ucfirst($ticket['status'])
                    } }}
                </x-myds.badge>
            @endif
        </footer>
        @endif
    </form>
</div>
