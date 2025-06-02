<x-app-layout>
    <!-- Hero Section with Background House Image - Unchanged -->
    <section class="relative bg-cover bg-center h-[600px]" style="background-image: url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        <div class="absolute inset-0 bg-black bg-opacity-50"></div>
        <div class="relative max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="text-center md:text-left md:max-w-lg">
                <h1 class="text-4xl md:text-5xl font-bold tracking-tight text-white mb-4">
                    Your Trusted Partner for Home Services
                </h1>
                <p class="text-xl text-white mb-8 max-w-lg">
                    From comprehensive renovations to minor repairs, we bring your vision to life with professional expertise.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4">
                    <a href="{{ route('services') }}" class="w-full sm:w-auto px-8 py-3 text-base font-medium text-red-600 bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                        View Services
                    </a>
                    <a href="{{ route('portfolio') }}" class="w-full sm:w-auto px-8 py-3 text-base font-medium text-white border border-white rounded-lg hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 transition-colors">
                        Our Portfolio
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Preview Section - Updated background to white -->
    <section class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between md:space-x-12">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                        Our Services
                    </span>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Transforming homes with professional services</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        We offer a comprehensive range of home services designed to enhance your property's value, functionality, and appearance. Our experienced team delivers quality workmanship with attention to detail.
                    </p>
                    
                    <div class="space-y-4">
                        @foreach($services->take(3) as $service)
                            <div class="flex items-start">
                                <svg class="h-6 w-6 text-red-500 mt-0.5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $service->title }}</h3>
                                    <p class="text-gray-600 text-sm">{{ Str::limit($service->description, 100) }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        <a href="{{ route('services') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            View All Services
                            <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="md:w-1/2">
                    <div class="relative rounded-2xl overflow-hidden shadow-xl aspect-video">
                        @if($services->count() > 0 && $services->first()->image_path)
                            <img src="{{ Storage::url($services->first()->image_path) }}" alt="{{ $services->first()->title }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://images.unsplash.com/photo-1556912167-f556f1f39fdf?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Home Services" class="w-full h-full object-cover">
                        @endif
                        
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 to-transparent p-6">
                            <h3 class="text-xl font-bold text-white">Quality Workmanship</h3>
                            <p class="text-white/90 text-sm">Professional service with exceptional results</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Portfolio Preview Section - Updated to light gray -->
    <section class="py-16 bg-gray-100">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between md:space-x-12 flex-row-reverse">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                        Recent Projects
                    </span>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">See our completed work</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Browse through our portfolio of completed projects to get a sense of our quality and attention to detail. From small repairs to complete renovations, we pride ourselves on delivering exceptional results.
                    </p>
                    
                    <div class="space-y-4">
                        @foreach($portfolio->take(2) as $project)
                            <div class="bg-white rounded-lg p-4 shadow-sm flex items-start">
                                <span class="flex-shrink-0 inline-flex items-center justify-center h-12 w-12 rounded-full bg-red-100 text-red-500 mr-4">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z" />
                                    </svg>
                                </span>
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $project->title }}</h3>
                                    <p class="text-gray-600 text-sm">Completed in {{ $project->duration_days }} days</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-8">
                        <a href="{{ route('portfolio') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            View Our Portfolio
                            <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
                
                <div class="md:w-1/2">
                    <div class="grid grid-cols-2 gap-4">
                        @if($portfolio->count() > 0)
                            @foreach($portfolio->take(2) as $project)
                                <div class="rounded-2xl overflow-hidden shadow-lg aspect-square relative group">
                                    @if($project->images->count() > 0)
                                        <img src="{{ asset('storage/' . $project->images->first()->image_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-105">
                                    @else
                                    <div class="bg-gray-200 w-full h-full flex items-center justify-center">
                                        <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent flex items-end p-4 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <div class="text-white">
                                        <p class="font-medium">{{ $project->title }}</p>
                                        <p class="text-sm">{{ $project->duration_days }} days</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="rounded-2xl overflow-hidden shadow-lg aspect-square">
                                <img src="https://images.unsplash.com/photo-1523413363574-c30aa5c2b6b7?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Project 1" class="w-full h-full object-cover">
                            </div>
                            <div class="rounded-2xl overflow-hidden shadow-lg aspect-square">
                                <img src="https://images.unsplash.com/photo-1584622781564-1d987f7333c1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Project 2" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Preview Section - Updated from red-50 to a more elegant gray-50 with red accents -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                    Our Experts
                </span>
                <h2 class="text-3xl font-bold text-gray-900">Meet our talented team</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Our dedicated professionals bring years of expertise to every project. Get to know the people who will transform your home.
                </p>
            </div>
    
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @if($team->count() > 0)
                    @foreach($team->take(3) as $member)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="aspect-square overflow-hidden">
                                <img src="{{ asset('storage/' . $member->image_path) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900">{{ $member->name }}</h3>
                                <p class="text-red-600 font-medium">{{ $member->title }}</p>
                                <p class="mt-2 text-gray-600 text-sm">{{ $member->position }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback content if no team members exist -->
                @endif
            </div>
    
            <div class="text-center mt-10">
                <a href="{{ route('about') }}" class="inline-flex items-center px-6 py-3 border border-red-600 text-base font-medium rounded-md text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    Meet Our Full Team
                    <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section - Updated to white background for clean look -->
    <section class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                    Testimonials
                </span>
                <h2 class="text-3xl font-bold text-gray-900">What our clients say</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Don't just take our word for it. Hear from our satisfied clients about their experience with our services.
                </p>
            </div>

            <div class="relative">
                <div class="testimonial-carousel flex overflow-x-auto pb-8 space-x-6 snap-x scrollbar-hide">
                    @if($feedback->count() > 0)
                        @foreach($feedback as $testimonial)
                            <div class="flex-shrink-0 w-full sm:w-80 md:w-96 snap-start">
                                <div class="bg-gray-50 p-6 rounded-xl shadow-md h-full flex flex-col">
                                    @if($testimonial->rating)
                                        <div class="flex text-yellow-400 mb-3">
                                            @for($i = 0; $i < $testimonial->rating; $i++)
                                                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                            @for($i = $testimonial->rating; $i < 5; $i++)
                                                <svg class="h-5 w-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endfor
                                        </div>
                                    @endif
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $testimonial->title }}</h3>
                                    <p class="text-gray-600 mb-4 flex-grow">{{ Str::limit($testimonial->content, 150) }}</p>
                                    <div class="flex items-center border-t border-gray-200 pt-4">
                                        <div class="bg-gray-100 rounded-full w-10 h-10 flex items-center justify-center">
                                            <span class="text-gray-600 font-medium">{{ substr($testimonial->user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-gray-900 font-medium">{{ $testimonial->user->name }}</p>
                                            <p class="text-gray-500 text-sm">{{ $testimonial->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="flex-shrink-0 w-full sm:w-80 md:w-96">
                            <div class="bg-gray-50 p-6 rounded-xl shadow-md h-full">
                                <div class="flex text-yellow-400 mb-3">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Exceptional Service</h3>
                                <p class="text-gray-600 mb-4">The team was professional, efficient, and delivered beyond our expectations. Our kitchen renovation was completed on time and on budget.</p>
                                <div class="flex items-center border-t border-gray-200 pt-4">
                                    <div class="bg-gray-100 rounded-full w-10 h-10 flex items-center justify-center">
                                        <span class="text-gray-600 font-medium">J</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-gray-900 font-medium">John Smith</p>
                                        <p class="text-gray-500 text-sm">May 1, 2025</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full sm:w-80 md:w-96">
                            <div class="bg-gray-50 p-6 rounded-xl shadow-md h-full">
                                <div class="flex text-yellow-400 mb-3">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Highly Recommended</h3>
                                <p class="text-gray-600 mb-4">I couldn't be happier with the bathroom renovation. The attention to detail and quality of work was outstanding.</p>
                                <div class="flex items-center border-t border-gray-200 pt-4">
                                    <div class="bg-gray-100 rounded-full w-10 h-10 flex items-center justify-center">
                                        <span class="text-gray-600 font-medium">A</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-gray-900 font-medium">Alice Johnson</p>
                                        <p class="text-gray-500 text-sm">April 24, 2025</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full sm:w-80 md:w-96">
                            <div class="bg-gray-50 p-6 rounded-xl shadow-md h-full">
                                <div class="flex text-yellow-400 mb-3">
                                    @for($i = 0; $i < 4; $i++)
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                    <svg class="h-5 w-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Great Experience</h3>
                                <p class="text-gray-600 mb-4">The team was professional and responsive throughout our home renovation project. Would use their services again.</p>
                                <div class="flex items-center border-t border-gray-200 pt-4">
                                    <div class="bg-gray-100 rounded-full w-10 h-10 flex items-center justify-center">
                                        <span class="text-gray-600 font-medium">R</span>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-gray-900 font-medium">Robert Davis</p>
                                        <p class="text-gray-500 text-sm">April 18, 2025</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Navigation Arrows -->
                <button class="testimonial-prev absolute top-1/2 -translate-y-1/2 -left-4 w-12 h-12 rounded-full bg-white shadow-lg flex items-center justify-center text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 z-10 hidden md:flex">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="testimonial-next absolute top-1/2 -translate-y-1/2 -right-4 w-12 h-12 rounded-full bg-white shadow-lg flex items-center justify-center text-gray-800 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500 z-10 hidden md:flex">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('feedback') }}" class="inline-flex items-center px-6 py-3 border border-red-600 text-base font-medium rounded-md text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                    View All Testimonials
                    <svg class="ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
</x-app-layout>

<!-- JavaScript for Testimonial Carousel -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.querySelector('.testimonial-carousel');
        const prevButton = document.querySelector('.testimonial-prev');
        const nextButton = document.querySelector('.testimonial-next');
        
        if (carousel && prevButton && nextButton) {
            const slideWidth = carousel.querySelector('div').offsetWidth;
            const scrollAmount = slideWidth + 24; // Width + gap
            
            nextButton.addEventListener('click', function() {
                carousel.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            });
            
            prevButton.addEventListener('click', function() {
                carousel.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            });
        }
    });
</script>