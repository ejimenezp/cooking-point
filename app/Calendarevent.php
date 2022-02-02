<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

use \DateTime;
use \DateTimeZone;
use \DateInterval;
use Log;

class Calendarevent extends Model
{
    protected $table = 'calendarevents';
	public $timestamps = false;
    protected $appends = array('registered', 'availablecovid', 'startdateatom', 'enddateatom', 'validfromdateatom');
    protected $hidden = ['bookings', 'registered', 'availablecovid'];

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

    public function groups()
    {
        $groups = $this->bookings->where('status_filter', 'REGISTERED')->map(function($item) {return $item->adult + $item->child;})->sortDesc()->all();        
        $groups = array_merge($groups, [0, 0, 0]);
        return $groups;
               
    }
    public function getAvailablecovidAttribute()
    {
        $groups = $this->bookings->where('status_filter', 'REGISTERED')->map(function($item) {return $item->adult + $item->child;})->sortDesc()->all();
        
        if (count($groups) > 2) return 0;

        $groups = array_merge($groups, [0, 0]);
        // Log::info($this->date . ' groups ' . json_encode($groups));

        $filtered = CovidLayout::get()->first( function ($item) use ($groups) {
            return ($item['group1'] == $groups[0]) && ($item['group2'] == $groups[1]); 
        });
        // Log::info($this->date . ' filtered ' . json_encode($filtered));
        if (is_null($filtered)) {
            return 0;
        } else {
            // Log::info($this->date . ' capacity ' . $this->capacity . ' available ' . (int) $filtered['available']);
            return min($this->capacity, (int) $filtered['available']);
        }
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
