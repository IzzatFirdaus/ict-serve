<div class="bg-white rounded-lg shadow-sm border border-gray-200">
  {{-- Header --}}
  <div class="px-6 py-4 border-b border-gray-200">
    <div class="flex items-center justify-between">
      <div>
        <h3 class="text-lg font-semibold text-gray-900">
          {{ __('document_generator.title') }}
        </h3>
        <p class="text-sm text-gray-600 mt-1">
          {{ __('document_generator.subtitle') }}
        </p>
      </div>
      @if ($loanRequest)
        <div class="text-sm text-gray-500">
          Rujukan: {{ $loanRequest->reference_number ?? 'N/A' }}
        </div>
      @endif
    </div>
  </div>

  {{-- Flash Messages --}}
  @if (session()->has('message'))
    <div
      class="mx-6 mt-4 p-4 bg-success-50 border border-success-200 rounded-md"
    >
      <div class="flex">
        <div class="flex-shrink-0">
          <x-icon name="check-circle" class="h-5 w-5 text-success-400" />
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-success-800">
            {{ session('message') }}
          </p>
        </div>
      </div>
    </div>
  @endif

  @if (session()->has('error'))
    <div class="mx-6 mt-4 p-4 bg-danger-50 border border-danger-200 rounded-md">
      <div class="flex">
        <div class="flex-shrink-0">
          <x-icon name="x-circle" class="h-5 w-5 text-danger-400" />
        </div>
        <div class="ml-3">
          <p class="text-sm font-medium text-danger-800">
            {{ session('error') }}
          </p>
        </div>
      </div>
    </div>
  @endif

  {{-- Document Type Selection --}}
  <div class="px-6 py-6">
    <h4 class="text-sm font-medium text-gray-900 mb-4">
      {{ __('document_generator.select_type') }}
    </h4>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
      @foreach ($documentTypes as $type => $config)
        <div class="relative">
          <button
            wire:click="setDocumentType('{{ $type }}')"
            class="w-full text-left p-4 border-2 rounded-lg transition-all duration-200 {{ $documentType === $type ? 'border-otl-primary-300 bg-primary-50' : 'border-gray-200 hover:border-gray-300 bg-white' }} {{ $this->canGenerateDocument($type) ? '' : 'opacity-50 cursor-not-allowed' }}"
            @if(!$this->canGenerateDocument($type)) disabled @endif
          >
            <div class="flex items-start justify-between">
              <div class="flex-1">
                <h5 class="text-sm font-medium text-gray-900">
                  {{ $config['title'] }}
                </h5>
                <p class="text-xs text-gray-600 mt-1">
                  {{ $config['description'] }}
                </p>
              </div>
              @if ($documentType === $type)
                <x-icon
                  name="check-circle"
                  class="h-5 w-5 text-txt-primary ml-2"
                />
              @endif
            </div>

            @if (! $this->canGenerateDocument($type))
              <div class="mt-2">
                <span
                  class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600"
                >
                  <x-icon name="lock-closed" class="h-3 w-3 mr-1" />
                  Tidak Tersedia
                </span>
              </div>
            @endif
          </button>
        </div>
      @endforeach
    </div>
    class="inline-flex items-center px-4 py-2 border border-transparent text-sm
    font-medium rounded-md text-txt-white bg-bg-primary-600
    hover:bg-bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2
    focus:ring-fr-primary disabled:opacity-50 disabled:cursor-not-allowed">

    {{-- Action Buttons --}}
    @if ($loanRequest && $this->canGenerateDocument($documentType))
      <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
        <div class="flex flex-wrap gap-3">
          <button
            wire:click="generatePreview"
            class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-primary"
          >
            <x-icon name="eye" class="w-4 h-4 mr-2" />
            {{ __('document_generator.preview') }}
          </button>

          <button
            wire:click="generatePDF"
            wire:loading.attr="disabled"
            wire:target="generatePDF"
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-txt-white bg-bg-primary-600 hover:bg-bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-primary disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <div wire:loading.remove wire:target="generatePDF">
              <x-icon name="download" class="w-4 h-4 mr-2" />
              Jana & Muat Turun PDF
            </div>

            <div
              wire:loading
              wire:target="generatePDF"
              class="flex items-center"
            >
              <svg
                class="animate-spin -ml-1 mr-2 h-4 w-4 text-white"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
              >
                <circle
                  class="opacity-25"
                  cx="12"
                  cy="12"
                  r="10"
                  stroke="currentColor"
                  stroke-width="4"
                ></circle>
                <path
                  class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                ></path>
              </svg>
              Menjana...
            </div>
          </button>
        </div>
      </div>
    @endif

    {{-- Document Preview --}}
    @if ($showPreview && $loanRequest)
      <div class="px-6 py-6 border-t border-gray-200">
        <h4 class="text-sm font-medium text-gray-900 mb-4">
          Pratonton Dokumen
        </h4>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
          <div class="text-center mb-6">
            <h2 class="text-lg font-bold text-gray-900">
              {{ $documentTypes[$documentType]['title'] }}
            </h2>
            <p class="text-sm text-gray-600 mt-1">
              KEMENTERIAN PELANCONGAN, SENI DAN BUDAYA MALAYSIA
            </p>
            <p class="text-sm text-gray-600">BAHAGIAN PENGURUSAN MAKLUMAT</p>
          </div>

          <div class="space-y-4">
            {{-- Basic Information --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-sm font-medium text-gray-700">
                  Nama Pemohon
                </label>
                <p class="mt-1 text-sm text-gray-900">
                  {{ $loanRequest->user->name ?? 'N/A' }}
                </p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">
                  No. Rujukan
                </label>
                <p class="mt-1 text-sm text-gray-900">
                  {{ $loanRequest->reference_number ?? 'N/A' }}
                </p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">
                  Tarikh Permohonan
                </label>
                <p class="mt-1 text-sm text-gray-900">
                  {{ $loanRequest->created_at?->format('d/m/Y') ?? 'N/A' }}
                </p>
              </div>
              <div>
                <label class="block text-sm font-medium text-gray-700">
                  Status
                </label>
                <p class="mt-1 text-sm text-gray-900">
                  {{ ucfirst($loanRequest->status) }}
                </p>
              </div>
            </div>

            {{-- Equipment List --}}
            @if ($loanRequest->equipmentItems && $loanRequest->equipmentItems->count() > 0)
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                  {{ __('forms.labels.requested_equipment') }}
                </label>
                <div
                  class="bg-white border border-gray-200 rounded-md overflow-hidden"
                >
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th
                          class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase"
                        >
                          Peralatan
                        </th>
                        <th
                          class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase"
                        >
                          Kuantiti
                        </th>
                        <th
                          class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase"
                        >
                          Tempoh
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      @foreach ($loanRequest->equipmentItems as $item)
                        <tr>
                          <td class="px-4 py-2 text-sm text-gray-900">
                            {{ $item->name }}
                          </td>
                          <td class="px-4 py-2 text-sm text-gray-900">
                            {{ $item->pivot->quantity ?? 1 }}
                          </td>
                          <td class="px-4 py-2 text-sm text-gray-900">
                            {{ $loanRequest->loan_start_date?->format('d/m/Y') }}
                            -
                            {{ $loanRequest->loan_end_date?->format('d/m/Y') }}
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            @endif

            {{-- Document-specific content preview --}}
            @if ($documentType === 'approval_letter' && $loanRequest->status === 'approved')
              <div
                class="mt-6 p-4 bg-success-50 border border-success-200 rounded-md"
              >
                <h5 class="text-sm font-medium text-success-800">
                  Keputusan Permohonan
                </h5>
                <p class="text-sm text-success-700 mt-1">
                  Permohonan ini telah diluluskan pada
                  {{ $loanRequest->approved_at?->format('d/m/Y H:i') }}.
                </p>
              </div>
            @endif
          </div>

          <div class="mt-6 text-center">
            <p class="text-xs text-gray-500">
              Ini adalah pratonton ringkas. Dokumen sebenar akan mengandungi
              maklumat yang lebih lengkap.
            </p>
          </div>
        </div>
      </div>
    @endif

    {{-- Existing Documents --}}
    @if ($availableDocuments->count() > 0)
      <div class="px-6 py-6 border-t border-gray-200">
        <h4 class="text-sm font-medium text-gray-900 mb-4">
          Dokumen Sedia Ada
        </h4>
        <div class="space-y-3">
          @foreach ($availableDocuments as $document)
            <div
              class="flex items-center justify-between p-4 border border-gray-200 rounded-lg"
            >
              <div class="flex items-center space-x-3">
                <x-icon name="document-text" class="h-5 w-5 text-gray-400" />
                <div>
                  <p class="text-sm font-medium text-gray-900">
                    {{ $document['name'] }}
                  </p>
                  <p class="text-xs text-gray-500">
                    {{ number_format($document['size'] / 1024, 1) }} KB •
                    {{ $document['created']->format('d/m/Y H:i') }}
                  </p>
                </div>
              </div>
              <button
                wire:click="downloadExisting('{{ $document['path'] }}')"
                class="inline-flex items-center px-3 py-1 border border-gray-300 text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-fr-primary"
              >
                <x-icon name="download" class="w-3 h-3 mr-1" />
                Muat Turun
              </button>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</div>
