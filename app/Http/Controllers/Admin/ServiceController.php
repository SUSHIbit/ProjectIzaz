<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceAvailability;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        return view('admin.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'estimated_price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_info' => 'nullable|string',
        ]);

        $imagePath = $request->file('image')->store('services', 'public');

        $service = Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'estimated_price' => $request->estimated_price,
            'image_path' => $imagePath,
            'additional_info' => $request->additional_info,
        ]);

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            $displayOrder = 0;
            foreach ($request->file('additional_images') as $image) {
                $imagePath = $image->store('services/images', 'public');
                
                ServiceImage::create([
                    'service_id' => $service->id,
                    'image_path' => $imagePath,
                    'display_order' => $displayOrder++,
                ]);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully');
    }

    public function show(Service $service)
    {
        $service->load('images');
        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $service->load('images');
        return view('admin.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'estimated_price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_info' => 'nullable|string',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'estimated_price' => $request->estimated_price,
            'additional_info' => $request->additional_info,
        ];

        if ($request->hasFile('image')) {
            // Delete the old image
            if ($service->image_path) {
                Storage::disk('public')->delete($service->image_path);
            }
            
            // Store the new image
            $data['image_path'] = $request->file('image')->store('services', 'public');
        }

        $service->update($data);

        // Handle additional images
        if ($request->hasFile('additional_images')) {
            $displayOrder = $service->images()->max('display_order') + 1 ?? 0;
            
            foreach ($request->file('additional_images') as $image) {
                $imagePath = $image->store('services/images', 'public');
                
                ServiceImage::create([
                    'service_id' => $service->id,
                    'image_path' => $imagePath,
                    'display_order' => $displayOrder++,
                ]);
            }
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        // Delete the main image
        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }
        
        // Delete all associated service images
        foreach ($service->images as $image) {
            if ($image->image_path) {
                Storage::disk('public')->delete($image->image_path);
            }
            $image->delete();
        }
        
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully');
    }

    public function availability(Service $service)
    {
        $availabilities = $service->availabilities;
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        
        return view('admin.services.availability', compact('service', 'availabilities', 'daysOfWeek'));
    }

    public function storeAvailability(Request $request, Service $service)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'notes' => 'nullable|string',
        ]);

        ServiceAvailability::create([
            'service_id' => $service->id,
            'day_of_week' => $request->day_of_week,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'notes' => $request->notes,
        ]);

        return redirect()->route('admin.services.availability', $service->id)
            ->with('success', 'Availability added successfully');
    }

    public function destroyAvailability(ServiceAvailability $availability)
    {
        $serviceId = $availability->service_id;
        $availability->delete();

        return redirect()->route('admin.services.availability', $serviceId)
            ->with('success', 'Availability removed successfully');
    }
    
    public function removeImage(ServiceImage $image)
    {
        $serviceId = $image->service_id;
        
        // Delete the image file
        if ($image->image_path) {
            Storage::disk('public')->delete($image->image_path);
        }
        
        $image->delete();

        return redirect()->route('admin.services.edit', $serviceId)
            ->with('success', 'Image removed successfully');
    }
}