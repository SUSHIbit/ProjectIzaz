<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LoanStatus;
use Illuminate\Http\Request;

class LoanStatusController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
            ->with('loanStatus')
            ->get();
        
        return view('lawyer.loan-status.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'remarks' => 'nullable|string|max:500'
        ]);

        $loanStatus = $user->loanStatus()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'status' => $request->status,
                'remarks' => $request->remarks,
                'updated_by' => auth()->id()
            ]
        );

        return redirect()->back()->with('success', 'Loan status updated successfully');
    }
} 