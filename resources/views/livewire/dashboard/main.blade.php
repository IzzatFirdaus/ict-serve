{{-- Dashboard Main Component - MYDS Compliant --}}
<div class="min-h-screen bg-background-light">
  {{-- Main Content --}}
  <main class="container mx-auto px-6 py-8">
    {{-- Page Title --}}
    <div class="mb-8">
      <h1 class="font-poppins text-2xl font-semibold text-black-900 mb-2">
        Dashboard ICTServe
      </h1>
      <p class="font-inter text-sm text-black-700">
        Selamat datang ke sistem pengurusan ICT MOTAC
      </p>
    </div>

    {{-- Dashboard Grid - MYDS 12-8-4 Grid System --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
      {{-- Quick Access Widget --}}
      <livewire:dashboard.quick-access-widget />

      {{-- Status Widget --}}
      <livewire:dashboard.status-widget />

      {{-- Notification Widget --}}
      <livewire:dashboard.notification-widget />
    </div>

    {{-- Recent Activity Section --}}
    <div class="bg-white rounded-lg border border-divider p-6">
      <h2 class="font-poppins text-xl font-medium text-black-900 mb-4">
        Aktiviti Terkini
      </h2>
      <div class="space-y-4">
        {{-- Activity items will be populated by Livewire --}}
        <div class="flex items-center gap-4 p-3 bg-background-light rounded-md">
          <svg
            class="w-5 h-5 text-success-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M5 13l4 4L19 7"
            />
          </svg>
          <div class="flex-1">
            <p class="font-inter text-sm text-black-900">
              Permohonan pinjaman peralatan telah diluluskan
            </p>
            <p class="font-inter text-xs text-black-500">2 jam yang lalu</p>
          </div>
        </div>
        <div class="flex items-center gap-4 p-3 bg-background-light rounded-md">
          <svg
            class="w-5 h-5 text-primary-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
            />
          </svg>
          <div class="flex-1">
            <p class="font-inter text-sm text-black-900">
              Tiket helpdesk baharu telah dibuka
            </p>
            <p class="font-inter text-xs text-black-500">4 jam yang lalu</p>
          </div>
        </div>
        <div class="flex items-center gap-4 p-3 bg-background-light rounded-md">
          <svg
            class="w-5 h-5 text-warning-600"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
            />
          </svg>
          <div class="flex-1">
            <p class="font-inter text-sm text-black-900">
              Peralatan perlu dipulangkan dalam 2 hari
            </p>
            <p class="font-inter text-xs text-black-500">1 hari yang lalu</p>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
