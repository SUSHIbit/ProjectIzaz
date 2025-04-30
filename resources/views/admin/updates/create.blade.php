<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add Project Update for') }} {{ $user->name }}
            </h2>
            <a href="{{ route('admin.updates.user', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to User Updates
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.updates.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Update Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="e.g. Weekly Progress, Foundation Complete, etc." />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="description" :value="__('Update Description')" />
                            <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Provide details about the project progress...">{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label :value="__('Upload Images (Max 10)')" />
                            <p class="text-sm text-gray-500 mb-2">You can upload up to 10 images to show the project progress.</p>
                            
                            <div class="image-upload-container">
                                <template id="image-upload-template">
                                    <div class="image-upload-item mb-4 p-4 border border-gray-200 rounded-lg">
                                        <div class="flex items-start">
                                            <div class="w-full">
                                                <div class="mb-3">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Image
                                                    </label>
                                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative">
                                                        <div class="space-y-1 text-center">
                                                            <svg class="mx-auto h-12 w-12 text-gray-400 image-placeholder" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                            <img class="mx-auto h-32 w-auto object-cover hidden image-preview" alt="Image preview" />
                                                            <div class="flex text-sm text-gray-600">
                                                                <label class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                                    <span>Upload a file</span>
                                                                    <input type="file" name="images[]" class="sr-only image-input" accept="image/*" required>
                                                                </label>
                                                                <p class="pl-1">or drag and drop</p>
                                                            </div>
                                                            <p class="text-xs text-gray-500">
                                                                PNG, JPG, GIF up to 2MB
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="block text-sm font-medium text-gray-700">
                                                        Image Description
                                                    </label>
                                                    <input type="text" name="image_descriptions[]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Describe what's in this image...">
                                                </div>
                                            </div>
                                            
                                            <div class="ml-3">
                                                <button type="button" class="remove-image text-red-600 hover:text-red-800">
                                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                
                                <div id="image-uploads" class="mb-4">
                                    <!-- Image upload items will be inserted here -->
                                </div>
                                
                                <div class="mb-4">
                                    <button type="button" id="add-image" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Add Another Image
                                    </button>
                                </div>
                                
                                <x-input-error :messages="$errors->get('images')" class="mt-2" />
                                <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                                <x-input-error :messages="$errors->get('image_descriptions')" class="mt-2" />
                                <x-input-error :messages="$errors->get('image_descriptions.*')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Create Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add the first image upload field
            addImageUpload();
            
            // Setup event listeners
            document.getElementById('add-image').addEventListener('click', function() {
                const currentCount = document.querySelectorAll('#image-uploads .image-upload-item').length;
                if (currentCount < 10) {
                    addImageUpload();
                } else {
                    alert('You can only add up to 10 images per update.');
                }
            });
            
            // Event delegation for the image uploads container
            document.getElementById('image-uploads').addEventListener('click', function(event) {
                // Check if the clicked element or its parent has the remove-image class
                const removeButton = event.target.closest('.remove-image');
                if (removeButton) {
                    const item = removeButton.closest('.image-upload-item');
                    // Only allow removal if there's more than one image item
                    const itemCount = document.querySelectorAll('#image-uploads .image-upload-item').length;
                    if (itemCount > 1) {
                        item.remove();
                    } else {
                        alert('You need at least one image. You can change it instead of removing.');
                    }
                }
            });
            
            // Event delegation for file inputs
            document.getElementById('image-uploads').addEventListener('change', function(event) {
                const input = event.target;
                if (input.classList.contains('image-input')) {
                    const item = input.closest('.image-upload-item');
                    const placeholder = item.querySelector('.image-placeholder');
                    const preview = item.querySelector('.image-preview');
                    
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            placeholder.classList.add('hidden');
                            preview.classList.remove('hidden');
                        };
                        
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            });
        });
        
        function addImageUpload() {
            const template = document.getElementById('image-upload-template');
            const container = document.getElementById('image-uploads');
            const clone = template.content.cloneNode(true);
            container.appendChild(clone);
        }
    </script>
</x-app-layout>