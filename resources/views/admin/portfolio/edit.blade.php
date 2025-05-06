@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Edit Portfolio Project') }}
                    </h2>
                    <a href="{{ route('admin.portfolio.show', $portfolio->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Back to Project
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.portfolio.update', $portfolio->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <x-input-label for="title" :value="__('Project Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $portfolio->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="description" :value="__('Project Description')" />
                        <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description', $portfolio->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="duration_days" :value="__('Project Duration (days)')" />
                        <x-text-input id="duration_days" class="block mt-1 w-full" type="number" name="duration_days" :value="old('duration_days', $portfolio->duration_days)" min="1" required />
                        <x-input-error :messages="$errors->get('duration_days')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="extra_info" :value="__('Additional Information (Optional)')" />
                        <textarea id="extra_info" name="extra_info" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('extra_info', $portfolio->extra_info) }}</textarea>
                        <x-input-error :messages="$errors->get('extra_info')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Update Project') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h3 class="text-lg font-medium mb-4">Project Images</h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @forelse($portfolio->images as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Project image" class="w-full aspect-square object-cover rounded-md">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-center justify-center transition-all duration-200">
                                <form action="{{ route('admin.portfolio.images.destroy', $image->id) }}" method="POST" class="hidden group-hover:block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-white bg-red-600 rounded-full p-1 hover:bg-red-700 focus:outline-none" onclick="return confirm('Are you sure you want to delete this image?')">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-gray-500 text-center py-4">
                            No images available for this project.
                        </div>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('admin.portfolio.images.store', $portfolio->id) }}" enctype="multipart/form-data" class="mt-6">
                    @csrf
                    
                    <div class="mb-4">
                        <x-input-label for="add_images" :value="__('Add More Images')" />
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="add_images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload images</span>
                                        <input id="add_images" name="images[]" type="file" class="sr-only" multiple accept="image/*" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF up to 2MB each
                                </p>
                            </div>
                        </div>
                        <div id="image-preview" class="mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4"></div>
                        <x-input-error :messages="$errors->get('images')" class="mt-2" />
                        <x-input-error :messages="$errors->get('images.*')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Add Images') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Image preview functionality
    document.getElementById('add_images').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('image-preview');
        previewContainer.innerHTML = '';

        Array.from(event.target.files).forEach(file => {
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative aspect-square bg-gray-100 rounded-md overflow-hidden';
                    
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    img.alt = 'Image preview';
                    
                    div.appendChild(img);
                    previewContainer.appendChild(div);
                }
                
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endsection