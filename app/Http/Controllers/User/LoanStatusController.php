<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoanStatusController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get the latest user detail with bank_loan payment type
        $userDetail = $user->userDetails()
            ->where('payment_type', 'bank_loan')
            ->latest()
            ->first();
        
        if ($userDetail) {
            $loanStatus = $user->loanStatus;
            return view('user.loan-status', compact('loanStatus'));
        }

        // If not a bank loan user, show access denied message
        return view('user.loan-status', ['accessDenied' => true]);
    }
} 