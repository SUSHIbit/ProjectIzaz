<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PaymentItem;
use Illuminate\Http\Request;

class PaymentTypeController extends Controller
{
    /**
     * Display a listing of users with their payment types.
     */
    public function index()
    {
        $users = User::where('role', 'user')
            ->with(['paymentItems' => function ($query) {
                $query->latest();
            }])
            ->get();

        return view('admin.payment-types.index', compact('users'));
    }

    /**
     * Update the payment type for a user's payment item.
     */
    public function update(Request $request, PaymentItem $payment)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,bank_loan',
        ]);

        // Only allow updating payment method if the payment is pending
        if ($payment->status !== 'pending') {
            return redirect()->back()
                ->with('error', 'Payment method can only be changed for pending payments.');
        }

        $payment->update([
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->back()
            ->with('success', 'Payment method updated successfully.');
    }
} 