<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\PaymentItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function index()
    {
        // Get all pending bank loan payments
        $payments = PaymentItem::where('payment_method', 'bank_loan')
            ->where('status', 'pending')
            ->with(['user'])
            ->latest()
            ->paginate(10);

        return view('lawyer.payments.index', compact('payments'));
    }
    
    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('lawyer.payments.create', compact('users'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'required|string',
            'receipt' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        
        $receiptPath = $request->file('receipt')->store('receipts', 'public');
        
        Payment::create([
            'user_id' => $request->user_id,
            'lawyer_id' => auth()->id(),
            'amount' => $request->amount,
            'description' => $request->description,
            'receipt_path' => $receiptPath,
            'status' => 'pending',
        ]);
        
        return redirect()->route('lawyer.payments.index')
            ->with('success', 'Payment receipt has been sent to the user.');
    }
    
    public function uploadReceipt(Request $request, PaymentItem $payment)
    {
        // Verify this is a bank loan payment
        if ($payment->payment_method !== 'bank_loan') {
            return redirect()->back()->with('error', 'This payment is not a bank loan payment.');
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

            return redirect()->route('lawyer.payments.index')
                ->with('success', 'Bank loan receipt uploaded successfully. Waiting for admin verification.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload receipt. Please try again.');
        }
    }

    public function show(PaymentItem $payment)
    {
        // Only allow viewing bank loan payments
        if ($payment->payment_method !== 'bank_loan') {
            abort(404);
        }

        return view('lawyer.payments.show', compact('payment'));
    }
} 