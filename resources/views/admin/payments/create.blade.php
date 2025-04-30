<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Add Payment Item for') }} {{ $user->name }}
            </h2>
            <a href="{{ route('admin.payments.user', $user->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Back to User Payments
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.payments.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">

                        <div class="mb-6">
                            <x-input-label for="title" :value="__('Payment Title')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" required autofocus placeholder="e.g. Consultation Fee, Down Payment, etc." />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="price" :value="__('Amount ($)')" />
                            <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" step="0.01" min="0" required placeholder="0.00" />
                            <x-input-error :messages="$errors->get('price')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button>
                                {{ __('Create Payment Item') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Payment Guidelines</h3>
                    <div class="space-y-4 text-sm text-gray-600">
                        <p>
                            <span class="font-medium">Clear Title:</span> Use descriptive titles for payment items so users understand what they're paying for.
                        </p>
                        <p>
                            <span class="font-medium">Exact Amount:</span> Specify the exact amount required for the payment.
                        </p>
                        <p>
                            <span class="font-medium">Follow Up:</span> After creating a payment item, users will be able to see it in their dashboard and upload payment receipts.
                        </p>
                        <p>
                            <span class="font-medium">Verification:</span> Once a user uploads a receipt, you'll need to verify it to complete the payment process.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>