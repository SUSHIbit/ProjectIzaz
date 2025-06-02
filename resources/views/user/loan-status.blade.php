@extends('layouts.user')

@section('content')
<div class="py-12">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h2 class="text-2xl font-bold mb-4">Loan Status</h2>
                
                @if(isset($accessDenied))
                    <div class="text-center py-8">
                        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-red-700">
                                        You don't have access to this page. Only users with bank loan payment type can access this page.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($loanStatus)
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Status</h3>
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                {{ $loanStatus->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($loanStatus->status) }}
                            </span>
                        </div>

                        @if($loanStatus->remarks)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Remarks</h3>
                                <p class="mt-1 text-gray-600">{{ $loanStatus->remarks }}</p>
                            </div>
                        @endif

                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Last Updated</h3>
                            <p class="mt-1 text-gray-600">{{ $loanStatus->updated_at->format('F j, Y g:i A') }}</p>
                        </div>
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-600">Your loan status is pending. Please wait for the lawyer to review your application.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection 