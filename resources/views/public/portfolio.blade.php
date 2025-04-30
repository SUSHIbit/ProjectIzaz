<x-app-layout>
    <div class="bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                Our Portfolio
            </h1>
            <p class="mt-4 text-xl max-w-3xl">
                Browse through our completed projects and see the quality of our work.
            </p>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($portfolio->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($portfolio as $project)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            @if($project->images->count() > 0)
                                <div class="relative h-56">
                                    <img src="{{ asset('storage/' . $project->images->first()->image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover">
                                    @if($project->images->count() > 1)
                                        <div class="absolute bottom-2 right-2 bg-black bg-opacity-60 text-white text-xs rounded px-2 py-1">
                                            +{{ $project->images->count() - 1 }} more photos
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                    <span class="text-gray-400">No image available</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $project->title }}</h3>
                                <p class="text-gray-700 text-sm mb-4">{{ Str::limit($project->description, 100) }}</p>
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Duration: {{ $project->duration_days }} days
                                    </span>
                                </div>
                                @if($project->extra_info)
                                    <div class="text-sm text-gray-600 mb-4">
                                        <strong>Additional Info:</strong> {{ Str::limit($project->extra_info, 100) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $portfolio->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No Projects Available</h3>
                    <p class="mt-1 text-sm text-gray-500">Check back later for new projects.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>