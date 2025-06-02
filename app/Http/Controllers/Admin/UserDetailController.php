<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Service;
use Illuminate\Http\Request;

class UserDetailController extends Controller
{
    /**
     * Display a listing of users with their details.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user')
            ->with(['userDetails.service']);

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%");
            });
        }

        $users = $query->get();
        $services = Service::all();
        $paymentTypes = UserDetail::getPaymentTypes();

        return view('admin.user-details.index', compact('users', 'services', 'paymentTypes'));
    }

    /**
     * Store or update user details.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'payment_type' => 'required|in:cash,bank_loan',
            'notes' => 'nullable|string',
        ]);

        UserDetail::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'service_id' => $request->service_id,
            ],
            [
                'payment_type' => $request->payment_type,
                'notes' => $request->notes,
            ]
        );

        return redirect()->route('admin.user-details.index')
            ->with('success', 'User details saved successfully.');
    }

    /**
     * Remove user details.
     */
    public function destroy(UserDetail $userDetail)
    {
        $userDetail->delete();
        return redirect()->route('admin.user-details.index')
            ->with('success', 'User details removed successfully.');
    }
} 