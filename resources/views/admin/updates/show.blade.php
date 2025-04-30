<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Project Update Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.updates.edit', $update->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Update
                </a>
                <a href="{{ route('admin.updates.user', $update->user_id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to User Updates
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $update->title }}</h3>
                        
                        <div class="flex items-center text-sm text-gray-500 mb-4">
                            <svg class="h-5 w-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $update->created_at->format('F d, Y') }}</span>
                            
                            <span class="mx-2">•</span>
                            
                            <svg class="h-5 w-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>For: {{ $update->user->name }}</span>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h4 class="text-md font-medium text-gray-700 mb-2">Update Description</h4>
                            <div class="text-gray-700 whitespace-pre-line">{{ $update->description }}</div>
                        </div>
                    </div>
                    
                    <div class="mb-8">
                        <div class="flex justify-between items-center mb-4">
                            <h4 class="text-lg font-medium">Update Images ({{ $update->images->count() }}/10)</h4>
                            
                            @if($update->images->count() < 10)
                                <button type="button" onclick="openAddImagesModal()" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add More Images
                                </button>
                            @endif
                        </div>
                        
                        @if($update->images->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($update->images as $image)
                                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm">
                                        <div class="relative aspect-video bg-gray-100">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Update image" class="w-full h-full object-cover">
                                            <div class="absolute top-2 right-2">
                                                <form action="{{ route('admin.updates.images.destroy', $image->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 text-white rounded-full p-1 hover:bg-red-700 focus:outline-none" onclick="return confirm('Are you sure you want to remove this image?')">
                                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="p-4">
                                            <p class="text-sm text-gray-700">{{ $image->description ?: 'No description provided' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 bg-gray-50 rounded-lg">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No images</h3>
                                <p class="mt-1 text-sm text-gray-500">Add images to showcase this project update.</p>
                                <div class="mt-6">
                                    <button type="button" onclick="openAddImagesModal()" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Add Images
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex justify-between items-center mt-6 pt-6 border-t border-gray-200">
                        <form action="{{ route('admin.updates.destroy', $update->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this update? All images will be permanently removed.')">
                                Delete Update
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.updates.edit', $update->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Edit Update
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Images Modal -->
    <div id="addImagesModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-4xl w-full mx-4 max-h-screen overflow-y-auto">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Add More Images</h3>
                    <button type="button" onclick="closeAddImagesModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="px-6 py-4">
                <form id="addImagesForm" method="POST" action="{{ route('admin.updates.images.store', $update->id) }}" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-4">You can add up to {{ 10 - $update->images->count() }} more images to this update.</p>
                        
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
                            
                            <div id="additional-image-uploads" class="mb-4">
                                <!-- Image upload items will be inserted here -->
                            </div>
                            
                            <div class="mb-4">
                                <button type="button" id="add-additional-image" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Another Image
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="button" onclick="closeAddImagesModal()" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                    Cancel
                </button>
                <button type="button" onclick="submitAddImagesForm()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Upload Images
                </button>
            </div>
        </div>
    </div>

    <script>
        function openAddImagesModal() {
            document.getElementById('addImagesModal').classList.remove('hidden');
            addAdditionalImageUpload();
        }
        
        function closeAddImagesModal() {
            document.getElementById('addImagesModal').classList.add('hidden');
            document.getElementById('additional-image-uploads').innerHTML = '';
        }
        
        function submitAddImagesForm() {
            document.getElementById('addImagesForm').submit();
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            // Setup event listeners for the add images modal
            document.getElementById('add-additional-image').addEventListener('click', function() {
                const currentCount = document.querySelectorAll('#additional-image-uploads .image-upload-item').length;
                const maxAdditional = {{ 10 - $update->images->count() }};
                
                if (currentCount < maxAdditional) {
                    addAdditionalImageUpload();
                } else {
                    alert(`You can only add up to ${maxAdditional} more images.`);
                }
            });
            
            // Event delegation for the additional image uploads container
            document.getElementById('additional-image-uploads').addEventListener('click', function(event) {
                // Check if the clicked element or its parent has the remove-image class
                const removeButton = event.target.closest('.remove-image');
                if (removeButton) {
                    const item = removeButton.closest('.image-upload-item');
                    // Only allow removal if there's more than one image item
                    const itemCount = document.querySelectorAll('#additional-image-uploads .image-upload-item').length;
                    if (itemCount > 1) {
                        item.remove();
                    } else {
                        alert('You need at least one image.');
                    }
                }
            });
            
            // Event delegation for file inputs
            document.getElementById('additional-image-uploads').addEventListener('change', function(event) {
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
        
        function addAdditionalImageUpload() {
            const template = document.getElementById('image-upload-template');
            const container = document.getElementById('additional-image-uploads');
            const clone = template.content.cloneNode(true);
            container.appendChild(clone);
        }
    </script>
</x-app-layout>