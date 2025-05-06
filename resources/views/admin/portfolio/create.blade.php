@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Add New Portfolio Project') }}
                    </h2>
                    <a href="{{ route('admin.portfolio.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Back to Portfolio
                    </a>
                </div>

                <form method="POST" action="{{ route('admin.portfolio.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6">
                        <x-input-label for="title" :value="__('Project Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="description" :value="__('Project Description')" />
                        <textarea id="description" name="description" rows="5" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="duration_days" :value="__('Project Duration (days)')" />
                        <x-text-input id="duration_days" class="block mt-1 w-full" type="number" name="duration_days" :value="old('duration_days')" min="1" required />
                        <x-input-error :messages="$errors->get('duration_days')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="extra_info" :value="__('Additional Information (Optional)')" />
                        <textarea id="extra_info" name="extra_info" rows="3" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('extra_info') }}</textarea>
                        <x-input-error :messages="$errors->get('extra_info')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="images" :value="__('Project Images')" />
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                        <span>Upload images</span>
                                        <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*" required>
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
                            {{ __('Create Project') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Image preview functionality
    document.getElementById('images').addEventListener('change', function(event) {
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