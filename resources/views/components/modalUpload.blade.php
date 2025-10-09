<div>
    <button onclick="openModal('uploadModal')"
        class="bg-supaGirlRose hover:bg-green-gs transform rounded-lg px-4 py-2 text-white shadow transition duration-300 ease-in-out hover:scale-105">
        {{ __('uploadModal.title') }}
    </button>
    <div id="uploadModal" class="fixed left-0 top-0 z-50 hidden h-full w-full bg-black/50">
        <div class="fixed inset-0 flex items-center justify-center bg-opacity-50 p-4">
            <div class="w-full max-w-md rounded-lg bg-white shadow-xl">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <h3 id="stepNumber1" class="text-green-gs mb-4 text-lg font-medium leading-6">
                            {{ __('uploadModal.step1') }}</h3>
                        <h3 id="stepNumber2" class="text-green-gs mb-4 hidden text-lg font-medium leading-6">
                            {{ __('uploadModal.step2') }}</h3>
                    </div>
                    <form id="restoreForm" action="{{ route('backups.restore.upload') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <!-- Étape 1 : Dropzone DB -->
                            <div id="dbDropzoneWrapper">
                                <div id="dbDropzone"
                                    class="z-10 cursor-pointer rounded-lg border-2 border-dashed border-gray-300 p-4 transition-all duration-300 ease-in-out hover:bg-gray-50">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4">
                                            </path>
                                        </svg>
                                        <h4 class="mt-2 text-sm font-medium text-gray-700">{{ __('uploadModal.db') }}
                                        </h4>
                                        <p class="mt-1 text-xs text-gray-500">{{ __('uploadModal.dropzone') }}</p>
                                        <p id="dbError" class="mt-1 hidden text-xs text-red-500"></p>
                                    </div>
                                </div>
                                <div id="dbProgressContainer" class="mt-4 hidden">
                                    <div class="h-2.5 w-full rounded-full bg-gray-200">
                                        <div id="dbProgressBar"
                                            class="bg-green-gs h-2.5 rounded-full transition-all duration-300 ease-in-out"
                                            style="width: 0%;"></div>
                                    </div>
                                </div>
                                <div id="dbButtons" class="mt-6 flex hidden justify-end space-x-3">
                                    <button id="cancelDb" type="button" onclick="cancelDbUpload()"
                                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        {{ __('uploadModal.cancel') }}
                                    </button>
                                    <button type="button" onclick="confirmDbUpload()" id="confirmUploaddb" disabled
                                        class="bg-green-gs hover:bg-supaGirlRose focus:ring-supaGirlRose rounded-md border border-transparent px-4 py-2 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2">
                                        {{ __('uploadModal.confirm') }}
                                    </button>
                                </div>
                            </div>
                            <!-- Étape 2 : Dropzone Storage -->
                            <div id="storageDropzoneWrapper" class="hidden">
                                <div id="storageDropzone"
                                    class="cursor-pointer rounded-lg border-2 border-dashed border-gray-300 p-4 transition-all duration-300 ease-in-out hover:bg-gray-50">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4">
                                            </path>
                                        </svg>
                                        <h4 class="mt-2 text-sm font-medium text-gray-700">{{ __('uploadModal.files') }}
                                        </h4>
                                        <p class="mt-1 text-xs text-gray-500">{{ __('uploadModal.dropzone') }}</p>
                                        <p id="storageError" class="mt-1 hidden text-xs text-red-500"></p>
                                    </div>
                                </div>
                                <div id="storageProgressContainer" class="mt-4 hidden">
                                    <div class="h-2.5 w-full rounded-full bg-gray-200">
                                        <div id="storageProgressBar"
                                            class="bg-green-gs h-2.5 rounded-full transition-all duration-300 ease-in-out"
                                            style="width: 0%;"></div>
                                    </div>
                                </div>
                                <div id="storageButtons" class="mt-6 flex hidden justify-end space-x-3">
                                    <button id="cancelStorage" type="button" onclick="cancelStorageUpload()"
                                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        {{ __('uploadModal.cancel') }}
                                    </button>
                                    <button type="button" onclick="confirmStorageUpload()" id="confirmUploadStorage"
                                        disabled
                                        class="bg-green-gs hover:bg-supaGirlRose focus:ring-supaGirlRose rounded-md border border-transparent px-4 py-2 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2">
                                        {{ __('uploadModal.confirm') }}
                                    </button>
                                </div>
                            </div>

                            <div id="chekupload" class="hidden">
                                <div class="flex flex-col items-center space-x-2">
                                    <div>
                                        <svg class="text-green-500" width="50" height="50" viewBox="0 0 24 24"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path d="M22 4L12 14.01l-3-3" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                    <h4 class="text-green-gs text-lg font-medium">{{ __('uploadModal.terminer') }}</h4>
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="mt-6 flex hidden justify-end space-x-3">
                                <button type="button" onclick="closeModal('uploadModal')" id="cancelUpload"
                                    class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                    {{ __('uploadModal.cancel') }}
                                </button>
                                <button type="submit" id="confirmUpload" disabled
                                    class="bg-green-gs hover:bg-supaGirlRose focus:ring-supaGirlRose rounded-md border border-transparent px-4 py-2 text-sm font-medium text-white shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2">
                                    {{ __('uploadModal.confirm') }}
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
    let noSqlFileUploaded = false;
    let noDbFileUploaded = false;

    var dbDropzone = new Dropzone("#dbDropzone", {
        url: "{{ route('backups.restore.upload.chunk') }}",
        paramName: "file",
        uploadMultiple: false,
        maxFilesize: 1024,
        acceptedFiles: ".sql",
        chunking: true,
        forceChunking: true,
        chunkSize: 5 * 1024 * 1024,
        parallelChunkUploads: false,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        autoProcessQueue: false,
        clickable: true,
        init: function() {


            this.on("addedfile", function(file) {
                // Vérification du type de fichier
                if (!file.name.endsWith('.sql')) {
                    this.removeFile(file);
                    document.getElementById('dbError').textContent =
                        "{{ __('uploadModal.errorFilesql') }}";
                    document.getElementById('dbError').classList.remove('hidden');
                    document.getElementById('dbDropzone').classList.add('border-red-500');
                    document.getElementById('confirmUploaddb').disabled = true;
                    console.log('Le fichier doit être au format SQL', file.name);
                    document.getElementById('storageDropzoneWrapper').classList.add('hidden');
                    noSqlFileUploaded = true;
                    return;
                }

                // Réinitialiser les erreurs si le fichier est valide
                document.getElementById('dbError').classList.add('hidden');
                document.getElementById('dbDropzone').classList.remove('border-red-500');
                document.getElementById('dbButtons').classList.remove('hidden');
                document.getElementById('confirmUploaddb').disabled = false;
                noSqlFileUploaded = false;
            });

            this.on("error", function(file, message) {
                this.removeFile(file);
                document.getElementById('dbError').textContent = message;
                document.getElementById('dbError').classList.remove('hidden');
                document.getElementById('dbDropzone').classList.add('border-red-500');
                document.getElementById('confirmUploaddb').disabled = true;
            });

            this.on("uploadprogress", function(file, progress) {
                document.getElementById('dbButtons').classList.add('hidden');

                updateProgressBar('dbProgress', progress);
            });

            this.on("sending", function(file, xhr, formData) {
                formData.append('dzchunkfilename', file.name);
                formData.append('type', 'db_file');
            });

            this.on("complete", function(file) {
                if (!noSqlFileUploaded) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length ===
                        0) {
                        dbFileUploaded = true;
                        document.getElementById('dbButtons').classList.add('hidden');
                        resetProgressBar('dbProgress');
                        console.log('dbFileUploaded degan', dbFileUploaded);
                        document.getElementById('storageDropzoneWrapper').classList.remove(
                        'hidden');
                        document.getElementById('dbDropzoneWrapper').classList.add('hidden');
                        document.getElementById('stepNumber1').classList.add('hidden');
                        document.getElementById('stepNumber2').classList.remove('hidden');
                        checkAllUploadsComplete();
                    }
                }
            });
        }
    });

    var storageDropzone = new Dropzone("#storageDropzone", {
        url: "{{ route('backups.restore.upload.chunk') }}",
        paramName: "file",
        uploadMultiple: false,
        maxFilesize: 1024,
        acceptedFiles: ".zip",
        chunking: true,
        forceChunking: true,
        chunkSize: 5 * 1024 * 1024,
        parallelChunkUploads: false,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        autoProcessQueue: false,
        clickable: true,
        init: function() {
            this.on("addedfile", function(file) {
                // Vérification du type de fichier
                if (!file.name.endsWith('.zip')) {
                    this.removeFile(file);
                    document.getElementById('storageError').textContent =
                        "{{ __('uploadModal.errorFilezip') }}";
                    document.getElementById('storageError').classList.remove('hidden');
                    document.getElementById('storageDropzone').classList.add('border-red-500');
                    document.getElementById('confirmUploadStorage').disabled = true;
                    noDbFileUploaded = true;
                    return;
                }

                // Réinitialiser les erreurs si le fichier est valide
                document.getElementById('storageError').classList.add('hidden');
                document.getElementById('storageDropzone').classList.remove('border-red-500');
                document.getElementById('storageButtons').classList.remove('hidden');
                document.getElementById('confirmUploadStorage').disabled = false;
                noDbFileUploaded = false;
            });

            this.on("error", function(file, message) {
                this.removeFile(file);
                document.getElementById('storageError').textContent = message;
                document.getElementById('storageError').classList.remove('hidden');
                document.getElementById('storageDropzone').classList.add('border-red-500');
                document.getElementById('confirmUploadStorage').disabled = true;
            });

            this.on("uploadprogress", function(file, progress) {
                document.getElementById('storageButtons').classList.add('hidden');
                updateProgressBar('storageProgress', progress);
            });

            this.on("sending", function(file, xhr, formData) {
                formData.append('dzchunkfilename', file.name);
                formData.append('type', 'storage_file');
            });

            this.on("complete", function(file) {
                if (!noDbFileUploaded) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length ===
                        0) {
                        storageFileUploaded = true;
                        document.getElementById('storageButtons').classList.add('hidden');
                        document.getElementById('cancelStorage').disabled = true;
                        document.getElementById('confirmUploadStorage').disabled = true;
                        resetProgressBar('storageProgress');
                        checkAllUploadsComplete();
                    }
                }
            });
        }
    });

    function updateProgressBar(id, progress) {
        document.getElementById(id + 'Container').classList.remove('hidden');
        document.getElementById(id + 'Bar').style.width = progress + "%";
    }

    function resetProgressBar(id) {
        document.getElementById(id + 'Bar').style.width = "0%";
        document.getElementById(id + 'Container').classList.add('hidden');
    }

    function checkAllUploadsComplete() {
        const confirmBtn = document.getElementById('confirmUpload');
        confirmBtn.disabled = !(dbFileUploaded && storageFileUploaded);
        if (dbFileUploaded && storageFileUploaded) {
            document.getElementById('storageDropzoneWrapper').classList.add('hidden');
            document.getElementById('chekupload').classList.remove('hidden');
            document.getElementById('stepNumber2').classList.add('hidden');

            fetch("{{ route('backups.restore.upload.complete') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        db_file: dbDropzone.files.length > 0 ? dbDropzone.files[0].name : null,
                        storage_file: storageDropzone.files.length > 0 ? storageDropzone.files[0].name :
                            null
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeModal('uploadModal');
                        window.location.reload();
                    } else {
                        throw new Error(data.message || 'Une erreur est survenue');
                    }
                })
                .catch(error => {
                    console.error('Erreur :', error);
                    alert(error.message || 'Échec du téléversement');
                });
        }
    }

    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.getElementById('storageDropzoneWrapper').classList.add('hidden');
        document.getElementById('chekupload').classList.add('hidden');
        document.getElementById('confirmUpload').disabled = true;
        dbFileUploaded = false;
        storageFileUploaded = false;
        resetProgressBar('dbProgress');
        resetProgressBar('storageProgress');

        // Réinitialiser les erreurs et les styles
        document.getElementById('dbError').classList.add('hidden');
        document.getElementById('storageError').classList.add('hidden');
        document.getElementById('dbDropzone').classList.remove('border-red-500');
        document.getElementById('storageDropzone').classList.remove('border-red-500');

        // Réinitialiser les dropzones
        dbDropzone.removeAllFiles(true);
        storageDropzone.removeAllFiles(true);

        // Réinitialiser les boutons
        document.getElementById('dbButtons').classList.add('hidden');
        document.getElementById('storageButtons').classList.add('hidden');

        // Réinitialiser les étapes
        document.getElementById('stepNumber1').classList.remove('hidden');
        document.getElementById('stepNumber2').classList.add('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function confirmDbUpload() {
        dbDropzone.processQueue();
    }

    function cancelDbUpload() {
        dbDropzone.removeAllFiles(true);
        document.getElementById('dbButtons').classList.add('hidden');
        document.getElementById('dbError').classList.add('hidden');
        document.getElementById('dbDropzone').classList.remove('border-red-500');
    }

    function confirmStorageUpload() {
        storageDropzone.processQueue();
    }

    function cancelStorageUpload() {
        storageDropzone.removeAllFiles(true);
        document.getElementById('storageButtons').classList.add('hidden');
        document.getElementById('storageError').classList.add('hidden');
        document.getElementById('storageDropzone').classList.remove('border-red-500');
    }
</script>

<style>
    .dz-error-mark,
    .dz-success-mark {
        display: none;
    }

    .dz-details {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .border-red-500 {
        border-color: #ef4444;
    }
</style>
