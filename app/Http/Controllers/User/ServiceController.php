<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('user.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        $availabilities = $service->availabilities()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
            
        return view('user.services.show', compact('service', 'availabilities'));
    }
}