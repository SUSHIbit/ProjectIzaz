<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Document Details') }}
            </h2>
            <a href="{{ route('lawyer.documents.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                Back to Documents
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">{{ $document->title }}</h3>
                        <div class="mt-2 flex items-center space-x-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $document->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($document->status === 'signed' ? 'bg-blue-100 text-blue-800' : 
                                   ($document->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                   ($document->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))) }}">
                                {{ $document->status === 'signed' ? 'Awaiting Admin Review' : ucfirst($document->status) }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ $document->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>

                    @if($document->description)
                        <div class="prose max-w-none mb-6">
                            <p class="text-gray-600">{{ $document->description }}</p>
                        </div>
                    @endif

                    <div class="mt-8">
                        <div class="flex justify-end space-x-4">
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                View Document
                            </a>
                            <a href="{{ Storage::url($document->file_path) }}" download class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Download Document
                            </a>
                            
                            @if($document->requires_signature && !$document->signed_file_path)
                                <button type="button" onclick="document.getElementById('signatureModal').classList.remove('hidden')" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                    Sign Document
                                </button>
                            @endif
                        </div>
                    </div>

                    @if($document->status === 'rejected' && $document->rejection_reason)
                        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-red-800">Rejection Reason</h4>
                            <p class="mt-1 text-sm text-red-700">{{ $document->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Signature Modal -->
    @if($document->requires_signature && !$document->signed_file_path)
        <div id="signatureModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 hidden">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg p-6 max-w-lg w-full">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Sign Document</h3>
                    <form action="{{ route('lawyer.documents.sign', $document->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="signed_document" class="block text-sm font-medium text-gray-700">Upload Signed Document</label>
                            <input type="file" name="signed_document" id="signed_document" accept=".pdf" required class="mt-1 block w-full">
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" onclick="document.getElementById('signatureModal').classList.add('hidden')" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                Cancel
                            </button>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                                Upload Signature
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</x-app-layout> 