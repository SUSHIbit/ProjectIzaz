<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserUpdate;
use App\Models\UpdateImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserUpdateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.updates.index', compact('users'));
    }

    /**
     * Display updates for a specific user.
     */
    public function userUpdates(User $user)
    {
        if ($user->role !== 'user') {
            return redirect()->route('admin.updates.index')
                ->with('error', 'You can only manage updates for users.');
        }

        $updates = $user->updates()->latest()->paginate(10);
        return view('admin.updates.user_updates', compact('user', 'updates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        
        if ($user->role !== 'user') {
            return redirect()->route('admin.updates.index')
                ->with('error', 'You can only add updates for users.');
        }
        
        return view('admin.updates.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'required|array|min:1|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_descriptions' => 'required|array|min:1|max:10',
            'image_descriptions.*' => 'nullable|string|max:255',
        ]);

        $user = User::findOrFail($request->user_id);
        if ($user->role !== 'user') {
            return redirect()->route('admin.updates.index')
                ->with('error', 'You can only add updates for users.');
        }

        $update = UserUpdate::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('updates', 'public');
                
                UpdateImage::create([
                    'user_update_id' => $update->id,
                    'image_path' => $imagePath,
                    'description' => $request->image_descriptions[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.updates.user', $request->user_id)
            ->with('success', 'Project update created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(UserUpdate $update)
    {
        return view('admin.updates.show', compact('update'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserUpdate $update)
    {
        return view('admin.updates.edit', compact('update'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserUpdate $update)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $update->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Update image descriptions if provided
        if ($request->has('image_descriptions')) {
            foreach ($request->image_descriptions as $imageId => $description) {
                $image = UpdateImage::findOrFail($imageId);
                if ($image->user_update_id === $update->id) {
                    $image->update(['description' => $description]);
                }
            }
        }

        return redirect()->route('admin.updates.show', $update->id)
            ->with('success', 'Project update modified successfully');
    }

    /**
     * Add additional images to an existing update.
     */
    public function addImages(Request $request, UserUpdate $update)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_descriptions' => 'required|array|min:1',
            'image_descriptions.*' => 'nullable|string|max:255',
        ]);

        // Check if adding these images would exceed the 10 image limit
        $currentCount = $update->images()->count();
        $newImagesCount = count($request->file('images'));

        if ($currentCount + $newImagesCount > 10) {
            return back()->with('error', 'Cannot add more images. Maximum of 10 images allowed per update.');
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('updates', 'public');
                
                UpdateImage::create([
                    'user_update_id' => $update->id,
                    'image_path' => $imagePath,
                    'description' => $request->image_descriptions[$index] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.updates.show', $update->id)
            ->with('success', 'Images added successfully');
    }

    /**
     * Remove an image from an update.
     */
    public function removeImage(UpdateImage $image)
    {
        $updateId = $image->user_update_id;
        
        // Delete the image file
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $image->delete();

        return redirect()->route('admin.updates.show', $updateId)
            ->with('success', 'Image removed successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserUpdate $update)
    {
        $userId = $update->user_id;
        
        // Delete all associated images
        foreach ($update->images as $image) {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }
        
        $update->delete();

        return redirect()->route('admin.updates.user', $userId)
            ->with('success', 'Project update deleted successfully');
    }
}