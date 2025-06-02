<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lawyer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recent Documents -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Documents</h3>
                            <a href="{{ route('lawyer.documents.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        @if($recentDocuments->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentDocuments as $document)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $document->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ Str::limit($document->description, 100) }}</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $document->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                {{ ucfirst($document->status) }}
                                            </span>
                                        </div>
                                        <a href="{{ route('lawyer.documents.show', $document->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                            View
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">No recent documents.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Payments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">Recent Payments</h3>
                            <div class="flex space-x-4">
                                <a href="{{ route('lawyer.payments.create') }}" class="text-sm text-green-600 hover:text-green-800">Create New</a>
                                <a href="{{ route('lawyer.payments.index') }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                            </div>
                        </div>
                        @if($recentPayments->count() > 0)
                            <div class="space-y-4">
                                @foreach($recentPayments as $payment)
                                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                        <div>
                                            <h4 class="font-medium text-gray-900">${{ number_format($payment->amount, 2) }}</h4>
                                            <p class="text-sm text-gray-600">{{ $payment->user->name }}</p>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </div>
                                        <a href="{{ route('lawyer.payments.show', $payment->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                            View
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-600">No recent payments.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 