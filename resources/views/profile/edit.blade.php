{{--
  ICTServe (iServe) User Profile Edit Page
  ========================================
  This component provides the main view for users to manage their profile information,
  update their password, and delete their account.
  
  MYDS & MyGovEA Principles Applied:
  - Kandungan Terancang (Planned Content): Re-architected from a simple vertical list into a clean tabbed interface, organizing related actions into logical sections ("Profil", "Kata Laluan", "Padam Akaun"). This reduces cognitive load.
  - Antara Muka Minimalis dan Mudah (Minimalist Interface): By using tabs, only relevant information is shown at one time, creating a much cleaner and less cluttered page.
  - Seragam (Consistent): The entire component, including the tab styles, cards, and spacing, adheres to the MYDS design tokens and patterns.
  - Kawalan Pengguna (User Control): Provides clear, separated sections for users to control distinct aspects of their account.
  - Komponen UI/UX: Implements the MYDS "Tabs" component pattern for superior navigation and user experience on settings pages.
--}}

<x-app-layout>
  {{-- Page Header --}}
  <x-slot name="header">
    <h2
      class="font-semibold font-poppins text-xl text-txt-black-800 dark:text-txt-black-200 leading-tight"
    >
      Urus Profil Pengguna
    </h2>
    <p class="mt-1 text-sm text-txt-black-500 dark:text-txt-black-400">
      Kemaskini maklumat profil, kata laluan dan tetapan akaun anda di sini.
    </p>
  </x-slot>

  {{-- Main Content Area --}}
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      {{-- Tabbed Interface powered by Alpine.js --}}
      <div
        x-data="{ activeTab: 'profile' }"
        class="bg-white dark:bg-gray-900 border border-otl-gray-200 dark:border-otl-gray-800 rounded-lg shadow-card"
      >
        {{-- Tab Triggers (Navigation) --}}
        <div class="border-b border-otl-divider dark:border-otl-divider">
          <nav class="-mb-px flex space-x-6 px-6" aria-label="Tabs">
            {{-- Profile Tab --}}
            <button
              @click="activeTab = 'profile'"
              :class="{
                                    'border-primary-600 text-primary-600 dark:border-primary-400 dark:text-primary-300': activeTab === 'profile',
                                    'border-transparent text-txt-black-500 hover:text-txt-black-700 hover:border-gray-300 dark:text-txt-black-400 dark:hover:text-txt-black-200': activeTab !== 'profile'
                                }"
              class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors focus:outline-none"
              aria-controls="tab-panel-profile"
              role="tab"
            >
              Maklumat Profil
            </button>

            {{-- Password Tab --}}
            <button
              @click="activeTab = 'password'"
              :class="{
                                    'border-primary-600 text-primary-600 dark:border-primary-400 dark:text-primary-300': activeTab === 'password',
                                    'border-transparent text-txt-black-500 hover:text-txt-black-700 hover:border-gray-300 dark:text-txt-black-400 dark:hover:text-txt-black-200': activeTab !== 'password'
                                }"
              class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors focus:outline-none"
              aria-controls="tab-panel-password"
              role="tab"
            >
              Tukar Kata Laluan
            </button>

            {{-- Delete Account Tab --}}
            <button
              @click="activeTab = 'delete'"
              :class="{
                                    'border-danger-600 text-danger-600 dark:border-danger-400 dark:text-danger-300': activeTab === 'delete',
                                    'border-transparent text-txt-black-500 hover:text-txt-black-700 hover:border-gray-300 dark:text-txt-black-400 dark:hover:text-txt-black-200': activeTab !== 'delete'
                                }"
              class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors focus:outline-none"
              aria-controls="tab-panel-delete"
              role="tab"
            >
              Padam Akaun
            </button>
          </nav>
        </div>

        {{-- Tab Panels (Content) --}}
        <div class="p-6 sm:p-8">
          {{-- Profile Information Panel --}}
          <div
            id="tab-panel-profile"
            x-show="activeTab === 'profile'"
            role="tabpanel"
            x-cloak
          >
            <div class="max-w-xl">
              @include('profile.partials.update-profile-information-form')
            </div>
          </div>

          {{-- Update Password Panel --}}
          <div
            id="tab-panel-password"
            x-show="activeTab === 'password'"
            role="tabpanel"
            x-cloak
          >
            <div class="max-w-xl">
              @include('profile.partials.update-password-form')
            </div>
          </div>

          {{-- Delete User Panel --}}
          <div
            id="tab-panel-delete"
            x-show="activeTab === 'delete'"
            role="tabpanel"
            x-cloak
          >
            <div class="max-w-xl">
              @include('profile.partials.delete-user-form')
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>
