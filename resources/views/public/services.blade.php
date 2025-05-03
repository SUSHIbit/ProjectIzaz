<x-app-layout>
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-[400px]" style="background-image: url('https://images.unsplash.com/photo-1613545325278-f24b0cae1224?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80');">
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>
        <div class="relative max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
            <div class="text-center mx-auto max-w-3xl">
                <h1 class="text-4xl font-bold tracking-tight text-white sm:text-5xl md:text-6xl">
                    Our Services
                </h1>
                <p class="mt-4 text-xl text-white">
                    Discover the comprehensive range of home services we offer to enhance your property.
                </p>
            </div>
        </div>
    </section>

    <!-- Services Grid Section -->
    <section class="py-16 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">Transform Your Home</h2>
                <p class="mt-4 text-lg text-gray-600 max-w-3xl mx-auto">
                    From renovations to repairs, we have the expertise to make your vision a reality. Browse our services below.
                </p>
            </div>

            @if($services->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($services as $service)
                        <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105">
                            </div>
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-xl font-bold text-gray-900">{{ $service->title }}</h3>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        ${{ number_format($service->estimated_price, 2) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-4">{{ Str::limit($service->description, 120) }}</p>
                                <div class="mt-6 flex justify-end">
                                    <a href="{{ route('service.detail', $service->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        View Service
                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-12">
                    {{ $services->links() }}
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-2xl">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No Services Available</h3>
                    <p class="mt-2 text-base text-gray-500">Check back later for new services.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gray-50 py-16">
        <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-red-600 rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-12 md:p-12 md:flex md:items-center md:justify-between">
                    <div class="max-w-3xl">
                        <h2 class="text-3xl font-bold tracking-tight text-white">
                            Ready to transform your home?
                        </h2>
                        <p class="mt-3 text-lg text-red-100">
                            Contact us today for a free consultation and quote. Our professional team is ready to help you bring your vision to life.
                        </p>
                    </div>
                    <div class="mt-8 md:mt-0 md:ml-8 md:flex-shrink-0">
                        <a href="#" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-red-600 bg-white hover:bg-red-50">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>