<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-poppins">Profil Pengguna</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">Uruskan maklumat peribadi dan tetapan akaun anda</p>
    </div>

    <!-- Success/Error Messages -->
    <div x-data="{ show: false }"
         @profile-updated.window="show = true; setTimeout(() => show = false, 3000)"
         @password-changed.window="show = true; setTimeout(() => show = false, 3000)"
         @preferences-updated.window="show = true; setTimeout(() => show = false, 3000)"
         @avatar-removed.window="show = true; setTimeout(() => show = false, 3000)">
        <div x-show="show" x-transition
             class="mb-6 bg-success-50 dark:bg-success-900/20 border border-success-200 dark:border-success-700 rounded-lg p-4">
            <div class="flex items-center">
                <x-icon name="check-circle" class="w-5 h-5 text-success-600 dark:text-success-400 mr-3" />
                <span class="text-success-800 dark:text-success-200" x-text="$event.detail[0]?.message || 'Berjaya dikemaskini!'"></span>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700 mb-6">
        <nav class="-mb-px flex space-x-8">
            <button wire:click="setActiveTab('profile')"
                    class="py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                           {{ $activeTab === 'profile'
                               ? 'border-otl-primary-300 text-txt-primary dark:text-txt-primary'
                               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                <x-icon name="user" class="w-4 h-4 inline-block mr-2" />
                Maklumat Peribadi
            </button>

            <button wire:click="setActiveTab('security')"
                    class="py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                           {{ $activeTab === 'security'
                               ? 'border-otl-primary-300 text-txt-primary dark:text-txt-primary'
                               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                <x-icon name="lock-closed" class="w-4 h-4 inline-block mr-2" />
                Keselamatan
            </button>

            <button wire:click="setActiveTab('notifications')"
                    class="py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                           {{ $activeTab === 'notifications'
                               ? 'border-otl-primary-300 text-txt-primary dark:text-txt-primary'
                               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                <x-icon name="bell" class="w-4 h-4 inline-block mr-2" />
                Notifikasi
            </button>

            <button wire:click="setActiveTab('activity')"
                    class="py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200
                           {{ $activeTab === 'activity'
                               ? 'border-otl-primary-300 text-txt-primary dark:text-txt-primary'
                               : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300' }}">
                <x-icon name="clock" class="w-4 h-4 inline-block mr-2" />
                Aktiviti Terkini
            </button>
        </nav>
    </div>

    <!-- Tab Content -->

    <!-- Profile Tab -->
    @if ($activeTab === 'profile')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white font-poppins">Maklumat Peribadi</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kemaskini maklumat profil dan avatar anda</p>
        </div>

        <form wire:submit="updateProfile" class="px-6 py-5 space-y-6">
            <!-- Avatar Section -->
            <div class="flex items-center space-x-6">
                <div class="shrink-0">
                    @if($avatar_url)
                        <img class="h-20 w-20 rounded-full object-cover" src="{{ Storage::url($avatar_url) }}" alt="Avatar">
                    @else
                        <div class="h-20 w-20 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                            <x-icon name="user" class="w-8 h-8 text-gray-400" />
                        </div>
                    @endif
                </div>

                <div class="flex flex-col space-y-2">
                    <div class="flex space-x-3">
                        <label class="cursor-pointer bg-bg-primary-600 hover:bg-bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Pilih Avatar Baharu
                            <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                        </label>

                        @if($avatar_url)
                        <button type="button" wire:click="removeAvatar"
                                    class="bg-bg-danger-600 hover:bg-bg-danger-700 text-txt-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Padam Avatar
                        </button>
                        @endif
                    </div>

                    @error('avatar')
                        <p class="text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror

                    <p class="text-xs text-gray-500 dark:text-gray-400">JPG, GIF atau PNG. Maksimum 2MB.</p>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nama Penuh <span class="text-danger-500">*</span>
                    </label>
                    <input type="text"
                           wire:model="name"
                           id="name"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                  focus:ring-2 focus:ring-fr-primary focus:border-otl-primary-300
                                  dark:bg-gray-700 dark:text-white"
                           placeholder="Masukkan nama penuh">
                    @error('name')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        ID Kakitangan <span class="text-danger-500">*</span>
                    </label>
                    <input type="text"
                           wire:model="employee_id"
                           id="employee_id"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                  focus:ring-2 focus:ring-fr-primary focus:border-otl-primary-300
                                  dark:bg-gray-700 dark:text-white"
                           placeholder="Contoh: EMP001">
                    @error('employee_id')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        E-mel
                    </label>
                    <input type="email"
                           value="{{ $email }}"
                           disabled
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                  bg-gray-50 dark:bg-gray-600 text-gray-500 dark:text-gray-400 cursor-not-allowed">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">E-mel tidak boleh ditukar. Hubungi pentadbir jika perlu menukar.</p>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Nombor Telefon
                    </label>
                    <input type="text"
                           wire:model="phone"
                           id="phone"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                  focus:ring-2 focus:ring-fr-primary focus:border-otl-primary-300
                                  dark:bg-gray-700 dark:text-white"
                           placeholder="Contoh: 03-1234567">
                    @error('phone')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="department" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Jabatan <span class="text-danger-500">*</span>
                    </label>
                    <input type="text"
                           wire:model="department"
                           id="department"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                  focus:ring-2 focus:ring-fr-primary focus:border-otl-primary-300
                                  dark:bg-gray-700 dark:text-white"
                           placeholder="Contoh: Jabatan Teknologi Maklumat">
                    @error('department')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="position" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Jawatan <span class="text-danger-500">*</span>
                    </label>
                    <input type="text"
                           wire:model="position"
                           id="position"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                  focus:ring-2 focus:ring-fr-primary focus:border-otl-primary-300
                                  dark:bg-gray-700 dark:text-white"
                           placeholder="Contoh: Pegawai Teknologi Maklumat">
                    @error('position')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="office_location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Lokasi Pejabat <span class="text-danger-500">*</span>
                    </label>
                    <input type="text"
                           wire:model="office_location"
                           id="office_location"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                  focus:ring-2 focus:ring-fr-primary focus:border-otl-primary-300
                                  dark:bg-gray-700 dark:text-white"
                           placeholder="Contoh: Tingkat 5, Blok A, Kompleks MOTAC">
                    @error('office_location')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-4">
                <button type="submit"
                        class="bg-bg-primary-600 hover:bg-bg-primary-700 text-white px-6 py-2 rounded-md text-sm font-medium
                               transition-colors duration-200 flex items-center space-x-2"
                        wire:loading.attr="disabled">
                    <x-icon name="save" class="w-4 h-4" />
                    <span wire:loading.remove>Simpan Perubahan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Security Tab -->
    @if ($activeTab === 'security')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white font-poppins">Keselamatan Akaun</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Uruskan kata laluan dan tetapan keselamatan akaun</p>
        </div>

        <div class="px-6 py-5">
            <!-- Current Password Info -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Kata Laluan</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                            Kata laluan terakhir dikemaskini: {{ $user->updated_at->format('d/m/Y') }}
                        </p>
                    </div>
                    <button wire:click="togglePasswordForm"
                            class="bg-bg-primary-600 hover:bg-bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        {{ $showPasswordForm ? 'Batal' : 'Tukar Kata Laluan' }}
                    </button>
                </div>
            </div>

            <!-- Password Change Form -->
            @if ($showPasswordForm)
            <form wire:submit="changePassword" class="space-y-6">
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Kata Laluan Semasa <span class="text-danger-500">*</span>
                    </label>
                    <input type="password"
                           wire:model="current_password"
                           id="current_password"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                  focus:ring-2 focus:ring-fr-primary focus:border-otl-primary-300
                                  dark:bg-gray-700 dark:text-white"
                           placeholder="Masukkan kata laluan semasa">
                    @error('current_password')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Kata Laluan Baharu <span class="text-danger-500">*</span>
                    </label>
                    <input type="password"
                           wire:model="new_password"
                           id="new_password"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                  focus:ring-2 focus:ring-fr-primary focus:border-otl-primary-300
                                  dark:bg-gray-700 dark:text-white"
                           placeholder="Masukkan kata laluan baharu">
                    @error('new_password')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        Kata laluan mesti sekurang-kurangnya 8 aksara dan mengandungi campuran huruf dan nombor.
                    </p>
                </div>

                <div>
                    <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Pengesahan Kata Laluan Baharu <span class="text-danger-500">*</span>
                    </label>
                    <input type="password"
                           wire:model="new_password_confirmation"
                           id="new_password_confirmation"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm
                                  focus:ring-2 focus:ring-fr-primary focus:border-otl-primary-300
                                  dark:bg-gray-700 dark:text-white"
                           placeholder="Ulang kata laluan baharu">
                    @error('new_password_confirmation')
                        <p class="mt-1 text-sm text-danger-600 dark:text-danger-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button"
                            wire:click="togglePasswordForm"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit"
                            class="bg-bg-primary-600 hover:bg-bg-primary-700 text-white px-6 py-2 rounded-md text-sm font-medium
                                   transition-colors duration-200 flex items-center space-x-2"
                            wire:loading.attr="disabled">
                        <x-icon name="lock-closed" class="w-4 h-4" />
                        <span wire:loading.remove>Tukar Kata Laluan</span>
                        <span wire:loading>Menukar...</span>
                    </button>
                </div>
            </form>
            @endif

            @if ($passwordChanged)
            <div class="mt-6 bg-success-50 dark:bg-success-900/20 border border-success-200 dark:border-success-700 rounded-lg p-4">
                <div class="flex items-center">
                    <x-icon name="check-circle" class="w-5 h-5 text-success-600 dark:text-success-400 mr-3" />
                    <span class="text-success-800 dark:text-success-200">Kata laluan berjaya ditukar!</span>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Notifications Tab -->
    @if ($activeTab === 'notifications')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white font-poppins">Tetapan Notifikasi</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pilih jenis notifikasi yang ingin anda terima</p>
        </div>

        <form wire:submit="updateNotificationPreferences" class="px-6 py-5">
            <div class="space-y-6">
                <!-- Email Notifications -->
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Notifikasi E-mel</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Terima notifikasi umum melalui e-mel</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="email_notifications" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"></div>
                    </label>
                </div>

                <!-- SMS Notifications -->
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Notifikasi SMS</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Terima notifikasi penting melalui SMS</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="sms_notifications" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"></div>
                    </label>
                </div>

                <!-- Loan Reminders -->
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Peringatan Pinjaman</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Peringatan untuk tempoh akhir pinjaman peralatan</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="loan_reminders" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"></div>
                    </label>
                </div>

                <!-- Approval Notifications -->
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Notifikasi Kelulusan</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Notifikasi status kelulusan permohonan</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="approval_notifications" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"></div>
                    </label>
                </div>

                <!-- System Announcements -->
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Pengumuman Sistem</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Pengumuman rasmi dan kemas kini sistem</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="system_announcements" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"></div>
                    </label>
                </div>

                <!-- Weekly Digest -->
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">Ringkasan Mingguan</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Ringkasan aktiviti dan statistik mingguan</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" wire:model="weekly_digest" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"></div>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end pt-6 border-t border-gray-200 dark:border-gray-700 mt-6">
                <button type="submit"
                        class="bg-bg-primary-600 hover:bg-bg-primary-700 text-white px-6 py-2 rounded-md text-sm font-medium
                               transition-colors duration-200 flex items-center space-x-2"
                        wire:loading.attr="disabled">
                    <x-icon name="bell" class="w-4 h-4" />
                    <span wire:loading.remove>Simpan Tetapan</span>
                    <span wire:loading>Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>
    @endif

    <!-- Activity Tab -->
    @if ($activeTab === 'activity')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white font-poppins">Aktiviti Terkini</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lihat aktiviti dan permohonan terkini anda</p>
        </div>

        <div class="px-6 py-5">
            @if (count($recentActivity) > 0)
                <div class="space-y-4">
                    @foreach ($recentActivity as $activity)
                    <div class="flex items-start space-x-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center">
                                <x-icon name="{{ $activity['icon'] }}" class="w-4 h-4 {{ $activity['color'] }}" />
                            </div>
                        </div>
                                <button type="button" wire:click="removeAvatar"
                                        class="bg-bg-danger-600 hover:bg-bg-danger-700 text-txt-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $activity['date'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 text-center">
                    <a href="{{ route('loan-applications.index') }}"
                       class="text-txt-primary hover:text-txt-primary dark:text-txt-primary text-sm font-medium">
                        Lihat Semua Permohonan →
                    </a>
                </div>
            @else
                <div class="text-center py-8">
                    <x-icon name="clock" class="w-12 h-12 text-gray-400 mx-auto mb-4" />
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Tiada Aktiviti Lagi</h4>
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Anda belum mempunyai sebarang aktiviti atau permohonan.</p>
                    <a href="{{ route('loan-applications.create') }}"
                       class="bg-bg-primary-600 hover:bg-bg-primary-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                        Buat Permohonan Baharu
                    </a>
                </div>
            @endif
        </div>
    </div>
    @endif
</div>








