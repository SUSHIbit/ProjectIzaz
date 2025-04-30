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
        $payments = Auth::user()->paymentItems()->latest()->paginate(10);
        return view('user.payments.index', compact('payments'));
    }

    /**
     * Upload a receipt for the payment item.
     */
    public function uploadReceipt(Request $request, PaymentItem $paymentItem)
    {
        // Ensure the payment item belongs to the authenticated user
        if ($paymentItem->user_id !== Auth::id()) {
            return redirect()->route('user.payments.index')
                ->with('error', 'You do not have permission to upload to this payment item.');
        }

        $request->validate([
            'receipt' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Delete the old receipt if exists
        if ($paymentItem->receipt_path) {
            Storage::disk('public')->delete($paymentItem->receipt_path);
        }

        $filePath = $request->file('receipt')->store('receipts', 'public');

        $paymentItem->update([
            'receipt_path' => $filePath,
            'status' => 'paid',
        ]);

        return redirect()->route('user.payments.index')
            ->with('success', 'Receipt uploaded successfully. It will be reviewed by the admin.');
    }
}