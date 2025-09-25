{{-- Livewire Theme Switcher Component --}}
<div class="flex items-center space-x-2" wire:ignore>
    <label for="theme-switcher" class="sr-only">{{ __('messages.theme_switcher') }}</label>
    <select id="theme-switcher" wire:model="theme" class="rounded-md border-divider focus:ring-primary-300 focus:border-primary-600 text-sm" aria-label="{{ __('messages.theme_switcher') }}">
        <option value="light">{{ __('messages.theme_light') }}</option>
        <option value="dark">{{ __('messages.theme_dark') }}</option>
        <option value="system">{{ __('messages.theme_system') }}</option>
    </select>
</div>
