<div>
@section('title', 'Borang Permohonan Peminjaman Peralatan ICT')

<!-- Content Banner -->
<div class="bg-primary-50 border-b border-otl-divider">
    <x-myds.container>
        <x-myds.grid>
            <x-myds.grid-item span="full">
                <x-myds.heading level="1" class="mb-2">Borang Permohonan Peminjaman Peralatan ICT</x-myds.heading>
                <x-myds.text variant="secondary" class="mb-3">Untuk Kegunaan Rasmi Kementerian Pelancongan, Seni dan Budaya</x-myds.text>
                <x-myds.breadcrumb :items="[
                    ['label' => 'Utama', 'url' => '/'],
                    ['label' => 'ServiceDesk ICT'],
                    ['label' => 'Permohonan Peminjaman']
                ]" />
            </x-myds.grid-item>
        </x-myds.grid>
    </x-myds.container>
</div>

<x-myds.container class="py-12">
    <x-myds.grid>
        <x-myds.grid-item span="10" offset="1">
            <!-- Success Message -->
            @if (session('success'))
                <x-myds.alert variant="success" class="mb-6">
                    <strong>Berjaya!</strong> {{ session('success') }}
                </x-myds.alert>
            @endif

            <form wire:submit="submit" class="space-y-8">
                <!-- Part 1: Applicant Information -->
                <x-myds.card>
                    <x-myds.heading level="2" class="mb-6 pb-3 border-b border-otl-divider">
                        Bahagian 1: Maklumat Pemohon
                    </x-myds.heading>

                    <x-myds.grid>
                        <x-myds.grid-item span="6">
                            <x-myds.input
                                label="Nama Penuh"
                                name="applicant_name"
                                wire:model="applicant_name"
                                required
                                :error="$errors->first('applicant_name')"
                                placeholder="Masukkan nama penuh"
                            />
                        </x-myds.grid-item>

                        <x-myds.grid-item span="6">
                            <x-myds.input
                                label="Jawatan & Gred"
                                name="applicant_position"
                                wire:model="applicant_position"
                                required
                                :error="$errors->first('applicant_position')"
                                placeholder="Contoh: Penolong Pegawai Tadbir N29"
                            />
                        </x-myds.grid-item>

                        <x-myds.grid-item span="6">
                            <x-myds.select
                                label="Bahagian/Unit"
                                name="applicant_division"
                                wire:model="applicant_division"
                                required
                                :error="$errors->first('applicant_division')"
                                :options="$this->getDivisionOptions()"
                                placeholder="Pilih bahagian/unit anda"
                            />
                        </x-myds.grid-item>

                        <x-myds.grid-item span="6">
                            <x-myds.input
                                label="No. Telefon"
                                name="applicant_phone"
                                wire:model="applicant_phone"
                                required
                                :error="$errors->first('applicant_phone')"
                                placeholder="012-3456789"
                            />
                        </x-myds.grid-item>

                        <x-myds.grid-item span="full">
                            <x-myds.textarea
                                label="Tujuan Permohonan"
                                name="purpose"
                                wire:model="purpose"
                                required
                                :error="$errors->first('purpose')"
                                placeholder="Nyatakan tujuan penggunaan peralatan ICT..."
                                rows="3"
                            />
                        </x-myds.grid-item>

                        <x-myds.grid-item span="6">
                            <x-myds.input
                                label="Lokasi Penggunaan"
                                name="location"
                                wire:model="location"
                                required
                                :error="$errors->first('location')"
                                placeholder="Contoh: Bilik Mesyuarat A, Tingkat 3"
                            />
                        </x-myds.grid-item>

                        <x-myds.grid-item span="6">
                            <x-myds.input
                                label="Tarikh Mula Pinjaman"
                                name="loan_start_date"
                                type="date"
                                wire:model="loan_start_date"
                                required
                                :error="$errors->first('loan_start_date')"
                            />
                        </x-myds.grid-item>

                        <x-myds.grid-item span="6">
                            <x-myds.input
                                label="Tarikh Dijangka Pulang"
                                name="loan_end_date"
                                type="date"
                                wire:model="loan_end_date"
                                required
                                :error="$errors->first('loan_end_date')"
                            />
                        </x-myds.grid-item>
                    </x-myds.grid>
                </x-myds.card>

                <!-- Part 2: Responsible Officer Information -->
                <x-myds.card>
                    <x-myds.heading level="2" class="mb-6 pb-3 border-b border-otl-divider">
                        Bahagian 2: Maklumat Pegawai Bertanggungjawab
                    </x-myds.heading>

                    <div class="mb-6">
                        <x-myds.checkbox
                            label="Pemohon adalah pegawai yang bertanggungjawab"
                            name="is_same_person"
                            wire:model.live="is_same_person"
                        />
                    </div>

                    @if(!$is_same_person)
                        <div class="p-4 bg-gray-50 rounded-[var(--radius-m)]">
                            <x-myds.grid>
                                <x-myds.grid-item span="6">
                                    <x-myds.input
                                        label="Nama Penuh"
                                        name="responsible_name"
                                        wire:model="responsible_name"
                                        required
                                        :error="$errors->first('responsible_name')"
                                        placeholder="Masukkan nama pegawai bertanggungjawab"
                                    />
                                </x-myds.grid-item>

                                <x-myds.grid-item span="6">
                                    <x-myds.input
                                        label="Jawatan & Gred"
                                        name="responsible_position"
                                        wire:model="responsible_position"
                                        required
                                        :error="$errors->first('responsible_position')"
                                        placeholder="Contoh: Pegawai Tadbir N41"
                                    />
                                </x-myds.grid-item>

                                <x-myds.grid-item span="6">
                                    <x-myds.input
                                        label="No. Telefon"
                                        name="responsible_phone"
                                        wire:model="responsible_phone"
                                        required
                                        :error="$errors->first('responsible_phone')"
                                        placeholder="012-3456789"
                                    />
                                </x-myds.grid-item>
                            </x-myds.grid>
                        </div>
                    @endif
                </x-myds.card>

                <!-- Part 3: Equipment Information -->
                <x-myds.card>
                    <x-myds.heading level="2" class="mb-6 pb-3 border-b border-otl-divider">
                        Bahagian 3: Maklumat Peralatan
                    </x-myds.heading>

                    <div class="space-y-4">
                        @foreach($equipment_items as $index => $item)
                            <div class="p-4 border border-otl-gray-200 rounded-[var(--radius-m)] {{ $index > 0 ? 'bg-gray-50' : '' }}">
                                <div class="flex items-center justify-between mb-4">
                                    <x-myds.text weight="semibold">Peralatan {{ $index + 1 }}</x-myds.text>
                                    @if($index > 0)
                                        <x-myds.button
                                            type="button"
                                            variant="danger"
                                            size="sm"
                                            wire:click="removeEquipmentItem({{ $index }})"
                                        >
                                            Buang
                                        </x-myds.button>
                                    @endif
                                </div>

                                <x-myds.grid>
                                    <x-myds.grid-item span="4">
                                        <x-myds.select
                                            label="Jenis Peralatan"
                                            name="equipment_items.{{ $index }}.type"
                                            wire:model="equipment_items.{{ $index }}.type"
                                            required
                                            :error="$errors->first('equipment_items.' . $index . '.type')"
                                            :options="$this->getEquipmentTypeOptions()"
                                            placeholder="Pilih jenis peralatan"
                                        />
                                    </x-myds.grid-item>

                                    <x-myds.grid-item span="4">
                                        <x-myds.input
                                            label="Kuantiti"
                                            name="equipment_items.{{ $index }}.quantity"
                                            type="number"
                                            wire:model="equipment_items.{{ $index }}.quantity"
                                            required
                                            min="1"
                                            max="10"
                                            :error="$errors->first('equipment_items.' . $index . '.quantity')"
                                        />
                                    </x-myds.grid-item>

                                    <x-myds.grid-item span="4">
                                        <x-myds.input
                                            label="Catatan"
                                            name="equipment_items.{{ $index }}.notes"
                                            wire:model="equipment_items.{{ $index }}.notes"
                                            placeholder="Spesifikasi khusus (jika ada)"
                                        />
                                    </x-myds.grid-item>
                                </x-myds.grid>
                            </div>
                        @endforeach

                        <div class="flex justify-center">
                            <x-myds.button
                                type="button"
                                variant="outline"
                                wire:click="addEquipmentItem"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Tambah Peralatan
                            </x-myds.button>
                        </div>
                    </div>
                </x-myds.card>

                <!-- Action Buttons -->
                <x-myds.card>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <x-myds.button
                            type="submit"
                            class="flex-1"
                        >
                            Hantar Permohonan
                        </x-myds.button>

                        <x-myds.button
                            type="button"
                            variant="secondary"
                            wire:click="resetForm"
                            class="flex-1"
                        >
                            Reset Borang
                        </x-myds.button>
                    </div>
                </x-myds.card>
            </form>

            <!-- Terms and Conditions -->
            <x-myds.alert variant="warning" class="mt-8">
                <x-myds.heading level="4" class="mb-4">Syarat-Syarat Permohonan</x-myds.heading>
                <div class="space-y-2">
                    <x-myds.text size="sm">• Sila isi borang ini dengan lengkap. Tanda * adalah WAJIB diisi.</x-myds.text>
                    <x-myds.text size="sm">• Permohonan tertakluk kepada ketersediaan peralatan melalui konsep 'First Come, First Serve'.</x-myds.text>
                    <x-myds.text size="sm">• Permohonan akan diproses dalam tempoh 3 hari bekerja dari tarikh permohonan lengkap diterima.</x-myds.text>
                    <x-myds.text size="sm">• Pemohon bertanggungjawab sepenuhnya ke atas keselamatan dan pemulangan peralatan.</x-myds.text>
                    <x-myds.text size="sm">• Permohonan memerlukan pengesahan daripada pegawai Gred 41 ke atas.</x-myds.text>
                </div>
            </x-myds.alert>
        </x-myds.grid-item>
    </x-myds.grid>
</x-myds.container>

</div>
