<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\PortfolioProject;
use App\Models\Service;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        $services = Service::latest()->take(4)->get();
        $portfolio = PortfolioProject::with('images')->latest()->take(3)->get();
        $feedback = Feedback::where('is_approved', true)->latest()->take(5)->get();
        $team = TeamMember::orderBy('display_order')->take(4)->get();
        
        return view('public.index', compact('services', 'portfolio', 'feedback', 'team'));
    }

    public function services()
    {
        $services = Service::latest()->paginate(9);
        return view('public.services', compact('services'));
    }

    public function portfolio()
    {
        $portfolio = PortfolioProject::with('images')->latest()->paginate(9);
        return view('public.portfolio', compact('portfolio'));
    }

    public function about()
    {
        $team = TeamMember::orderBy('display_order')->get();
        return view('public.about', compact('team'));
    }

    public function feedback()
    {
        $feedback = Feedback::where('is_approved', true)->latest()->paginate(10);
        return view('public.feedback', compact('feedback'));
    }
}