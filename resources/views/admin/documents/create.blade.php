<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Upload Document for') }} {{ $user->name }}
            </h2>
            <a href="{{ route('admin.documents.user', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to Documents
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.documents.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        
                        <!-- Document title field -->
                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Document Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>
                    
                        <!-- Requires signature checkbox -->
                        <div class="mb-6">
                            <div class="flex items-center">
                                <input id="requires_signature" name="requires_signature" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" {{ old('requires_signature') ? 'checked' : '' }}>
                                <label for="requires_signature" class="ml-2 block text-sm text-gray-900">
                                    This document requires signature from the user
                                </label>
                            </div>
                        </div>
                    
                        <!-- File upload field -->
                        <div class="mb-6">
                            <x-input-label for="document" :value="__('Upload PDF Document')" />
                            <input type="file" id="document" name="document" accept=".pdf" class="mt-1 block w-full" required>
                            <x-input-error :messages="$errors->get('document')" class="mt-2" />
                            <p class="mt-1 text-sm text-gray-500">PDF up to 10MB</p>
                        </div>
                    
                        <!-- Submit button -->
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Upload Document') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show file name when selected
        document.getElementById('document').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                document.getElementById('file-name').textContent = `Selected file: ${fileName}`;
            } else {
                document.getElementById('file-name').textContent = '';
            }
        });
    </script>
</x-app-layout>