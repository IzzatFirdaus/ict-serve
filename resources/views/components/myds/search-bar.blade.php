{{-- MYDS Search Bar Component --}}
<form {{ $attributes->merge(['role' => 'search', 'class' => 'flex items-center space-x-2']) }}>
    <input type="search" name="q" class="w-full px-3 py-2 border border-divider rounded-md font-inter text-sm focus:ring-2 focus:ring-primary-300 focus:border-primary-600" placeholder="{{ __('messages.search') }}" aria-label="{{ __('messages.search') }}" />
    <x-myds.button type="submit" aria-label="{{ __('messages.search') }}">
        <x-myds.icon name="search" class="w-4 h-4" aria-hidden="true" />
    </x-myds.button>
</form>
