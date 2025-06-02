@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Document Management') }}
                    </h2>
                    
                    <!-- Search Form -->
                    <form action="{{ route('admin.documents.index') }}" method="GET" class="flex items-center space-x-2">
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}" 
                                   placeholder="Search users..." 
                                   class="w-64 rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            @if(request('search'))
                                <a href="{{ route('admin.documents.index') }}" 
                                   class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Search
                        </button>
                    </form>
                </div>
                
                @if($users->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($users as $user)
                            <div class="bg-white rounded-lg shadow-sm border p-4 hover:shadow-md transition-shadow">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $user->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                        </div>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $user->role === 'lawyer' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                    <div class="mt-2 space-y-1">
                                        <div class="text-xs text-gray-500">
                                            <span>Documents: {{ $user->documents->count() }}</span>
                                        </div>
                                        @if($user->role === 'user' && $user->userDetails->isNotEmpty())
                                            @foreach($user->userDetails as $detail)
                                                <div class="text-xs">
                                                    <span class="text-gray-600">Service:</span>
                                                    <span class="font-medium text-gray-900">{{ $detail->service->title }}</span>
                                                </div>
                                                <div class="text-xs">
                                                    <span class="text-gray-600">Payment Type:</span>
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ $detail->payment_type === 'cash' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800' }}">
                                                        {{ $detail->payment_type === 'cash' ? 'Cash' : 'Bank Loan' }}
                                                    </span>
                                                </div>
                                            @endforeach
                                        @elseif($user->role === 'user')
                                            <div class="text-xs text-gray-500 italic">No service or payment type assigned</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 mt-4">
                                    <a href="{{ route('admin.documents.user', $user->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View
                                    </a>
                                    <form action="{{ route('admin.documents.create') }}" method="GET">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Add Document
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No users found</h3>
                        <p class="mt-1 text-sm text-gray-500">No users match your search criteria.</p>
                    </div>
                @endif

                <!-- Recent Document Activity -->
                <div class="mt-6">
                    <h3 class="text-lg font-medium mb-4">Recent Document Activity</h3>
                    
                    @php
                        $recentDocuments = \App\Models\Document::with('user')->latest()->take(5)->get();
                    @endphp
                    
                    @if($recentDocuments->count() > 0)
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Document</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentDocuments as $document)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $document->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $document->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $document->title }}</div>
                                                <div class="text-xs text-gray-500">
                                                    @if($document->requires_signature)
                                                        <span class="text-orange-600">Requires Signature</span>
                                                    @else
                                                        <span class="text-green-600">Information Only</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($document->status === 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @elseif($document->status === 'approved')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Approved</span>
                                                @elseif($document->status === 'rejected')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rejected</span>
                                                @elseif($document->status === 'view_only')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">View Only</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $document->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.documents.show', $document->id) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No recent document activity.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection