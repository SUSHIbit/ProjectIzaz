@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <!-- Header Section -->
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            Upload Document for {{ $user->name }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">Add one or multiple documents for this user</p>
                    </div>
                    <a href="{{ route('admin.documents.user', $user->id) }}" 
                       class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:bg-gray-200 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Documents
                    </a>
                </div>

                <!-- Form Section -->
                <form method="POST" action="{{ route('admin.documents.bulkStore') }}" enctype="multipart/form-data" id="bulk-doc-form">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    
                    <div id="documents-wrapper">
                        <!-- Initial Document Group -->
                        <div class="document-group bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h5 class="text-lg font-semibold text-gray-800">Document #1</h5>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Document Title</label>
                                    <input type="text" name="documents[0][title]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category</label>
                                    <select name="documents[0][category]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        @foreach($categories as $key => $label)
                                            <option value="{{ $key }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
                                    <input type="date" name="documents[0][expiry_date]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea name="documents[0][description]" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Upload PDF Document</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="file-upload-0" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                    <span>Upload a file</span>
                                                    <input id="file-upload-0" name="documents[0][document]" type="file" class="sr-only" accept=".pdf" required onchange="updateFileName(this)">
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF up to 10MB</p>
                                            <p id="file-name-0" class="text-sm text-indigo-600 mt-2"></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-2 flex space-x-6">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="documents[0][requires_signature]" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label class="ml-2 block text-sm text-gray-700">Requires Signature</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" name="documents[0][is_required]" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label class="ml-2 block text-sm text-gray-700">Expiry Date is Required</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center space-x-4 mt-6">
                        <button type="button" id="add-doc-btn" class="inline-flex items-center px-4 py-2 bg-indigo-100 border border-transparent rounded-md font-semibold text-xs text-indigo-700 uppercase tracking-widest hover:bg-indigo-200 focus:bg-indigo-200 active:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add More Document
                        </button>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Upload Documents
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Simple counter for document index
let docIndex = 1;

// Function to update file name display
function updateFileName(input) {
    const fileName = input.files[0]?.name;
    const index = input.id.split('-').pop();
    const fileNameElement = document.getElementById(`file-name-${index}`);
    if (fileNameElement) {
        fileNameElement.textContent = fileName || '';
    }
}

// Function to add new document form
function addNewDocument() {
    const wrapper = document.getElementById('documents-wrapper');
    const newGroup = document.createElement('div');
    newGroup.classList.add('document-group', 'bg-white', 'border', 'border-gray-200', 'rounded-lg', 'shadow-sm', 'p-6', 'mb-6');
    
    newGroup.innerHTML = `
        <div class="flex items-center justify-between mb-4">
            <h5 class="text-lg font-semibold text-gray-800">Document #${docIndex + 1}</h5>
            <button type="button" class="remove-doc-btn bg-red-100 text-red-600 px-3 py-1 rounded-full text-sm font-medium hover:bg-red-200 transition-colors duration-200">
                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Document Title</label>
                <input type="text" name="documents[${docIndex}][title]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select name="documents[${docIndex}][category]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
                <input type="date" name="documents[${docIndex}][expiry_date]" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="documents[${docIndex}][description]" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
            </div>

            <div class="col-span-2">
                <label class="block text-sm font-medium text-gray-700">Upload PDF Document</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="file-upload-${docIndex}" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>Upload a file</span>
                                <input id="file-upload-${docIndex}" name="documents[${docIndex}][document]" type="file" class="sr-only" accept=".pdf" required onchange="updateFileName(this)">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF up to 10MB</p>
                        <p id="file-name-${docIndex}" class="text-sm text-indigo-600 mt-2"></p>
                    </div>
                </div>
            </div>

            <div class="col-span-2 flex space-x-6">
                <div class="flex items-center">
                    <input type="checkbox" name="documents[${docIndex}][requires_signature]" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label class="ml-2 block text-sm text-gray-700">Requires Signature</label>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="documents[${docIndex}][is_required]" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label class="ml-2 block text-sm text-gray-700">Expiry Date is Required</label>
                </div>
            </div>
        </div>
    `;
    
    wrapper.appendChild(newGroup);
    docIndex++;
}

// Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Add click event listener to the Add More Doc button
    const addButton = document.getElementById('add-doc-btn');
    if (addButton) {
        addButton.addEventListener('click', function(e) {
            e.preventDefault();
            addNewDocument();
        });
    }

    // Add click event listener for remove buttons
    const documentsWrapper = document.getElementById('documents-wrapper');
    if (documentsWrapper) {
        documentsWrapper.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-doc-btn') || e.target.closest('.remove-doc-btn')) {
                const button = e.target.classList.contains('remove-doc-btn') ? e.target : e.target.closest('.remove-doc-btn');
                button.closest('.document-group').remove();
            }
        });
    }
});
</script>
@endsection