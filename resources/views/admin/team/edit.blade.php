<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Team Member') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('admin.team.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Team
                        </a>
                    </div>

                    <!-- Form for Editing Team Member -->
                    <form action="{{ route('admin.team.update', $teamMember->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Name Field -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $teamMember->name) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Title Field -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $teamMember->title) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            @error('title')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Position Field -->
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700 mb-1">Position</label>
                            <input type="text" name="position" id="position" value="{{ old('position', $teamMember->position) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            @error('position')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Display Order Field -->
                        <div>
                            <label for="display_order" class="block text-sm font-medium text-gray-700 mb-1">Display Order</label>
                            <input type="number" name="display_order" id="display_order" value="{{ old('display_order', $teamMember->display_order) }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                            <p class="mt-1 text-sm text-gray-500">Lower numbers will be displayed first.</p>
                            @error('display_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Image Upload Field -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Profile Image</label>
                            <div class="mt-1 flex items-center">
                                <div id="image-preview" class="mr-5 h-32 w-32 border-2 {{ $teamMember->image ? '' : 'border-dashed' }} border-gray-300 rounded-md flex items-center justify-center {{ $teamMember->image ? '' : 'hidden' }}">
                                    @if($teamMember->image)
                                        <img id="preview" src="{{ asset('storage/' . $teamMember->image) }}" alt="Current Image" class="h-full w-full object-cover rounded-md">
                                    @else
                                        <img id="preview" src="#" alt="Image Preview" class="h-full w-full object-cover rounded-md">
                                    @endif
                                </div>
                                
                                <div id="upload-container" class="flex flex-col space-y-2">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>{{ $teamMember->image ? 'Change image' : 'Upload a file' }}</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/*" onchange="previewImage()">
                                    </label>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Update Team Member
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const preview = document.getElementById('preview');
            const file = document.getElementById('image').files[0];
            const previewContainer = document.getElementById('image-preview');
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    previewContainer.classList.remove('border-dashed');
                }
                
                reader.readAsDataURL(file);
            }
        }
    </script>
</x-app-layout>