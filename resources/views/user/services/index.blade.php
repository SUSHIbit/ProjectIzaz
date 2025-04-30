<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Available Services') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($services->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($services as $service)
                                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                    <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="w-full h-56 object-cover">
                                    <div class="p-6">
                                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $service->title }}</h3>
                                        <p class="text-gray-700 text-sm mb-4">{{ Str::limit($service->description, 100) }}</p>
                                        <div class="flex justify-between items-center">
                                            <span class="text-blue-600 font-bold">${{ number_format($service->estimated_price, 2) }}</span>
                                            <a href="{{ route('user.services.show', $service->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $services->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No Services Available</h3>
                            <p class="mt-1 text-sm text-gray-500">Check back later for new services.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>