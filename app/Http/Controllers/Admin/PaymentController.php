<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.payments.index', compact('users'));
    }

    /**
     * Display payments for a specific user.
     */
    public function userPayments(User $user)
    {
        if ($user->role !== 'user') {
            return redirect()->route('admin.payments.index')
                ->with('error', 'You can only manage payments for users.');
        }

        $payments = $user->paymentItems()->latest()->paginate(10);
        return view('admin.payments.user_payments', compact('user', 'payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        
        if ($user->role !== 'user') {
            return redirect()->route('admin.payments.index')
                ->with('error', 'You can only add payment items for users.');
        }
        
        return view('admin.payments.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);

        $user = User::findOrFail($request->user_id);
        if ($user->role !== 'user') {
            return redirect()->route('admin.payments.index')
                ->with('error', 'You can only add payment items for users.');
        }

        PaymentItem::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'price' => $request->price,
            'status' => 'pending',
        ]);

        return redirect()->route('admin.payments.user', $request->user_id)
            ->with('success', 'Payment item added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentItem $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Update the document status.
     */
    public function updateStatus(Request $request, PaymentItem $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,verified',
        ]);

        $payment->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.payments.show', $payment->id)
            ->with('success', 'Payment status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentItem $payment)
    {
        $userId = $payment->user_id;
        
        // Delete receipt if exists
        if ($payment->receipt_path) {
            Storage::disk('public')->delete($payment->receipt_path);
        }
        
        $payment->delete();

        return redirect()->route('admin.payments.user', $userId)
            ->with('success', 'Payment item deleted successfully');
    }
}