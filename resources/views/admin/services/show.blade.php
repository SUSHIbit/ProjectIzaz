<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Service Details') }}
            </h2>
            <div>
                <a href="{{ route('admin.services.edit', $service->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                    Edit Service
                </a>
                <a href="{{ route('admin.services.availability', $service->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Manage Availability
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row">
                        <div class="md:w-1/3 p-4">
                            <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="w-full h-auto rounded-lg shadow">
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
                                
                                @if($service->availabilities->count() > 0)
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @foreach($service->availabilities->sortBy(function ($availability) {
                                            $days = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7];
                                            return $days[$availability->day_of_week];
                                        }) as $availability)
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
                                    <p class="text-gray-500">No availability has been set for this service.</p>
                                @endif
                                
                                <div class="mt-4">
                                    <a href="{{ route('admin.services.availability', $service->id) }}" class="text-blue-600 hover:underline">Manage Availability →</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>