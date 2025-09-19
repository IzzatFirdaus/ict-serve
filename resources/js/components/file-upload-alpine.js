/**
 * File Upload Component for ICTServe (iServe)
 * MYDS-compliant file upload with drag & drop, progress tracking, and accessibility
 * Supports multiple files, validation, and preview functionality
 */

/**
 * Alpine.js data function for file upload component
 * @param {Object} config - Configuration options
 * @param {Array} config.existingFiles - Existing files array
 * @param {number} config.maxFiles - Maximum number of files allowed
 * @param {number} config.maxSize - Maximum file size in MB
 * @param {Array} config.allowedTypes - Allowed file extensions
 * @param {boolean} config.multiple - Allow multiple file selection
 * @param {string} config.uploadUrl - Server endpoint for file upload
 * @returns {Object} Alpine.js data object
 */
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

    /**
     * Handle file selection from input
     * @param {Event} event - File input change event
     */
    handleFileSelect(event) {
      const files = Array.from(event.target.files || []);
      this.processFiles(files);
      event.target.value = ''; // Reset input for re-selection
    },

    /**
     * Handle drag and drop file selection
     * @param {DragEvent} event - Drop event
     */
    handleDrop(event) {
      this.isDragOver = false;
      const files = Array.from(event.dataTransfer.files || []);
      this.processFiles(files);
    },

    /**
     * Process selected files with validation
     * @param {File[]} newFiles - Array of files to process
     */
    processFiles(newFiles) {
      for (const file of newFiles) {
        // Check if single file limit is reached
        if (!this.multiple && this.files.length >= 1) {
          this.showToast('Hanya satu fail dibenarkan', 'warning');
          break;
        }

        // Check maximum files limit
        if (this.files.length >= this.maxFiles) {
          this.showToast('Anda telah mencapai had maksimum fail', 'warning');
          break;
        }

        // Validate file
        if (!this.validateFile(file)) {
          continue;
        }

        // Create file object
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
          url: null,
        };

        this.files.push(fileObj);
        this.uploadFile(fileObj);
      }
    },

    /**
     * Validate file size and type
     * @param {File} file - File to validate
     * @returns {boolean} - Validation result
     */
    validateFile(file) {
      // Check file size
      if (file.size > this.maxSize * 1024 * 1024) {
        this.showToast(
          `Fail ${file.name} terlalu besar. Maksimum ${this.maxSize}MB`,
          'error'
        );
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

    /**
     * Upload file to server with progress tracking
     * @param {Object} fileObj - File object to upload
     */
    async uploadFile(fileObj) {
      const formData = new FormData();
      formData.append('file', fileObj.file);

      fileObj.uploading = true;
      fileObj.progress = 0;

      try {
        const xhr = new XMLHttpRequest();

        // Track upload progress
        xhr.upload.onprogress = (event) => {
          if (event.lengthComputable) {
            fileObj.progress = Math.round((event.loaded / event.total) * 100);
          }
        };

        // Handle successful upload
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

        // Handle upload error
        xhr.onerror = () => {
          throw new Error('Upload failed');
        };

        // Send upload request
        xhr.open('POST', config.uploadUrl);
        const csrf = document.querySelector('meta[name="csrf-token"]');
        if (csrf) {
          xhr.setRequestHeader('X-CSRF-TOKEN', csrf.getAttribute('content'));
        }
        xhr.send(formData);
      } catch (error) {
        fileObj.uploading = false;
        fileObj.error = 'Gagal memuat naik fail';
        this.showToast('Gagal memuat naik fail', 'error');
      }
    },

    /**
     * Remove file from upload list
     * @param {number} index - Index of file to remove
     */
    removeFile(index) {
      this.files.splice(index, 1);
    },

    /**
     * Remove existing file
     * @param {string} fileId - ID of existing file to remove
     */
    removeExistingFile(fileId) {
      this.existingFiles = this.existingFiles.filter((f) => f.id !== fileId);
    },

    /**
     * Preview file in modal
     * @param {Object} file - File to preview
     */
    previewFile(file) {
      this.previewFile = file;
      this.showPreviewModal = true;
    },

    /**
     * Check if file is an image
     * @param {Object} file - File object
     * @returns {boolean} - True if file is an image
     */
    isImage(file) {
      const imageTypes = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
      const name = file?.name || '';
      const extension = name.split('.').pop().toLowerCase();
      return imageTypes.includes(extension);
    },

    /**
     * Get preview URL for file
     * @param {Object} file - File object
     * @returns {string|null} - Preview URL or null
     */
    getFilePreviewUrl(file) {
      if (file.url) return file.url;
      if (file.file && this.isImage(file)) {
        return URL.createObjectURL(file.file);
      }
      return null;
    },

    /**
     * Get file extension from filename
     * @param {string} filename - File name
     * @returns {string} - File extension
     */
    getFileExtension(filename) {
      return (filename || '').split('.').pop().toLowerCase();
    },

    /**
     * Get CSS classes for file type icon
     * @param {Object} file - File object
     * @returns {string} - CSS classes for icon
     */
    getFileIconClasses(file) {
      const extension = this.getFileExtension(file.name);
      const classes = {
        pdf: 'bg-danger-500',
        doc: 'bg-primary-600',
        docx: 'bg-primary-600',
        xls: 'bg-success-600',
        xlsx: 'bg-success-600',
        ppt: 'bg-warning-600',
        pptx: 'bg-warning-600',
        jpg: 'bg-purple-600',
        jpeg: 'bg-purple-600',
        png: 'bg-purple-600',
        gif: 'bg-purple-600',
      };
      return classes[extension] || 'bg-gray-500';
    },

    /**
     * Format file size in human readable format
     * @param {number} bytes - File size in bytes
     * @returns {string} - Formatted file size
     */
    formatFileSize(bytes) {
      if (!bytes || bytes === 0) return '0 Bytes';
      const k = 1024;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },

    /**
     * Get help text for upload
     * @returns {string} - Help text
     */
    getUploadHelpText() {
      const remaining = this.maxFiles - this.files.length;
      if (this.multiple && remaining > 0) {
        return `Anda boleh memuat naik ${remaining} lagi fail`;
      } else if (!this.multiple && this.files.length === 0) {
        return `Pilih satu fail untuk dimuat naik`;
      }
      return '';
    },

    /**
     * Show toast notification
     * @param {string} message - Toast message
     * @param {string} type - Toast type
     */
    showToast(message, type = 'info') {
      if (window.showToast) {
        window.showToast(message, type);
      } else if (window.toast) {
        window.toast(
          type === 'error'
            ? 'error'
            : type === 'success'
              ? 'success'
              : type === 'warning'
                ? 'warning'
                : 'info',
          message
        );
      } else {
        // Fallback to alert if no toast system available
        alert(message);
      }
    },
  };
}

// Export for module usage
export { fileUpload };

// Make available globally for backward compatibility
if (typeof window !== 'undefined') {
  window.fileUpload = fileUpload;
}
