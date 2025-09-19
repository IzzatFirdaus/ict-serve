<div class="max-w-4xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  <!-- Page Header -->
  <div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white font-poppins">
  {{ __('profile.title') ?? 'Profil Pengguna' }}
    </h1>
    <p class="mt-2 text-gray-600 dark:text-gray-400">
  {{ __('profile.subtitle') ?? 'Uruskan maklumat peribadi dan tetapan akaun anda' }}
    </p>
  </div>

  <!-- Success/Error Messages -->
  <div
    x-data="{ show: false }"
    @profile-updated.window="show = true; setTimeout(() => show = false, 3000)"
    @password-changed.window="show = true; setTimeout(() => show = false, 3000)"
    @preferences-updated.window="show = true; setTimeout(() => show = false, 3000)"
    @avatar-removed.window="show = true; setTimeout(() => show = false, 3000)"
  >
    <div
      x-show="show"
      x-transition
      class="mb-6 bg-success-50 dark:bg-success-900/20 border border-success-200 dark:border-success-700 rounded-lg p-4"
    >
      <div class="flex items-center">
        <x-icon
          name="check-circle"
          class="w-5 h-5 text-success-600 dark:text-success-400 mr-3"
        />
        <span
          class="text-success-800 dark:text-success-200"
          x-text="$event.detail[0]?.message || 'Berjaya dikemaskini!'"
        ></span>
      </div>
    </div>
  </div>

  <!-- Tab Navigation -->
  <div class="border-b border-otl-divider mb-6">
    <nav class="-mb-px flex space-x-8">
  <x-myds.button
        wire:click="setActiveTab('profile')"
        variant="{{ $activeTab === 'profile' ? 'primary' : 'ghost' }}"
        class="py-2 px-1 border-b-2 {{ $activeTab === 'profile' ? 'border-otl-primary-300' : 'border-transparent' }}"
      >
        <x-icon name="user" class="w-4 h-4 inline-block mr-2" />
  {{ __('profile.tabs.personal') ?? 'Maklumat Peribadi' }}
      </x-myds.button>

      <x-myds.button
        wire:click="setActiveTab('security')"
        variant="{{ $activeTab === 'security' ? 'primary' : 'ghost' }}"
        class="py-2 px-1 border-b-2 {{ $activeTab === 'security' ? 'border-otl-primary-300' : 'border-transparent' }}"
      >
        <x-icon name="lock-closed" class="w-4 h-4 inline-block mr-2" />
  {{ __('profile.tabs.security') ?? 'Keselamatan' }}
      </x-myds.button>

      <x-myds.button
        wire:click="setActiveTab('notifications')"
        variant="{{ $activeTab === 'notifications' ? 'primary' : 'ghost' }}"
        class="py-2 px-1 border-b-2 {{ $activeTab === 'notifications' ? 'border-otl-primary-300' : 'border-transparent' }}"
      >
        <x-icon name="bell" class="w-4 h-4 inline-block mr-2" />
  {{ __('profile.tabs.notifications') ?? 'Notifikasi' }}
      </x-myds.button>

      <x-myds.button
        wire:click="setActiveTab('activity')"
        variant="{{ $activeTab === 'activity' ? 'primary' : 'ghost' }}"
        class="py-2 px-1 border-b-2 {{ $activeTab === 'activity' ? 'border-otl-primary-300' : 'border-transparent' }}"
      >
        <x-icon name="clock" class="w-4 h-4 inline-block mr-2" />
  {{ __('profile.tabs.activity') ?? 'Aktiviti Terkini' }}
      </x-myds.button>
    </nav>
  </div>

  <!-- Tab Content -->

  <!-- Profile Tab -->
  @if ($activeTab === 'profile')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
      <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
        <h3
          class="text-lg font-medium text-gray-900 dark:text-white font-poppins"
        >
          Maklumat Peribadi
        </h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          Kemaskini maklumat profil dan avatar anda
        </p>
      </div>

      <form wire:submit="updateProfile" class="px-6 py-5 space-y-6">
        <!-- Avatar Section -->
        <div class="flex items-center space-x-6">
          <div class="shrink-0">
            @if ($avatar_url)
              <img
                class="h-20 w-20 rounded-full object-cover"
                src="{{ Storage::url($avatar_url) }}"
                alt="Avatar"
              />
            @else
              <div
                class="h-20 w-20 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center"
              >
                <x-icon name="user" class="w-8 h-8 text-gray-400" />
              </div>
            @endif
          </div>

          <div class="flex flex-col space-y-2">
            <div class="flex space-x-3">
              <x-myds.button variant="primary" class="relative">
                {{ __('profile.buttons.choose_new_avatar') ?? 'Pilih Avatar Baharu' }}
                <input
                  type="file"
                  wire:model="avatar"
                  accept="image/*"
                  class="absolute inset-0 opacity-0 cursor-pointer"
                />
              </x-myds.button>

              @if ($avatar_url)
                <x-myds.button
                  type="button"
                  wire:click="removeAvatar"
                  variant="danger"
                >
                  {{ __('profile.buttons.remove_avatar') ?? 'Padam Avatar' }}
                </x-myds.button>
              @endif
            </div>

            @error('avatar')
              <p class="text-sm text-danger-600 dark:text-danger-400">
                {{ $message }}
              </p>
            @enderror

            <p class="text-xs text-gray-500 dark:text-gray-400">
              {{ __('profile.avatar_hint') ?? 'JPG, GIF atau PNG. Maksimum 2MB.' }}
            </p>
          </div>
        </div>

        <!-- Basic Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <x-myds.input
              type="text"
              wire:model="name"
              :label="__('forms.labels.full_name')"
              name="name"
              :placeholder="__('forms.placeholders.enter_full_name')"
              required
            />
          </div>

          <div>
            <x-myds.input
              type="text"
              wire:model="employee_id"
              :label="__('profile.labels.employee_id') ?? 'ID Kakitangan'"
              name="employee_id"
              :placeholder="__('profile.placeholders.employee_id') ?? 'Contoh: EMP001'"
              required
            />
          </div>

          <div>
            <x-myds.input
              type="email"
              value="{{ $email }}"
              :label="__('forms.labels.email')"
              name="email"
              disabled
              :help-text="__('profile.help.email_immutable') ?? 'E-mel tidak boleh ditukar. Hubungi pentadbir jika perlu menukar.'"
            />
          </div>

          <div>
            <x-myds.input
              type="text"
              wire:model="phone"
              :label="__('forms.labels.phone')"
              name="phone"
              :placeholder="__('profile.placeholders.phone') ?? 'Contoh: 03-1234567'"
            />
          </div>

          <div>
            <x-myds.input
              type="text"
              wire:model="department"
              :label="__('forms.labels.department')"
              name="department"
              :placeholder="__('profile.placeholders.department') ?? 'Contoh: Jabatan Teknologi Maklumat'"
              required
            />
          </div>

          <div>
            <x-myds.input
              type="text"
              wire:model="position"
              :label="__('forms.labels.position') ?? 'Jawatan'"
              name="position"
              :placeholder="__('profile.placeholders.position') ?? 'Contoh: Pegawai Teknologi Maklumat'"
              required
            />
          </div>

          <div class="md:col-span-2">
            <x-myds.input
              type="text"
              wire:model="office_location"
              :label="__('profile.labels.office_location') ?? 'Lokasi Pejabat'"
              name="office_location"
              :placeholder="__('profile.placeholders.office_location') ?? 'Contoh: Tingkat 5, Blok A, Kompleks MOTAC'"
              required
            />
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-4">
          <x-myds.button
            type="submit"
            variant="primary"
            wire:loading.attr="disabled"
          >
            <x-icon name="save" class="w-4 h-4 mr-2" />
            <span wire:loading.remove>
              {{ __('buttons.save') ?? 'Simpan Perubahan' }}
            </span>
            <span wire:loading>
              {{ __('buttons.saving') ?? 'Menyimpan...' }}
            </span>
          </x-myds.button>
        </div>
      </form>
    </div>
  @endif

  <!-- Security Tab -->
  @if ($activeTab === 'security')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
      <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
        <h3
          class="text-lg font-medium text-gray-900 dark:text-white font-poppins"
        >
          Keselamatan Akaun
        </h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          Uruskan kata laluan dan tetapan keselamatan akaun
        </p>
      </div>

      <div class="px-6 py-5">
        <!-- Current Password Info -->
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
          <div class="flex items-center justify-between">
            <div>
              <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                Kata Laluan
              </h4>
              <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Kata laluan terakhir dikemaskini:
                {{ $user->updated_at->format('d/m/Y') }}
              </p>
            </div>
            <x-myds.button wire:click="togglePasswordForm" variant="primary">
              {{ $showPasswordForm ? 'Batal' : 'Tukar Kata Laluan' }}
            </x-myds.button>
          </div>
        </div>

        <!-- Password Change Form -->
        @if ($showPasswordForm)
          <form wire:submit="changePassword" class="space-y-6">
            <x-myds.input
              type="password"
              wire:model="current_password"
              label="Kata Laluan Semasa"
              name="current_password"
              placeholder="Masukkan kata laluan semasa"
              required
            />

            <x-myds.input
              type="password"
              wire:model="new_password"
              label="Kata Laluan Baharu"
              name="new_password"
              placeholder="Masukkan kata laluan baharu"
              help-text="Kata laluan mesti sekurang-kurangnya 8 aksara dan mengandungi campuran huruf dan nombor."
              required
            />

            <x-myds.input
              type="password"
              wire:model="new_password_confirmation"
              label="Pengesahan Kata Laluan Baharu"
              name="new_password_confirmation"
              placeholder="Ulang kata laluan baharu"
              required
            />

            <div class="flex justify-end space-x-3 pt-4">
              <x-myds.button
                type="button"
                wire:click="togglePasswordForm"
                variant="ghost"
              >
                Batal
              </x-myds.button>
              <x-myds.button
                type="submit"
                variant="primary"
                wire:loading.attr="disabled"
              >
                <x-icon name="lock-closed" class="w-4 h-4 mr-2" />
                <span wire:loading.remove>Tukar Kata Laluan</span>
                <span wire:loading>Menukar...</span>
              </x-myds.button>
            </div>
          </form>
        @endif

        @if ($passwordChanged)
          <div
            class="mt-6 bg-success-50 dark:bg-success-900/20 border border-success-200 dark:border-success-700 rounded-lg p-4"
          >
            <div class="flex items-center">
              <x-icon
                name="check-circle"
                class="w-5 h-5 text-success-600 dark:text-success-400 mr-3"
              />
              <span class="text-success-800 dark:text-success-200">
                Kata laluan berjaya ditukar!
              </span>
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
        <h3
          class="text-lg font-medium text-gray-900 dark:text-white font-poppins"
        >
          Tetapan Notifikasi
        </h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          Pilih jenis notifikasi yang ingin anda terima
        </p>
      </div>

      <form wire:submit="updateNotificationPreferences" class="px-6 py-5">
        <div class="space-y-6">
          <!-- Email Notifications -->
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                Notifikasi E-mel
              </h4>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Terima notifikasi umum melalui e-mel
              </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input
                type="checkbox"
                wire:model="email_notifications"
                class="sr-only peer"
              />
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"
              ></div>
            </label>
          </div>

          <!-- SMS Notifications -->
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                Notifikasi SMS
              </h4>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Terima notifikasi penting melalui SMS
              </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input
                type="checkbox"
                wire:model="sms_notifications"
                class="sr-only peer"
              />
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"
              ></div>
            </label>
          </div>

          <!-- Loan Reminders -->
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                Peringatan Pinjaman
              </h4>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Peringatan untuk tempoh akhir pinjaman peralatan
              </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input
                type="checkbox"
                wire:model="loan_reminders"
                class="sr-only peer"
              />
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"
              ></div>
            </label>
          </div>

          <!-- Approval Notifications -->
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                Notifikasi Kelulusan
              </h4>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Notifikasi status kelulusan permohonan
              </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input
                type="checkbox"
                wire:model="approval_notifications"
                class="sr-only peer"
              />
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"
              ></div>
            </label>
          </div>

          <!-- System Announcements -->
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                Pengumuman Sistem
              </h4>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Pengumuman rasmi dan kemas kini sistem
              </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input
                type="checkbox"
                wire:model="system_announcements"
                class="sr-only peer"
              />
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"
              ></div>
            </label>
          </div>

          <!-- Weekly Digest -->
          <div class="flex items-center justify-between">
            <div class="flex-1">
              <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                Ringkasan Mingguan
              </h4>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                Ringkasan aktiviti dan statistik mingguan
              </p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input
                type="checkbox"
                wire:model="weekly_digest"
                class="sr-only peer"
              />
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-fr-primary dark:peer-focus:ring-fr-primary rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-bg-primary-600"
              ></div>
            </label>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end pt-6 border-t border-otl-divider mt-6">
          <x-myds.button
            type="submit"
            variant="primary"
            wire:loading.attr="disabled"
          >
            <x-icon name="bell" class="w-4 h-4 mr-2" />
            <span wire:loading.remove>Simpan Tetapan</span>
            <span wire:loading>Menyimpan...</span>
          </x-myds.button>
        </div>
      </form>
    </div>
  @endif

  <!-- Activity Tab -->
  @if ($activeTab === 'activity')
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
      <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
        <h3
          class="text-lg font-medium text-gray-900 dark:text-white font-poppins"
        >
          Aktiviti Terkini
        </h3>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
          Lihat aktiviti dan permohonan terkini anda
        </p>
      </div>

      <div class="px-6 py-5">
        @if (count($recentActivity) > 0)
          <div class="space-y-4">
            @foreach ($recentActivity as $activity)
              <div
                class="flex items-start space-x-3 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg"
              >
                <div class="flex-shrink-0">
                  <div
                    class="w-8 h-8 bg-primary-100 dark:bg-primary-900 rounded-full flex items-center justify-center"
                  >
                    <x-icon
                      name="{{ $activity['icon'] }}"
                      class="w-4 h-4 {{ $activity['color'] }}"
                    />
                  </div>
                </div>
                <div class="flex-1">
                  <h4 class="text-sm font-medium text-txt-black-900">
                    {{ $activity['title'] }}
                  </h4>
                  <p class="text-sm text-txt-black-500">
                    {{ $activity['description'] }}
                  </p>
                  <p class="text-xs text-txt-black-400 mt-1">
                    {{ $activity['date'] }}
                  </p>
                </div>
              </div>
            @endforeach
          </div>

          <div class="mt-6 text-center">
            <a
              href="{{ route('loan.index') }}"
              class="text-txt-primary hover:text-txt-primary dark:text-txt-primary text-sm font-medium"
            >
              Lihat Semua Permohonan →
            </a>
          </div>
        @else
          <div class="text-center py-8">
            <x-icon name="clock" class="w-12 h-12 text-gray-400 mx-auto mb-4" />
            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
              {{ __('ui.no_activity_title') }}
            </h4>
            <p class="text-gray-500 dark:text-gray-400 mb-4">
              {{ __('ui.no_activity_subtitle') }}
            </p>
            <x-myds.button
              href="{{ route('loan.create') }}"
              variant="primary"
            >
              {{ __('buttons.create_new_application') }}
            </x-myds.button>
          </div>
        @endif
      </div>
    </div>
  @endif
</div>
