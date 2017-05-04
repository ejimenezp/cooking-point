<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \DateTime;
use \DateTimeZone;

class Calendarevent extends Model
{
    protected $table = 'calendarevents';
	public $timestamps = false;
    protected $appends = array('registered', 'dateatom');

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    public function getRegisteredAttribute()
    {
        $adults = $this->bookings->where('status_filter', 'REGISTERED')->sum('adult');  
        $children = $this->bookings->where('status_filter', 'REGISTERED')->sum('child');  
        return $adults + $children;
    }

    public function getDateatomAttribute()
    {
        $atom = new DateTime($this->date ." ". $this->time);
        $atom->setTimezone(new DateTimeZone('Europe/Madrid'));
        return $atom->format(DATE_ATOM);
    }
}
