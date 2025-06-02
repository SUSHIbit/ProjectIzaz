<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $recentDocuments = Document::where('lawyer_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();
            
        $recentPayments = Payment::where('lawyer_id', auth()->id())
            ->latest()
            ->take(5)
            ->get();
            
        return view('lawyer.dashboard', compact('recentDocuments', 'recentPayments'));
    }
} 