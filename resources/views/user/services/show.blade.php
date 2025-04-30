<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Service Details') }}
            </h2>
            <a href="{{ route('user.services.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Back to Services
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 p-4">
                            <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="w-full h-auto rounded-lg shadow">
                            
                            <div class="mt-6">
                                <a href="{{ route('user.bookings.create', $service->id) }}" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Book this Service
                                </a>
                            </div>
                        </div>
                        <div class="md:w-2/3 p-4">
                            <h3 class="text-2xl font-bold text-gray-800 mb-4">{{ $service->title }}</h3>
                            
                            <div class="mb-4">
                                <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
                                    Estimated Price: ${{ number_format($service->estimated_price, 2) }}
                                </span>
                            </div>
                            
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold mb-2">Description</h4>
                                <p class="text-gray-700 whitespace-pre-line">{{ $service->description }}</p>
                            </div>
                            
                            @if($service->additional_info)
                                <div class="mb-6">
                                    <h4 class="text-lg font-semibold mb-2">Additional Information</h4>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $service->additional_info }}</p>
                                </div>
                            @endif
                            
                            <div class="border-t border-gray-200 pt-4">
                                <h4 class="text-lg font-semibold mb-2">Availability</h4>
                                
                                @if($availabilities->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($availabilities as $availability)
                                            <div class="bg-gray-50 p-3 rounded-md">
                                                <div class="font-medium">{{ $availability->day_of_week }}</div>
                                                <div class="text-sm text-gray-600">
                                                    {{ date('g:i A', strtotime($availability->start_time)) }} - 
                                                    {{ date('g:i A', strtotime($availability->end_time)) }}
                                                </div>
                                                @if($availability->notes)
                                                    <div class="text-xs text-gray-500 mt-1">{{ $availability->notes }}</div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">No availability has been set for this service. Please contact us for more information.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
