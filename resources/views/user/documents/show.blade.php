<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Document Details') }}
            </h2>
            <a href="{{ route('user.documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to Documents
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $document->title }}</h3>
                    
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        <div class="flex justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Document Type</h4>
                                @if($document->requires_signature)
                                    <p class="text-base text-orange-600">Requires Signature</p>
                                @else
                                    <p class="text-base text-green-600">Information Only</p>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Status</h4>
                                @if($document->status === 'pending')
                                    <p class="text-base font-medium text-yellow-600">Pending</p>
                                @elseif($document->status === 'signed')
                                    <p class="text-base font-medium text-blue-600">Awaiting Approval</p>
                                @elseif($document->status === 'approved')
                                    <p class="text-base font-medium text-green-600">Approved</p>
                                @elseif($document->status === 'rejected')
                                    <p class="text-base font-medium text-red-600">Rejected</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            <h4 class="text-sm font-medium text-gray-500">Received On</h4>
                            <p class="text-base text-gray-900">{{ $document->created_at->format('F d, Y') }}</p>
                        </div>
                        
                        @if($document->status === 'rejected')
                            <div class="mt-4 bg-red-50 border-l-4 border-red-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Document Needs Attention</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p>Your signed document was rejected. Please re-sign and re-upload.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="text-lg font-medium mb-4">Document</h4>
                        <div class="mb-4">
                            <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z" clip-rule="evenodd" />
                                </svg>
                                View Document
                            </a>
                            
                            <a href="{{ asset('storage/' . $document->file_path) }}" download class="ml-2 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                    
                    @if($document->signed_file_path)
                        <div class="mt-6 mb-6">
                            <h4 class="text-lg font-medium mb-4">Your Signed Document</h4>
                            <div class="mb-4">
                                <a href="{{ asset('storage/' . $document->signed_file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 011-1h2a1 1 0 110 2H9a1 1 0 01-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    View Signed Document
                                </a>
                                
                                <a href="{{ asset('storage/' . $document->signed_file_path) }}" download class="ml-2 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                            
                            @if($document->status === 'signed')
                                <div class="bg-blue-50 border-l-4 border-blue-400 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700">
                                                Your document is under review. We'll update you once it's approved.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    @if($document->requires_signature && ($document->status === 'pending' || $document->status === 'rejected'))
                        <div class="mt-8 bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
                            <h4 class="text-lg font-medium mb-4">Upload Signed Document</h4>
                            <p class="text-sm text-gray-600 mb-6">Please download the document, sign it, and upload the signed version:</p>
                            
                            <form method="POST" action="{{ route('user.documents.sign', $document->id) }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-6">
                                    <x-input-label for="signed_document" :value="__('Upload Signed PDF')" />
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="signed_document" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                    <span>Upload a file</span>
                                                    <input id="signed_document" name="signed_document" type="file" class="sr-only" accept=".pdf" required>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PDF up to 10MB
                                            </p>
                                        </div>
                                    </div>
                                    <div id="file-name" class="mt-2 text-sm text-gray-600"></div>
                                    <x-input-error :messages="$errors->get('signed_document')" class="mt-2" />
                                </div>
                                
                                <div class="flex items-center justify-end">
                                    <x-primary-button>
                                        {{ __('Upload Signed Document') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show file name when selected
        document.getElementById('signed_document')?.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                document.getElementById('file-name').textContent = `Selected file: ${fileName}`;
            } else {
                document.getElementById('file-name').textContent = '';
            }
        });
    </script>
</x-app-layout>