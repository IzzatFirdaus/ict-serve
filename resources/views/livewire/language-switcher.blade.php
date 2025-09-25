{{-- Livewire Language Switcher Component --}}
<div class="flex items-center space-x-2" wire:ignore>
    <label for="language-switcher" class="sr-only">{{ __('messages.language_switcher') }}</label>
    <select id="language-switcher" wire:model="language" class="rounded-md border-divider focus:ring-primary-300 focus:border-primary-600 text-sm" aria-label="{{ __('messages.language_switcher') }}">
        <option value="ms">{{ __('messages.language_bm') }}</option>
        <option value="en">{{ __('messages.language_en') }}</option>
    </select>
</div>
