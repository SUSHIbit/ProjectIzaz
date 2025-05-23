<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents for the authenticated user.
     */
    public function index()
    {
        $documents = Auth::user()->documents()->latest()->paginate(10);
        return view('user.documents.index', compact('documents'));
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document)
    {
        // Ensure the document belongs to the authenticated user
        if ($document->user_id !== Auth::id()) {
            return redirect()->route('user.documents.index')
                ->with('error', 'You do not have permission to view this document.');
        }

        return view('user.documents.show', compact('document'));
    }

    /**
     * Upload a signed version of the document.
     */
    public function uploadSigned(Request $request, Document $document)
    {
        // Ensure the document belongs to the authenticated user
        if ($document->user_id !== Auth::id()) {
            return redirect()->route('user.documents.index')
                ->with('error', 'You do not have permission to upload to this document.');
        }

        // Ensure the document requires signature
        if (!$document->requires_signature) {
            return redirect()->route('user.documents.show', $document->id)
                ->with('error', 'This document does not require a signature.');
        }

        $request->validate([
            'signed_document' => 'required|mimes:pdf|max:10240', // 10MB max
        ]);

        // Delete the old signed file if exists
        if ($document->signed_file_path) {
            Storage::disk('public')->delete($document->signed_file_path);
        }

        $filePath = $request->file('signed_document')->store('documents/signed', 'public');

        $document->update([
            'signed_file_path' => $filePath,
            'status' => 'signed',
        ]);

        return redirect()->route('user.documents.show', $document->id)
            ->with('success', 'Signed document uploaded successfully. It will be reviewed by the admin.');
    }
}