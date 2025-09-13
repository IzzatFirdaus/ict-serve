@props([
    'action' => null,
    'method' => 'POST',
    'ticket' => null,
    'categories' => [],
    'priorities' => ['low', 'medium', 'high', 'urgent'],
    'readonly' => false,
])

<div class="bg-bg-white shadow-sm rounded-lg border border-otl-divider" {{ $attributes }}>
    <form 
        @if($action) action="{{ $action }}" @endif
        method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
        @if(!$readonly) wire:submit.prevent="submit" @endif
        class="divide-y divide-otl-divider"
        enctype="multipart/form-data"
    >
        @if($method !== 'GET' && $method !== 'POST')
            @method($method)
        @endif
        @csrf

        {{-- Form Header --}}
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-txt-black-900 font-heading">
                        {{ $readonly ? 'Maklumat Tiket Helpdesk' : 'Borang Aduan/Permintaan Sokongan ICT' }}
                    </h2>
                    <p class="text-sm text-txt-black-600 mt-1">
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

        {{-- Section 1: Reporter Information --}}
        <div class="px-6 py-6">
            <h3 class="text-lg font-medium text-txt-black-900 font-heading mb-4">
                1. Maklumat Pelapor
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Full Name --}}
                <div>
                    <x-myds.label for="reporter_name" required>
                        Nama Penuh
                    </x-myds.label>
                    <x-myds.input 
                        type="text"
                        id="reporter_name"
                        name="reporter_name"
                        :value="$ticket['reporter_name'] ?? auth()->user()->name"
                        :readonly="$readonly"
                        wire:model.defer="ticket.reporter_name"
                        placeholder="Nama penuh pelapor"
                        required
                    />
                    @error('ticket.reporter_name')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Staff ID --}}
                <div>
                    <x-myds.label for="staff_id" required>
                        No. Kakitangan
                    </x-myds.label>
                    <x-myds.input 
                        type="text"
                        id="staff_id"
                        name="staff_id"
                        :value="$ticket['staff_id'] ?? auth()->user()->staff_id"
                        :readonly="$readonly"
                        wire:model.defer="ticket.staff_id"
                        placeholder="No. kakitangan"
                        required
                    />
                    @error('ticket.staff_id')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Department --}}
                <div>
                    <x-myds.label for="department" required>
                        Jabatan/Unit
                    </x-myds.label>
                    <x-myds.input 
                        type="text"
                        id="department"
                        name="department"
                        :value="$ticket['department'] ?? auth()->user()->department"
                        :readonly="$readonly"
                        wire:model.defer="ticket.department"
                        placeholder="Jabatan atau unit kerja"
                        required
                    />
                    @error('ticket.department')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Extension/Phone --}}
                <div>
                    <x-myds.label for="phone" required>
                        No. Telefon/Sambungan
                    </x-myds.label>
                    <x-myds.input 
                        type="tel"
                        id="phone"
                        name="phone"
                        :value="$ticket['phone'] ?? auth()->user()->phone"
                        :readonly="$readonly"
                        wire:model.defer="ticket.phone"
                        placeholder="012-345-6789 atau Ext: 1234"
                        required
                    />
                    @error('ticket.phone')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <x-myds.label for="email" required>
                        Alamat E-mel
                    </x-myds.label>
                    <x-myds.input 
                        type="email"
                        id="email"
                        name="email"
                        :value="$ticket['email'] ?? auth()->user()->email"
                        :readonly="$readonly"
                        wire:model.defer="ticket.email"
                        placeholder="nama@motac.gov.my"
                        required
                    />
                    @error('ticket.email')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Location --}}
                <div>
                    <x-myds.label for="location" required>
                        Lokasi Kejadian
                    </x-myds.label>
                    <x-myds.input 
                        type="text"
                        id="location"
                        name="location"
                        :value="$ticket['location'] ?? ''"
                        :readonly="$readonly"
                        wire:model.defer="ticket.location"
                        placeholder="Contoh: Bilik 301, Aras 3, Blok A"
                        required
                    />
                    @error('ticket.location')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section 2: Issue Details --}}
        <div class="px-6 py-6">
            <h3 class="text-lg font-medium text-txt-black-900 font-heading mb-4">
                2. Butiran Masalah/Permintaan
            </h3>

            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Category --}}
                    <div>
                        <x-myds.label for="category" required>
                            Kategori Masalah
                        </x-myds.label>
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

                    {{-- Priority --}}
                    <div>
                        <x-myds.label for="priority" required>
                            Tahap Keutamaan
                        </x-myds.label>
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

                {{-- Subject --}}
                <div>
                    <x-myds.label for="subject" required>
                        Tajuk Masalah
                    </x-myds.label>
                    <x-myds.input 
                        type="text"
                        id="subject"
                        name="subject"
                        :value="$ticket['subject'] ?? ''"
                        :readonly="$readonly"
                        wire:model.defer="ticket.subject"
                        placeholder="Ringkasan ringkas masalah yang dihadapi"
                        required
                    />
                    @error('ticket.subject')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <x-myds.label for="description" required>
                        Penerangan Terperinci
                    </x-myds.label>
                    <x-myds.textarea 
                        id="description"
                        name="description"
                        :readonly="$readonly"
                        wire:model.defer="ticket.description"
                        rows="6"
                        placeholder="Terangkan masalah dengan lengkap termasuk:
- Apakah yang berlaku?
- Bila masalah mula berlaku?
- Langkah-langkah yang telah diambil?
- Mesej ralat (jika ada)?"
                        required
                    >{{ $ticket['description'] ?? '' }}</x-myds.textarea>
                    @error('ticket.description')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Asset/Equipment Details --}}
                <div>
                    <x-myds.label for="asset_details">
                        Butiran Aset/Peralatan
                    </x-myds.label>
                    <x-myds.textarea 
                        id="asset_details"
                        name="asset_details"
                        :readonly="$readonly"
                        wire:model.defer="ticket.asset_details"
                        rows="3"
                        placeholder="Nyatakan butiran peralatan yang bermasalah:
- Jenis peralatan (Komputer, Laptop, Printer, dll)
- Model/Brand
- No. Siri/Aset (jika ada)
- Umur peralatan (anggaran)"
                    >{{ $ticket['asset_details'] ?? '' }}</x-myds.textarea>
                    @error('ticket.asset_details')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Impact Assessment --}}
                <div>
                    <x-myds.label for="impact_assessment">
                        Kesan Kepada Kerja
                    </x-myds.label>
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
            </div>
        </div>

        {{-- Section 3: Attachments --}}
        @if(!$readonly)
            <div class="px-6 py-6">
                <h3 class="text-lg font-medium text-txt-black-900 font-heading mb-4">
                    3. Lampiran (Jika Ada)
                </h3>

                <div class="space-y-4">
                    <div>
                        <x-myds.label for="attachments">
                            Fail Lampiran
                        </x-myds.label>
                        <input 
                            type="file"
                            id="attachments"
                            name="attachments[]"
                            wire:model="attachments"
                            multiple
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt"
                            class="block w-full text-sm text-txt-black-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100"
                        />
                        <p class="text-xs text-txt-black-500 mt-1">
                            Format disokong: JPG, PNG, PDF, DOC, DOCX, TXT. Maksimum 5 fail, 10MB setiap fail.
                        </p>
                        @error('attachments.*')
                            <x-myds.error>{{ $message }}</x-myds.error>
                        @enderror
                    </div>

                    {{-- Screenshot/Evidence Info --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    <strong>Petua:</strong> Sertakan tangkapan skrin (screenshot) mesej ralat atau foto kerosakan untuk membantu proses diagnosis.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Section 4: Previous Actions --}}
        <div class="px-6 py-6">
            <h3 class="text-lg font-medium text-txt-black-900 font-heading mb-4">
                {{ $readonly ? '4. Langkah Yang Telah Diambil' : '4. Langkah Yang Telah Cuba Diambil' }}
            </h3>

            <div>
                <x-myds.label for="attempted_solutions">
                    Langkah Penyelesaian
                </x-myds.label>
                <x-myds.textarea 
                    id="attempted_solutions"
                    name="attempted_solutions"
                    :readonly="$readonly"
                    wire:model.defer="ticket.attempted_solutions"
                    rows="4"
                    placeholder="Nyatakan langkah-langkah yang telah cuba diambil untuk menyelesaikan masalah ini:
- Restart komputer/perisian
- Semak sambungan kabel
- Hubungi pihak vendor
- Lain-lain langkah..."
                >{{ $ticket['attempted_solutions'] ?? '' }}</x-myds.textarea>
                @error('ticket.attempted_solutions')
                    <x-myds.error>{{ $message }}</x-myds.error>
                @enderror
            </div>
        </div>

        {{-- Form Actions --}}
        @if(!$readonly)
            <div class="px-6 py-4 bg-gray-50 flex items-center justify-between">
                <div class="text-sm text-txt-black-600">
                    <span class="text-danger-600">*</span> menandakan medan wajib diisi
                </div>
                
                <div class="flex space-x-3">
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
                        <span wire:loading.remove wire:target="submit">
                            Hantar Tiket
                        </span>
                        <span wire:loading wire:target="submit" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Menghantar...
                        </span>
                    </x-myds.button>
                </div>
            </div>
        @else
            {{-- Read-only Footer --}}
            <div class="px-6 py-4 bg-gray-50">
                <div class="flex items-center justify-between">
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
                </div>
            </div>
        @endif
    </form>
</div>