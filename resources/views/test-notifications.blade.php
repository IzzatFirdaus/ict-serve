<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Test Notifications</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
  </head>
  <body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-8">
      <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow p-6 mb-8">
          <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">
              Test Notification System
            </h1>
            <div class="flex items-center space-x-4">
              <!-- Notification Bell Component -->
              @livewire('notifications.notification-bell')

              <a
                href="{{ route('notifications.index') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
              >
                Full Notification Center
              </a>

              <a
                href="{{ route('profile.index') }}"
                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
              >
                User Profile
              </a>

              <a
                href="{{ route('dashboard') }}"
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
              >
                Dashboard
              </a>
            </div>
          </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
          <h2 class="text-lg font-semibold mb-4">
            Notification Center Component
          </h2>
          @livewire('notifications.notification-center')
        </div>
      </div>
    </div>

    @livewireScripts
    <script src="//unpkg.com/alpinejs" defer></script>
  </body>
</html>
