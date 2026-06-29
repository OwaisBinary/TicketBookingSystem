<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingInfo;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::with('event')->where('user_id',Auth::id())->get();
        return view('bookings/index',compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingInfo $request)
    {
        DB::transaction(function() use ($request){
            $event = Event::lockForUpdate()->findOrFail($request->event_id);
            if ($request->seats_booked > $event->available_seats) {
                throw ValidationException::withMessages([
                    'seats_booked' => 'Not enough seats available.'
                ]);
            }
            if ($event->event_date < now()) {
                throw ValidationException::withMessages([
                    'event' => 'This event has already expired.'
                ]);
            }
            $booking=Booking::where('user_id',Auth::id())->where('event_id',$request->event_id)->first();
            if($booking === null)
            {
                Booking::create([
                    'user_id' => Auth::id(),
                    'event_id' => $event->id,
                    'seats_booked' => $request->seats_booked,
                    'date_booked' => now(),
                ]);
            }
            else{
                if(($booking->seats_booked+$request->seats_booked) >5)
                {
                    throw ValidationException::withMessages([
                        'seats_booked' => 'You already have booked 5 seats'
                    ]);
                }
                $booking->update([
                    'seats_booked' => $booking->seats_booked+$request->seats_booked,
                ]);
            }
            $event->decrement('available_seats',$request->seats_booked);
        });
        return Redirect()->route('bookings.index')
        ->with('success', 'Booking completed successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       //      
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreBookingInfo $request, string $id)
    {
        $booking=Booking::findorfail($id);
        if(Auth::id()==$booking->user_id)
        {
            $booking->update($request->all());
        }
        return Redirect()->route('bookings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking=Booking::findorfail($id);
        if(Auth::id()==$booking->user_id)
        {
            $booking->delete;
        }
        return Redirect()->route('bookings.index');
    }
}
