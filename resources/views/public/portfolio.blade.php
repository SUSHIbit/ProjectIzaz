<x-app-layout>
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-[400px]" style="background-image: url('https://images.unsplash.com/photo-1560185007-cde436f6a4d0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="text-center mx-auto max-w-3xl">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
                    Our Portfolio
                </h1>
                <p class="mt-4 text-xl text-white">
                    Browse through our completed projects and see the quality of our work.
                </p>
            </div>
        </div>
    </section>

    <!-- Portfolio Grid Section -->
    <section class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Exceptional Results</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Explore our past projects to see our attention to detail and commitment to quality. From small repairs to complete renovations, we take pride in our work.
                </p>
            </div>

            @if($portfolio->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($portfolio as $project)
                        <div class="group relative bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="aspect-square overflow-hidden">
                                @if($project->images->count() > 0)
                                    <img src="{{ asset('storage/' . $project->images->first()->image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                @else
                                    <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                        <svg class="h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                
                                @if($project->images->count() > 1)
                                    <div class="absolute top-3 right-3 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded-full">
                                        {{ $project->images->count() }} Images
                                    </div>
                                @endif
                            </div>
                            
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $project->title }}</h3>
                                <div class="flex flex-wrap gap-2 mt-2 mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        {{ $project->duration_days }} days
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm">{{ Str::limit($project->description, 100) }}</p>
                                
                                @if($project->extra_info)
                                    <div class="mt-3 text-xs text-gray-500">
                                        <strong>Additional Info:</strong> {{ Str::limit($project->extra_info, 60) }}
                                    </div>
                                @endif
                                
                                <div class="mt-6 flex justify-end">
                                    <a href="{{ route('portfolio.detail', $project->id) }}" class="inline-flex items-center text-red-600 hover:text-red-700">
                                        View Project
                                        <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent flex items-end opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none p-6">
                                <a href="{{ route('portfolio.detail', $project->id) }}" class="text-white font-medium group-hover:underline pointer-events-auto">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-12">
                    {{ $portfolio->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-gray-50 rounded-2xl">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No Projects Available</h3>
                    <p class="mt-2 text-base text-gray-500">Check back later for our upcoming projects.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Masonry Gallery Preview (Optional) -->
    @if($portfolio->count() > 0)
    <?php
    $imageCount = 0;
    foreach ($portfolio as $project) {
        $imageCount += $project->images->count();
    }
    ?>
    @if($imageCount > 4)
    <section class="py-16 bg-gray-50">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Project Gallery</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    A selection of images from our favorite projects.
                </p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <?php 
                $images = collect();
                foreach ($portfolio as $project) {
                    foreach ($project->images as $image) {
                        $images->push($image);
                    }
                }
                $images = $images->shuffle()->take(8);
                ?>
                
                @foreach($images as $index => $image)
                    <div class="{{ $index % 5 == 0 ? 'col-span-2 row-span-2' : '' }} overflow-hidden rounded-lg shadow-md">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery image" class="w-full h-full object-cover">
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    @endif

    <!-- CTA Section -->
    <section class="bg-white py-16">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-red-600 rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-12 md:p-12 md:flex md:items-center md:justify-between">
                    <div class="max-w-3xl">
                        <h2 class="text-3xl font-bold tracking-tight text-white">
                            Ready to start your project?
                        </h2>
                        <p class="mt-3 text-lg text-red-100">
                            Our team of professionals is ready to help bring your vision to life. Contact us today for a consultation.
                        </p>
                    </div>
                    <div class="mt-8 md:mt-0 md:ml-8 md:flex-shrink-0">
                        <a href="{{ route('services') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-red-50">
                            Explore Services
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>