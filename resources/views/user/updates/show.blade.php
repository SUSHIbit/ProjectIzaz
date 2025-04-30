<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Project Update Details') }}
            </h2>
            <a href="{{ route('user.updates.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to Updates
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $update->title }}</h3>
                        
                        <div class="flex items-center text-sm text-gray-500 mb-6">
                            <svg class="h-5 w-5 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>{{ $update->created_at->format('F d, Y') }}</span>
                        </div>
                        
                        <div class="bg-gray-50 rounded-lg p-6 mb-8">
                            <h4 class="text-md font-medium text-gray-700 mb-4">Update Description</h4>
                            <div class="text-gray-700 whitespace-pre-line">{{ $update->description }}</div>
                        </div>
                    </div>
                    
                    @if($update->images->count() > 0)
                        <div class="mb-8">
                            <h4 class="text-lg font-medium mb-4">Project Images</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($update->images as $image)
                                    <div class="bg-white border rounded-lg overflow-hidden shadow-sm">
                                        <div class="aspect-video bg-gray-100">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Project image" class="w-full h-full object-cover">
                                        </div>
                                        @if($image->description)
                                            <div class="p-4">
                                                <p class="text-sm text-gray-700">{{ $image->description }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <a href="{{ route('user.updates.index') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            &larr; Back to all updates
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>