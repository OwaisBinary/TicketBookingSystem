<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 
class Event extends Model
{
    protected $fillable=[
        'id',
        'title',
        'description',
        'event_date',
        'total_seats',
        'avalible_seats'
    ];

    public function bookings(){
        return $this->hasMany(Booking::class);
    }
    
}
        