<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentItem;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.payments.index', compact('users'));
    }

    public function userPayments(User $user)
    {
        $payments = $user->paymentItems()->latest()->paginate(10);
        return view('admin.payments.user_payments', compact('user', 'payments'));
    }

    public function create(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        return view('admin.payments.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        PaymentItem::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'price' => $request->price,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.payments.user', $request->user_id)
            ->with('success', 'Payment item added successfully');
    }

    public function show(PaymentItem $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    public function update(Request $request, PaymentItem $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,verified',
        ]);

        $payment->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.payments.user', $payment->user_id)
            ->with('success', 'Payment status updated successfully');
    }

    public function destroy(PaymentItem $payment)
    {
        $userId = $payment->user_id;
        $payment->delete();

        return redirect()->route('admin.payments.user', $userId)
            ->with('success', 'Payment item deleted successfully');
    }
}