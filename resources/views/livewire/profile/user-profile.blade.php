<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
  <!-- Header -->
  <div
    class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Profil Pengguna / User Profile
          </h1>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Urus maklumat profil dan keutamaan anda / Manage your profile
            information and preferences
          </p>
        </div>

        <div class="flex items-center gap-4">
          <a
            href="{{ route('dashboard') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"
          >
            <svg
              class="w-4 h-4 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"
              ></path>
            </svg>
            Kembali / Back
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
      <!-- Profile Sidebar -->
      <div class="lg:col-span-1">
        <div
          class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 p-6"
        >
          <!-- Profile Picture Section -->
          <div class="text-center mb-6">
            <div class="relative mx-auto w-24 h-24 mb-4">
              @if ($current_profile_picture)
                <img
                  src="{{ Storage::url($current_profile_picture) }}"
                  alt="Profile Picture"
                  class="w-24 h-24 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-lg"
                />
              @else
                <div
                  class="w-24 h-24 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center border-4 border-white dark:border-gray-700 shadow-lg"
                >
                  <svg
                    class="w-12 h-12 text-gray-400 dark:text-gray-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                    ></path>
                  </svg>
                </div>
              @endif
            </div>

            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
              {{ $name }}
            </h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">
              {{ $staff_id }}
            </p>
            <p class="text-xs text-gray-400 dark:text-gray-500">
              {{ $department }}
            </p>
          </div>

          <!-- Profile Picture Upload -->
          <div class="space-y-4">
            @if ($profile_picture)
              <div class="text-center">
                <img
                  src="{{ $profile_picture->temporaryUrl() }}"
                  alt="Preview"
                  class="w-16 h-16 rounded-full object-cover mx-auto mb-2 border-2 border-blue-500"
                />
                <p class="text-xs text-gray-500">Gambar baharu / New image</p>
              </div>
            @endif

            <div>
              <label
                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
              >
                Gambar Profil / Profile Picture
              </label>
              <input
                type="file"
                wire:model="profile_picture"
                accept="image/*"
                class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
              />
              @error('profile_picture')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">
                  {{ $message }}
                </p>
              @enderror
            </div>

            <div class="flex gap-2">
              @if ($profile_picture)
                <button
                  wire:click="updateProfilePicture"
                  class="flex-1 bg-blue-600 text-white text-xs py-2 px-3 rounded-md hover:bg-blue-700 transition-colors"
                >
                  Simpan / Save
                </button>
              @endif

              @if ($current_profile_picture)
                <button
                  wire:click="deleteProfilePicture"
                  wire:confirm="Adakah anda pasti ingin memadam gambar profil? / Are you sure you want to delete profile picture?"
                  class="flex-1 bg-red-600 text-white text-xs py-2 px-3 rounded-md hover:bg-red-700 transition-colors"
                >
                  Padam / Delete
                </button>
              @endif
            </div>
          </div>

          <!-- User Statistics -->
          <div class="mt-8 pt-6 border-t border-gray-200 dark:border-gray-700">
            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-4">
              Statistik / Statistics
            </h4>

            <div class="space-y-3">
              <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">
                  Jumlah Tiket / Total Tickets
                </span>
                <span class="font-medium text-gray-900 dark:text-white">
                  {{ $userStats['total_tickets'] ?? 0 }}
                </span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">
                  Tiket Selesai / Resolved
                </span>
                <span class="font-medium text-green-600">
                  {{ $userStats['resolved_tickets'] ?? 0 }}
                </span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">
                  Pinjaman Aktif / Active Loans
                </span>
                <span class="font-medium text-blue-600">
                  {{ $userStats['active_loans'] ?? 0 }}
                </span>
              </div>
              <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">
                  Jumlah Pinjaman / Total Loans
                </span>
                <span class="font-medium text-gray-900 dark:text-white">
                  {{ $userStats['total_loans'] ?? 0 }}
                </span>
              </div>
            </div>

            <div
              class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700"
            >
              <div class="text-xs text-gray-500 dark:text-gray-400">
                <p>
                  Sertai pada / Joined:
                  {{ isset($userStats['join_date']) ? $userStats['join_date']->format('M Y') : '-' }}
                </p>
                <p>
                  Log masuk terakhir / Last login:
                  {{ isset($userStats['last_login']) ? $userStats['last_login']->diffForHumans() : '-' }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="lg:col-span-3 space-y-8">
        <!-- Profile Information -->
        <div
          class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
        >
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
              Maklumat Profil / Profile Information
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
              Kemaskini maklumat peribadi anda / Update your personal
              information
            </p>
          </div>
          <form wire:submit="updateProfile" class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Name -->
              <div>
                <label
                  for="name"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  Nama Penuh / Full Name
                </label>
                <input
                  type="text"
                  wire:model="name"
                  id="name"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                @error('name')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- Email -->
              <div>
                <label
                  for="email"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  E-mel / Email
                </label>
                <input
                  type="email"
                  wire:model="email"
                  id="email"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                @error('email')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- Staff ID -->
              <div>
                <label
                  for="staff_id"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  ID Staf / Staff ID
                </label>
                <input
                  type="text"
                  wire:model="staff_id"
                  id="staff_id"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                @error('staff_id')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- Department -->
              <div>
                <label
                  for="department"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  Jabatan / Department
                </label>
                <input
                  type="text"
                  wire:model="department"
                  id="department"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                @error('department')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- Phone -->
              <div>
                <label
                  for="phone"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  Telefon / Phone
                </label>
                <input
                  type="text"
                  wire:model="phone"
                  id="phone"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                @error('phone')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- Position -->
              <div>
                <label
                  for="position"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  Jawatan / Position
                </label>
                <input
                  type="text"
                  wire:model="position"
                  id="position"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                @error('position')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>
            </div>

            <div class="flex justify-end">
              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              >
                <svg
                  wire:loading
                  wire:target="updateProfile"
                  class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  ></circle>
                  <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                  ></path>
                </svg>
                <span wire:loading.remove wire:target="updateProfile">
                  Kemaskini Profil / Update Profile
                </span>
                <span wire:loading wire:target="updateProfile">
                  Mengemaskini... / Updating...
                </span>
              </button>
            </div>
          </form>
        </div>

        <!-- Change Password -->
        <div
          class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
        >
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
              Tukar Kata Laluan / Change Password
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
              Kemaskini kata laluan untuk keselamatan yang lebih baik / Update
              your password for better security
            </p>
          </div>
          <form wire:submit="updatePassword" class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <!-- Current Password -->
              <div>
                <label
                  for="current_password"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  Kata Laluan Semasa / Current Password
                </label>
                <input
                  type="password"
                  wire:model="current_password"
                  id="current_password"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                @error('current_password')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- New Password -->
              <div>
                <label
                  for="new_password"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  Kata Laluan Baru / New Password
                </label>
                <input
                  type="password"
                  wire:model="new_password"
                  id="new_password"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                @error('new_password')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- Confirm Password -->
              <div>
                <label
                  for="new_password_confirmation"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  Sahkan Kata Laluan / Confirm Password
                </label>
                <input
                  type="password"
                  wire:model="new_password_confirmation"
                  id="new_password_confirmation"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                />
                @error('new_password_confirmation')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>
            </div>

            <div class="flex justify-end">
              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
              >
                <svg
                  wire:loading
                  wire:target="updatePassword"
                  class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  ></circle>
                  <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                  ></path>
                </svg>
                <span wire:loading.remove wire:target="updatePassword">
                  Tukar Kata Laluan / Change Password
                </span>
                <span wire:loading wire:target="updatePassword">
                  Menukar... / Changing...
                </span>
              </button>
            </div>
          </form>
        </div>

        <!-- Preferences -->
        <!-- Privacy Controls (MYDS-compliant) -->
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700 mt-8">
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
              Privasi & Data / Privacy & Data
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
              Anda boleh memadam semua data memori anda yang disimpan oleh sistem. Tindakan ini tidak boleh diundur. / You may delete all your memory data stored by the system. This action is irreversible.
            </p>
          </div>
          <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
              <x-icon name="info" class="w-5 h-5 text-warning-600" aria-hidden="true" />
              <span class="text-sm text-gray-700 dark:text-gray-300">
                Memadam memori akan menghapuskan semua data berkaitan anda dalam sistem pengetahuan. / Deleting memory will erase all your related data in the knowledge system.
              </span>
            </div>
            <x-myds.button
              variant="danger"
              size="md"
              wire:click="confirmDeleteMemory"
              class="ml-auto"
              aria-label="Padam Memori / Delete Memory"
            >
              <x-icon name="trash" class="w-4 h-4 mr-2" aria-hidden="true" />
              Padam Memori / Delete Memory
            </x-myds.button>
          </div>

          <!-- Confirmation Dialog -->
          <x-myds.dialog
            wire:model.defer="showDeleteMemoryDialog"
            title="Padam Semua Memori? / Delete All Memory?"
            aria-label="Padam Semua Memori? / Delete All Memory?"
          >
            <div class="space-y-2">
              <x-icon name="warning" class="w-6 h-6 text-danger-600 inline-block align-middle mr-2" aria-hidden="true" />
              <span class="text-danger-700 dark:text-danger-400 font-semibold">
                Tindakan ini tidak boleh diundur. Semua data memori anda akan dipadam secara kekal. / This action cannot be undone. All your memory data will be permanently deleted.
              </span>
            </div>
            <div class="mt-6 flex justify-end gap-2">
              <x-myds.button variant="ghost" wire:click="cancelDeleteMemory">Batal / Cancel</x-myds.button>
              <x-myds.button variant="danger" wire:click="deleteMemory" wire:loading.attr="disabled">
                <x-icon name="trash" class="w-4 h-4 mr-2" aria-hidden="true" />
                Ya, Padam / Yes, Delete
              </x-myds.button>
            </div>
          </x-myds.dialog>
        </div>
        <div
          class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
        >
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
              Keutamaan / Preferences
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
              Tetapkan keutamaan aplikasi anda / Set your application
              preferences
            </p>
          </div>
          <form wire:submit="updatePreferences" class="p-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Language Preference -->
              <div>
                <label
                  for="preferred_language"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  Bahasa Pilihan / Preferred Language
                </label>
                <select
                  wire:model="preferred_language"
                  id="preferred_language"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
                  <option value="ms">Bahasa Malaysia</option>
                  <option value="en">English</option>
                </select>
                @error('preferred_language')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- Theme Preference -->
              <div>
                <label
                  for="theme_preference"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  Tema / Theme
                </label>
                <select
                  wire:model="theme_preference"
                  id="theme_preference"
                  class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                >
                  <option value="light">Terang / Light</option>
                  <option value="dark">Gelap / Dark</option>
                  <option value="system">Ikut Sistem / System</option>
                </select>
                @error('theme_preference')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>
            </div>

            <!-- Notification Preferences -->
            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
              <h4
                class="text-base font-medium text-gray-900 dark:text-white mb-4"
              >
                Tetapan Notifikasi / Notification Settings
              </h4>

              <div class="space-y-4">
                <div class="flex items-center">
                  <input
                    type="checkbox"
                    wire:model="email_notifications"
                    id="email_notifications"
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded"
                  />
                  <label
                    for="email_notifications"
                    class="ml-3 text-sm text-gray-700 dark:text-gray-300"
                  >
                    Notifikasi E-mel / Email Notifications
                  </label>
                </div>

                <div class="flex items-center">
                  <input
                    type="checkbox"
                    wire:model="sms_notifications"
                    id="sms_notifications"
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded"
                  />
                  <label
                    for="sms_notifications"
                    class="ml-3 text-sm text-gray-700 dark:text-gray-300"
                  >
                    Notifikasi SMS / SMS Notifications
                  </label>
                </div>

                <div class="flex items-center">
                  <input
                    type="checkbox"
                    wire:model="browser_notifications"
                    id="browser_notifications"
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded"
                  />
                  <label
                    for="browser_notifications"
                    class="ml-3 text-sm text-gray-700 dark:text-gray-300"
                  >
                    Notifikasi Browser / Browser Notifications
                  </label>
                </div>
              </div>

              <!-- Notification Types -->
              <div class="mt-6">
                <h5
                  class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3"
                >
                  Jenis Notifikasi / Notification Types
                </h5>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div class="flex items-center">
                    <input
                      type="checkbox"
                      wire:model="notification_types.ticket_updates"
                      id="ticket_updates"
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded"
                    />
                    <label
                      for="ticket_updates"
                      class="ml-3 text-sm text-gray-700 dark:text-gray-300"
                    >
                      Kemaskini Tiket / Ticket Updates
                    </label>
                  </div>

                  <div class="flex items-center">
                    <input
                      type="checkbox"
                      wire:model="notification_types.loan_approvals"
                      id="loan_approvals"
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded"
                    />
                    <label
                      for="loan_approvals"
                      class="ml-3 text-sm text-gray-700 dark:text-gray-300"
                    >
                      Kelulusan Pinjaman / Loan Approvals
                    </label>
                  </div>

                  <div class="flex items-center">
                    <input
                      type="checkbox"
                      wire:model="notification_types.equipment_reminders"
                      id="equipment_reminders"
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded"
                    />
                    <label
                      for="equipment_reminders"
                      class="ml-3 text-sm text-gray-700 dark:text-gray-300"
                    >
                      Peringatan Peralatan / Equipment Reminders
                    </label>
                  </div>

                  <div class="flex items-center">
                    <input
                      type="checkbox"
                      wire:model="notification_types.system_announcements"
                      id="system_announcements"
                      class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 dark:border-gray-600 rounded"
                    />
                    <label
                      for="system_announcements"
                      class="ml-3 text-sm text-gray-700 dark:text-gray-300"
                    >
                      Pengumuman Sistem / System Announcements
                    </label>
                  </div>
                </div>
              </div>
            </div>

            <div class="flex justify-end">
              <button
                type="submit"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
              >
                <svg
                  wire:loading
                  wire:target="updatePreferences"
                  class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                  fill="none"
                  viewBox="0 0 24 24"
                >
                  <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4"
                  ></circle>
                  <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                  ></path>
                </svg>
                <span wire:loading.remove wire:target="updatePreferences">
                  Simpan Keutamaan / Save Preferences
                </span>
                <span wire:loading wire:target="updatePreferences">
                  Menyimpan... / Saving...
                </span>
              </button>
            </div>
          </form>
        </div>

        <!-- Recent Activity -->
        @if (! empty($recentActivity))
          <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
          >
            <div
              class="px-6 py-4 border-b border-gray-200 dark:border-gray-700"
            >
              <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                Aktiviti Terkini / Recent Activity
              </h3>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                Aktiviti terkini anda dalam sistem / Your recent activity in the
                system
              </p>
            </div>
            <div class="p-6">
              <div class="space-y-4">
                @foreach ($recentActivity as $activity)
                  <div class="flex items-start space-x-3">
                    <div
                      class="flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center {{ $activity['type'] === 'ticket' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600' }}"
                    >
                      @if ($activity['type'] === 'ticket')
                        <svg
                          class="w-4 h-4"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                          ></path>
                        </svg>
                      @else
                        <svg
                          class="w-4 h-4"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4-8-4m16 0v10l-8 4-8-4V7"
                          ></path>
                        </svg>
                      @endif
                    </div>
                    <div class="flex-1 min-w-0">
                      <p
                        class="text-sm font-medium text-gray-900 dark:text-white"
                      >
                        {{ $activity['title'] }}
                      </p>
                      <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ $activity['description'] }}
                      </p>
                      <div class="flex items-center mt-1 space-x-2">
                        <span
                          class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300"
                        >
                          {{ $activity['status'] }}
                        </span>
                        <span class="text-xs text-gray-400">
                          {{ \Carbon\Carbon::parse($activity['created_at'])->diffForHumans() }}
                        </span>
                      </div>
                    </div>
                    <div class="flex-shrink-0">
                      <a
                        href="{{ $activity['url'] }}"
                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                      >
                        <svg
                          class="w-4 h-4"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                          ></path>
                        </svg>
                      </a>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Flash Messages -->
  @if (session('success'))
    <div
      class="fixed bottom-4 right-4 max-w-sm w-full bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded shadow-lg z-50"
    >
      <div class="flex items-center">
        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
            clip-rule="evenodd"
          ></path>
        </svg>
        {{ session('success') }}
      </div>
    </div>
  @endif

  @if (session('error'))
    <div
      class="fixed bottom-4 right-4 max-w-sm w-full bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded shadow-lg z-50"
    >
      <div class="flex items-center">
        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path
            fill-rule="evenodd"
            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
            clip-rule="evenodd"
          ></path>
        </svg>
        {{ session('error') }}
      </div>
    </div>
  @endif

  <!-- Auto-hide flash messages -->
  <script
    src="{{ asset('js/livewire/profile-user-profile.js') }}"
    defer
  ></script>
</div>
