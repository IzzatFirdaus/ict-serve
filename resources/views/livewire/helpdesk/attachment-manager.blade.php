<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
  <!-- Header -->
  <div
    class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700"
  >
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
      <div class="flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
            Lampiran Tiket / Ticket Attachments
          </h1>
          <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            #{{ $ticket->ticket_number }} - {{ $ticket->title }}
          </p>
        </div>

        <div class="flex items-center gap-4">
          <a
            href="{{ route('helpdesk.index-enhanced') }}"
            class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"
          >
            <svg
              class="w-4 h-4 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"
              ></path>
            </svg>
            Kembali / Back
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <!-- Upload Section -->
      @if ($canUpload)
        <div class="lg:col-span-1">
          <div
            class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
          >
            <div
              class="px-6 py-4 border-b border-gray-200 dark:border-gray-700"
            >
              <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                Muat Naik Lampiran / Upload Attachments
              </h3>
              <p class="text-sm text-gray-600 dark:text-gray-400">
                Had saiz: 5MB setiap fail / Size limit: 5MB per file
              </p>
            </div>
            <form wire:submit="uploadFiles" class="p-6 space-y-6">
              <!-- File Upload -->
              <div>
                <label
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                >
                  Pilih Fail / Select Files
                </label>
                <div
                  class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-gray-400 dark:hover:border-gray-500 transition-colors"
                >
                  <div class="space-y-1 text-center">
                    <svg
                      class="mx-auto h-12 w-12 text-gray-400"
                      stroke="currentColor"
                      fill="none"
                      viewBox="0 0 48 48"
                    >
                      <path
                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                      />
                    </svg>
                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                      <label
                        for="file-upload"
                        class="relative cursor-pointer bg-white dark:bg-gray-800 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500"
                      >
                        <span>Muat naik fail / Upload files</span>
                        <input
                          id="file-upload"
                          wire:model="files"
                          type="file"
                          multiple
                          class="sr-only"
                        />
                      </label>
                      <p class="pl-1">
                        atau seret dan lepas / or drag and drop
                      </p>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                      PDF, DOC, DOCX, JPG, PNG, GIF, XLSX, TXT, ZIP hingga / up
                      to 5MB
                    </p>
                  </div>
                </div>
                @error('files.*')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- File Preview -->
              @if (! empty($files))
                <div>
                  <label
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                  >
                    Fail Dipilih / Selected Files
                  </label>
                  <ul
                    class="divide-y divide-gray-200 dark:divide-gray-700 border border-gray-200 dark:border-gray-700 rounded-md"
                  >
                    @foreach ($files as $index => $file)
                      <li class="p-3 flex items-center justify-between">
                        <div class="flex items-center">
                          <svg
                            class="h-5 w-5 text-gray-400 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                            ></path>
                          </svg>
                          <span class="text-sm text-gray-900 dark:text-white">
                            {{ $file->getClientOriginalName() }}
                          </span>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                          {{ number_format($file->getSize() / 1024, 1) }} KB
                        </div>
                      </li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <!-- Description -->
              <div>
                <label
                  for="attachmentDescription"
                  class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                  Keterangan (Pilihan) / Description (Optional)
                </label>
                <div class="mt-1">
                  <textarea
                    wire:model="attachmentDescription"
                    id="attachmentDescription"
                    rows="3"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md"
                    placeholder="Huraikan fail yang dimuat naik (pilihan) / Describe the uploaded files (optional)"
                  ></textarea>
                </div>
                @error('attachmentDescription')
                  <p class="mt-2 text-sm text-red-600 dark:text-red-400">
                    {{ $message }}
                  </p>
                @enderror
              </div>

              <!-- Upload Button -->
              <button
                type="submit"
                @if(empty($files)) disabled @endif
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
              >
                <svg
                  wire:loading
                  wire:target="uploadFiles"
                  class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
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
                <span wire:loading.remove wire:target="uploadFiles">
                  Muat Naik / Upload
                </span>
                <span wire:loading wire:target="uploadFiles">
                  Memuat naik... / Uploading...
                </span>
              </button>
            </form>
          </div>
        </div>
      @endif

      <!-- Attachments List -->
      <div class="{{ $canUpload ? 'lg:col-span-2' : 'lg:col-span-3' }}">
        <div
          class="bg-white dark:bg-gray-800 shadow-lg rounded-lg border border-gray-200 dark:border-gray-700"
        >
          <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
              Lampiran Sedia Ada / Existing Attachments
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
              {{ count($attachments) }} fail dilampirkan / files attached
            </p>
          </div>

          @if (empty($attachments))
            <div class="p-12 text-center">
              <svg
                class="mx-auto h-12 w-12 text-gray-400"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
              </svg>
              <h3
                class="mt-2 text-sm font-medium text-gray-900 dark:text-white"
              >
                Tiada lampiran / No attachments
              </h3>
              <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Belum ada fail yang dilampirkan pada tiket ini / No files have
                been attached to this ticket yet
              </p>
            </div>
          @else
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
              @foreach ($attachments as $attachment)
                <li class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700">
                  <div class="flex items-center justify-between">
                    <div class="flex items-start space-x-4">
                      <!-- File Icon -->
                      <div class="flex-shrink-0">
                        <div
                          class="w-10 h-10 bg-gray-100 dark:bg-gray-600 rounded-lg flex items-center justify-center"
                        >
                          @php
                            $icon = $this->getFileIcon($attachment['mime_type']);
                          @endphp

                          <svg
                            class="w-6 h-6 text-gray-600 dark:text-gray-300"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                          >
                            @if ($icon === 'photograph')
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                              ></path>
                            @elseif ($icon === 'table')
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M3 10h18M3 14h18m-9-4v8m-7 0V7a2 2 0 012-2h14a2 2 0 012 2v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"
                              ></path>
                            @elseif ($icon === 'archive')
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"
                              ></path>
                            @else
                              <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                              ></path>
                            @endif
                          </svg>
                        </div>
                      </div>

                      <!-- File Info -->
                      <div class="flex-1 min-w-0">
                        <p
                          class="text-sm font-medium text-gray-900 dark:text-white truncate"
                        >
                          {{ $attachment['original_name'] }}
                        </p>
                        <div
                          class="flex items-center text-xs text-gray-500 dark:text-gray-400 space-x-4"
                        >
                          <span>
                            {{ $this->formatFileSize($attachment['size']) }}
                          </span>
                          <span>•</span>
                          <span>
                            {{ $attachment['uploaded_by_name'] ?? 'Unknown' }}
                          </span>
                          <span>•</span>
                          <span>
                            {{ \Carbon\Carbon::parse($attachment['uploaded_at'])->format('d/m/Y H:i') }}
                          </span>
                        </div>
                        @if ($attachment['description'])
                          <p
                            class="mt-1 text-xs text-gray-600 dark:text-gray-400"
                          >
                            {{ $attachment['description'] }}
                          </p>
                        @endif
                      </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center space-x-2">
                      <!-- Download Button -->
                      <button
                        wire:click="downloadFile('{{ $attachment['id'] }}')"
                        class="inline-flex items-center p-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm bg-white dark:bg-gray-700 text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"
                      >
                        <svg
                          class="w-4 h-4"
                          fill="none"
                          stroke="currentColor"
                          viewBox="0 0 24 24"
                        >
                          <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                          ></path>
                        </svg>
                      </button>

                      <!-- Delete Button -->
                      @php
                        $user = Auth::user();
                        $canDelete =
                          $user->id === (int) $attachment['uploaded_by'] ||
                          in_array($user->role, ['ict_admin', 'supervisor']) ||
                          $user->id === $ticket->user_id;
                      @endphp

                      @if ($canDelete)
                        <button
                          wire:click="deleteFile('{{ $attachment['id'] }}')"
                          wire:confirm="Adakah anda pasti ingin memadam fail ini? / Are you sure you want to delete this file?"
                          class="inline-flex items-center p-2 border border-red-300 dark:border-red-600 rounded-md shadow-sm bg-red-50 dark:bg-red-900 text-sm font-medium text-red-700 dark:text-red-200 hover:bg-red-100 dark:hover:bg-red-800"
                        >
                          <svg
                            class="w-4 h-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                          >
                            <path
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            ></path>
                          </svg>
                        </button>
                      @endif
                    </div>
                  </div>
                </li>
              @endforeach
            </ul>
          @endif
        </div>
      </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
      <div
        class="fixed bottom-4 right-4 max-w-sm w-full bg-green-100 dark:bg-green-800 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded shadow-lg z-50"
      >
        <div class="flex items-center">
          <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
              clip-rule="evenodd"
            ></path>
          </svg>
          {{ session('success') }}
        </div>
      </div>
    @endif

    @if (session('error'))
      <div
        class="fixed bottom-4 right-4 max-w-sm w-full bg-red-100 dark:bg-red-800 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded shadow-lg z-50"
      >
        <div class="flex items-center">
          <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path
              fill-rule="evenodd"
              d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
              clip-rule="evenodd"
            ></path>
          </svg>
          {{ session('error') }}
        </div>
      </div>
    @endif
  </div>

  <!-- Auto-hide flash messages -->
  @vite(['resources/js/livewire/helpdesk/attachment-manager.js'])
</div>
