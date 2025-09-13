@props([
    'items' => [],
    'separator' => '/',
    'homeLabel' => 'Utama',
    'homeUrl' => '/',
])

<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <!-- Home Link -->
        <li class="inline-flex items-center">
            <a
                href="{{ $homeUrl }}"
                class="inline-flex items-center text-sm font-medium text-txt-black-500 hover:text-txt-primary transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary rounded-[var(--radius-s)]"
            >
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                </svg>
                {{ $homeLabel }}
            </a>
        </li>

        <!-- Breadcrumb Items -->
        @foreach($items as $index => $item)
            <li>
                <div class="flex items-center">
                    <!-- Separator -->
                    <svg class="w-5 h-5 text-txt-black-400 mx-1" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>

                    <!-- Breadcrumb Item -->
                    @if($loop->last)
                        <!-- Current Page (no link) -->
                        <span class="ml-1 text-sm font-medium text-txt-black-900" aria-current="page">
                            {{ $item['label'] }}
                        </span>
                    @else
                        <!-- Linked Item -->
                        <a
                            href="{{ $item['url'] ?? '#' }}"
                            class="ml-1 text-sm font-medium text-txt-black-500 hover:text-txt-primary transition-colors focus:outline-none focus:ring-2 focus:ring-fr-primary rounded-[var(--radius-s)]"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endif
                </div>
            </li>
        @endforeach

        <!-- Slot Content (for manual breadcrumb items) -->
        @if($slot->isNotEmpty())
            <li>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-txt-black-400 mx-1" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    {{ $slot }}
                </div>
            </li>
        @endif
    </ol>
</nav>
