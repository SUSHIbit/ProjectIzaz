<x-app-layout>
    <!-- Hero Section with Background House Image -->
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

    <!-- Services Preview Section -->
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
                            <img src="{{ asset('storage/' . $services->first()->image_path) }}" alt="{{ $services->first()->title }}" class="w-full h-full object-cover">
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

    <!-- Portfolio Preview Section -->
    <section class="py-16 bg-gray-50">
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

    <!-- Team Preview Section -->
    <section class="py-16 bg-white">
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
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="aspect-square bg-gray-100 flex items-center justify-center">
                            <svg class="h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">John Doe</h3>
                            <p class="text-red-600 font-medium">CEO</p>
                            <p class="mt-2 text-gray-600 text-sm">Founder & Lead Designer</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="aspect-square bg-gray-100 flex items-center justify-center">
                            <svg class="h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">Jane Smith</h3>
                            <p class="text-red-600 font-medium">COO</p>
                            <p class="mt-2 text-gray-600 text-sm">Operations Manager</p>
                        </div>
                    </div>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden">
                        <div class="aspect-square bg-gray-100 flex items-center justify-center">
                            <svg class="h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900">Mike Johnson</h3>
                            <p class="text-red-600 font-medium">Lead Craftsman</p>
                            <p class="mt-2 text-gray-600 text-sm">20+ Years Experience</p>
                        </div>
                    </div>
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

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
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
                                <div class="bg-white p-6 rounded-xl shadow-md h-full flex flex-col">
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
                                    <div class="flex items-center border-t border-gray-100 pt-4">
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
                            <div class="bg-white p-6 rounded-xl shadow-md h-full">
                                <div class="flex text-yellow-400 mb-3">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Exceptional Service</h3>
                                <p class="text-gray-600 mb-4">The team was professional, efficient, and delivered beyond our expectations. Our kitchen renovation was completed on time and on budget.</p>
                                <div class="flex items-center border-t border-gray-100 pt-4">
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
                            <div class="bg-white p-6 rounded-xl shadow-md h-full">
                                <div class="flex text-yellow-400 mb-3">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">Highly Recommended</h3>
                                <p class="text-gray-600 mb-4">I couldn't be happier with the bathroom renovation. The attention to detail and quality of work was outstanding.</p>
                                <div class="flex items-center border-t border-gray-100 pt-4">
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
                            <div class="bg-white p-6 rounded-xl shadow-md h-full">
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
                                <div class="flex items-center border-t border-gray-100 pt-4">
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

    <!-- Contact Form Section -->
    <section class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:justify-between">
                <div class="lg:w-1/2 lg:pr-12 mb-12 lg:mb-0">
                    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                        Get In Touch
                    </span>
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Contact us for a free consultation</h2>
                    <p class="text-gray-600 mb-6 leading-relaxed">
                        Whether you're planning a complete home renovation or need a small repair, we're here to help. Reach out to us to discuss your project and get a free quote.
                    </p>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-gray-900 font-medium">Call us</p>
                                <p class="text-gray-600">(555) 123-4567</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-gray-900 font-medium">Email us</p>
                                <p class="text-gray-600">info@homeservices.com</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-gray-900 font-medium">Visit us</p>
                                <p class="text-gray-600">123 Main Street, Kuala Lumpur, Malaysia</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-red-600">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-red-600">
                            <span class="sr-only">Instagram</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="lg:w-1/2 bg-white rounded-2xl shadow-xl p-8">
                <form method="POST" action="#" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Your Name</label>
                        <input type="text" name="name" id="name" class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" required>
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" id="email" class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" required>
                    </div>
                    
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" name="phone" id="phone" class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">Your Message</label>
                        <textarea id="message" name="message" rows="4" class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500" required></textarea>
                    </div>
                    
                    <div>
                        <button type="submit" class="w-full inline-flex justify-center py-3 px-6 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

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
</x-app-layout>