@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Project Update') }}
    </h2>
    <a href="{{ route('admin.updates.show', $update->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        Back to Update Details
    </a>
</div>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form method="POST" action="{{ route('admin.updates.update', $update->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <x-input-label for="title" :value="__('Update Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $update->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="description" :value="__('Update Description')" />
                        <textarea id="description" name="description" rows="4" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>{{ old('description', $update->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="progress" :value="__('Progress Percentage')" />
                        <div class="flex items-center">
                            <x-text-input 
                                id="progress" 
                                class="block mt-1 w-24" 
                                type="number" 
                                name="progress" 
                                :value="old('progress', $update->progress)" 
                                min="0" 
                                max="100" 
                                placeholder="0"
                            />
                            <span class="ml-2 text-gray-600">%</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Enter a value between 0 and 100</p>
                        <x-input-error :messages="$errors->get('progress')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button>
                            {{ __('Update') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection