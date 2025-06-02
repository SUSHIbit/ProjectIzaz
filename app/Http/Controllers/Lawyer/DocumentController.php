<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::where('lawyer_id', auth()->id())
            ->orWhere('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('lawyer.documents.index', compact('documents'));
    }
    
    public function show(Document $document)
    {
        if ($document->lawyer_id !== auth()->id() && $document->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('lawyer.documents.show', compact('document'));
    }

    public function sign(Request $request, Document $document)
    {
        if ($document->lawyer_id !== auth()->id() && $document->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$document->requires_signature) {
            return redirect()->back()->with('error', 'This document does not require a signature.');
        }

        if ($document->signed_file_path) {
            return redirect()->back()->with('error', 'This document has already been signed.');
        }

        $request->validate([
            'signed_document' => 'required|file|mimes:pdf|max:10240', // 10MB max
        ]);

        try {
            $file = $request->file('signed_document');
            $path = $file->store('signed_documents', 'public');

            $document->update([
                'signed_file_path' => $path,
                'status' => 'signed'
            ]);

            return redirect()->route('lawyer.documents.show', $document->id)
                ->with('success', 'Document signed successfully. Waiting for admin approval.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to upload signed document. Please try again.');
        }
    }
} 