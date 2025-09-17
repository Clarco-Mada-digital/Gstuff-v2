    <div>
        <button id="openModalBtn"
            class="text-green-gs hover:text-green-gs hover:bg-fieldBg bg-supaGirlRose font-roboto-slab flex cursor-pointer items-center gap-2 sm:rounded-md sm:px-5 sm:py-2 p-2 rounded-full">
            <i class="fas fa-plus sm:mr-2"></i> <span class="hidden sm:block">
            {{ __('gallery_manage.add') }}
            </span>
        </button>

        <div id="galleryModal" class="modal z-50">
            <div id="modalOverlay" class="modal-overlay z-50">
                <div class="font-roboto-slab mt-10 w-full rounded-lg bg-white p-6 shadow-xl md:w-[80vw] xl:w-[60vw]">
                    <h3 class="text-green-gs mb-4 text-xl font-semibold">
                        {{ __('gallery_manage.add_media') }}
                    </h3>
                    <form id="uploadForm" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="space-y-4">
                            <div>
                                <label class="text-green-gs mb-1 block text-sm font-medium">
                                    {{ __('gallery_manage.title') }} *
                                </label>
                                <input type="text" name="title" id="mediaTitle" required
                                    class="w-full rounded-lg border-gray-300">
                                <div id="titleError" class="mt-1 hidden text-sm text-red-500"></div>
                            </div>
                            <div>
                                <label class="text-green-gs mb-1 block text-sm font-medium">
                                    {{ __('gallery_manage.description') }}
                                </label>
                                <textarea name="description" id="mediaDescription" rows="3" class="w-full rounded-lg border-gray-300"></textarea>
                            </div>
                            <div>
                                <label class="text-green-gs mb-1 block text-sm font-medium">
                                    {{ __('gallery_manage.media') }} *
                                </label>
                                <div class="upload-container">
                                    <div class="rounded-lg border-2 border-dashed border-gray-300 p-4 text-center"
                                        id="dropZone">
                                        <input type="file" name="media[]" multiple accept="image/*,video/*"
                                            class="hidden" id="galleryUpload">
                                        <label for="galleryUpload" class="cursor-pointer">
                                            <i class="fas fa-cloud-upload-alt text-green-gs mb-2 text-3xl"></i>
                                            <p class="text-sm text-gray-600">{{ __('gallery_manage.drag_drop') }}</p>
                                            <p class="mt-1 text-xs text-gray-500">
                                                {{ __('gallery_manage.supported_formats') }}
                                            </p>
                                        </label>
                                    </div>
                                    <div id="uploadProgress" class="mt-2 hidden">
                                        <div class="h-2 overflow-hidden rounded-full bg-gray-200">
                                            <div id="progressBar" class="h-full bg-blue-500 transition-all duration-300"
                                                style="width: 0%"></div>
                                        </div>
                                        <p id="progressText" class="mt-1 text-xs text-gray-500">
                                            {{ __('gallery_manage.uploading') }}... 0%</p>
                                    </div>
                                    <div id="fileError" class="mt-1 hidden text-sm text-red-500"></div>
                                </div>
                            </div>
                            <div class="mt-4" id="filesPreviewContainer">
                                <!-- Preview files will be added here -->
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="is_public_checkbox" id="isPublic"
                                    class="text-green-gs rounded border-gray-300" checked>
                                <input type="hidden" name="is_public" id="isPublicHidden" value="1">
                                <label for="isPublic" class="text-green-gs ml-2 text-sm">
                                    {{ __('gallery_manage.make_public') }}
                                </label>
                            </div>

                        </div>
                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" id="closeModalBtn"
                                class="text-green-gs rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium transition-colors hover:bg-gray-200 disabled:opacity-50">
                                {{ __('gallery_manage.cancel') }}
                            </button>
                            <button type="submit" id="submitBtn"
                                class="bg-green-gs hover:bg-green-gs/80 rounded px-4 py-2 text-sm font-medium text-white transition-colors disabled:opacity-50">
                                <span id="submitBtnText">{{ __('gallery_manage.save') }}</span>
                                <span id="submitBtnLoading" class="flex hidden items-center">
                                    <svg class="-ml-1 mr-2 h-4 w-4 animate-spin text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    {{ __('gallery_manage.uploading') }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            flex: items-center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .upload-container {
            position: relative;
            min-height: 150px;
        }

        #dropZone {
            transition: all 0.3s ease;
        }

        #dropZone.highlight {
            border-color: #4CAF50;
            background-color: rgba(76, 175, 80, 0.1);
        }

        #previewContainer img,
        #previewContainer video {
            max-width: 100%;
            max-height: 150px;
            object-fit: cover;
        }
    </style>
    @push('scripts')
        <script>
            let isInitialized = false;

            const initializeGalleryModal = () => {
                if (isInitialized) {
                    return;
                }

                isInitialized = true;
                console.log('Gallery modal initialized escorte');

                const modal = document.getElementById('galleryModal');
                const modalOverlay = document.getElementById('modalOverlay');
                const openModalBtn = document.getElementById('openModalBtn');
                const closeModalBtn = document.getElementById('closeModalBtn');
                const uploadForm = document.getElementById('uploadForm');
                const dropZone = document.getElementById('dropZone');
                const galleryUpload = document.getElementById('galleryUpload');
                const filesPreviewContainer = document.getElementById('filesPreviewContainer');
                const submitBtn = document.getElementById('submitBtn');
                const submitBtnText = document.getElementById('submitBtnText');
                const submitBtnLoading = document.getElementById('submitBtnLoading');
                const isPublicCheckbox = document.getElementById('isPublic');
                const isPublicHidden = document.getElementById('isPublicHidden');

                let files = [];
                let isUploading = false;
                let isFormSubmitting = false;

                const openModal = () => {
                    console.log('openModal');
                    modal.style.display = 'flex';
                    resetForm();
                };

                const closeModal = () => {
                    if (isUploading) return;
                    modal.style.display = 'none';
                    resetForm();
                };

                const resetForm = () => {
                    files = [];
                    isUploading = false;
                    uploadForm.reset();
                    filesPreviewContainer.innerHTML = '';
                    isPublicHidden.value = isPublicCheckbox.checked ? '1' : '0';
                };

                const preventDefaults = (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                };

                const highlight = () => {
                    dropZone.classList.add('highlight');
                };

                const unhighlight = () => {
                    dropZone.classList.remove('highlight');
                };

                const handleDrop = (e) => {
                    const dt = e.dataTransfer;
                    const fileList = dt.files;
                    processFiles(fileList);
                };

                const handleFileSelect = () => {
                    const fileList = galleryUpload.files;
                    processFiles(fileList);
                };

                const processFiles = (fileList) => {
                    const filesArray = Array.from(fileList);
                    const validFiles = filesArray.filter(file => file.type.match('image.*') || file.type.match(
                        'video.*'));

                    validFiles.forEach(file => {
                        const fileWithPreview = {
                            name: file.name,
                            size: file.size,
                            type: file.type,
                            preview: URL.createObjectURL(file),
                            file: file
                        };
                        files.push(fileWithPreview);
                    });

                    renderFilesPreview();
                };

                const renderFilesPreview = () => {
                    filesPreviewContainer.innerHTML = `
            <div class="mb-2 text-sm text-gray-600">
                ${files.length} {{ __('gallery_manage.files_selected') }}, ${formatTotalSize()}
            </div>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 max-h-[30vh] overflow-y-auto">
                ${files.map((file, index) => `
                            <div class="relative rounded-lg border border-gray-200 overflow-hidden h-[100px]">
                                ${file.type.startsWith('image') ? `<img src="${file.preview}" class="h-full w-full object-cover" alt="${file.name}">` : ''}
                                ${file.type.startsWith('video') ? `
                            <video class="h-full w-full object-cover" controls>
                                <source src="${file.preview}" type="${file.type}">
                            </video>
                        ` : ''}
                                <button onclick="removeFile(${index})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                                <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white p-1 text-xs truncate">
                                    ${file.name}
                                </div>
                            </div>
                        `).join('')}
            </div>
        `;
                };

                const formatTotalSize = () => {
                    const totalSize = files.reduce((total, file) => total + file.size, 0);
                    if (totalSize < 1024) return totalSize + ' bytes';
                    else if (totalSize < 1048576) return (totalSize / 1024).toFixed(1) + ' KB';
                    else return (totalSize / 1048576).toFixed(1) + ' MB';
                };

                window.removeFile = (index) => {
                    URL.revokeObjectURL(files[index].preview);
                    files.splice(index, 1);
                    renderFilesPreview();
                };

                const uploadMedia = async () => {
                    if (files.length === 0) {
                        console.error('No files to upload');
                        return;
                    }
                    if (isFormSubmitting) {
                        console.error('Form is already submitting');
                        return;
                    }

                    isUploading = true;
                    submitBtnText.classList.add('hidden');
                    submitBtnLoading.classList.remove('hidden');
                    isFormSubmitting = true;

                    const formData = new FormData(uploadForm);

                    // Update the hidden field based on the checkbox state
                    isPublicHidden.value = isPublicCheckbox.checked ? '1' : '0';

                    // Add files to FormData
                    files.forEach((fileObj, index) => {
                        formData.append(`media[${index}]`, fileObj.file);
                    });


                    console.log("formate 1 :", formData);

                    try {
                        const response = await fetch('{{ route('media.upload') }}', {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content')
                            },
                            body: formData
                        });


                        if (response.redirected) {
                            window.location.href = response.url;
                            return;
                        }

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || 'Upload failed');
                        }
                        const data = await response.json();
                        console.log('Upload successful:', data);



                        resetForm();
                        closeModal();

                    } catch (error) {
                        console.error('Upload error:', error);
                        isUploading = false;
                        submitBtnText.classList.remove('hidden');
                        submitBtnLoading.classList.add('hidden');
                        isFormSubmitting = false;
                    } finally {

                    }
                };

                // Event listeners
                openModalBtn.addEventListener('click', openModal);
                closeModalBtn.addEventListener('click', closeModal);

                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, unhighlight, false);
                });

                dropZone.addEventListener('drop', handleDrop);
                galleryUpload.addEventListener('change', handleFileSelect);
                let count = 0;
                uploadForm.addEventListener('submit', (e) => {
                    e.preventDefault();
                    e.stopPropagation(); // Ensure event does not propagate

                    if (isFormSubmitting) {
                        console.log('Form is already submitting, ignoring this click.');
                        return;
                    }

                    count++;
                    console.log('Uploading files...', count);

                    uploadMedia();
                });

                // Update hidden field when checkbox changes
                isPublicCheckbox.addEventListener('change', () => {
                    isPublicHidden.value = isPublicCheckbox.checked ? '1' : '0';
                });


            };

            document.addEventListener('DOMContentLoaded', initializeGalleryModal);
        </script>
    @endpush
