<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Welcome to the Admin Dashboard</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Quick Stats -->
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="font-medium text-gray-700 mb-2">Services</h4>
                            <p class="text-3xl font-bold text-blue-600">{{ \App\Models\Service::count() }}</p>
                            <a href="{{ route('admin.services.index') }}" class="text-sm text-blue-500 hover:underline">Manage Services →</a>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="font-medium text-gray-700 mb-2">Pending Bookings</h4>
                            <p class="text-3xl font-bold text-orange-600">{{ \App\Models\Booking::where('status', 'pending')->count() }}</p>
                            <a href="{{ route('admin.bookings.index') }}" class="text-sm text-blue-500 hover:underline">View Bookings →</a>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg shadow">
                            <h4 class="font-medium text-gray-700 mb-2">Users</h4>
                            <p class="text-3xl font-bold text-green-600">{{ \App\Models\User::where('role', 'user')->count() }}</p>
                        </div>
                        
                        <!-- Quick Links -->
                        <div class="md:col-span-3 mt-6">
                            <h4 class="font-medium text-gray-700 mb-4">Quick Actions</h4>
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <a href="{{ route('admin.services.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg p-4 text-center transition">
                                    <span class="block font-medium">Add New Service</span>
                                </a>
                                
                                <a href="{{ route('admin.portfolio.create') }}" class="bg-green-500 hover:bg-green-600 text-white rounded-lg p-4 text-center transition">
                                    <span class="block font-medium">Add Portfolio Project</span>
                                </a>
                                
                                <a href="{{ route('admin.team.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white rounded-lg p-4 text-center transition">
                                    <span class="block font-medium">Add Team Member</span>
                                </a>
                                
                                <a href="{{ route('admin.feedback.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg p-4 text-center transition">
                                    <span class="block font-medium">Review Feedback</span>
                                </a>
                            </div>
                        </div>
                        
                        <!-- Recent Bookings -->
                        <div class="md:col-span-3 mt-6">
                            <h4 class="font-medium text-gray-700 mb-4">Recent Booking Requests</h4>
                            <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach(\App\Models\Booking::with(['service', 'user'])->latest()->take(5)->get() as $booking)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $booking->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $booking->email }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $booking->service->title }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">{{ $booking->booking_date->format('M d, Y') }}</div>
                                                    <div class="text-sm text-gray-500">{{ date('g:i A', strtotime($booking->preferred_time)) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($booking->status == 'pending')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                    @elseif($booking->status == 'approved')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                                    @else
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if(\App\Models\Booking::count() == 0)
                                            <tr>
                                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                                    No bookings found
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('admin.bookings.index') }}" class="text-sm text-blue-500 hover:underline">View All Bookings →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>