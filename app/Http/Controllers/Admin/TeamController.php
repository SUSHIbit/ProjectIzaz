<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::orderBy('display_order')->paginate(10);
        return view('admin.team.index', compact('teamMembers'));
    }

    public function create()
    {
        return view('admin.team.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $imagePath = $request->file('image')->store('team', 'public');

        TeamMember::create([
            'name' => $request->name,
            'title' => $request->title,
            'position' => $request->position,
            'image_path' => $imagePath,
            'display_order' => $request->display_order ?? 0,
        ]);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member added successfully');
    }

    public function edit(TeamMember $team)
    {
        return view('admin.team.edit', compact('team'));
    }

    public function update(Request $request, TeamMember $team)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'nullable|integer|min:0',
        ]);

        $data = [
            'name' => $request->name,
            'title' => $request->title,
            'position' => $request->position,
            'display_order' => $request->display_order ?? $team->display_order,
        ];

        if ($request->hasFile('image')) {
            // Delete the old image
            if ($team->image_path) {
                Storage::disk('public')->delete($team->image_path);
            }
            
            // Store the new image
            $data['image_path'] = $request->file('image')->store('team', 'public');
        }

        $team->update($data);

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member updated successfully');
    }

    public function destroy(TeamMember $team)
    {
        // Delete the image
        if ($team->image_path) {
            Storage::disk('public')->delete($team->image_path);
        }
        
        $team->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'Team member deleted successfully');
    }
}