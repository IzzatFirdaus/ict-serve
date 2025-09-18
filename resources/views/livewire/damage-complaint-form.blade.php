<div>
<!-- Content Banner -->
<div class="bg-primary-50 border-b border-otl-divider relative overflow-hidden">
    <div class="myds-container py-8">
        <div class="myds-grid-12">
            <div class="col-span-full">
                <h1 class="myds-heading-md text-txt-black-900 mb-2">Borang Aduan Kerosakan ICT</h1>
                <nav class="text-sm text-txt-black-500" aria-label="Breadcrumb">
                    <a href="/" class="hover:text-txt-primary">Utama</a>
                    <span class="mx-2">/</span>
                    <span>ServiceDesk ICT</span>
                </nav>
            </div>
        </div>
    </div>
    <!-- Decorative background with telephone receiver graphic -->
    <div class="absolute inset-0 opacity-5">
        <svg class="w-32 h-32 absolute top-4 right-8 transform rotate-12" fill="currentColor" viewBox="0 0 24 24">
            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
        </svg>
    </div>
</div>

<div class="myds-container py-12">
    <div class="myds-grid-12">
        <div class="col-span-full lg:col-span-8 lg:col-start-3">
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

            <!-- Main Form -->
            <div class="bg-white rounded-[var(--radius-xl)] border border-otl-gray-200 shadow-md p-8">
                <form wire:submit="submit" class="space-y-6">
                    <!-- Full Name -->
                    <x-myds.form.input
                        label="Nama Penuh"
                        name="full_name"
                        wire:model="full_name"
                        required
                        :error="$errors->first('full_name')"
                        placeholder="Masukkan nama penuh anda"
                    />

                    <!-- Division -->
                    <x-myds.form.select
                        label="Bahagian"
                        name="division"
                        wire:model="division"
                        required
                        :error="$errors->first('division')"
                        :options="$this->getDivisionOptions()"
                        placeholder="Pilih bahagian anda"
                    />

                    <!-- Position Grade -->
                    <x-myds.form.input
                        label="Gred Jawatan"
                        name="position_grade"
                        wire:model="position_grade"
                        :error="$errors->first('position_grade')"
                        placeholder="Contoh: 41, 44, 48"
                        help="Medan ini adalah pilihan"
                    />

                    <!-- Email -->
                    <x-myds.form.input
                        label="E-Mel"
                        name="email"
                        type="email"
                        wire:model="email"
                        required
                        :error="$errors->first('email')"
                        placeholder="nama@motac.gov.my"
                    />

                    <!-- Phone Number -->
                    <x-myds.form.input
                        label="No. Telefon"
                        name="phone_number"
                        wire:model="phone_number"
                        required
                        :error="$errors->first('phone_number')"
                        placeholder="012-3456789"
                    />

                    <!-- Damage Type -->
                    <x-myds.form.select
                        label="Jenis Kerosakan"
                        name="damage_type"
                        wire:model.live="damage_type"
                        required
                        :error="$errors->first('damage_type')"
                        :options="$this->getDamageTypeOptions()"
                        placeholder="Pilih jenis kerosakan"
                    />

                    <!-- Asset Number (Conditional) -->
                    @if($this->show_asset_number)
                        <div class="p-4 bg-warning-50 border border-otl-warning-200 rounded-[var(--radius-m)]">
                            <x-myds.form.input
                                label="No. Aset / Printer ID"
                                name="asset_number"
                                wire:model="asset_number"
                                required
                                :error="$errors->first('asset_number')"
                                placeholder="Masukkan nombor aset atau printer ID"
                                help="Nombor aset diperlukan untuk kerosakan perkakasan"
                            />
                        </div>
                    @endif

                    <!-- Damage Information -->
                    <x-myds.form.textarea
                        label="Maklumat Kerosakan"
                        name="damage_info"
                        wire:model="damage_info"
                        required
                        :error="$errors->first('damage_info')"
                        placeholder="Sila berikan butiran lengkap mengenai masalah yang dihadapi..."
                        rows="6"
                        help="Berikan penerangan yang terperinci untuk memudahkan diagnosis masalah"
                    />

                    <!-- Declaration -->
                    <div class="p-6 bg-gray-50 rounded-[var(--radius-m)] border border-otl-gray-200">
                        <x-myds.form.checkbox
                            label="Saya memperakui dan mengesahkan bahawa semua maklumat yang diberikan di dalam eBorang Laporan Kerosakan ini adalah benar, dan bersetuju menerima perkhidmatan Bahagian Pengurusan Maklumat (BPM) berdasarkan Piagam Pelanggan sedia ada."
                            name="declaration"
                            wire:model.live="declaration"
                            required
                            :error="$errors->first('declaration')"
                        />
                    </div>

                    <!-- Action Buttons (Only show when declaration is checked) -->
                    @if($declaration)
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-otl-divider">
                            <x-myds.button
                                type="submit"
                                class="flex-1"
                                :loading="$this->form->processing ?? false"
                            >
                                Hantar Aduan
                            </x-myds.button>

                            <x-myds.button
                                type="button"
                                variant="secondary"
                                wire:click="resetForm"
                                class="flex-1"
                            >
                                Reset
                            </x-myds.button>
                        </div>
                    @endif
                </form>
            </div>

            <!-- Help Information -->
            <div class="mt-8 p-6 bg-primary-50 rounded-[var(--radius-m)] border border-otl-primary-200">
                <h3 class="myds-heading-2xs text-txt-primary mb-4">Maklumat Bantuan</h3>
                <div class="space-y-3 text-sm text-txt-black-700">
                    <p><strong>Masa Pemprosesan:</strong> Aduan akan diproses dalam tempoh 3 hari bekerja.</p>
                    <p><strong>Status Aduan:</strong> Anda akan menerima maklum balas melalui e-mel yang didaftarkan.</p>
                    <p><strong>Kecemasan ICT:</strong> Untuk isu kritikal, sila hubungi BPM terus di talian 03-XXXXXXX.</p>
                </div>
            </div>
        </div>
    </div>

</div>
