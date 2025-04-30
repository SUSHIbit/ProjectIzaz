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
    public function index()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.updates.index', compact('users'));
    }

    public function userUpdates(User $user)
    {
        $updates = $user->updates()->latest()->paginate(10);
        return view('admin.updates.user_updates', compact('user', 'updates'));
    }

    public function create(Request $request)
    {
        $userId = $request->user_id;
        $user = User::findOrFail($userId);
        return view('admin.updates.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'required|array|max:10',
        ]);

        $update = UserUpdate::create([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('updates', 'public');
                
                UpdateImage::create([
                    'user_update_id' => $update->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('admin.updates.user', $request->user_id)
            ->with('success', 'Update created successfully');
    }

    public function show(UserUpdate $update)
    {
        return view('admin.updates.show', compact('update'));
    }

    public function edit(UserUpdate $update)
    {
        return view('admin.updates.edit', compact('update'));
    }

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

        return redirect()->route('admin.updates.user', $update->user_id)
            ->with('success', 'Update modified successfully');
    }

    public function addImages(Request $request, UserUpdate $update)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'images' => 'required|array',
        ]);

        // Check if adding these images would exceed the 10 image limit
        $currentCount = $update->images()->count();
        $newImagesCount = count($request->file('images'));

        if ($currentCount + $newImagesCount > 10) {
            return back()->with('error', 'Cannot add more images. Maximum of 10 images allowed per update.');
        }

        foreach ($request->file('images') as $image) {
            $imagePath = $image->store('updates', 'public');
            
            UpdateImage::create([
                'user_update_id' => $update->id,
                'image_path' => $imagePath,
            ]);
        }

        return redirect()->route('admin.updates.show', $update->id)
            ->with('success', 'Images added successfully');
    }

    public function removeImage(UpdateImage $image)
    {
        $updateId = $image->user_update_id;
        $update = UserUpdate::findOrFail($updateId);

        // Delete the image file
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $image->delete();

        return redirect()->route('admin.updates.show', $updateId)
            ->with('success', 'Image removed successfully');
    }

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
            ->with('success', 'Update deleted successfully');
    }
}