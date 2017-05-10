<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use \DateTime;
use \DateTimeZone;
use \DateInterval;

class Calendarevent extends Model
{
    protected $table = 'calendarevents';
	public $timestamps = false;
    protected $appends = array('registered', 'startdateatom', 'enddateatom');

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

    public function getStartdateatomAttribute()
    {
        $atom = new DateTime($this->date ." ". $this->time);
        $atom->setTimezone(new DateTimeZone('Europe/Madrid'));
        return $atom->format(DATE_ATOM);
    }

    public function getEnddateatomAttribute()
    {
        $atom = new DateTime($this->date ." ". $this->time);
        $atom->setTimezone(new DateTimeZone('Europe/Madrid'));
        $atom->add(new DateInterval("PT4H"));
        return $atom->format(DATE_ATOM);
    }
}
