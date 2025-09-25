{{-- Livewire Feedback Toast for language/theme changes --}}
<div x-data="{ show: @entangle('show') }" x-show="show" class="fixed bottom-4 right-4 z-50">
    <div class="bg-success-100 text-success-800 px-4 py-2 rounded shadow-lg flex items-center space-x-2" role="status" aria-live="polite">
        <x-myds.icon name="check-circle" class="w-5 h-5 text-success-600" />
        <span>{{ $message }}</span>
        <button @click="show = false" class="ml-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-300 rounded-full" aria-label="{{ __('messages.close') }}">
            <x-myds.icon name="cross" class="w-4 h-4" />
        </button>
    </div>
</div>
