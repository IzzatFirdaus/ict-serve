export function fileUpload(config) {
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
      event.target.value = '';
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
          url: null,
        };

        this.files.push(fileObj);
        this.uploadFile(fileObj);
      }
    },

    validateFile(file) {
      if (file.size > this.maxSize * 1024 * 1024) {
        this.showToast(`Fail ${file.name} terlalu besar. Maksimum ${this.maxSize}MB`, 'error');
        return false;
      }

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
            fileObj.uploading = false;
            fileObj.error = 'Gagal memuat naik fail';
            this.showToast('Gagal memuat naik fail', 'error');
          }
        };

        xhr.onerror = () => {
          fileObj.uploading = false;
          fileObj.error = 'Gagal memuat naik fail';
          this.showToast('Gagal memuat naik fail', 'error');
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
      this.existingFiles = this.existingFiles.filter((f) => f.id !== fileId);
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
        window.toast(type === 'error' ? 'error' : type === 'success' ? 'success' : type === 'warning' ? 'warning' : 'info', message);
      } else {
        alert(message);
      }
    },
  };
}
