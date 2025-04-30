<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Feedback Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium">All User Feedback</h3>
                        
                        <div class="flex items-center space-x-2">
                            <span class="text-sm text-gray-600">Filter:</span>
                            <a href="?filter=pending" class="px-3 py-1 text-sm rounded-full {{ !request('filter') || request('filter') == 'pending' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Pending Approval
                            </a>
                            <a href="?filter=approved" class="px-3 py-1 text-sm rounded-full {{ request('filter') == 'approved' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                Approved
                            </a>
                            <a href="?filter=all" class="px-3 py-1 text-sm rounded-full {{ request('filter') == 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                                All
                            </a>
                        </div>
                    </div>

                    @if($feedback->count() > 0)
                        <div class="space-y-6">
                            @foreach($feedback as $item)
                                <div class="bg-white shadow overflow-hidden sm:rounded-lg border {{ $item->is_approved ? 'border-green-200' : 'border-yellow-200' }}">
                                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center {{ $item->is_approved ? 'bg-green-50' : 'bg-yellow-50' }}">
                                        <div>
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $item->title }}</h3>
                                            <div class="mt-1 flex items-center">
                                                <p class="text-sm text-gray-500 mr-4">
                                                    By: {{ $item->user->name }} ({{ $item->user->email }})
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $item->created_at->format('M d, Y') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            @if($item->is_approved)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Approved
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @endif
                                            
                                            <a href="{{ route('admin.feedback.show', $item->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                    <div class="border-t border-gray-200">
                                        <div class="px-4 py-5 sm:p-6">
                                            @if($item->rating)
                                                <div class="flex text-yellow-400 mb-3">
                                                    @for($i = 0; $i < $item->rating; $i++)
                                                        <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    @endfor
                                                    @for($i = $item->rating; $i < 5; $i++)
                                                        <svg class="h-5 w-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    @endfor
                                                </div>
                                            @endif
                                            
                                            <p class="text-gray-700">{{ Str::limit($item->content, 300) }}</p>
                                            
                                            <div class="mt-4 flex justify-end space-x-3">
                                                @if(!$item->is_approved)
                                                    <form action="{{ route('admin.feedback.approve', $item->id) }}" method="POST" class="inline-block">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                            Approve
                                                        </button>
                                                    </form>
                                                @endif
                                                
                                                <form action="{{ route('admin.feedback.destroy', $item->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this feedback?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $feedback->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No feedback found</h3>
                            <p class="mt-1 text-sm text-gray-500">No user has submitted any feedback yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>