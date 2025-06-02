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
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">{{ $update->title }}</h3>
                        <p class="mt-2 text-sm text-gray-500">Posted on {{ $update->created_at->format('F d, Y') }}</p>
                    </div>

                    @if($update->progress !== null)
                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-2">Project Progress</h4>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $update->progress }}%"></div>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">{{ $update->progress }}% Complete</p>
                    </div>
                    @endif

                    <div class="mb-6">
                        <h4 class="text-md font-medium text-gray-700 mb-2">Update Description</h4>
                        <p class="text-gray-600 whitespace-pre-wrap">{{ $update->description }}</p>
                    </div>

                    @if($update->images->count() > 0)
                    <div class="mt-8">
                        <h4 class="text-md font-medium text-gray-700 mb-4">Progress Images</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($update->images as $image)
                            <div class="relative">
                                <img src="{{ Storage::url($image->image_path) }}" alt="Progress Image" class="w-full h-48 object-cover rounded-lg">
                                @if($image->description)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600">{{ $image->description }}</p>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>