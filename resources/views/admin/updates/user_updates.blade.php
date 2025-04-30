<!-- resources/views/admin/updates/user_updates.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Project Updates for') }} {{ $user->name }}
            </h2>
            <div class="flex space-x-2">
                <form action="{{ route('admin.updates.create') }}" method="GET">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add New Update
                    </button>
                </form>
                <a href="{{ route('admin.updates.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Users
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $user->email }}</p>
                                <p class="text-xs text-gray-500 mt-1">Joined: {{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">Total Updates: {{ $updates->total() }}</p>
                            </div>
                        </div>
                    </div>

                    @if($updates->count() > 0)
                        <div class="space-y-6">
                            @foreach($updates as $update)
                                <div class="bg-white shadow overflow-hidden sm:rounded-lg border">
                                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                                        <div>
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $update->title }}</h3>
                                            <p class="mt-1 text-sm text-gray-500">
                                                Created: {{ $update->created_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.updates.show', $update->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                                View Details
                                            </a>
                                            <a href="{{ route('admin.updates.edit', $update->id) }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.updates.destroy', $update->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-medium" onclick="return confirm('Are you sure you want to delete this update? All images will be permanently removed.')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="border-t border-gray-200">
                                        <div class="px-4 py-5 sm:p-6">
                                            <p class="text-sm text-gray-700">{{ Str::limit($update->description, 150) }}</p>
                                            
                                            @if($update->images->count() > 0)
                                                <div class="mt-4 flex space-x-3 overflow-auto">
                                                    @foreach($update->images as $image)
                                                        <div class="flex-shrink-0 w-24 h-24">
                                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Update image" class="w-full h-full object-cover rounded-md">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <p class="mt-2 text-xs text-gray-500">{{ $update->images->count() }} {{ Str::plural('image', $update->images->count()) }}</p>
                                            @else
                                                <p class="mt-2 text-xs text-gray-500">No images</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $updates->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No updates</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new project update for this user.</p>
                            <div class="mt-6">
                                <form action="{{ route('admin.updates.create') }}" method="GET" class="inline-block">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Add New Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>