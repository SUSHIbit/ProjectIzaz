@extends('layouts.admin')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Payment Item Details') }}
                    </h2>
                    <a href="{{ route('admin.payments.user', $payment->user_id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Back to User Payments
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $payment->title }}</h3>
                        
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <div class="flex justify-between">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">User</h4>
                                    <p class="text-base font-medium text-gray-900">{{ $payment->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $payment->user->email }}</p>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Payment Status</h4>
                                    @if($payment->status === 'pending')
                                        <p class="text-base font-medium text-yellow-600">Pending</p>
                                    @elseif($payment->status === 'paid')
                                        <p class="text-base font-medium text-blue-600">Paid</p>
                                    @elseif($payment->status === 'verified')
                                        <p class="text-base font-medium text-green-600">Verified</p>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-500">Created On</h4>
                                <p class="text-base text-gray-900">{{ $payment->created_at->format('F d, Y') }}</p>
                            </div>
                            
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-500">Amount</h4>
                                <p class="text-xl font-bold text-gray-900">${{ number_format($payment->price, 2) }}</p>
                            </div>
                        </div>
                        
                        @if($payment->receipt_path)
                            <div class="mt-6 mb-6">
                                <h4 class="text-lg font-medium mb-4">Payment Receipt</h4>
                                <div class="bg-gray-100 rounded-lg overflow-hidden shadow-sm">
                                    <img src="{{ asset('storage/' . $payment->receipt_path) }}" alt="Payment Receipt" class="w-full max-h-96 object-contain">
                                </div>
                                <div class="flex justify-center mt-4">
                                    <a href="{{ asset('storage/' . $payment->receipt_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                        </svg>
                                        View Full Receipt
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="mt-6 mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">No Receipt Uploaded</h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>The user has not uploaded a receipt for this payment yet.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <div class="md:col-span-1">
                        @if($payment->receipt_path && $payment->status === 'paid')
                            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                                <h4 class="text-lg font-medium mb-4">Verify Payment</h4>
                                <p class="text-sm text-gray-600 mb-6">Update the status of this payment after reviewing the receipt.</p>
                                
                                <form method="POST" action="{{ route('admin.payments.status', $payment->id) }}">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <x-input-label for="status" :value="__('Update Status')" />
                                        <select id="status" name="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                            <option value="verified">Verify Payment</option>
                                            <option value="pending">Reject Receipt</option>
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
                            <h4 class="text-lg font-medium mb-4">Payment Actions</h4>
                            
                            <div class="space-y-4">
                                <form method="POST" action="{{ route('admin.payments.destroy', $payment->id) }}" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" onclick="return confirm('Are you sure you want to delete this payment item?')">
                                        <svg class="h-4 w-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        Delete Payment Item
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