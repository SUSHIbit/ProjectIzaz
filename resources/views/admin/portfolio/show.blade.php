<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Portfolio Project Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Edit Project
                </a>
                <a href="{{ route('admin.portfolio.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Portfolio
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $portfolio->title }}</h3>
                            
                            <div class="mb-6">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <svg class="h-5 w-5 mr-1 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="font-medium">Project Duration:</span>
                                    <span class="ml-1">{{ $portfolio->duration_days }} days</span>
                                </div>
                                
                                <h4 class="text-lg font-medium mb-2">Description</h4>
                                <div class="text-gray-700 whitespace-pre-line mb-4">{{ $portfolio->description }}</div>

                                @if($portfolio->extra_info)
                                    <h4 class="text-lg font-medium mb-2">Additional Information</h4>
                                    <div class="text-gray-700 whitespace-pre-line">{{ $portfolio->extra_info }}</div>
                                @endif
                            </div>
                            
                            <div class="flex items-center mt-6">
                                <form action="{{ route('admin.portfolio.destroy', $portfolio->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this project? All images will be permanently removed.')">
                                        Delete Project
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="md:col-span-1">
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                                <h4 class="text-lg font-medium mb-2">Project Details</h4>
                                <div class="text-sm space-y-2">
                                    <div>
                                        <span class="font-medium text-gray-600">Created:</span>
                                        <span class="text-gray-700">{{ $portfolio->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-600">Last Updated:</span>
                                        <span class="text-gray-700">{{ $portfolio->updated_at->format('M d, Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium text-gray-600">Number of Images:</span>
                                        <span class="text-gray-700">{{ $portfolio->images->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Project Images</h3>
                        <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Add / Manage Images
                        </a>
                    </div>
                    
                    @if($portfolio->images->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($portfolio->images as $image)
                                <div class="relative group rounded-lg overflow-hidden shadow-sm">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="Project image" class="w-full aspect-video object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 flex items-end justify-start p-3 transition-all duration-200">
                                        <form action="{{ route('admin.portfolio.images.destroy', $image->id) }}" method="POST" class="hidden group-hover:block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white bg-red-600 rounded-md px-2 py-1 text-xs hover:bg-red-700 focus:outline-none" onclick="return confirm('Are you sure you want to delete this image?')">
                                                Remove
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 bg-gray-50 rounded-lg">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No images</h3>
                            <p class="mt-1 text-sm text-gray-500">Add images to showcase this project.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.portfolio.edit', $portfolio->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Add Images
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>