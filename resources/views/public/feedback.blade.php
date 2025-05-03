<x-app-layout>
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-[400px]" style="background-image: url('https://images.unsplash.com/photo-1562654501-a0ccc0fc3fb1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="text-center mx-auto max-w-3xl">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
                    Client Testimonials
                </h1>
                <p class="mt-4 text-xl text-white">
                    See what our satisfied clients have to say about our home services.
                </p>
            </div>
        </div>
    </section>

    <!-- Featured Testimonials -->
    <section class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                    Featured Testimonials
                </span>
                <h2 class="text-3xl font-bold text-gray-900">Client Success Stories</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Discover what our clients have experienced working with us on their home improvement projects.
                </p>
            </div>

            @if($feedback->count() > 0)
                <!-- Featured Testimonial Carousel - Horizontal Scroll -->
                <div class="relative">
                    <div class="testimonial-carousel flex overflow-x-auto pb-8 space-x-6 snap-x scrollbar-hide">
                        @foreach($feedback->take(3) as $testimonial)
                            <div class="flex-shrink-0 w-full md:w-1/2 lg:w-1/3 snap-start">
                                <div class="bg-white p-8 rounded-2xl shadow-lg h-full flex flex-col border border-gray-100">
                                    @if($testimonial->rating)
                                        <div class="flex text-yellow-400 mb-4">
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
                                    <div class="mb-4">
                                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $testimonial->title }}</h3>
                                        <div class="relative">
                                            <svg class="absolute top-0 left-0 transform -translate-x-6 -translate-y-3 h-16 w-16 text-red-100" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                                <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                            </svg>
                                            <p class="relative text-lg text-gray-600 leading-relaxed">{{ Str::limit($testimonial->content, 200) }}</p>
                                        </div>
                                    </div>
                                    <div class="mt-auto flex items-center pt-4 border-t border-gray-100">
                                        <div class="bg-gray-100 rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0">
                                            <span class="text-gray-600 font-medium text-lg">{{ substr($testimonial->user->name, 0, 1) }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-gray-900 font-medium">{{ $testimonial->user->name }}</h4>
                                            <p class="text-gray-500 text-sm">{{ $testimonial->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Placeholder Testimonials -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="flex text-yellow-400 mb-4">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        <div class="mb-4">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Exceptional Service</h3>
                            <div class="relative">
                                <svg class="absolute top-0 left-0 transform -translate-x-6 -translate-y-3 h-16 w-16 text-red-100" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                </svg>
                                <p class="relative text-lg text-gray-600">The team was professional, efficient, and delivered beyond our expectations. Our kitchen renovation was completed on time and on budget.</p>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center pt-4 border-t border-gray-100">
                            <div class="bg-gray-100 rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0">
                                <span class="text-gray-600 font-medium text-lg">J</span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-gray-900 font-medium">John Smith</h4>
                                <p class="text-gray-500 text-sm">May 1, 2025</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="flex text-yellow-400 mb-4">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                        </div>
                        <div class="mb-4">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Highly Recommended</h3>
                            <div class="relative">
                                <svg class="absolute top-0 left-0 transform -translate-x-6 -translate-y-3 h-16 w-16 text-red-100" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                </svg>
                                <p class="relative text-lg text-gray-600">I couldn't be happier with the bathroom renovation. The attention to detail and quality of work was outstanding.</p>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center pt-4 border-t border-gray-100">
                            <div class="bg-gray-100 rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0">
                                <span class="text-gray-600 font-medium text-lg">A</span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-gray-900 font-medium">Alice Johnson</h4>
                                <p class="text-gray-500 text-sm">April 24, 2025</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                        <div class="flex text-yellow-400 mb-4">
                            @for($i = 0; $i < 4; $i++)
                                <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                </svg>
                            @endfor
                            <svg class="h-5 w-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </div>
                        <div class="mb-4">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Great Experience</h3>
                            <div class="relative">
                                <svg class="absolute top-0 left-0 transform -translate-x-6 -translate-y-3 h-16 w-16 text-red-100" fill="currentColor" viewBox="0 0 32 32" aria-hidden="true">
                                    <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                </svg>
                                <p class="relative text-lg text-gray-600">The team was professional and responsive throughout our home renovation project. Would use their services again.</p>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center pt-4 border-t border-gray-100">
                            <div class="bg-gray-100 rounded-full w-12 h-12 flex items-center justify-center flex-shrink-0">
                                <span class="text-gray-600 font-medium text-lg">R</span>
                            </div>
                            <div class="ml-4">
                                <h4 class="text-gray-900 font-medium">Robert Davis</h4>
                                <p class="text-gray-500 text-sm">April 18, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- All Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded mb-2">
                    All Testimonials
                </span>
                <h2 class="text-3xl font-bold text-gray-900">What Our Clients Say</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    Read through all of our client testimonials to see why our clients love working with us.
                </p>
            </div>

            @if($feedback->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($feedback as $testimonial)
                        <div class="bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="p-6">
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
                                <p class="text-gray-600 mb-4">{{ $testimonial->content }}</p>
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
                </div>
                
                <div class="mt-8">
                    {{ $feedback->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No Testimonials Yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Be the first to share your experience with our services.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Submit Feedback CTA -->
    <section class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gray-50 rounded-2xl shadow-md overflow-hidden">
                <div class="lg:flex">
                    <div class="lg:w-1/2 p-8 lg:p-12">
                        <h2 class="text-3xl font-bold text-gray-900 mb-4">Share Your Experience</h2>
                        <p class="text-lg text-gray-600 mb-8">
                            We value your feedback! Help us improve our services by sharing your experience with us.
                        </p>
                        
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 font-medium">Help others make informed decisions</p>
                                    <p class="text-gray-600 text-sm">Your feedback helps potential clients choose the right service.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3m0 0V11" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 font-medium">Help us improve</p>
                                    <p class="text-gray-600 text-sm">Your feedback helps us enhance our services.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 font-medium">Quick and easy</p>
                                    <p class="text-gray-600 text-sm">Submitting feedback takes just a minute of your time.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="lg:w-1/2 bg-red-600 text-white p-8 lg:p-12 flex flex-col justify-center">
                        <h3 class="text-2xl font-bold mb-4">Ready to share your feedback?</h3>
                        <p class="mb-8">
                            Create an account or log in to share your experience with our home services.
                        </p>
                        <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                            @auth
                                <a href="{{ route('user.feedback.create') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Submit Feedback
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-red-600 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Log In
                                </a>
                                <a href="{{ route('register') }}" class="inline-flex justify-center items-center px-6 py-3 border border-white rounded-md text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Create Account
                                </a>
                            @endauth
                        </div>
                    </div>
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