<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    
    protected $table = 'bookings';
	public $timestamps = false;

    function calendarevent()
    {
        return $this->belongsTo('App\Calendarevent');
    }

    function source()
    {
    	return $this->belongsTo('App\Source');
    }
}
