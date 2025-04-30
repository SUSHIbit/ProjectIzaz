<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioProject;
use App\Models\PortfolioImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = PortfolioProject::with('images')->latest()->paginate(10);
        return view('admin.portfolio.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.portfolio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_days' => 'required|integer|min:1',
            'extra_info' => 'nullable|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $project = PortfolioProject::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration_days' => $request->duration_days,
            'extra_info' => $request->extra_info,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('portfolio', 'public');
                
                PortfolioImage::create([
                    'portfolio_project_id' => $project->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio project created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PortfolioProject $portfolio)
    {
        return view('admin.portfolio.show', compact('portfolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PortfolioProject $portfolio)
    {
        return view('admin.portfolio.edit', compact('portfolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PortfolioProject $portfolio)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration_days' => 'required|integer|min:1',
            'extra_info' => 'nullable|string',
        ]);

        $portfolio->update([
            'title' => $request->title,
            'description' => $request->description,
            'duration_days' => $request->duration_days,
            'extra_info' => $request->extra_info,
        ]);

        return redirect()->route('admin.portfolio.show', $portfolio->id)
            ->with('success', 'Portfolio project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PortfolioProject $portfolio)
    {
        // Delete all associated images
        foreach ($portfolio->images as $image) {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }
        
        $portfolio->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'Portfolio project deleted successfully');
    }

    /**
     * Add additional images to an existing project.
     */
    public function addImages(Request $request, PortfolioProject $portfolio)
    {
        $request->validate([
            'images' => 'required|array|min:1',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('portfolio', 'public');
                
                PortfolioImage::create([
                    'portfolio_project_id' => $portfolio->id,
                    'image_path' => $imagePath,
                ]);
            }
        }

        return redirect()->route('admin.portfolio.show', $portfolio->id)
            ->with('success', 'Images added successfully');
    }

    /**
     * Remove an image from a project.
     */
    public function removeImage(PortfolioImage $image)
    {
        $projectId = $image->portfolio_project_id;
        
        // Delete the image file
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $image->delete();

        return redirect()->route('admin.portfolio.show', $projectId)
            ->with('success', 'Image removed successfully');
    }
}