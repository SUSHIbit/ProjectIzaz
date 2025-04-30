<!-- resources/views/user/updates/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Project Updates') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($updates->count() > 0)
                        <div class="space-y-6">
                            @foreach($updates as $update)
                                <div class="bg-white shadow overflow-hidden sm:rounded-lg border">
                                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                                        <div>
                                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $update->title }}</h3>
                                            <p class="mt-1 text-sm text-gray-500">{{ $update->created_at->format('F d, Y') }}</p>
                                        </div>
                                        <div>
                                            <a href="{{ route('user.updates.show', $update->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                View Update
                                            </a>
                                        </div>
                                    </div>
                                    <div class="border-t border-gray-200">
                                        <div class="px-4 py-5 sm:p-6">
                                            <p class="text-sm text-gray-700">{{ Str::limit($update->description, 200) }}</p>
                                            
                                            @if($update->images->count() > 0)
                                                <div class="mt-4 flex space-x-3 overflow-auto">
                                                    @foreach($update->images->take(4) as $image)
                                                        <div class="flex-shrink-0 w-24 h-24">
                                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Update image" class="w-full h-full object-cover rounded-md">
                                                        </div>
                                                    @endforeach
                                                    @if($update->images->count() > 4)
                                                        <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded-md flex items-center justify-center">
                                                            <span class="text-sm text-gray-600">+{{ $update->images->count() - 4 }} more</span>
                                                        </div>
                                                    @endif
                                                </div>
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
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No Updates Yet</h3>
                            <p class="mt-1 text-sm text-gray-500">Check back later for updates on your project. The admin will post progress updates here.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>