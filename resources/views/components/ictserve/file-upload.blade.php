@props([
    'name' => 'files',
    'label' => 'Muat Naik Fail',
    'accept' => null,
    'multiple' => true,
    'maxFiles' => 5,
    'maxSize' => 10, // MB
    'required' => false,
    'helpText' => null,
    'error' => null,
    'disabled' => false,
    'showPreview' => true,
    'allowedTypes' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'jpg', 'jpeg', 'png', 'gif'],
    'uploadUrl' => '/upload',
    'existingFiles' => [],
])

@php
$acceptString = $accept ?? implode(',', array_map(fn($type) => ".$type", $allowedTypes));
$helpText = $helpText ?? "Maksimum {$maxFiles} fail, saiz maksimum {$maxSize}MB setiap fail. Format yang dibenarkan: " . implode(', ', $allowedTypes);
@endphp

<div
    class="file-upload-component"
    x-data="fileUpload({
        maxFiles: {{ $maxFiles }},
        maxSize: {{ $maxSize }},
        allowedTypes: {{ json_encode($allowedTypes) }},
        uploadUrl: '{{ $uploadUrl }}',
        multiple: {{ $multiple ? 'true' : 'false' }},
        existingFiles: {{ json_encode($existingFiles) }}
    })"
    {{ $attributes }}
>
    {{-- Label --}}
    @if($label)
        <label class="block text-sm font-medium text-txt-black-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-txt-danger">*</span>
            @endif
        </label>
    @endif

    {{-- Drop Zone --}}
    <div
        role="button"
        :aria-disabled="disabled"
        tabindex="0"
        @keydown.enter.prevent="$refs.fileInput.click()"
        @keydown.space.prevent="$refs.fileInput.click()"
        @drop.prevent="handleDrop($event)"
        @dragover.prevent="isDragOver = true"
        @dragleave.prevent="isDragOver = false"
        @click="!disabled && $refs.fileInput.click()"
        class="relative border-2 border-dashed rounded-lg p-6 text-center cursor-pointer transition-colors duration-200 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary"
        :class="{
            'border-otl-primary-300 bg-primary-50': isDragOver,
            'border-otl-gray-300 hover:border-otl-gray-300': !isDragOver && !disabled,
            'border-otl-gray-200 bg-gray-50 cursor-not-allowed': disabled
        }"
        x-show="files.length === 0 || multiple"
        aria-label="Zon muat naik fail"
    >
        {{-- Upload Icon (MYDS 20x20 base) --}}
        <svg class="mx-auto h-12 w-12 text-txt-black-400" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14 10v5a3 3 0 01-3 3H6a3 3 0 01-3-3v-3m10-6l-4-4-4 4m4-4v10" />
        </svg>

        {{-- Upload Text --}}
        <div class="mt-4">
            <p class="text-sm text-txt-black-600">
                <span class="font-medium text-txt-primary">Klik untuk memuat naik</span>
                atau seret dan lepas fail di sini
            </p>
            <p class="text-xs text-txt-black-500 mt-1" x-text="getUploadHelpText()"></p>
        </div>

        {{-- File Input --}}
        <input
            x-ref="fileInput"
            type="file"
            :name="multiple ? '{{ $name }}[]' : '{{ $name }}'"
            :accept="'{{ $acceptString }}'"
            :multiple="multiple"
            :disabled="disabled"
            @change="handleFileSelect($event)"
            class="hidden"
        />
    </div>

    {{-- File List --}}
    <div x-show="files.length > 0" class="mt-4 space-y-3">
        <template x-for="(file, index) in files" :key="file.id">
            <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-otl-gray-200">
                {{-- File Icon --}}
                <div class="flex-shrink-0 mr-3">
                    <div
                        class="w-10 h-10 rounded-lg flex items-center justify-center"
                        :class="getFileIconClasses(file)"
                        aria-hidden="true"
                    >
                        <span class="text-xs font-medium text-white" x-text="getFileExtension(file.name)"></span>
                    </div>
                </div>

                {{-- File Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-txt-black-900 truncate" x-text="file.name"></p>
                        <p class="text-sm text-txt-black-500 ml-2" x-text="formatFileSize(file.size)"></p>
                    </div>

                    {{-- Upload Progress --}}
                    <div x-show="file.uploading" class="mt-2" role="status" aria-live="polite">
                        <div class="w-full bg-gray-200 rounded-full h-2" aria-hidden="true">
                            <div
                                class="bg-primary-600 h-2 rounded-full transition-all duration-300"
                                :style="'width: ' + file.progress + '%'"
                            ></div>
                        </div>
                        <p class="text-xs text-txt-black-500 mt-1">
                            Memuat naik... <span x-text="file.progress"></span>%
                        </p>
                    </div>

                    {{-- Upload Status --}}
                    <div x-show="file.uploaded" class="mt-1 flex items-center text-xs text-txt-success">
                        <svg class="w-4 h-4 mr-1" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l3 3 7-7" />
                        </svg>
                        Berjaya dimuat naik
                    </div>

                    <div x-show="file.error" class="mt-1 text-xs text-txt-danger" x-text="file.error" role="alert"></div>
                </div>

                {{-- Preview Button (for images) --}}
                <div x-show="isImage(file) && showPreview" class="flex-shrink-0 ml-3">
                    <button
                        @click="previewFile(file)"
                        class="text-txt-primary hover:text-primary-700 text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                        type="button"
                    >
                        Lihat
                    </button>
                </div>

                {{-- Remove Button --}}
                <div class="flex-shrink-0 ml-3">
                    <button
                        @click="removeFile(index)"
                        class="text-txt-danger hover:text-danger-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                        type="button"
                        :disabled="file.uploading"
                        aria-label="Padam fail"
                    >
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 14l8-8M6 6l8 8"/>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    {{-- Existing Files --}}
    <div x-show="existingFiles.length > 0" class="mt-4">
        <h4 class="text-sm font-medium text-txt-black-700 mb-2">Fail Sedia Ada</h4>
        <div class="space-y-2">
            <template x-for="file in existingFiles" :key="file.id">
                <div class="flex items-center justify-between p-2 bg-primary-50 rounded border border-otl-primary-200">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-txt-primary mr-2" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M4 3h7l5 5v7a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                        </svg>
                        <span class="text-sm text-txt-primary" x-text="file.name"></span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a
                            :href="file.url"
                            target="_blank"
                            rel="noopener"
                            class="text-xs text-txt-primary hover:text-primary-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                        >
                            Muat Turun
                        </a>
                        <button
                            @click="removeExistingFile(file.id)"
                            class="text-xs text-txt-danger hover:text-danger-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded"
                            type="button"
                        >
                            Padam
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </div>

    {{-- Error Message --}}
    @if($error)
        <p class="mt-2 text-sm text-txt-danger" role="alert">{{ $error }}</p>
    @endif

    {{-- Help Text --}}
    @if($helpText)
        <p class="mt-2 text-xs text-txt-black-500">{{ $helpText }}</p>
    @endif

    {{-- File Limit Warning --}}
    <div x-show="files.length >= maxFiles && multiple" class="mt-2 text-xs text-txt-warning">
        Anda telah mencapai had maksimum fail yang dibenarkan.
    </div>

    {{-- Hidden inputs for uploaded files --}}
    <template x-for="file in files.filter(f => f.uploaded)" :key="file.id">
        <input type="hidden" :name="'{{ $name }}_uploaded[]'" :value="file.path" />
    </template>
</div>

{{-- File Preview Modal --}}
<div
    x-show="showPreviewModal"
    class="fixed inset-0 z-50 overflow-y-auto"
    x-cloak
    role="dialog"
    aria-modal="true"
    aria-labelledby="file-preview-title"
>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50" @click="showPreviewModal = false" aria-hidden="true"></div>

        <div class="inline-block align-bottom bg-bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="file-preview-title" class="text-lg font-medium text-txt-black-900">Pratonton Fail</h3>
                    <button @click="showPreviewModal = false" class="text-txt-black-400 hover:text-txt-black-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-fr-primary rounded" aria-label="Tutup pratonton">
                        <svg class="w-6 h-6" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 14l8-8M6 6l8 8"/>
                        </svg>
                    </button>
                </div>

                <div class="text-center">
                    <img
                        x-show="previewFile && isImage(previewFile)"
                        :src="previewFile ? previewFile.url || getFilePreviewUrl(previewFile) : ''"
                        :alt="previewFile ? previewFile.name : ''"
                        class="max-w-full h-auto max-h-96 mx-auto rounded"
                    />

                    <div x-show="previewFile && !isImage(previewFile)" class="py-8">
                        <svg class="mx-auto h-16 w-16 text-txt-black-400" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h5l4 4v8a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2z"/>
                        </svg>
                        <p class="mt-2 text-sm text-txt-black-600">Pratonton tidak tersedia untuk jenis fail ini</p>
                    </div>

                    <p class="mt-2 text-sm text-txt-black-700" x-text="previewFile ? previewFile.name : ''"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function fileUpload(config) {
    return {
        files: [],
        existingFiles: config.existingFiles || [],
        isDragOver: false,
        showPreviewModal: false,
        previewFile: null,
        maxFiles: config.maxFiles,
        maxSize: config.maxSize,
        allowedTypes: config.allowedTypes,
        multiple: config.multiple,

        handleFileSelect(event) {
            const files = Array.from(event.target.files || []);
            this.processFiles(files);
            event.target.value = ''; // Reset input
        },

        handleDrop(event) {
            this.isDragOver = false;
            const files = Array.from(event.dataTransfer.files || []);
            this.processFiles(files);
        },

        processFiles(newFiles) {
            for (const file of newFiles) {
                if (!this.multiple && this.files.length >= 1) {
                    this.showToast('Hanya satu fail dibenarkan', 'warning');
                    break;
                }

                if (this.files.length >= this.maxFiles) {
                    this.showToast('Anda telah mencapai had maksimum fail', 'warning');
                    break;
                }

                if (!this.validateFile(file)) {
                    continue;
                }

                const fileObj = {
                    id: Date.now() + Math.random(),
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    file: file,
                    uploading: false,
                    uploaded: false,
                    progress: 0,
                    error: null,
                    path: null,
                    url: null
                };

                this.files.push(fileObj);
                this.uploadFile(fileObj);
            }
        },

        validateFile(file) {
            // Check file size
            if (file.size > this.maxSize * 1024 * 1024) {
                this.showToast(`Fail ${file.name} terlalu besar. Maksimum ${this.maxSize}MB`, 'error');
                return false;
            }

            // Check file type
            const extension = file.name.split('.').pop().toLowerCase();
            if (!this.allowedTypes.includes(extension)) {
                this.showToast(`Jenis fail ${extension} tidak dibenarkan`, 'error');
                return false;
            }

            return true;
        },

        async uploadFile(fileObj) {
            const formData = new FormData();
            formData.append('file', fileObj.file);

            fileObj.uploading = true;
            fileObj.progress = 0;

            try {
                const xhr = new XMLHttpRequest();

                xhr.upload.onprogress = (event) => {
                    if (event.lengthComputable) {
                        fileObj.progress = Math.round((event.loaded / event.total) * 100);
                    }
                };

                xhr.onload = () => {
                    if (xhr.status === 200) {
                        const response = JSON.parse(xhr.responseText);
                        fileObj.uploaded = true;
                        fileObj.uploading = false;
                        fileObj.path = response.path;
                        fileObj.url = response.url;
                        this.showToast('Fail berjaya dimuat naik', 'success');
                    } else {
                        throw new Error('Upload failed');
                    }
                };

                xhr.onerror = () => {
                    throw new Error('Upload failed');
                };

                xhr.open('POST', config.uploadUrl);
                const csrf = document.querySelector('meta[name="csrf-token"]');
                if (csrf) xhr.setRequestHeader('X-CSRF-TOKEN', csrf.getAttribute('content'));
                xhr.send(formData);

            } catch (error) {
                fileObj.uploading = false;
                fileObj.error = 'Gagal memuat naik fail';
                this.showToast('Gagal memuat naik fail', 'error');
            }
        },

        removeFile(index) {
            this.files.splice(index, 1);
        },

        removeExistingFile(fileId) {
            this.existingFiles = this.existingFiles.filter(f => f.id !== fileId);
        },

        previewFile(file) {
            this.previewFile = file;
            this.showPreviewModal = true;
        },

        isImage(file) {
            const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
            const name = file?.name || '';
            const extension = name.split('.').pop().toLowerCase();
            return imageTypes.includes(extension);
        },

        getFilePreviewUrl(file) {
            if (file.url) return file.url;
            if (file.file && this.isImage(file)) {
                return URL.createObjectURL(file.file);
            }
            return null;
        },

        getFileExtension(filename) {
            return (filename || '').split('.').pop().toLowerCase();
        },

        getFileIconClasses(file) {
            const extension = this.getFileExtension(file.name);
            const classes = {
                'pdf': 'bg-danger-500',
                'doc': 'bg-primary-600',
                'docx': 'bg-primary-600',
                'xls': 'bg-success-600',
                'xlsx': 'bg-success-600',
                'ppt': 'bg-warning-600',
                'pptx': 'bg-warning-600',
                'jpg': 'bg-purple-600',
                'jpeg': 'bg-purple-600',
                'png': 'bg-purple-600',
                'gif': 'bg-purple-600'
            };
            return classes[extension] || 'bg-gray-500';
        },

        formatFileSize(bytes) {
            if (!bytes || bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        getUploadHelpText() {
            const remaining = this.maxFiles - this.files.length;
            if (this.multiple && remaining > 0) {
                return `Anda boleh memuat naik ${remaining} lagi fail`;
            } else if (!this.multiple && this.files.length === 0) {
                return `Pilih satu fail untuk dimuat naik`;
            }
            return '';
        },

        showToast(message, type = 'info') {
            if (window.showToast) {
                window.showToast(message, type);
            } else if (window.toast) {
                window.toast(type === 'error' ? 'error' : (type === 'success' ? 'success' : (type === 'warning' ? 'warning' : 'info')), message);
            } else {
                alert(message);
            }
        }
    }
}
</script>
