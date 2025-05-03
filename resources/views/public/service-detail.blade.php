<!-- resources/views/public/service-detail.blade.php -->
<x-app-layout>
    <!-- Updated to RED header from blue -->
    <section class="bg-red-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="flex items-center">
                <a href="{{ route('services') }}" class="text-white hover:text-red-200 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
                    {{ $service->title }}
                </h1>
            </div>
            <p class="mt-4 text-xl max-w-3xl">
                Estimated price: ${{ number_format($service->estimated_price, 2) }}
            </p>
        </div>
    </section>

    <!-- Rest of the content remains unchanged -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <div class="flex flex-col md:flex-row gap-8">
                    <div class="md:w-1/2">
                        <!-- Main Service Image -->
                        <div id="mainImage" class="w-full h-96 bg-gray-100 rounded-lg overflow-hidden mb-4">
                            @if($service->images->count() > 0)
                                <img src="{{ asset('storage/' . $service->images->first()->image_path) }}" alt="{{ $service->title }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        
                        <!-- Thumbnail Gallery -->
                        @if($service->images->count() > 1 || ($service->images->count() === 0 && $service->image_path))
                        <div class="grid grid-cols-5 gap-2">
                            @if($service->images->count() === 0 && $service->image_path)
                                <div class="thumbnail-image cursor-pointer h-20 bg-gray-100 rounded overflow-hidden" data-image="{{ asset('storage/' . $service->image_path) }}">
                                    <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="w-full h-full object-cover hover:opacity-75 transition-opacity">
                                </div>
                            @else
                                @foreach($service->images as $image)
                                <div class="thumbnail-image cursor-pointer h-20 bg-gray-100 rounded overflow-hidden" data-image="{{ asset('storage/' . $image->image_path) }}">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $service->title }}" class="w-full h-full object-cover hover:opacity-75 transition-opacity">
                                </div>
                                @endforeach
                            @endif
                        </div>
                        @endif
                    </div>
                    
                    <div class="md:w-1/2">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Service Description</h2>
                        <div class="prose max-w-none text-gray-700 mb-6">
                            {{ $service->description }}
                        </div>
                        
                        @if($service->additional_info)
                        <div class="bg-gray-50 p-4 rounded-lg mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Additional Information</h3>
                            <div class="prose max-w-none text-gray-700">
                                {{ $service->additional_info }}
                            </div>
                        </div>
                        @endif
                        
                        @if($availabilities->count() > 0)
                        <div class="border-t border-gray-200 pt-4 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Availability</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                                @foreach($availabilities as $availability)
                                    <div class="bg-gray-50 p-2 rounded">
                                        <span class="font-medium">{{ $availability->day_of_week }}:</span>
                                        {{ date('g:i A', strtotime($availability->start_time)) }} - 
                                        {{ date('g:i A', strtotime($availability->end_time)) }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <div class="mt-8">
                            @auth
                                <a href="{{ route('user.bookings.create', $service->id) }}" class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    Book Now
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    Login to Book
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                
                <div class="mt-10 pt-6 border-t border-gray-200">
                    <a href="{{ route('services') }}" class="inline-flex items-center text-red-600 hover:text-red-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Services
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>