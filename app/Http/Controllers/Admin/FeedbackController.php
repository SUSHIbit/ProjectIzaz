<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedback = Feedback::with('user')->latest()->paginate(10);
        return view('admin.feedback.index', compact('feedback'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Feedback $feedback)
    {
        return view('admin.feedback.show', compact('feedback'));
    }

    /**
     * Approve feedback to be displayed publicly.
     */
    public function approve(Feedback $feedback)
    {
        $feedback->update(['is_approved' => true]);
        
        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback approved successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feedback $feedback)
    {
        $feedback->delete();
        
        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback deleted successfully');
    }
}