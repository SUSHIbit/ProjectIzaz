@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Service Details') }}
    </h2>
    <div class="flex space-x-2">
        <a href="{{ route('admin.services.edit', $service->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition">
            Edit Service
        </a>
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition">
            Back to Services
        </a>
    </div>
</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex flex-col md:flex-row md:space-x-6">
                    <div class="md:w-1/3 space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Main Image</h3>
                            <div class="mt-2 w-full h-64 border border-gray-200 rounded-md overflow-hidden">
                                <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="w-full h-full object-cover">
                            </div>
                        </div>
                        
                        @if($service->images->count() > 0)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Additional Images</h3>
                            <div class="mt-2 grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($service->images as $image)
                                <div class="w-full h-32 border border-gray-200 rounded-md overflow-hidden">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $service->title }}" class="w-full h-full object-cover">
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Actions</h3>
                            <div class="mt-2 flex flex-col space-y-2">
                                <a href="{{ route('admin.services.availability', $service->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition">
                                    Manage Availability
                                </a>
                                
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition">
                                    Edit Service
                                </a>
                                
                                <form method="POST" action="{{ route('admin.services.destroy', $service->id) }}" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition">
                                        Delete Service
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="md:w-2/3 mt-6 md:mt-0">
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Service Information</h3>
                            <dl class="mt-2 divide-y divide-gray-200">
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Title</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $service->title }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Estimated Price</dt>
                                    <dd class="text-sm font-medium text-gray-900">${{ number_format($service->estimated_price, 2) }}</dd>
                                </div>
                                <div class="py-3">
                                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $service->description }}</dd>
                                </div>
                                @if($service->additional_info)
                                <div class="py-3">
                                    <dt class="text-sm font-medium text-gray-500">Additional Information</dt>
                                    <dd class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $service->additional_info }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Availability Schedule</h3>
                            @if($service->availabilities->count() > 0)
                            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
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
                            <p class="mt-2 text-sm text-gray-500">No availability has been set for this service. <a href="{{ route('admin.services.availability', $service->id) }}" class="text-indigo-600 hover:text-indigo-500">Add availability</a></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection