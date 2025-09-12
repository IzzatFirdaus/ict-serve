<div>
@section('title', 'Borang Permohonan Peminjaman Peralatan ICT')

<!-- Content Banner -->
<div class="bg-primary-50 border-b border-otl-divider">
    <div class="myds-container py-8">
        <div class="myds-grid-12">
            <div class="col-span-full">
                <h1 class="myds-heading-md text-txt-black-900 mb-2">Borang Permohonan Peminjaman Peralatan ICT</h1>
                <p class="text-txt-black-600 mb-3">Untuk Kegunaan Rasmi Kementerian Pelancongan, Seni dan Budaya</p>
                <nav class="text-sm text-txt-black-500" aria-label="Breadcrumb">
                    <a href="/" class="hover:text-txt-primary">Utama</a>
                    <span class="mx-2">/</span>
                    <span>ServiceDesk ICT</span>
                </nav>
            </div>
        </div>
    </div>
</div>

<div class="myds-container py-12">
    <div class="myds-grid-12">
        <div class="col-span-full lg:col-span-10 lg:col-start-2">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-success-50 border border-otl-success-200 rounded-[var(--radius-m)]">
                    <div class="flex">
                        <svg class="w-5 h-5 text-txt-success mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h4 class="text-sm font-semibold text-txt-success mb-1">Berjaya!</h4>
                            <p class="text-sm text-txt-success">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form wire:submit="submit" class="space-y-8">
                <!-- Part 1: Applicant Information -->
                <div class="bg-white rounded-[var(--radius-xl)] border border-otl-gray-200 shadow-md p-8">
                    <h2 class="myds-heading-xs text-txt-black-900 mb-6 pb-3 border-b border-otl-divider">
                        Bahagian 1: Maklumat Pemohon
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-myds.form.input
                            label="Nama Penuh"
                            name="applicant_name"
                            wire:model="applicant_name"
                            required
                            :error="$errors->first('applicant_name')"
                            placeholder="Masukkan nama penuh"
                        />

                        <x-myds.form.input
                            label="Jawatan & Gred"
                            name="applicant_position"
                            wire:model="applicant_position"
                            required
                            :error="$errors->first('applicant_position')"
                            placeholder="Contoh: Penolong Pegawai Tadbir N29"
                        />

                        <x-myds.form.select
                            label="Bahagian/Unit"
                            name="applicant_division"
                            wire:model="applicant_division"
                            required
                            :error="$errors->first('applicant_division')"
                            :options="$this->getDivisionOptions()"
                            placeholder="Pilih bahagian/unit anda"
                        />

                        <x-myds.form.input
                            label="No. Telefon"
                            name="applicant_phone"
                            wire:model="applicant_phone"
                            required
                            :error="$errors->first('applicant_phone')"
                            placeholder="012-3456789"
                        />

                        <div class="md:col-span-2">
                            <x-myds.form.textarea
                                label="Tujuan Permohonan"
                                name="purpose"
                                wire:model="purpose"
                                required
                                :error="$errors->first('purpose')"
                                placeholder="Nyatakan tujuan penggunaan peralatan ICT..."
                                rows="3"
                            />
                        </div>

                        <x-myds.form.input
                            label="Lokasi Penggunaan"
                            name="location"
                            wire:model="location"
                            required
                            :error="$errors->first('location')"
                            placeholder="Contoh: Bilik Mesyuarat A, Tingkat 3"
                        />

                        <x-myds.form.input
                            label="Tarikh Mula Pinjaman"
                            name="loan_start_date"
                            type="date"
                            wire:model="loan_start_date"
                            required
                            :error="$errors->first('loan_start_date')"
                        />

                        <x-myds.form.input
                            label="Tarikh Dijangka Pulang"
                            name="loan_end_date"
                            type="date"
                            wire:model="loan_end_date"
                            required
                            :error="$errors->first('loan_end_date')"
                        />
                    </div>
                </div>

                <!-- Part 2: Responsible Officer Information -->
                <div class="bg-white rounded-[var(--radius-xl)] border border-otl-gray-200 shadow-md p-8">
                    <h2 class="myds-heading-xs text-txt-black-900 mb-6 pb-3 border-b border-otl-divider">
                        Bahagian 2: Maklumat Pegawai Bertanggungjawab
                    </h2>

                    <div class="mb-6">
                        <x-myds.form.checkbox
                            label="Pemohon adalah pegawai yang bertanggungjawab"
                            name="is_same_person"
                            wire:model.live="is_same_person"
                        />
                    </div>

                    @if(!$is_same_person)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-[var(--radius-m)]">
                            <x-myds.form.input
                                label="Nama Penuh"
                                name="responsible_name"
                                wire:model="responsible_name"
                                required
                                :error="$errors->first('responsible_name')"
                                placeholder="Masukkan nama pegawai bertanggungjawab"
                            />

                            <x-myds.form.input
                                label="Jawatan & Gred"
                                name="responsible_position"
                                wire:model="responsible_position"
                                required
                                :error="$errors->first('responsible_position')"
                                placeholder="Contoh: Pegawai Tadbir N41"
                            />

                            <x-myds.form.input
                                label="No. Telefon"
                                name="responsible_phone"
                                wire:model="responsible_phone"
                                required
                                :error="$errors->first('responsible_phone')"
                                placeholder="012-3456789"
                            />
                        </div>
                    @endif
                </div>

                <!-- Part 3: Equipment Information -->
                <div class="bg-white rounded-[var(--radius-xl)] border border-otl-gray-200 shadow-md p-8">
                    <h2 class="myds-heading-xs text-txt-black-900 mb-6 pb-3 border-b border-otl-divider">
                        Bahagian 3: Maklumat Peralatan
                    </h2>

                    <div class="space-y-4">
                        @foreach($equipment_items as $index => $item)
                            <div class="p-4 border border-otl-gray-200 rounded-[var(--radius-m)] {{ $index > 0 ? 'bg-gray-50' : '' }}">
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-sm font-semibold text-txt-black-900">Peralatan {{ $index + 1 }}</h3>
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

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <x-myds.form.select
                                        label="Jenis Peralatan"
                                        name="equipment_items.{{ $index }}.type"
                                        wire:model="equipment_items.{{ $index }}.type"
                                        required
                                        :error="$errors->first('equipment_items.' . $index . '.type')"
                                        :options="$this->getEquipmentTypeOptions()"
                                        placeholder="Pilih jenis peralatan"
                                    />

                                    <x-myds.form.input
                                        label="Kuantiti"
                                        name="equipment_items.{{ $index }}.quantity"
                                        type="number"
                                        wire:model="equipment_items.{{ $index }}.quantity"
                                        required
                                        min="1"
                                        max="10"
                                        :error="$errors->first('equipment_items.' . $index . '.quantity')"
                                    />

                                    <x-myds.form.input
                                        label="Catatan"
                                        name="equipment_items.{{ $index }}.notes"
                                        wire:model="equipment_items.{{ $index }}.notes"
                                        placeholder="Spesifikasi khusus (jika ada)"
                                    />
                                </div>
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
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-[var(--radius-xl)] border border-otl-gray-200 shadow-md p-8">
                    <div class="flex flex-col sm:flex-row gap-4">
                        <x-myds.button
                            type="submit"
                            class="flex-1"
                            :loading="$this->form->processing ?? false"
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
                </div>
            </form>

            <!-- Terms and Conditions -->
            <div class="mt-8 p-6 bg-warning-50 border border-otl-warning-200 rounded-[var(--radius-m)]">
                <h3 class="myds-heading-2xs text-txt-warning mb-4">Syarat-Syarat Permohonan</h3>
                <div class="space-y-2 text-sm text-txt-warning">
                    <p>• Sila isi borang ini dengan lengkap. Tanda * adalah WAJIB diisi.</p>
                    <p>• Permohonan tertakluk kepada ketersediaan peralatan melalui konsep 'First Come, First Serve'.</p>
                    <p>• Permohonan akan diproses dalam tempoh 3 hari bekerja dari tarikh permohonan lengkap diterima.</p>
                    <p>• Pemohon bertanggungjawab sepenuhnya ke atas keselamatan dan pemulangan peralatan.</p>
                    <p>• Permohonan memerlukan pengesahan daripada pegawai Gred 41 ke atas.</p>
                </div>
            </div>
        </div>
    </div>

</div>
