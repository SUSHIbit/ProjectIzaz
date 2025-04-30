<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Back Button -->
                    <div class="mb-6">
                        <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 active:bg-gray-400 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Bookings
                        </a>
                    </div>

                    <!-- Booking Information -->
                    <div class="bg-gray-50 p-6 rounded-lg mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Client Information</h3>
                                <p class="mb-2"><span class="font-semibold">Name:</span> {{ $booking->user->name }}</p>
                                <p class="mb-2"><span class="font-semibold">Email:</span> {{ $booking->user->email }}</p>
                                <p class="mb-2"><span class="font-semibold">Phone:</span> {{ $booking->user->phone ?? 'N/A' }}</p>
                            </div>
                            
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Booking Information</h3>
                                <p class="mb-2"><span class="font-semibold">Service:</span> {{ $booking->service }}</p>
                                <p class="mb-2"><span class="font-semibold">Title:</span> {{ $booking->title }}</p>
                                <p class="mb-2"><span class="font-semibold">Date:</span> {{ $booking->booking_date->format('F d, Y') }}</p>
                                <p class="mb-2"><span class="font-semibold">Time:</span> {{ $booking->booking_time }}</p>
                                <p class="mb-2">
                                    <span class="font-semibold">Status:</span> 
                                    @if($booking->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($booking->status == 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @elseif($booking->status == 'rejected')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($booking->notes)
                            <div class="mt-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Additional Notes</h3>
                                <div class="bg-white p-4 rounded border border-gray-200">
                                    <p>{{ $booking->notes }}</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Update Status Form -->
                    <div class="bg-white p-6 rounded-lg border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Update Booking Status</h3>
                        
                        <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <div class="flex space-x-4">
                                    <div class="flex items-center">
                                        <input id="status-pending" name="status" type="radio" value="pending" {{ $booking->status == 'pending' ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="status-pending" class="ml-2 block text-sm text-gray-700">Pending</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="status-approved" name="status" type="radio" value="approved" {{ $booking->status == 'approved' ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="status-approved" class="ml-2 block text-sm text-gray-700">Approved</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="status-rejected" name="status" type="radio" value="rejected" {{ $booking->status == 'rejected' ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="status-rejected" class="ml-2 block text-sm text-gray-700">Rejected</label>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                                <textarea id="admin_notes" name="admin_notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $booking->admin_notes }}</textarea>
                                <p class="mt-1 text-sm text-gray-500">Add any notes about this booking (optional). These notes are only visible to administrators.</p>
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Update Status
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>