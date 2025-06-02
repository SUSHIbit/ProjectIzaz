<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PaymentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the payments for the authenticated user.
     */
    public function index()
    {
        $payments = auth()->user()->paymentItems()
            ->latest()
            ->paginate(10);

        return view('user.payments.index', compact('payments'));
    }

    public function uploadReceipt(Request $request, PaymentItem $payment)
    {
        // Verify the payment belongs to the authenticated user
        if ($payment->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Verify this is a cash payment
        if (!$payment->isCashPayment()) {
            return redirect()->back()->with('error', 'You can only upload receipts for cash payments. Bank loan receipts must be uploaded by the lawyer.');
        }

        // Verify the payment is pending
        if ($payment->status !== 'pending') {
            return redirect()->back()->with('error', 'This payment is not pending.');
        }

        $request->validate([
            'receipt' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:2048'
        ]);

        try {
            // Delete existing receipt if any
            if ($payment->receipt_path) {
                Storage::delete($payment->receipt_path);
            }

            // Store the new receipt
            $path = $request->file('receipt')->store('receipts', 'public');
            
            // Update payment status
            $payment->update([
                'receipt_path' => $path,
                'status' => 'paid' // Change status to paid when receipt is uploaded
            ]);

            return redirect()->route('user.payments.index')
                ->with('success', 'Payment receipt uploaded successfully. Waiting for admin verification.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload receipt. Please try again.');
        }
    }
}