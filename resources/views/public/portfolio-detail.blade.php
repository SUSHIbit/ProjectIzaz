<!-- resources/views/public/portfolio-detail.blade.php -->
<x-app-layout>
    <!-- Updated blue to red -->
    <section class="bg-red-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center">
                <a href="{{ route('portfolio') }}" class="text-white hover:text-red-200 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                    {{ $project->title }}
                </h1>
            </div>
            <p class="mt-4 text-xl max-w-3xl">
                Project completed in {{ $project->duration_days }} days.
            </p>
        </div>
    </section>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="mb-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Project Description</h2>
                    <div class="prose max-w-none text-gray-700">
                        {{ $project->description }}
                    </div>
                </div>

                @if($project->extra_info)
                <div class="mb-10 bg-gray-50 p-6 rounded-lg">
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Additional Information</h2>
                    <div class="prose max-w-none text-gray-700">
                        {{ $project->extra_info }}
                    </div>
                </div>
                @endif

                @if($project->images->count() > 0)
                <div class="mt-10">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Project Gallery</h2>
                    
                    <!-- Main Gallery Image -->
                    <div id="mainImage" class="w-full h-96 bg-gray-100 rounded-lg overflow-hidden mb-4">
                        <img src="{{ Storage::url($project->images->first()->image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-contain">
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    @if($project->images->count() > 1)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                        @foreach($project->images as $image)
                        <div class="thumbnail-image cursor-pointer h-24 bg-gray-100 rounded-lg overflow-hidden" data-image="{{ Storage::url($image->image_path) }}">
                            <img src="{{ Storage::url($image->image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover hover:opacity-75 transition-opacity">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif

                <div class="mt-10 pt-6 border-t border-gray-200">
                    <a href="{{ route('portfolio') }}" class="inline-flex items-center text-red-600 hover:text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Portfolio
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Image gallery functionality - kept unchanged
        document.addEventListener('DOMContentLoaded', function() {
            const mainImage = document.getElementById('mainImage');
            const thumbnails = document.querySelectorAll('.thumbnail-image');
            
            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function() {
                    const imageUrl = this.getAttribute('data-image');
                    mainImage.querySelector('img').src = imageUrl;
                });
            });
        });
    </script>
</x-app-layout>