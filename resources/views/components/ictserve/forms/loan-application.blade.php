@props([
    'action' => null,
    'method' => 'POST',
    'application' => null,
    'equipmentCategories' => [],
    'readonly' => false,
])

<div class="bg-bg-white shadow-sm rounded-lg border border-otl-divider" {{ $attributes }}>
    <form 
        @if($action) action="{{ $action }}" @endif
        method="{{ $method === 'GET' ? 'GET' : 'POST' }}"
        @if(!$readonly) wire:submit.prevent="submit" @endif
        class="divide-y divide-otl-divider"
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
                        {{ $readonly ? 'Maklumat Permohonan Pinjaman' : 'Borang Permohonan Pinjaman Peralatan ICT' }}
                    </h2>
                    <p class="text-sm text-txt-black-600 mt-1">
                        {{ $readonly ? 'Butiran lengkap permohonan pinjaman peralatan' : 'Sila isi maklumat berikut dengan lengkap dan tepat' }}
                    </p>
                </div>
                @if($application && isset($application['reference_number']))
                    <div class="text-right">
                        <p class="text-sm font-medium text-txt-black-700">No. Rujukan:</p>
                        <p class="text-lg font-bold text-txt-primary">{{ $application['reference_number'] }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Section 1: Applicant Information --}}
        <div class="px-6 py-6">
            <h3 class="text-lg font-medium text-txt-black-900 font-heading mb-4">
                1. Maklumat Pemohon
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Full Name --}}
                <div>
                    <x-myds.label for="applicant_name" required>
                        Nama Penuh
                    </x-myds.label>
                    <x-myds.input 
                        type="text"
                        id="applicant_name"
                        name="applicant_name"
                        :value="$application['applicant_name'] ?? auth()->user()->name"
                        :readonly="$readonly"
                        wire:model.defer="application.applicant_name"
                        placeholder="Nama penuh pemohon"
                        required
                    />
                    @error('application.applicant_name')
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
                        :value="$application['staff_id'] ?? auth()->user()->staff_id"
                        :readonly="$readonly"
                        wire:model.defer="application.staff_id"
                        placeholder="No. kakitangan"
                        required
                    />
                    @error('application.staff_id')
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
                        :value="$application['department'] ?? auth()->user()->department"
                        :readonly="$readonly"
                        wire:model.defer="application.department"
                        placeholder="Jabatan atau unit kerja"
                        required
                    />
                    @error('application.department')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Position --}}
                <div>
                    <x-myds.label for="position" required>
                        Jawatan
                    </x-myds.label>
                    <x-myds.input 
                        type="text"
                        id="position"
                        name="position"
                        :value="$application['position'] ?? auth()->user()->position"
                        :readonly="$readonly"
                        wire:model.defer="application.position"
                        placeholder="Jawatan pemohon"
                        required
                    />
                    @error('application.position')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Phone Number --}}
                <div>
                    <x-myds.label for="phone" required>
                        No. Telefon
                    </x-myds.label>
                    <x-myds.input 
                        type="tel"
                        id="phone"
                        name="phone"
                        :value="$application['phone'] ?? auth()->user()->phone"
                        :readonly="$readonly"
                        wire:model.defer="application.phone"
                        placeholder="012-345-6789"
                        required
                    />
                    @error('application.phone')
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
                        :value="$application['email'] ?? auth()->user()->email"
                        :readonly="$readonly"
                        wire:model.defer="application.email"
                        placeholder="nama@motac.gov.my"
                        required
                    />
                    @error('application.email')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section 2: Equipment Request --}}
        <div class="px-6 py-6">
            <h3 class="text-lg font-medium text-txt-black-900 font-heading mb-4">
                2. Maklumat Peralatan Diperlukan
            </h3>

            <div class="space-y-6">
                {{-- Equipment Category --}}
                <div>
                    <x-myds.label for="equipment_category" required>
                        Kategori Peralatan
                    </x-myds.label>
                    <x-myds.select 
                        id="equipment_category"
                        name="equipment_category"
                        :disabled="$readonly"
                        wire:model.live="application.equipment_category"
                        required
                    >
                        <option value="">Pilih kategori peralatan</option>
                        @foreach($equipmentCategories as $category)
                            <option value="{{ $category['id'] }}" {{ ($application['equipment_category'] ?? '') === $category['id'] ? 'selected' : '' }}>
                                {{ $category['name'] }}
                            </option>
                        @endforeach
                    </x-myds.select>
                    @error('application.equipment_category')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Equipment Type --}}
                <div>
                    <x-myds.label for="equipment_type" required>
                        Jenis Peralatan
                    </x-myds.label>
                    <x-myds.input 
                        type="text"
                        id="equipment_type"
                        name="equipment_type"
                        :value="$application['equipment_type'] ?? ''"
                        :readonly="$readonly"
                        wire:model.defer="application.equipment_type"
                        placeholder="Contoh: Laptop, Projektor, Kamera Digital"
                        required
                    />
                    @error('application.equipment_type')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Quantity --}}
                <div>
                    <x-myds.label for="quantity" required>
                        Kuantiti
                    </x-myds.label>
                    <x-myds.input 
                        type="number"
                        id="quantity"
                        name="quantity"
                        :value="$application['quantity'] ?? 1"
                        :readonly="$readonly"
                        wire:model.defer="application.quantity"
                        min="1"
                        max="10"
                        required
                    />
                    <p class="text-xs text-txt-black-500 mt-1">Maksimum 10 unit bagi satu permohonan</p>
                    @error('application.quantity')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Specifications --}}
                <div>
                    <x-myds.label for="specifications">
                        Spesifikasi Khusus (Jika ada)
                    </x-myds.label>
                    <x-myds.textarea 
                        id="specifications"
                        name="specifications"
                        :readonly="$readonly"
                        wire:model.defer="application.specifications"
                        rows="3"
                        placeholder="Nyatakan spesifikasi khusus yang diperlukan, contoh: RAM minimum 16GB, Storage SSD 512GB"
                    >{{ $application['specifications'] ?? '' }}</x-myds.textarea>
                    @error('application.specifications')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section 3: Usage Details --}}
        <div class="px-6 py-6">
            <h3 class="text-lg font-medium text-txt-black-900 font-heading mb-4">
                3. Butiran Penggunaan
            </h3>

            <div class="space-y-6">
                {{-- Purpose --}}
                <div>
                    <x-myds.label for="purpose" required>
                        Tujuan Penggunaan
                    </x-myds.label>
                    <x-myds.textarea 
                        id="purpose"
                        name="purpose"
                        :readonly="$readonly"
                        wire:model.defer="application.purpose"
                        rows="4"
                        placeholder="Nyatakan dengan jelas tujuan penggunaan peralatan ICT ini"
                        required
                    >{{ $application['purpose'] ?? '' }}</x-myds.textarea>
                    @error('application.purpose')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                {{-- Usage Location --}}
                <div>
                    <x-myds.label for="usage_location" required>
                        Lokasi Penggunaan
                    </x-myds.label>
                    <x-myds.input 
                        type="text"
                        id="usage_location"
                        name="usage_location"
                        :value="$application['usage_location'] ?? ''"
                        :readonly="$readonly"
                        wire:model.defer="application.usage_location"
                        placeholder="Contoh: Bilik Mesyuarat A, Dewan Utama, Pejabat Pengarah"
                        required
                    />
                    @error('application.usage_location')
                        <x-myds.error>{{ $message }}</x-myds.error>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Start Date --}}
                    <div>
                        <x-myds.label for="loan_start_date" required>
                            Tarikh Mula Pinjaman
                        </x-myds.label>
                        <x-myds.input 
                            type="date"
                            id="loan_start_date"
                            name="loan_start_date"
                            :value="$application['loan_start_date'] ?? ''"
                            :readonly="$readonly"
                            wire:model.defer="application.loan_start_date"
                            :min="date('Y-m-d')"
                            required
                        />
                        @error('application.loan_start_date')
                            <x-myds.error>{{ $message }}</x-myds.error>
                        @enderror
                    </div>

                    {{-- End Date --}}
                    <div>
                        <x-myds.label for="loan_end_date" required>
                            Tarikh Akhir Pinjaman
                        </x-myds.label>
                        <x-myds.input 
                            type="date"
                            id="loan_end_date"
                            name="loan_end_date"
                            :value="$application['loan_end_date'] ?? ''"
                            :readonly="$readonly"
                            wire:model.defer="application.loan_end_date"
                            :min="date('Y-m-d', strtotime('+1 day'))"
                            required
                        />
                        @error('application.loan_end_date')
                            <x-myds.error>{{ $message }}</x-myds.error>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 4: Terms & Conditions --}}
        @if(!$readonly)
            <div class="px-6 py-6">
                <h3 class="text-lg font-medium text-txt-black-900 font-heading mb-4">
                    4. Terma dan Syarat
                </h3>

                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <h4 class="font-medium text-txt-black-900 mb-3">Syarat-syarat Pinjaman:</h4>
                    <ul class="text-sm text-txt-black-700 space-y-2 list-disc list-inside">
                        <li>Peralatan yang dipinjam hendaklah dijaga dengan baik dan digunakan mengikut tujuan yang dinyatakan sahaja.</li>
                        <li>Peminjam bertanggungjawab sepenuhnya terhadap sebarang kerosakan atau kehilangan peralatan.</li>
                        <li>Peralatan mesti dipulangkan mengikut tarikh yang ditetapkan dan dalam keadaan baik.</li>
                        <li>Sebarang kerosakan hendaklah dilaporkan segera kepada Bahagian Pengurusan Maklumat.</li>
                        <li>Peminjam tidak dibenarkan meminjamkan peralatan kepada pihak ketiga.</li>
                        <li>BPM berhak untuk menarik balik peralatan pada bila-bila masa jika perlu.</li>
                    </ul>
                </div>

                <div class="space-y-4">
                    <x-myds.checkbox 
                        id="terms_accepted"
                        name="terms_accepted"
                        wire:model.defer="application.terms_accepted"
                        required
                    >
                        Saya bersetuju dengan semua terma dan syarat yang dinyatakan di atas.
                    </x-myds.checkbox>

                    <x-myds.checkbox 
                        id="responsibility_accepted"
                        name="responsibility_accepted"
                        wire:model.defer="application.responsibility_accepted"
                        required
                    >
                        Saya mengaku bertanggungjawab sepenuhnya terhadap peralatan yang dipinjam.
                    </x-myds.checkbox>

                    <x-myds.checkbox 
                        id="data_consent"
                        name="data_consent"
                        wire:model.defer="application.data_consent"
                        required
                    >
                        Saya bersetuju untuk maklumat yang diberikan digunakan untuk tujuan pemprosesan permohonan ini.
                    </x-myds.checkbox>
                </div>

                @error('application.terms_accepted')
                    <x-myds.error>{{ $message }}</x-myds.error>
                @enderror
            </div>
        @endif

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
                            Hantar Permohonan
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
                        Permohonan dihantar pada: 
                        <span class="font-medium">
                            {{ $application['created_at'] ? $application['created_at']->format('d/m/Y \p\a\d\a H:i') : 'Tidak diketahui' }}
                        </span>
                    </div>
                    
                    @if(isset($application['status']))
                        <x-myds.badge 
                            :variant="match($application['status']) {
                                'approved' => 'success',
                                'pending_support', 'pending_approval' => 'warning',
                                'rejected' => 'danger',
                                'issued' => 'info',
                                'completed' => 'success',
                                default => 'gray'
                            }"
                        >
                            {{ match($application['status']) {
                                'pending_support' => 'Menunggu Sokongan',
                                'pending_approval' => 'Menunggu Kelulusan',
                                'approved' => 'Diluluskan',
                                'rejected' => 'Ditolak',
                                'issued' => 'Telah Dikeluarkan',
                                'completed' => 'Selesai',
                                default => ucfirst($application['status'])
                            } }}
                        </x-myds.badge>
                    @endif
                </div>
            </div>
        @endif
    </form>
</div>