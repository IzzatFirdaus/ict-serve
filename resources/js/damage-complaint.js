/**
 * Damage Complaint Form Interactions
 * Handles file upload with drag & drop and file management
 */
document.addEventListener('DOMContentLoaded', function () {
  const fileInput = document.getElementById('attachments');
  const fileList = document.getElementById('file-list');
  let selectedFiles = [];

  if (!fileInput || !fileList) return;

  // File selection handler
  fileInput.addEventListener('change', function (e) {
    const files = Array.from(e.target.files);
    selectedFiles = files;
    displayFiles();
  });

  // Display selected files
  function displayFiles() {
    fileList.innerHTML = '';
    selectedFiles.forEach((file, index) => {
      const fileItem = document.createElement('div');
      fileItem.className =
        'flex items-center justify-between p-2 bg-bg-gray-50 rounded-[var(--radius-m)]';

      const fileInfo = document.createElement('div');
      fileInfo.className = 'flex items-center space-x-2';

      const fileIcon = getFileIcon(file.type);
      const fileName = document.createElement('span');
      fileName.className = 'myds-body-sm text-txt-black-700';
      fileName.textContent = file.name;

      const fileSize = document.createElement('span');
      fileSize.className = 'myds-body-xs text-txt-black-500';
      fileSize.textContent = formatFileSize(file.size);

      fileInfo.appendChild(fileIcon);
      fileInfo.appendChild(fileName);
      fileInfo.appendChild(fileSize);

      const removeButton = document.createElement('button');
      removeButton.type = 'button';
      removeButton.className = 'text-txt-danger hover:text-txt-danger';
      removeButton.innerHTML = `
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            `;

      removeButton.addEventListener('click', function () {
        selectedFiles.splice(index, 1);
        updateFileInput();
        displayFiles();
      });

      fileItem.appendChild(fileInfo);
      fileItem.appendChild(removeButton);
      fileList.appendChild(fileItem);
    });
  }

  // Update file input with remaining files
  function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach((file) => dt.items.add(file));
    fileInput.files = dt.files;
  }

  // Get file icon based on file type
  function getFileIcon(fileType) {
    const icon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    icon.setAttribute('class', 'w-4 h-4 text-txt-black-400');
    icon.setAttribute('fill', 'currentColor');
    icon.setAttribute('viewBox', '0 0 20 20');

    let pathData;
    if (fileType.startsWith('image/')) {
      pathData =
        'M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z';
    } else if (fileType === 'application/pdf') {
      pathData =
        'M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z';
    } else {
      pathData =
        'M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z';
    }

    const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    path.setAttribute('fill-rule', 'evenodd');
    path.setAttribute('d', pathData);
    path.setAttribute('clip-rule', 'evenodd');

    icon.appendChild(path);
    return icon;
  }

  // Format file size
  function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
  }

  // Drag and drop functionality
  const dropZone = fileInput.closest('.border-dashed');

  if (dropZone) {
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach((eventName) => {
      dropZone.addEventListener(eventName, preventDefaults, false);
    });

    ['dragenter', 'dragover'].forEach((eventName) => {
      dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach((eventName) => {
      dropZone.addEventListener(eventName, unhighlight, false);
    });

    dropZone.addEventListener('drop', handleDrop, false);
  }

  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  function highlight(e) {
    dropZone.classList.add('border-otl-danger-300', 'bg-bg-danger-50');
  }

  function unhighlight(e) {
    dropZone.classList.remove('border-otl-danger-300', 'bg-bg-danger-50');
  }

  function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;

    selectedFiles = Array.from(files);
    updateFileInput();
    displayFiles();
  }
});
