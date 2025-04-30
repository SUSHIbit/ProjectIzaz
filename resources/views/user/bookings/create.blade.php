<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Book a Service') }}
            </h2>
            <a href="{{ route('user.services.show', $service->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Back to Service
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row mb-6">
                        <div class="md:w-1/4 p-4">
                            <img src="{{ asset('storage/' . $service->image_path) }}" alt="{{ $service->title }}" class="w-full h-auto rounded-lg shadow">
                        </div>
                        <div class="md:w-3/4 p-4">
                            <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $service->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ Str::limit($service->description, 200) }}</p>
                            <span class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">
                                Estimated Price: ${{ number_format($service->estimated_price, 2) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Booking Details</h3>
                        
                        <form method="POST" action="{{ route('user.bookings.store') }}">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="mb-4">
                                    <x-input-label for="title" :value="__('Booking Title/Subject')" />
                                    <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="e.g. Kitchen Renovation Consultation" />
                                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="name" :value="__('Your Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', Auth::user()->name)" required />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="email" :value="__('Email Address')" />
                                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', Auth::user()->email)" required />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="phone_number" :value="__('Phone Number')" />
                                    <x-text-input id="phone_number" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone_number')" required placeholder="e.g. (123) 456-7890" />
                                    <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="booking_date" :value="__('Preferred Date')" />
                                    <x-text-input id="booking_date" class="block mt-1 w-full" type="date" name="booking_date" :value="old('booking_date')" required min="{{ date('Y-m-d') }}" />
                                    <x-input-error :messages="$errors->get('booking_date')" class="mt-2" />
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="preferred_time" :value="__('Preferred Time')" />
                                    <x-text-input id="preferred_time" class="block mt-1 w-full" type="time" name="preferred_time" :value="old('preferred_time')" required />
                                    <x-input-error :messages="$errors->get('preferred_time')" class="mt-2" />
                                </div>
                            </div>
                            
                            @if($availabilities->count() > 0)
                                <div class="mt-4 mb-6">
                                    <h4 class="text-md font-medium text-gray-700 mb-2">Available Time Slots</h4>
                                    <div class="bg-gray-50 p-4 rounded-md">
                                        <p class="text-sm text-gray-600 mb-2">This service is available during the following hours:</p>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 text-sm">
                                            @foreach($availabilities->sortBy(function ($availability) {
                                                $days = ['Monday' => 1, 'Tuesday' => 2, 'Wednesday' => 3, 'Thursday' => 4, 'Friday' => 5, 'Saturday' => 6, 'Sunday' => 7];
                                                return $days[$availability->day_of_week];
                                            }) as $availability)
                                                <div>
                                                    <span class="font-medium">{{ $availability->day_of_week }}:</span>
                                                    {{ date('g:i A', strtotime($availability->start_time)) }} - 
                                                    {{ date('g:i A', strtotime($availability->end_time)) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="flex items-center justify-end mt-6">
                                <a href="{{ route('user.services.show', $service->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                    Cancel
                                </a>
                                <x-primary-button>
                                    {{ __('Submit Booking Request') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>