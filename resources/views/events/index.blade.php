@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2>Upcoming Events</h2>
        <p class="text-muted">
            Browse events and reserve your seats.
        </p>
    </div>

</div>

@if($events->count()==0)

<div class="alert alert-info">
    No events available.
</div>

@else

<div class="row">

@foreach($events as $event)

@php

    $expired = \Carbon\Carbon::parse($event->event_date)->isPast();

    $available = $event->available_seats > 0;

@endphp

<div class="col-lg-4 col-md-6 mb-4">

<div class="card h-100">

    <div class="card-body">

        <h4 class="card-title">

            {{ $event->title }}

        </h4>

        <p class="text-muted">

            {{ $event->description }}

        </p>

        <hr>

        <p>

            <strong>Event Date:</strong>

            <br>

            {{ \Carbon\Carbon::parse($event->event_date)->format('d M Y h:i A') }}

        </p>

        <p>

            <strong>Total Seats:</strong>

            {{ $event->total_seats }}

        </p>

        <p>

            <strong>Available Seats:</strong>

            {{ $event->available_seats }}

        </p>

        <div class="mb-3">

            @if($expired)

                <span class="badge bg-danger">

                    Expired

                </span>

            @else

                <span class="badge bg-success">

                    Upcoming

                </span>

                @if($available)

                <span class="badge bg-primary">

                    Available

                </span>

                @else

                    <span class="badge bg-secondary">

                        Not Available

                    </span>

                @endif

            @endif

           

        </div>

        @auth

            @if(!$expired && $available)

                <button
                    class="btn btn-success w-100"
                    onclick="toggleBooking({{ $event->id }})">

                    Book Ticket

                </button>

            @else

                <button
                    class="btn btn-secondary w-100"
                    disabled>

                    Booking Closed

                </button>

            @endif

        @else

            <a href="{{ route('login') }}"
               class="btn btn-primary w-100">

                Login To Book

            </a>

        @endauth

        @if(!$expired && $available)

        <div
            id="booking-form-{{ $event->id }}"
            style="display:none;">

            <hr>

            <form
                method="POST"
                action="{{ route('bookings.store') }}">

                @csrf

                <input
                    type="hidden"
                    name="event_id"
                    value="{{ $event->id }}">

                <div class="mb-3">

                    <label class="form-label">

                        Number of Seats

                    </label>

                    <input
                        type="number"
                        class="form-control"
                        name="seats_booked"
                        min="1"
                        max="5"
                        value="1"
                        required>

                    <small class="text-muted">

                        Maximum 5 seats per booking.

                    </small>

                </div>

                <button
                    class="btn btn-primary w-100">

                    Confirm Booking

                </button>

            </form>

        </div>

        @endif

    </div>

</div>

</div>

@endforeach

</div>

@endif

@endsection

@push('scripts')

<script>

function toggleBooking(id)
{
    let form=document.getElementById("booking-form-"+id);

    if(form.style.display==="none")
    {
        form.style.display="block";
    }
    else
    {
        form.style.display="none";
    }
}

</script>

@endpush
```
