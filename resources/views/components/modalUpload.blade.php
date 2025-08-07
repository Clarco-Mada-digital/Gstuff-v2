<div>
        <button onclick="openModal('uploadModal')" class="bg-supaGirlRose hover:bg-green-gs text-white px-4 py-2 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
            Importer
        </button>
        <div id="uploadModal" class="bg-black/50 w-full h-full absolute top-0 left-0 z-50 hidden">
            <div class="fixed inset-0 bg-opacity-50 flex justify-center items-center p-4">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                    <div class="p-6">
                        <h3 class="text-lg font-medium leading-6 text-green-gs mb-4">Importer une sauvegarde</h3>
                        <form id="restoreForm" action="{{ route('backups.restore.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="space-y-4">
                                <!-- Database Backup Dropzone -->
                                <div id="dbDropzone" class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                        </svg>
                                        <h4 class="mt-2 text-sm font-medium text-gray-700">Importer une sauvegarde de base de données</h4>
                                        <p class="mt-1 text-xs text-gray-500">Déposez les fichiers de base de données ici ou cliquez pour télécharger</p>
                                    </div>
                                </div>
                                <!-- Storage Backup Dropzone -->
                                <div id="storageDropzone" class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                        <h4 class="mt-2 text-sm font-medium text-gray-700">Importer une sauvegarde de stockage</h4>
                                        <p class="mt-1 text-xs text-gray-500">Déposez les fichiers de stockage ici ou cliquez pour télécharger</p>
                                    </div>
                                </div>
                                <!-- Buttons -->
                                <div class="mt-6 flex justify-end space-x-3">
                                    <button type="button" onclick="closeModal('uploadModal')" id="cancelUpload" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                        Annuler
                                    </button>
                                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-gs hover:bg-supaGirlRose focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supaGirlRose">
                                        Confirmer
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script>
        Dropzone.autoDiscover = false;
        let dbFileUploaded = false;
        let storageFileUploaded = false;

        // Database Dropzone
var dbDropzone = new Dropzone("#dbDropzone", {
    url: "{{ route('backups.restore.upload.chunk') }}",
    paramName: "file",
    uploadMultiple: false,
    maxFilesize: 1024, // MB
    chunking: true,
    forceChunking: true,
    chunkSize: 5 * 1024 * 1024, // MB
    parallelChunkUploads: false,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    autoProcessQueue: true,
    init: function() {
        this.on("sending", function(file, xhr, formData) {
            // Include the filename in the request
            formData.append('dzchunkfilename', file.name);
            formData.append('type', 'db_file');
            console.log("Uploading chunk db: " + file.name);
        });
        this.on("complete", function(file) {
            console.log("Chunk uploaded db: " + file.name);
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
                dbFileUploaded = true;
                checkAllUploadsComplete();
            }
        });
    }
});

// Storage Dropzone
var storageDropzone = new Dropzone("#storageDropzone", {
    url: "{{ route('backups.restore.upload.chunk') }}",
    paramName: "file",
    uploadMultiple: false,
    maxFilesize: 1024, // MB
    chunking: true,
    forceChunking: true,
    chunkSize: 5 * 1024 * 1024, // MB
    parallelChunkUploads: false,
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
    autoProcessQueue: true,
    init: function() {
        this.on("sending", function(file, xhr, formData) {
            // Include the filename in the request
            formData.append('dzchunkfilename', file.name);
            formData.append('type', 'storage_file');
            console.log("Uploading chunk storage: " + file.name);
        });
        this.on("complete", function(file) {
            storageFileUploaded = true;
            console.log('Storage file uploaded storage: ' + storageFileUploaded);
            checkAllUploadsComplete();
        });
    }
});


        function checkAllUploadsComplete() {
            if (dbFileUploaded && storageFileUploaded) {
                fetch("{{ route('backups.restore.upload.complete') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        db_file: dbDropzone.files.length > 0 ? dbDropzone.files[0].name : null,
                        storage_file: storageDropzone.files.length > 0 ? storageDropzone.files[0].name : null
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Upload successful db: ' + data.message);
                        closeModal('uploadModal');
                        window.location.reload();
                    } else {
                        throw new Error(data.message || 'An error occurred');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message || 'Upload failed');
                });
            }
        }

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>