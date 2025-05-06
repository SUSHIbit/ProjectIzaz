<x-user-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Welcome, {{ Auth::user()->name }}</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Quick Stats -->
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <h4 class="font-medium text-gray-700 mb-2">My Bookings</h4>
                    <p class="text-3xl font-bold text-blue-600">{{ Auth::user()->bookings()->count() }}</p>
                    <a href="{{ route('user.bookings.index') }}" class="text-sm text-blue-500 hover:underline">View All Bookings →</a>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <h4 class="font-medium text-gray-700 mb-2">Documents</h4>
                    <p class="text-3xl font-bold text-orange-600">{{ Auth::user()->documents()->count() }}</p>
                    <a href="{{ route('user.documents.index') }}" class="text-sm text-blue-500 hover:underline">View Documents →</a>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg shadow">
                    <h4 class="font-medium text-gray-700 mb-2">Project Updates</h4>
                    <p class="text-3xl font-bold text-green-600">{{ Auth::user()->updates()->count() }}</p>
                    <a href="{{ route('user.updates.index') }}" class="text-sm text-blue-500 hover:underline">View Updates →</a>
                </div>
                
                <!-- Quick Links -->
                <div class="md:col-span-3 mt-6">
                    <h4 class="font-medium text-gray-700 mb-4">Quick Actions</h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <a href="{{ route('user.services.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white rounded-lg p-4 text-center transition">
                            <span class="block font-medium">Book a Service</span>
                        </a>
                        
                        <a href="{{ route('user.payments.index') }}" class="bg-green-500 hover:bg-green-600 text-white rounded-lg p-4 text-center transition">
                            <span class="block font-medium">View Payments</span>
                        </a>
                        
                        <a href="{{ route('user.feedback.create') }}" class="bg-purple-500 hover:bg-purple-600 text-white rounded-lg p-4 text-center transition">
                            <span class="block font-medium">Submit Feedback</span>
                        </a>
                        
                        <a href="{{ route('user.documents.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg p-4 text-center transition">
                            <span class="block font-medium">Check Documents</span>
                        </a>
                    </div>
                </div>
                
                <!-- Recent Updates -->
                <div class="md:col-span-3 mt-6">
                    <h4 class="font-medium text-gray-700 mb-4">Recent Project Updates</h4>
                    <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <div class="divide-y divide-gray-200">
                            @foreach(Auth::user()->updates()->latest()->take(3)->get() as $update)
                                <div class="p-4">
                                    <h5 class="font-medium text-gray-900">{{ $update->title }}</h5>
                                    <p class="text-sm text-gray-500 mt-1">{{ \Illuminate\Support\Str::limit($update->description, 150) }}</p>
                                    <div class="mt-2">
                                        <a href="{{ route('user.updates.show', $update->id) }}" class="text-sm text-blue-500 hover:underline">View Details →</a>
                                    </div>
                                </div>
                            @endforeach

                            @if(Auth::user()->updates()->count() == 0)
                                <div class="p-4 text-center text-sm text-gray-500">
                                    No updates available yet
                                </div>
                            @endif
                        </div>
                    </div>
                    @if(Auth::user()->updates()->count() > 3)
                        <div class="mt-4">
                            <a href="{{ route('user.updates.index') }}" class="text-sm text-blue-500 hover:underline">View All Updates →</a>
                        </div>
                    @endif
                </div>

                <!-- Pending Documents -->
                <div class="md:col-span-3 mt-6">
                    <h4 class="font-medium text-gray-700 mb-4">Documents Requiring Action</h4>
                    <div class="bg-white shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date Added</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(Auth::user()->documents()->where('status', '!=', 'approved')->latest()->take(5)->get() as $document)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $document->title }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($document->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Needs Signature</span>
                                            @elseif($document->status == 'signed')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Under Review</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $document->created_at->format('M d, Y') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('user.documents.show', $document->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                        </td>
                                    </tr>
                                @endforeach

                                @if(Auth::user()->documents()->where('status', '!=', 'approved')->count() == 0)
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            No documents requiring action
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-user-layout>