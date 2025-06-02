<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payments') }}
            </h2>
            <a href="{{ route('lawyer.payments.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                Create New Payment
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($payments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Receipt</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $payment->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $payment->user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">${{ number_format($payment->amount, 2) }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">{{ Str::limit($payment->description, 50) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if($payment->status === 'pending')
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                        Pending Payment
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
                                                    <a href="{{ Storage::url($payment->receipt_path) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                                        View Bank Loan Receipt
                                                    </a>
                                                @else
                                                    <span class="text-gray-500">No receipt uploaded</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $payment->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <div class="flex space-x-3">
                                                    <a href="{{ route('lawyer.payments.show', $payment) }}" class="text-blue-600 hover:text-blue-900">
                                                        View Details
                                                    </a>
                                                    @if($payment->status === 'pending')
                                                        <form action="{{ route('lawyer.payments.receipt', $payment->id) }}" method="POST" enctype="multipart/form-data" class="inline-block" id="uploadForm-{{ $payment->id }}">
                                                            @csrf
                                                            <input type="file" name="receipt" id="receipt-{{ $payment->id }}" class="hidden" accept="image/*,.pdf" onchange="previewFile({{ $payment->id }})">
                                                            <button type="button" onclick="document.getElementById('receipt-{{ $payment->id }}').click()" class="text-green-600 hover:text-green-900">
                                                            Upload Bank Loan Receipt
                                                        </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $payments->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No payments</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating a new payment.</p>
                            <div class="mt-6">
                                <a href="{{ route('lawyer.payments.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Create Payment
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
            <div class="px-6 py-4 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">
                        Review Receipt
                    </h3>
                    <button type="button" onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="px-6 py-4">
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">Please review the receipt before submitting:</p>
                    <div id="previewContent" class="mt-4">
                        <!-- Preview content will be inserted here -->
                    </div>
                </div>
            </div>
            
            <div class="px-6 py-4 bg-gray-50 text-right">
                <button type="button" onclick="closePreviewModal()" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-2">
                    Cancel
                </button>
                <button type="button" onclick="submitPreviewedFile()" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Confirm & Submit
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentPaymentId = null;
        let currentFile = null;
            
        function previewFile(paymentId) {
            const fileInput = document.getElementById('receipt-' + paymentId);
            const file = fileInput.files[0];
            
            if (!file) return;
            
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                fileInput.value = '';
                return;
            }
            
            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please upload a valid image (JPEG, PNG, GIF) or PDF file');
                fileInput.value = '';
                return;
            }
            
            currentPaymentId = paymentId;
            currentFile = file;
            
            const previewContent = document.getElementById('previewContent');
            previewContent.innerHTML = ''; // Clear previous preview
            
            if (file.type.startsWith('image/')) {
                // For images, show the image preview
                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.className = 'max-h-96 mx-auto object-contain';
                img.alt = 'Receipt preview';
                previewContent.appendChild(img);
            } else if (file.type === 'application/pdf') {
                // For PDFs, show a PDF preview
                const embed = document.createElement('embed');
                embed.src = URL.createObjectURL(file);
                embed.type = 'application/pdf';
                embed.className = 'w-full h-96';
                previewContent.appendChild(embed);
            }
            
            // Show the preview modal
            document.getElementById('previewModal').classList.remove('hidden');
                }
        
        function closePreviewModal() {
            document.getElementById('previewModal').classList.add('hidden');
            if (currentPaymentId) {
                document.getElementById('receipt-' + currentPaymentId).value = '';
            }
            currentPaymentId = null;
            currentFile = null;
        }
        
        function submitPreviewedFile() {
            if (!currentPaymentId || !currentFile) return;
            
            const form = document.getElementById('uploadForm-' + currentPaymentId);
            form.submit();
        }
    </script>
</x-app-layout> 