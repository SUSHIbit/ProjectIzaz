@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Document Details') }}
                    </h2>
                    <a href="{{ route('admin.documents.user', $document->user_id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Back to User Documents
                    </a>
                </div>
                
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
                                    @elseif($document->status === 'view_only')
                                        <p class="text-base font-medium text-gray-600">View Only</p>
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
                            
                            <div class="mb-6">
                                <span class="block text-base font-semibold mb-2">Document</span>
                                <div class="flex space-x-3">
                                    <a href="{{ asset('storage/' . $document->file_path) }}" target="_blank" class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md text-sm shadow transition">
                                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m9 2a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11z"/></svg>
                                        VIEW DOCUMENT
                                    </a>
                                    @if($document->signed_file_path)
                                        <p class="text-xs text-gray-500 mb-2">Signed file path: {{ $document->signed_file_path }}</p>
                                        <a href="{{ asset('storage/' . $document->signed_file_path) }}" target="_blank" class="inline-flex items-center px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md text-sm shadow transition">
                                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m9 2a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11z"/></svg>
                                            VIEW SIGNED DOCUMENT
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            @if($document->signDocuments->count())
                                <div class="mt-8">
                                    <h4 class="text-lg font-medium mb-4">Signed Documents</h4>
                                    <ul class="space-y-2">
                                        @foreach($document->signDocuments as $signDoc)
                                            <li class="flex items-center space-x-4">
                                                <span class="text-sm text-gray-700">Signed by: {{ optional($signDoc->user)->name ?? 'User ID: ' . $signDoc->user_id }}</span>
                                                <span class="text-xs text-gray-500">on {{ $signDoc->created_at->format('M d, Y H:i') }}</span>
                                                <a href="{{ asset('storage/' . $signDoc->file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md text-xs shadow transition">
                                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m9 2a2 2 0 01-2 2H6a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11z"/></svg>
                                                    VIEW SIGNED DOCUMENT
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="md:col-span-1">
                        @if($document->status === 'pending' || $document->status === 'signed')
                            <div class="mt-6 bg-white shadow sm:rounded-lg">
                                <div class="px-4 py-5 sm:p-6">
                                    <h3 class="text-lg font-medium leading-6 text-gray-900">Document Review</h3>
                                    
                                    @if($document->requires_signature && !$document->signDocuments->where('user_id', $document->user_id)->count())
                                        <div class="mt-2 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm text-yellow-700">
                                                        This document has not been signed by the user yet.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="mt-2 max-w-xl text-sm text-gray-500">
                                            <p>Review and take action on this document.</p>
                                        </div>
                                        <form method="POST" action="{{ route('admin.documents.status', $document->id) }}" class="mt-5 space-y-4">
                                            @csrf
                                            
                                            <div>
                                                <x-input-label for="status" :value="__('Document Status')" class="text-sm font-medium text-gray-700" />
                                                <select id="status" name="status" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm">
                                                    <option value="">Select an action...</option>
                                                    <option value="approved" class="text-green-700">✓ Approve Document</option>
                                                    <option value="rejected" class="text-red-700">✕ Reject Document</option>
                                                </select>
                                            </div>
                                            
                                            <div id="rejection_reason_container" class="hidden">
                                                <x-input-label for="rejection_reason" :value="__('Reason for Rejection')" class="text-sm font-medium text-gray-700" />
                                                <textarea id="rejection_reason" name="rejection_reason" rows="3" class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm"></textarea>
                                            </div>
                                            
                                            <div class="flex justify-end space-x-3">
                                                <x-primary-button class="bg-blue-600 hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800">
                                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ __('Submit Review') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if($document->status === 'rejected' && $document->rejection_reason)
                            <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                <h4 class="text-sm font-medium text-red-800">Rejection Reason</h4>
                                <p class="mt-1 text-sm text-red-700">{{ $document->rejection_reason }}</p>
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
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const rejectionReasonContainer = document.getElementById('rejection_reason_container');
        const rejectionReasonInput = document.getElementById('rejection_reason');

        statusSelect.addEventListener('change', function() {
            if (this.value === 'rejected') {
                rejectionReasonContainer.classList.remove('hidden');
                rejectionReasonInput.setAttribute('required', 'required');
            } else {
                rejectionReasonContainer.classList.add('hidden');
                rejectionReasonInput.removeAttribute('required');
            }
        });
    });
</script>
@endpush