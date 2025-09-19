<div class="fixed top-4 right-4 z-50 space-y-4 pointer-events-none">
  @foreach ($toasts as $toast)
    <div
      x-data="{ show: true, autoHide: true }"
      x-show="show"
      x-init="
        if (autoHide) {
          setTimeout(() => {
            show = false
            setTimeout(() => $wire.removeToast('{{ $toast['id'] }}'), 300)
          }, {{ $toast['duration'] }})
        }
      "
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="opacity-0 transform translate-x-full"
      x-transition:enter-end="opacity-100 transform translate-x-0"
      x-transition:leave="transition ease-in duration-300"
      x-transition:leave-start="opacity-100 transform translate-x-0"
      x-transition:leave-end="opacity-0 transform translate-x-full"
      class="max-w-sm w-full pointer-events-auto"
      wire:key="toast-{{ $toast['id'] }}"
    >
      @php
        $toastConfig = match ($toast['type']) {
          'success' => [
            'bg' => 'bg-success-50',
            'border' => 'border-success-200',
            'icon' => 'check-circle',
            'iconColor' => 'text-success-600',
            'titleColor' => 'text-success-900',
            'messageColor' => 'text-success-700',
            'buttonColor' => 'text-success-500 hover:text-success-600',
          ],
          'error', 'danger' => [
            'bg' => 'bg-danger-50',
            'border' => 'border-danger-200',
            'icon' => 'x-circle',
            'iconColor' => 'text-danger-600',
            'titleColor' => 'text-danger-900',
            'messageColor' => 'text-danger-700',
            'buttonColor' => 'text-danger-500 hover:text-danger-600',
          ],
          'warning' => [
            'bg' => 'bg-warning-50',
            'border' => 'border-warning-200',
            'icon' => 'warning',
            'iconColor' => 'text-warning-600',
            'titleColor' => 'text-warning-900',
            'messageColor' => 'text-warning-700',
            'buttonColor' => 'text-warning-500 hover:text-warning-600',
          ],
          default => [
            'bg' => 'bg-primary-50',
            'border' => 'border-primary-200',
            'icon' => 'info',
            'iconColor' => 'text-primary-600',
            'titleColor' => 'text-primary-900',
            'messageColor' => 'text-primary-700',
            'buttonColor' => 'text-primary-500 hover:text-primary-600',
          ],
        };
      @endphp

      <div
        class="bg-white {{ $toastConfig['border'] }} border rounded-lg shadow-lg p-4"
      >
        <div class="flex">
          <div class="flex-shrink-0">
            <x-myds.icon
              name="{{ $toastConfig['icon'] }}"
              size="20"
              class="{{ $toastConfig['iconColor'] }}"
            />
          </div>
          <div class="ml-3 w-0 flex-1">
            @if ($toast['title'])
              <p
                class="text-sm font-medium {{ $toastConfig['titleColor'] }} font-inter"
              >
                {{ $toast['title'] }}
              </p>
            @endif

            <p
              class="text-sm {{ $toastConfig['messageColor'] }} font-inter {{ $toast['title'] ? 'mt-1' : '' }}"
            >
              {{ $toast['message'] }}
            </p>
          </div>
          <div class="ml-4 flex-shrink-0 flex">
            <button
              type="button"
              @click="show = false; setTimeout(() => $wire.removeToast('{{ $toast['id'] }}'), 300)"
              class="inline-flex {{ $toastConfig['buttonColor'] }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
            >
              <span class="sr-only">Tutup</span>
              <x-myds.icon name="close" size="16" />
            </button>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
