<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedback = Auth::user()->feedback()->latest()->paginate(10);
        return view('user.feedback.index', compact('feedback'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        Feedback::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_approved' => false,
        ]);

        return redirect()->route('user.feedback.index')
            ->with('success', 'Feedback submitted successfully. It will be visible once approved.');
    }
}