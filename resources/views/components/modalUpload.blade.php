



<div>
    

<button onclick="openModal('uploadModal')" class="bg-supaGirlRose hover:bg-green-gs text-white px-4 py-2 rounded-lg shadow transition duration-300 ease-in-out transform hover:scale-105">
                    {{ __('backup.importbtn') }}
                </button>
<div id="uploadModal" class="bg-black/50 w-full h-full absolute top-0 left-0 z-50 hidden">
        <div class="fixed inset-0 bg-opacity-50 flex justify-center items-center p-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h3 class="text-lg font-medium leading-6 text-green-gs mb-4">{{ __('backup.import_backup') }}</h3>
                    
                    <form id="restoreForm" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <!-- Database Backup -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                    </svg>
                                    <h4 class="mt-2 text-sm font-medium text-gray-700">{{ __('backup.import_backup_db') }}</h4>
                                    <p class="mt-1 text-xs text-gray-500">{{ __('backup.import_backup_db_message') }}</p>
                                    <div class="mt-2">
                                        <input type="file" id="dbFile" name="db_file" accept=".sql" class="hidden" required>
                                        <label for="dbFile" class="cursor-pointer text-sm text-green-gs hover:text-green-gs">
                                            {{ __('backup.select_file') }}
                                        </label>
                                        <p id="dbFileName" class="text-xs text-gray-500 mt-1">{{ __('backup.select_file') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Storage Backup -->
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                    <h4 class="mt-2 text-sm font-medium text-gray-700">{{ __('backup.import_backup_storage') }}</h4>
                                    <p class="mt-1 text-xs text-gray-500">{{ __('backup.import_backup_storage_message') }}</p>
                                    <div class="mt-2">
                                        <input type="file" id="storageFile" name="storage_file" accept=".zip" class="hidden">
                                        <label for="storageFile" class="cursor-pointer text-sm text-green-gs hover:text-green-gs">
                                            {{ __('backup.select_file_storage') }}
                                        </label>
                                        <p id="storageFileName" class="text-xs text-gray-500 mt-1">{{ __('backup.select_file_storage') }}</p>
                                    </div>
                                </div>
                            </div>


                            <!-- Buttons -->
                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" onclick="closeModal('uploadModal')" id="cancelUpload"
                                    class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    {{ __('backup.cancel') }}
                                </button>
                                <button type="submit" disabled
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-gs hover:bg-supaGirlRose focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-supaGirlRose opacity-50 cursor-not-allowed">
                                    {{ __('backup.confirm') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


</div>






















 
    <style>
.dot-animation::after {
    content: '';
    display: inline-block;
    width: 1em;
    text-align: left;
    animation: dots 1.5s steps(4, end) infinite;
}

@keyframes dots {
    0%   { content: ''; }
    25%  { content: '.'; }
    50%  { content: '..'; }
    75%  { content: '...'; }
    100% { content: ''; }
}
</style>

    <script>
       
       function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
    function validateFileType(file, allowedTypes) {
        const extension = file.name.split('.').pop().toLowerCase();
        return allowedTypes.includes(extension);
    }

    function updateFileUI(inputId, fileNameId, allowedTypes, required = true) {
        const input = document.getElementById(inputId);
        const file = input.files[0];
        const fileNameDisplay = document.getElementById(fileNameId);
        const container = input.closest('.border-dashed');
        const icon = container.querySelector('svg');

        // Reset styles
        container.classList.remove('border-supaGirlRose', 'border-red-500');
        icon.classList.remove('text-supaGirlRose', 'text-red-500');
        icon.classList.add('text-gray-400');

        let isValid = false;

        if (file && validateFileType(file, allowedTypes)) {
            fileNameDisplay.textContent = file.name;
            container.classList.add('border-supaGirlRose');
            icon.classList.remove('text-gray-400');
            icon.classList.add('text-supaGirlRose');
            isValid = true;
        } else if (file) {
            input.value = ''; // reset input
            fileNameDisplay.textContent = `❌ {{ __('backup.file_invalid') }} .${allowedTypes.join(' ou .')}`;
            container.classList.add('border-red-500');
            icon.classList.remove('text-gray-400');
            icon.classList.add('text-red-500');
        } else {
            fileNameDisplay.textContent = '{{ __('backup.select_file') }}';
        }

        validateRestoreButton();
        return isValid || !required;
    }

    function validateRestoreButton() {
        const dbFile = document.getElementById('dbFile').files[0];
        const storageFile = document.getElementById('storageFile').files[0];
        const restoreBtn = document.querySelector('#restoreForm button[type="submit"]');

        const dbValid = dbFile && validateFileType(dbFile, ['sql']);
        const storageValid = !storageFile || validateFileType(storageFile, ['zip']);

        if (dbValid && storageValid) {
            restoreBtn.disabled = false;
            restoreBtn.classList.remove('opacity-50', 'cursor-not-allowed');
        } else {
            restoreBtn.disabled = true;
            restoreBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }
    }

    // Bind events
    document.getElementById('dbFile').addEventListener('change', function () {
        updateFileUI('dbFile', 'dbFileName', ['sql'], true);
    });

    document.getElementById('storageFile').addEventListener('change', function () {
        updateFileUI('storageFile', 'storageFileName', ['zip'], false);
    });

    // Handle form submission
    document.getElementById('restoreForm').addEventListener('submit', function(e) {
        e.preventDefault();

            const cancelBtn = document.getElementById('uploadModal').querySelector('button[onclick*="closeModal"]');
            cancelBtn.disabled = true;
            cancelBtn.classList.add('opacity-50', 'cursor-not-allowed');
            
            const formData = new FormData(this);
            
            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="flex items-center"><svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Traitement...</span>';
            
            // Submit the form
            fetch('{{ route("backups.restore.upload") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                processData: false,
                contentType: false
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Erreur réseau');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('success', data.message || '{{ __('backup.restore_success') }}');
                    closeModal('uploadModal');
                    // Reload the page to reflect changes
                    console.log(data);
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    throw new Error(data.message || 'Une erreur est survenue');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('error', error.message || '{{ __('backup.restore_failed') }}');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
            });
    });

    // Helper function to show toast messages
    function showToast(type, message) {
        // Implement your toast notification system here
        alert(message); // Simple alert for now, replace with your toast implementation
    }
    </script>