<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>
<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Bookings</h3>
        
        @if($bookings->count() > 0)
            <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Service
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings->take(5) as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $booking->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->service->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->title }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->booking_date instanceof \DateTime ? $booking->booking_date->format('M d, Y') : date('M d, Y', strtotime($booking->booking_date)) }}</div>
                                    <div class="text-sm text-gray-500">{{ date('g:i A', strtotime($booking->preferred_time)) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($booking->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Pending
                                        </span>
                                    @elseif($booking->status == 'approved')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Approved
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Rejected
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.bookings.index') }}" class="text-blue-600 hover:text-blue-800">View All Bookings →</a>
            </div>
        @else
            <div class="text-center py-4">
                <p class="text-gray-500">No bookings found.</p>
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            <div class="bg-white overflow-hidden shadow rounded-lg border">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ \App\Models\User::where('role', 'user')->count() }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <a href="{{ route('admin.documents.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">View all users</a>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg border">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Total Services</dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ \App\Models\Service::count() }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <a href="{{ route('admin.services.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">View all services</a>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow rounded-lg border">
                <div class="px-4 py-5 sm:p-6">
                    <dt class="text-sm font-medium text-gray-500 truncate">Pending Messages</dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">{{ \App\Models\Message::where('sender_role', 'user')->where('is_read', false)->count() }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-4 sm:px-6">
                    <a href="{{ route('admin.chat.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">View chat messages</a>
                </div>
            </div>
        </div>
    </div>
</div>
</x-admin-layout>