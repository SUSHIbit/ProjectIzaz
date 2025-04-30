<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Auth::user()->bookings()->with('service')->latest()->paginate(10);
        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Service $service)
    {
        $availabilities = $service->availabilities()
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
            
        return view('user.bookings.create', compact('service', 'availabilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone_number' => 'required|string|max:20',
            'booking_date' => 'required|date|after_or_equal:today',
            'preferred_time' => 'required|date_format:H:i',
        ]);

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'service_id' => $request->service_id,
            'title' => $request->title,
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'booking_date' => $request->booking_date,
            'preferred_time' => $request->preferred_time,
            'status' => 'pending',
        ]);

        return redirect()->route('user.bookings.index')
            ->with('success', 'Booking request submitted successfully. We will notify you once it\'s approved.');
    }

    public function show(Booking $booking)
    {
        // Ensure the booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('user.bookings.index')
                ->with('error', 'You do not have permission to view this booking.');
        }

        return view('user.bookings.show', compact('booking'));
    }
}