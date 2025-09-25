{{--
  Admin layout for ICTServe (iServe)
  Includes Livewire-powered theme and language switchers, skip link, and feedback toast
  MYDS 12-8-4 grid, full accessibility, translation keys only
--}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-theme="{{ session('theme', 'system') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ trans('messages.admin_panel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-inter bg-white text-gray-900">
    <a href="#main-content" class="skip-link focus:outline-none focus:ring-2 focus:ring-primary-300">
        {{ trans('messages.skip_to_content') }}
    </a>
    <header class="bg-white border-b border-divider px-4 py-2 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <span class="font-poppins text-lg font-semibold text-primary-600">
                {{ trans('messages.admin_panel') }}
            </span>
        </div>
        <nav class="flex items-center space-x-2">
            <livewire:language-switcher />
            <livewire:theme-switcher />
        </nav>
    </header>
    <main id="main-content" class="container mx-auto py-8 grid grid-cols-12 gap-6">
        <div class="col-span-12 md:col-span-8">
            @yield('content')
        </div>
        <aside class="col-span-12 md:col-span-4">
            @yield('sidebar')
        </aside>
    </main>
    <footer class="bg-gray-50 border-t border-divider py-4 text-center text-xs text-gray-500">
        <p class="text-xs text-gray-500">{{ trans('messages.footer_copyright') }}</p>
    </footer>
    <livewire:feedback-toast />
    @livewireScripts
    <script>
        window.addEventListener('theme-changed', e => Livewire.emit('showToast', e.detail.message));
        window.addEventListener('language-changed', e => Livewire.emit('showToast', e.detail.message));
    </script>
</body>
</html>
