<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Payments') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Payment Summary</h3>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Total Payment Items</h4>
                                    <p class="text-2xl font-bold text-gray-900">{{ $payments->total() }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Amount Due</h4>
                                    <p class="text-2xl font-bold text-red-600">${{ number_format(Auth::user()->paymentItems()->where('status', 'pending')->sum('price'), 2) }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Amount Paid</h4>
                                    <p class="text-2xl font-bold text-green-600">${{ number_format(Auth::user()->paymentItems()->whereIn('status', ['paid', 'verified'])->sum('price'), 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($payments->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Payments Requiring Action</h3>
                            
                            @php
                                $pendingPayments = $payments->where('status', 'pending')
                                                           ->where('receipt_path', null);
                            @endphp
                            
                            @if($pendingPayments->count() > 0)
                                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($pendingPayments as $payment)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-medium text-gray-900">{{ $payment->title }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm font-bold text-red-600">${{ number_format($payment->price, 2) }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ $payment->created_at->format('M d, Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                        <button type="button" 
                                                                onclick="openUploadModal('{{ $payment->id }}', '{{ $payment->title }}', '{{ number_format($payment->price, 2) }}')" 
                                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                            Upload Receipt
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">No payments require your attention.</p>
                            @endif
                        </div>
                        
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">All Payments</h3>
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($payments as $payment)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">{{ $payment->title }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900">${{ number_format($payment->price, 2) }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($payment->status === 'pending')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                            Pending
                                                        </span>
                                                    @elseif($payment->status === 'paid')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Under Review
                                                        </span>
                                                    @elseif($payment->status === 'verified')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            Verified
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($payment->receipt_path)
                                                        <a href="{{ asset('storage/' . $payment->receipt_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View Receipt</a>
                                                    @else
                                                        <span class="text-gray-400">No Receipt</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $payment->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if(!$payment->receipt_path && $payment->status === 'pending')
                                                        <button type="button" 
                                                                onclick="openUploadModal('{{ $payment->id }}', '{{ $payment->title }}', '{{ number_format($payment->price, 2) }}')" 
                                                                class="text-indigo-600 hover:text-indigo-900">
                                                            Upload Receipt
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4">
                                {{ $payments->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No payment items</h3>
                            <p class="mt-1 text-sm text-gray-500">You don't have any payment items yet. Payment items will appear here once an admin adds them for you.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Upload Receipt Modal -->
    <div id="uploadModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Upload Payment Receipt</h3>
                    <button type="button" onclick="closeUploadModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="px-6 py-4">
                <div class="mb-4">
                    <p class="text-md text-gray-900 font-medium" id="paymentTitle"></p>
                    <p class="text-lg font-bold text-blue-600 mt-1" id="paymentAmount"></p>
                </div>

                <form id="receiptForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="receipt" class="block text-sm font-medium text-gray-700 mb-2">Upload Receipt Image</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="receipt" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="receipt" name="receipt" type="file" class="sr-only" accept="image/*" required>
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">
                                    PNG, JPG, GIF up to 2MB
                                </p>
                            </div>
                        </div>
                        <div id="preview-container" class="mt-4 hidden">
                            <img id="preview-image" class="h-48 mx-auto object-contain" alt="Receipt preview">
                        </div>
                    </div>
                </form>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="button" onclick="closeUploadModal()" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                    Cancel
                </button>
                <button type="button" onclick="submitForm()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Upload Receipt
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentPaymentId = null;
        
        function openUploadModal(paymentId, title, amount) {
            currentPaymentId = paymentId;
            document.getElementById('paymentTitle').textContent = title;
            document.getElementById('paymentAmount').textContent = '$' + amount;
            document.getElementById('uploadModal').classList.remove('hidden');
            document.getElementById('preview-container').classList.add('hidden');
            document.getElementById('receipt').value = '';
        }
        
        function closeUploadModal() {
            document.getElementById('uploadModal').classList.add('hidden');
            currentPaymentId = null;
        }
        
        function submitForm() {
            if (!currentPaymentId) return;
            
            const form = document.getElementById('receiptForm');
            const receiptInput = document.getElementById('receipt');
            
            if (!receiptInput.files || receiptInput.files.length === 0) {
                alert('Please select an image to upload');
                return;
            }
            
            // Set the form action dynamically
            form.action = '/user/payments/' + currentPaymentId + '/receipt';
            form.submit();
        }
        
        // Preview image before upload
        document.getElementById('receipt').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) {
                document.getElementById('preview-container').classList.add('hidden');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
                document.getElementById('preview-container').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        });
    </script>
</x-app-layout>