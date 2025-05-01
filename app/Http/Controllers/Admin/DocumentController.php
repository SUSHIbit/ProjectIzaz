<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.documents.index', compact('users'));
    }

    /**
     * Display documents for a specific user.
     */
    public function userDocuments(User $user)
    {
        if ($user->role !== 'user') {
            return redirect()->route('admin.documents.index')
                ->with('error', 'You can only manage documents for users.');
        }

        $documents = $user->documents()->latest()->paginate(10);
        return view('admin.documents.user_documents', compact('user', 'documents'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        
        if ($user->role !== 'user') {
            return redirect()->route('admin.documents.index')
                ->with('error', 'You can only add documents for users.');
        }
        
        return view('admin.documents.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Log incoming request for debugging
            \Log::info('Document upload request received', [
                'has_file' => $request->hasFile('document'), 
                'all' => $request->all()
            ]);
            
            // Validate the request
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'document' => 'required|file|mimes:pdf|max:10240', // 10MB max
                'requires_signature' => 'nullable', // Changed from 'sometimes|boolean'
            ]);
            
            \Log::info('Validation passed');

            $user = User::findOrFail($request->user_id);
            if ($user->role !== 'user') {
                return redirect()->route('admin.documents.index')
                    ->with('error', 'You can only add documents for users.');
            }
            
            // Check if file exists and is valid
            if (!$request->hasFile('document') || !$request->file('document')->isValid()) {
                \Log::error('Document file missing or invalid');
                return redirect()->back()
                    ->with('error', 'The document file is missing or invalid. Please try again.')
                    ->withInput();
            }
            
            // Store the file
            try {
                $file = $request->file('document');
                $fileName = $file->getClientOriginalName();
                $fileSize = $file->getSize();
                
                \Log::info('Attempting to store file', [
                    'name' => $fileName,
                    'size' => $fileSize
                ]);
                
                $filePath = $file->store('documents', 'public');
                \Log::info('File stored successfully at: ' . $filePath);
                
                // Create database record
                $document = Document::create([
                    'user_id' => $request->user_id,
                    'title' => $request->title,
                    'file_path' => $filePath,
                    'requires_signature' => $request->has('requires_signature'), // Simple boolean conversion
                    'status' => 'pending',
                ]);
                
                \Log::info('Document record created with ID: ' . $document->id);
                
                return redirect()->route('admin.documents.user', $request->user_id)
                    ->with('success', 'Document uploaded successfully');
            } catch (\Exception $e) {
                \Log::error('File storage error: ' . $e->getMessage(), ['exception' => $e]);
                return redirect()->back()
                    ->with('error', 'Failed to save the document file. Error: ' . $e->getMessage())
                    ->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error during document upload', ['errors' => $e->errors()]);
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('Unexpected error during document upload: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()
                ->with('error', 'An unexpected error occurred: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        return view('admin.documents.show', compact('document'));
    }

    /**
     * Update the document status.
     */
    public function updateStatus(Request $request, Document $document)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $document->update([
            'status' => $request->status,
        ]);

        return redirect()->route('admin.documents.show', $document->id)
            ->with('success', 'Document status updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        $userId = $document->user_id;
        
        // Delete the document file
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