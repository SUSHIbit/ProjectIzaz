<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Updates Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-6">Select a User to Manage Project Updates</h3>
                    
                    @if($users->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($users as $user)
                                <div class="bg-white rounded-lg shadow-sm border p-4 hover:shadow-md transition-shadow">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $user->name }}</h4>
                                            <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                            <div class="mt-2 text-xs text-gray-500">
                                                <span>Updates: {{ $user->updates->count() }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.updates.user', $user->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                View
                                            </a>
                                            <form action="{{ route('admin.updates.create') }}" method="GET">
                                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                <button type="submit" class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    Add Update
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-lg p-6 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No registered users</h3>
                            <p class="mt-1 text-sm text-gray-500">There are no registered users to provide updates for.</p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Recent Updates Activity</h3>
                    
                    @php
                        $recentUpdates = \App\Models\UserUpdate::with('user')
                                      ->latest()
                                      ->take(5)
                                      ->get();
                    @endphp
                    
                    @if($recentUpdates->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentUpdates as $update)
                                <div class="bg-white shadow overflow-hidden sm:rounded-lg border">
                                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                                        <div>
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $update->title }}</h3>
                                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                                For: {{ $update->user->name }} ({{ $update->user->email }})
                                            </p>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="text-sm text-gray-500 mr-4">{{ $update->created_at->format('M d, Y') }}</span>
                                            <a href="{{ route('admin.updates.show', $update->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                    <div class="border-t border-gray-200">
                                        <div class="px-4 py-5 sm:p-6">
                                            <p class="text-sm text-gray-700">{{ Str::limit($update->description, 150) }}</p>
                                            <div class="mt-4 flex space-x-2 overflow-auto">
                                                @foreach($update->images->take(3) as $image)
                                                    <div class="flex-shrink-0 w-20 h-20">
                                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Update image" class="w-full h-full object-cover rounded-md">
                                                    </div>
                                                @endforeach
                                                @if($update->images->count() > 3)
                                                    <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded-md flex items-center justify-center">
                                                        <span class="text-sm text-gray-500">+{{ $update->images->count() - 3 }} more</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">No recent updates activity.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>