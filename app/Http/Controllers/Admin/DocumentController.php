<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.documents.index', compact('users'));
    }

    public function userDocuments(User $user)
    {
        $documents = $user->documents()->latest()->paginate(10);
        return view('admin.documents.user_documents', compact('user', 'documents'));
    }

    public function create(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        return view('admin.documents.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'document' => 'required|mimes:pdf|max:10240', // 10MB max
            'requires_signature' => 'boolean',
        ]);

        $filePath = $request->file('document')->store('documents', 'public');

        Document::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'file_path' => $filePath,
            'requires_signature' => $request->has('requires_signature'),
            'status' => 'pending',
        ]);

        return redirect()->route('admin.documents.user', $request->user_id)
            ->with('success', 'Document uploaded successfully');
    }

    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    public function updateStatus(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|in:pending,approved',
        ]);

        $document->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.documents.user', $document->user_id)
            ->with('success', 'Document status updated successfully');
    }

    public function destroy(Document $document)
    {
        $userId = $document->user_id;
        
        // Delete the file
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        // Delete the signed file if exists
        if ($document->signed_file_path) {
            Storage::disk('public')->delete($document->signed_file_path);
        }
        
        $document->delete();

        return redirect()->route('admin.documents.user', $userId)
            ->with('success', 'Document deleted successfully');
    }
}
