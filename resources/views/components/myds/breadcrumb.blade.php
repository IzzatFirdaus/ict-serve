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
        class="inline-flex items-center text-sm font-inter font-medium text-black-500 hover:text-primary-600 transition-colors focus:outline-none focus:ring-2 focus:ring-primary-300 rounded-md"
      >
        <svg
          class="w-4 h-4 mr-2"
          fill="currentColor"
          viewBox="0 0 20 20"
          aria-hidden="true"
        >
          <path
            d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
          ></path>
        </svg>
        {{ $homeLabel }}
      </a>
    </li>

    <!-- Breadcrumb Items -->
    @foreach ($items as $index => $item)
      <li>
        <div class="flex items-center">
          <!-- Separator -->
          <svg
            class="w-4 h-4 text-secondary-500 mx-1"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            viewBox="0 0 20 20"
            aria-hidden="true"
          >
            <path
              d="M7 4l6 6-6 6"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>

          <!-- Breadcrumb Item -->
          @if ($loop->last)
            <!-- Current Page (no link) -->
            <span
              class="ml-1 text-sm font-inter font-medium text-secondary-500"
              aria-current="page"
            >
              {{ $item['label'] }}
            </span>
          @else
            <!-- Linked Item -->
            <a
              href="{{ $item['url'] ?? '#' }}"
              class="ml-1 text-sm font-inter font-medium text-primary-600 hover:underline focus:outline-none focus:ring focus:ring-primary-300 rounded transition"
            >
              {{ $item['label'] }}
            </a>
          @endif
        </div>
      </li>
    @endforeach

    <!-- Slot Content (for manual breadcrumb items) -->
    @if ($slot->isNotEmpty())
      <li>
        <div class="flex items-center">
          <svg
            class="w-4 h-4 text-secondary-500 mx-1"
            fill="none"
            stroke="currentColor"
            stroke-width="1.5"
            viewBox="0 0 20 20"
            aria-hidden="true"
          >
            <path
              d="M7 4l6 6-6 6"
              stroke-linecap="round"
              stroke-linejoin="round"
            />
          </svg>
          {{ $slot }}
        </div>
      </li>
    @endif
  </ol>
</nav>
