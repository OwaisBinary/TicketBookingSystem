
@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2>My Bookings</h2>
        <p class="text-muted">
            View all the tickets you have booked.
        </p>
    </div>

    <a href="{{ route('events.index') }}" class="btn btn-primary">
        Browse Events
    </a>

</div>

@if($bookings->isEmpty())

<div class="alert alert-info">
    <h5>No Bookings Found</h5>
    <p class="mb-0">
        You haven't booked any event yet.
    </p>
</div>

@else

<div class="card shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark">

                <tr>

                    <th>#</th>

                    <th>Event</th>

                    <th>Description</th>

                    <th>Event Date</th>

                    <th>Total Seats</th>

                    <th>Seats Booked</th>

                    <th>Booking Date</th>

                    <th>Status</th>

                </tr>

                </thead>

                <tbody>

                @foreach($bookings as $booking)

                @php

                    $expired = \Carbon\Carbon::parse($booking->event->event_date)->isPast();

                @endphp

                <tr>

                    <td>

                        {{ $loop->iteration }}

                    </td>

                    <td>

                        <strong>

                            {{ $booking->event->title }}

                        </strong>

                    </td>

                    <td>

                        {{ $booking->event->description }}

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($booking->event->event_date)->format('d M Y h:i A') }}

                    </td>

                    <td>

                        {{ $booking->event->total_seats }}

                    </td>

                    <td>

                        <span class="badge bg-primary">

                            {{ $booking->seats_booked }}

                        </span>

                    </td>

                    <td>

                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y h:i A') }}

                    </td>

                    <td>

                        @if($expired)

                            <span class="badge bg-danger">

                                Expired

                            </span>

                        @else

                            <span class="badge bg-success">

                                Upcoming

                            </span>

                        @endif

                    </td>

                </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<div class="mt-4">

    <div class="card">

        <div class="card-header">

            <h5 class="mb-0">

                Booking Summary

            </h5>

        </div>

        <div class="card-body">

            <div class="row text-center">

                <div class="col-md-4">

                    <h4>

                        {{ $bookings->count() }}

                    </h4>

                    <p>Total Bookings</p>

                </div>

                <div class="col-md-4">

                    <h4>

                        {{ $bookings->sum('seats_booked') }}

                    </h4>

                    <p>Total Seats Booked</p>

                </div>

                <div class="col-md-4">

                    <h4>

                        {{ $bookings->where('event.event_date','>',now())->count() }}

                    </h4>

                    <p>Upcoming Events</p>

                </div>

            </div>

        </div>

    </div>

</div>

@endif

@endsection
```
