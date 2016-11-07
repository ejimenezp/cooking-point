<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    function bookings()
    {
    	return $this->hasMany('App\Booking');
    }

    function priceplan()
    {
    	return $this->belongsTo('App\Priceplan');
    }
}
