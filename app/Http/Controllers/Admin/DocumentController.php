<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['user', 'lawyer'])
            ->with(['userDetails.service']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->get();
        return view('admin.documents.index', compact('users'));
    }

    /**
     * Display documents for a specific user.
     */
    public function userDocuments(User $user)
    {
        if (!in_array($user->role, ['user', 'lawyer'])) {
            return redirect()->route('admin.documents.index')
                ->with('error', 'You can only manage documents for users and lawyers.');
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
        
        if (!in_array($user->role, ['user', 'lawyer'])) {
            return redirect()->route('admin.documents.index')
                ->with('error', 'You can only add documents for users and lawyers.');
        }
        
        $categories = Document::CATEGORIES;
        
        return view('admin.documents.create', compact('user', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'title' => 'required|string|max:255',
                'category' => 'required|string|in:' . implode(',', array_keys(Document::CATEGORIES)),
                'description' => 'nullable|string',
                'document' => 'required|file|mimes:pdf|max:10240', // 10MB max
                'requires_signature' => 'nullable',
                'expiry_date' => 'nullable|date|after:today',
                'is_required' => 'nullable|boolean',
            ]);
            
            $user = User::findOrFail($request->user_id);
            if (!in_array($user->role, ['user', 'lawyer'])) {
                return redirect()->route('admin.documents.index')
                    ->with('error', 'You can only add documents for users and lawyers.');
            }
            
            if (!$request->hasFile('document') || !$request->file('document')->isValid()) {
                return redirect()->back()
                    ->with('error', 'The document file is missing or invalid. Please try again.')
                    ->withInput();
            }
            
            DB::beginTransaction();
            try {
                $file = $request->file('document');
                $fileName = $file->getClientOriginalName();
                $filePath = $file->store('documents', 'public');
                
                $document = Document::create([
                    'user_id' => $request->user_id,
                    'title' => $request->title,
                    'category' => $request->category,
                    'description' => $request->description,
                    'file_path' => $filePath,
                    'requires_signature' => $request->has('requires_signature'),
                    'expiry_date' => $request->expiry_date,
                    'is_required' => $request->has('is_required'),
                    'status' => 'pending',
                ]);
                
                DB::commit();
                
                return redirect()->route('admin.documents.user', $request->user_id)
                    ->with('success', 'Document uploaded successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                Storage::disk('public')->delete($filePath ?? '');
                throw $e;
            }
        } catch (\Exception $e) {
            \Log::error('Document upload error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to upload document: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Store multiple documents in bulk.
     */
    public function bulkStore(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'documents.*.title' => 'required|string|max:255',
                'documents.*.category' => 'required|string|in:' . implode(',', array_keys(Document::CATEGORIES)),
                'documents.*.description' => 'nullable|string',
                'documents.*.document' => 'required|file|mimes:pdf|max:10240',
                'documents.*.requires_signature' => 'nullable',
                'documents.*.expiry_date' => 'nullable|date|after:today',
                'documents.*.is_required' => 'nullable|boolean',
            ]);

            $user = User::findOrFail($request->user_id);
            if (!in_array($user->role, ['user', 'lawyer'])) {
                return redirect()->route('admin.documents.index')
                    ->with('error', 'You can only add documents for users and lawyers.');
            }

            DB::beginTransaction();
            try {
                $uploadedDocs = [];
                foreach ($request->documents as $doc) {
                    if (!$doc['document']->isValid()) {
                        throw new \Exception('Invalid file in upload');
                    }

                    $filePath = $doc['document']->store('documents', 'public');
                    $uploadedDocs[] = $filePath;

                    Document::create([
                        'user_id' => $request->user_id,
                        'title' => $doc['title'],
                        'category' => $doc['category'],
                        'description' => $doc['description'] ?? null,
                        'file_path' => $filePath,
                        'requires_signature' => isset($doc['requires_signature']),
                        'expiry_date' => $doc['expiry_date'] ?? null,
                        'is_required' => isset($doc['is_required']),
                        'status' => 'pending',
                    ]);
                }

                DB::commit();
                return redirect()->route('admin.documents.user', $request->user_id)
                    ->with('success', 'Documents uploaded successfully');
            } catch (\Exception $e) {
                DB::rollBack();
                // Clean up any uploaded files
                foreach ($uploadedDocs as $path) {
                    Storage::disk('public')->delete($path);
                }
                throw $e;
            }
        } catch (\Exception $e) {
            \Log::error('Bulk document upload error: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Failed to upload documents: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        // (The view (admin.documents.show) now displays a download link if $document->signed_file_path exists.)
        return view('admin.documents.show', compact('document'));
    }

    /**
     * Update the document status.
     */
    public function updateStatus(Request $request, Document $document)
    {
        // Check if document has been signed by the user
        if ($document->requires_signature && !$document->signDocuments()->where('user_id', $document->user_id)->exists()) {
            return redirect()->back()
                ->with('error', 'The document has not been signed by the user yet.');
        }

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:255',
        ]);

        $document->update([
            'status' => $request->status,
            'admin_id' => auth()->id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Notify the user about the status change
        if ($document->user_id) {
            $user = User::find($document->user_id);
            if ($user) {
                // You can implement notification logic here
                // For example, sending an email or creating a notification record
            }
        }

        $statusMessage = $request->status === 'approved' 
            ? 'Document has been approved successfully'
            : 'Document has been rejected';

        return redirect()->route('admin.documents.show', $document->id)
            ->with('success', $statusMessage);
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

    /**
     * Download a signed document.
     */
    public function downloadSigned(Document $document)
    {
        if (!$document->signed_file_path) {
             return redirect()->route('admin.documents.show', $document->id)->with('error', 'No signed document available.');
        }
        return Storage::disk('public')->download($document->signed_file_path, 'signed_' . basename($document->signed_file_path));
    }
}