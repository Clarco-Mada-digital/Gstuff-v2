
<div x-data="galleryModal()" x-init="console.log('Modal gallery component initialized')">
    <button 
        @click="openModal"
        class="flex items-center gap-2 text-green-gs hover:text-green-gs hover:bg-fieldBg px-5 py-2 bg-supaGirlRose rounded-md font-roboto-slab cursor-pointer"
    >
        <i class="fas fa-plus mr-2"></i> {{ __('gallery_manage.add') }}
    </button>

    <div 
        x-show="isOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
        @keydown.escape.window="closeModal"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div class="w-full max-w-2xl rounded-lg bg-white p-6 font-roboto-slab shadow-xl">
            <h3 class="mb-4 text-xl font-semibold text-green-gs">
                {{ __('gallery_manage.add_media') }}
            </h3>

            <form x-on:submit.prevent="uploadMedia" enctype="multipart/form-data" x-ref="uploadForm">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-green-gs">
                            {{ __('gallery_manage.title') }} *
                        </label>
                        <input type="text" name="title" id="mediaTitle" required
                            class="w-full rounded-lg border-gray-300">
                        <div id="titleError" class="mt-1 text-sm text-red-500 hidden"></div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-green-gs">
                            {{ __('gallery_manage.description') }}
                        </label>
                        <textarea name="description" id="mediaDescription" rows="3" class="w-full rounded-lg border-gray-300"></textarea>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-green-gs">
                            {{ __('gallery_manage.media') }} *
                        </label>
                        <div class="upload-container">
                            <div class="rounded-lg border-2 border-dashed border-gray-300 p-4 text-center" 
                                id="dropZone">
                                <input type="file" name="media[]" multiple accept="image/*,video/*" 
                                    class="hidden" id="galleryUpload"
                                    x-ref="fileInput"
                                    @change="handleFileSelect">
                                <label for="galleryUpload" class="cursor-pointer">
                                    <i class="fas fa-cloud-upload-alt mb-2 text-3xl text-green-gs"></i>
                                    <p class="text-sm text-gray-600">{{ __('gallery_manage.drag_drop') }}</p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ __('gallery_manage.supported_formats') }}
                                    </p>
                                </label>
                            </div>
                            <div id="uploadProgress" class="mt-2 hidden">
                                <div class="h-2 overflow-hidden rounded-full bg-gray-200">
                                    <div id="progressBar" class="h-full bg-blue-500 transition-all duration-300" style="width: 0%"></div>
                                </div>
                                <p id="progressText" class="mt-1 text-xs text-gray-500">{{ __('gallery_manage.uploading') }}... 0%</p>
                            </div>
                            <div id="fileError" class="mt-1 text-sm text-red-500 hidden"></div>
                        </div>
                    </div>

                    <!-- Preview Container -->
                    <div class="mt-4">
                        <div x-show="files.length > 0" class="mb-2 text-sm text-gray-600" x-text="`${files.length} {{ __('gallery_manage.files_selected') }}, ${totalSizeFormatted}`"></div>
                        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4">
                            <template x-for="(file, index) in files" :key="index">
                                <div class="relative rounded-lg border border-gray-200 overflow-hidden">
                                    <template x-if="file.type.startsWith('image')">
                                        <img :src="file.preview" class="h-32 w-full object-cover" :alt="file.name">
                                    </template>
                                    <template x-if="file.type.startsWith('video')">
                                        <video class="h-32 w-full object-cover" controls>
                                            <source :src="file.preview" :type="file.type">
                                        </video>
                                    </template>
                                    <button @click="removeFile(index)" 
                                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600">
                                        <i class="fas fa-times text-xs"></i>
                                    </button>
                                    <div class="p-2 text-xs truncate" x-text="file.name"></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="is_public" id="isPublic" 
                            class="rounded border-gray-300 text-green-gs" checked>
                        <label for="isPublic" class="ml-2 text-sm text-green-gs">
                            {{ __('gallery_manage.make_public') }}
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" 
                        @click="closeModal"
                        :disabled="isUploading"
                        class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-medium text-green-gs transition-colors hover:bg-gray-200 disabled:opacity-50">
                        {{ __('gallery_manage.cancel') }}
                    </button>
                    <button type="submit" 
                        :disabled="isUploading || !hasFiles"
                        class="bg-green-gs rounded px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-green-gs/80 disabled:opacity-50">
                        <span x-show="!isUploading">{{ __('gallery_manage.save') }}</span>
                        <span x-show="isUploading" class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ __('gallery_manage.uploading') }}
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>


<style>
#galleryModal {
    display: none;
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.upload-container {
    position: relative;
    min-height: 150px;
}

#dropZone {
    transition: all 0.3s ease;
}a

#dropZone.highlight {
    border-color: #4CAF50;
    background-color: rgba(76, 175, 80, 0.1);
}

#previewContainer img, #previewContainer video {
    max-width: 100%;
    max-height: 150px;
    object-fit: cover;
}
</style>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('galleryModal', () => ({
        isOpen: false,
        files: [],
        isUploading: false,
        progress: 0,
        errors: {},

        get totalSize() {
            return this.files.reduce((total, file) => total + file.size, 0);
        },

        get totalSizeFormatted() {
            if (this.totalSize < 1024) return this.totalSize + ' bytes';
            else if (this.totalSize < 1048576) return (this.totalSize / 1024).toFixed(1) + ' KB';
            else return (this.totalSize / 1048576).toFixed(1) + ' MB';
        },

        get hasFiles() {
            return this.files.length > 0;
        },

        init() {
            console.log('Gallery modal initialized');
            this.setupDropZone();
        },

        setupDropZone() {
            const dropZone = document.getElementById('dropZone');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, this.preventDefaults, false);
                document.body.addEventListener(eventName, this.preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, this.highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, this.unhighlight, false);
            });

            dropZone.addEventListener('drop', (e) => this.handleDrop(e));
        },

        preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        },

        highlight() {
            document.getElementById('dropZone').classList.add('highlight');
        },

        unhighlight() {
            document.getElementById('dropZone').classList.remove('highlight');
        },

        handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            this.processFiles(files);
        },

        handleFileSelect() {
            console.log('File selected');
            const files = this.$refs.fileInput.files;
            this.processFiles(files);
        },

        async processFiles(fileList) {
            console.log('Processing files:', fileList.length);
            
            for (let i = 0; i < fileList.length; i++) {
                const file = fileList[i];
                
                // Validate file type
                if (!file.type.match('image.*') && !file.type.match('video.*')) {
                    console.warn('Invalid file type:', file.type);
                    continue;
                }

                // Create preview URL
                file.preview = URL.createObjectURL(file);
                this.files.push(file);
            }

            console.log('Files ready:', this.files);
        },

        removeFile(index) {
            console.log('Removing file at index:', index);
            URL.revokeObjectURL(this.files[index].preview);
            this.files.splice(index, 1);
        },

        async uploadMedia() {
            if (this.files.length === 0) {
                console.error('No files to upload');
                return;
            }

            this.isUploading = true;
            this.progress = 0;
            this.errors = {};

            const formData = new FormData();
            
            // Add form fields
            formData.append('title', this.$refs.uploadForm.querySelector('[name="title"]').value);
            formData.append('description', this.$refs.uploadForm.querySelector('[name="description"]').value || '');
            
            // Convert is_public to boolean
            const isPublic = this.$refs.uploadForm.querySelector('[name="is_public"]').checked;
            formData.append('is_public', isPublic ? '1' : '0');
            
            // Add files to FormData
            this.files.forEach((file, index) => {
                formData.append(`media[${index}]`, file);
            });
            
            console.log('Form data prepared:', {
                title: formData.get('title'),
                description: formData.get('description'),
                is_public: formData.get('is_public'),
                files: this.files.map(f => f.name)
            });

            try {
                console.log('Starting file upload...');
                
                const response = await fetch('{{ route('media.upload') }}', {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData,
                    onUploadProgress: (progressEvent) => {
                        if (progressEvent.lengthComputable) {
                            this.progress = Math.round((progressEvent.loaded / progressEvent.total) * 100);
                            console.log(`Upload Progress: ${this.progress}%`);
                        }
                    }
                });

                // Handle redirect response
                if (response.redirected) {
                    // If the response is a redirect, follow it
                    window.location.href = response.url;
                    return;
                }
                
                // Handle JSON response (fallback)
                const data = await response.json();
                
                if (!response.ok) {
                    throw new Error(data.message || 'Upload failed');
                }

                console.log('Upload successful:', data);
                
                // Reset form and close modal on success
                this.resetForm();
                this.closeModal();
                
                // Emit event to notify parent component
                this.$dispatch('media-uploaded', { data });
                
                // Show success message
                this.showToast('{{ __("gallery_manage.media_added") }}', 'success');
                
            } catch (error) {
                console.error('Upload error:', error);
                this.errors.upload = error.message || 'An error occurred during upload';
                this.showToast(this.errors.upload, 'error');
            } finally {
                this.isUploading = false;
            }
        },

        resetForm() {
            this.files = [];
            this.progress = 0;
            this.errors = {};
            this.$refs.uploadForm.reset();
        },

        showToast(message, type = 'success') {
            // You can implement a toast notification system here
            // For now, we'll just use alert
            alert(`${type.toUpperCase()}: ${message}`);
        },

        closeModal() {
            if (this.isUploading) return;
            this.isOpen = false;
            this.resetForm();
        },

        openModal() {
            this.isOpen = true;
        }
    }));
});
</script>
