<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Document Details') }}
            </h2>
            <a href="{{ route('admin.documents.user', $document->user_id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to User Documents
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2">
                            <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $document->title }}</h3>
                            
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <div class="flex justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">User</h4>
                                        <p class="text-base font-medium text-gray-900">{{ $document->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $document->user->email }}</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Document Status</h4>
                                        @if($document->status === 'pending')
                                            <p class="text-base font-medium text-yellow-600">Pending</p>
                                        @elseif($document->status === 'signed')
                                            <p class="text-base font-medium text-blue-600">Signed</p>
                                        @elseif($document->status === 'approved')
                                            <p class="text-base font-medium text-green-600">Approved</p>
                                        @elseif($document->status === 'rejected')
                                            <p class="text-base font-medium text-red-600">Rejected</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-500">Upload Date</h4>
                                    <p class="text-base text-gray-900">{{ $document->created_at->format('F d, Y') }}</p>
                                </div>
                                
                                <div class="mt-4">
                                    <h4 class="text-sm font-medium text-gray-500">Document Type</h4>
                                    @if($document->requires_signature)
                                        <p class="text-base text-orange-600">Requires Signature</p>
                                    @else
                                        <p class="text-base text-green-600">Information Only</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <h4 class="text-lg font-medium mb-4">Original Document</h4>
                                
                                <div class="mb-4">
                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd" />
                                        </svg>
                                        View Document
                                    </a>
                                </div>
                                
                                @if($document->signed_file_path)
                                    <div class="mt-8">
                                        <h4 class="text-lg font-medium mb-4">Signed Document</h4>
                                        <div class="mb-4">
                                            <a href="{{ asset('storage/' . $document->signed_file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                View Signed Document
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="md:col-span-1">
                            @if($document->status === 'signed')
                                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                    <h4 class="text-lg font-medium mb-4">Review Signed Document</h4>
                                    <p class="text-sm text-gray-600 mb-6">Update the status of this document after reviewing the signed version.</p>
                                    
                                    <form method="POST" action="{{ route('admin.documents.status', $document->id) }}">
                                        @csrf
                                        
                                        <div class="mb-4">
                                            <x-input-label for="status" :value="__('Update Status')" />
                                            <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                                <option value="approved">Approve Document</option>
                                                <option value="rejected">Reject Document</option>
                                            </select>
                                        </div>
                                        
                                        <div class="flex justify-end">
                                            <x-primary-button>
                                                {{ __('Update Status') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            
                            <div class="mt-6 bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                <h4 class="text-lg font-medium mb-4">Document Actions</h4>
                                
                                <div class="space-y-4">
                                    <form method="POST" action="{{ route('admin.documents.destroy', $document->id) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this document?')">
                                            <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                            Delete Document
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>