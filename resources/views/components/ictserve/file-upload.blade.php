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
        <label class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-danger-600">*</span>
            @endif
        </label>
    @endif

    {{-- Drop Zone --}}
    <div
        @drop.prevent="handleDrop($event)"
        @dragover.prevent="isDragOver = true"
        @dragleave.prevent="isDragOver = false"
        @click="$refs.fileInput.click()"
        class="relative border-2 border-dashed rounded-lg p-6 text-center cursor-pointer transition-colors duration-200"
        :class="{
            'border-primary-300 bg-primary-50': isDragOver,
            'border-gray-300 hover:border-gray-400': !isDragOver && !disabled,
            'border-gray-200 bg-gray-50 cursor-not-allowed': disabled
        }"
        x-show="files.length === 0 || multiple"
    >
        {{-- Upload Icon --}}
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        
        {{-- Upload Text --}}
        <div class="mt-4">
            <p class="text-sm text-gray-600">
                <span class="font-medium text-primary-600">Klik untuk memuat naik</span>
                atau seret dan lepas fail di sini
            </p>
            <p class="text-xs text-gray-500 mt-1" x-text="getUploadHelpText()"></p>
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
            <div class="flex items-center p-3 bg-gray-50 rounded-lg border">
                {{-- File Icon --}}
                <div class="flex-shrink-0 mr-3">
                    <div 
                        class="w-10 h-10 rounded-lg flex items-center justify-center"
                        :class="getFileIconClasses(file)"
                    >
                        <span class="text-xs font-medium text-white" x-text="getFileExtension(file.name)"></span>
                    </div>
                </div>
                
                {{-- File Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-900 truncate" x-text="file.name"></p>
                        <p class="text-sm text-gray-500 ml-2" x-text="formatFileSize(file.size)"></p>
                    </div>
                    
                    {{-- Upload Progress --}}
                    <div x-show="file.uploading" class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div 
                                class="bg-primary-600 h-2 rounded-full transition-all duration-300"
                                :style="'width: ' + file.progress + '%'"
                            ></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            Memuat naik... <span x-text="file.progress"></span>%
                        </p>
                    </div>
                    
                    {{-- Upload Status --}}
                    <div x-show="file.uploaded" class="mt-1 flex items-center text-xs text-success-600">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                        Berjaya dimuat naik
                    </div>
                    
                    <div x-show="file.error" class="mt-1 text-xs text-danger-600" x-text="file.error"></div>
                </div>
                
                {{-- Preview Button (for images) --}}
                <div x-show="isImage(file) && showPreview" class="flex-shrink-0 ml-3">
                    <button 
                        @click="previewFile(file)"
                        class="text-primary-600 hover:text-primary-800 text-sm"
                        type="button"
                    >
                        Lihat
                    </button>
                </div>
                
                {{-- Remove Button --}}
                <div class="flex-shrink-0 ml-3">
                    <button 
                        @click="removeFile(index)"
                        class="text-danger-600 hover:text-danger-800"
                        type="button"
                        :disabled="file.uploading"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    {{-- Existing Files --}}
    <div x-show="existingFiles.length > 0" class="mt-4">
        <h4 class="text-sm font-medium text-gray-700 mb-2">Fail Sedia Ada</h4>
        <div class="space-y-2">
            <template x-for="file in existingFiles" :key="file.id">
                <div class="flex items-center justify-between p-2 bg-blue-50 rounded border border-blue-200">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm text-blue-900" x-text="file.name"></span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <a 
                            :href="file.url"
                            target="_blank"
                            class="text-xs text-blue-600 hover:text-blue-800"
                        >
                            Muat Turun
                        </a>
                        <button 
                            @click="removeExistingFile(file.id)"
                            class="text-xs text-danger-600 hover:text-danger-800"
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
        <p class="mt-2 text-sm text-danger-600">{{ $error }}</p>
    @endif

    {{-- Help Text --}}
    @if($helpText)
        <p class="mt-2 text-xs text-gray-500">{{ $helpText }}</p>
    @endif

    {{-- File Limit Warning --}}
    <div x-show="files.length >= maxFiles && multiple" class="mt-2 text-xs text-warning-600">
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
>
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showPreviewModal = false"></div>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Pratonton Fail</h3>
                    <button @click="showPreviewModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-600">Pratonton tidak tersedia untuk jenis fail ini</p>
                    </div>
                    
                    <p class="mt-2 text-sm text-gray-700" x-text="previewFile ? previewFile.name : ''"></p>
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
            const files = Array.from(event.target.files);
            this.processFiles(files);
            event.target.value = ''; // Reset input
        },
        
        handleDrop(event) {
            this.isDragOver = false;
            const files = Array.from(event.dataTransfer.files);
            this.processFiles(files);
        },
        
        processFiles(newFiles) {
            for (const file of newFiles) {
                if (!this.multiple && this.files.length >= 1) {
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
                xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
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
            const extension = file.name.split('.').pop().toLowerCase();
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
            return filename.split('.').pop().toLowerCase();
        },
        
        getFileIconClasses(file) {
            const extension = this.getFileExtension(file.name);
            const classes = {
                'pdf': 'bg-red-500',
                'doc': 'bg-blue-500',
                'docx': 'bg-blue-500',
                'xls': 'bg-green-500',
                'xlsx': 'bg-green-500',
                'ppt': 'bg-orange-500',
                'pptx': 'bg-orange-500',
                'jpg': 'bg-purple-500',
                'jpeg': 'bg-purple-500',
                'png': 'bg-purple-500',
                'gif': 'bg-purple-500'
            };
            return classes[extension] || 'bg-gray-500';
        },
        
        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
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
            } else {
                alert(message);
            }
        }
    }
}
</script>