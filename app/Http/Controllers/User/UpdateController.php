<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateController extends Controller
{
    /**
     * Display a listing of the updates for the authenticated user.
     */
    public function index()
    {
        $updates = Auth::user()->updates()->latest()->paginate(10);
        return view('user.updates.index', compact('updates'));
    }

    /**
     * Display the specified update.
     */
    public function show(UserUpdate $update)
    {
        // Ensure the update belongs to the authenticated user
        if ($update->user_id !== Auth::id()) {
            return redirect()->route('user.updates.index')
                ->with('error', 'You do not have permission to view this update.');
        }

        return view('user.updates.show', compact('update'));
    }
}