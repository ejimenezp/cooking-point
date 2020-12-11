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
    protected $appends = array('registered', 'startdateatom', 'enddateatom', 'validfromdateatom');

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function eventtype()
    {
        return $this->hasOne('App\Eventtype', 'type', 'type');
    }

    public function staff()
    {
        return $this->belongsTo('App\Staff');
    }

    public function secondstaff()
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
        $d1=new DateTime("2000-01-01 00:00:00");
        $d2=new DateTime("2000-01-01 " . $this->duration);
        $atom->add( $d1->diff($d2) );
        return $atom->format(DATE_ATOM);
    }

    public function getValidfromdateatomAttribute()
    {
        $atom = new DateTime($this->date ." ". $this->time);
        $atom->setTimezone(new DateTimeZone('Europe/Madrid'));
        $interval = new DateInterval('P1M');
        $atom->sub($interval);
        return $atom->format(DATE_ATOM);
    }

}
