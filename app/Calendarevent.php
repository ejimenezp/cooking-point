<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Cookie;

use \DateTime;
use \DateTimeZone;
use \DateInterval;
use Log;
use AvailabilityHold;

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

    public function availabilityholds()
    {
        return $this->hasMany('App\AvailabilityHold');
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

    public function checkAvailabilityAsOfNow($travellers) {

        // calculate cutoff time based on travellers and previous bookings
        $startTime = new DateTime($this->getStartdateatomAttribute());
        $capacity = $this->getAvailableCovid($travellers);

        switch ($this->type) {
            case 'PAELLA':
                switch ($this->getRegisteredAttribute()) {
                    case 0:  // no bookings yet
                        switch ($travellers) {
                            case '1':
                                $cutOff = $startTime->sub(new DateInterval("PT24H")); // 24 hours
                                break;
                            
                            default:
                                $cutOff = $startTime->sub(new DateInterval("PT12H")); // 12 hours
                                break;
                        }
                        
                        break;     
                    default: // some bookings already
                        $cutOff = $startTime->sub(new DateInterval("PT1H")); // 1 hour
                        break;
                }
                break;

            case 'TAPAS':
                switch ($this->getRegisteredAttribute()) {
                    case 0:  // sin reservas
                        switch ($travellers) {
                            case '1':
                                $cutOff = $startTime->sub(new DateInterval("PT24H")); // 24 hours
                                break;
                            
                            default:
                                $cutOff = $startTime->sub(new DateInterval("PT6H")); // 6 hours
                                break;
                        }
                        
                        break;     
                    default: // con reservas
                        $cutOff = $startTime->sub(new DateInterval("PT90M")); // 1.5 hours
                        break;
                }
                break;

            default:
                $cutOff = $startTime->sub(new DateInterval("PT24H")); // 24 hours
                break;
        }

        if ($cutOff < new DateTime()) {
            $status = 'UNAVAILABLE';
            $reason = 'PAST_CUTOFF_DATE';
        } else if (!$capacity) {
            $status = 'UNAVAILABLE';
            $reason = 'SOLD_OUT';
        } else if ($capacity == -1) {
            $status = 'UNAVAILABLE';
            $reason = 'TRAVELLER_MISMATCH';
            $capacity = $this->getAvailableCovid(0);
        } else if ($travellers > $capacity) {
            $status = 'UNAVAILABLE';
            $reason = 'TRAVELLER_MISMATCH';
        } else { // there is room and before cutoff
            $status = 'AVAILABLE';
            $reason = '';
        }
        return array($cutOff->format(DATE_ATOM), $capacity , $status, $reason);
    }

    public function getRegisteredAttribute()
    {
        $adults = $this->bookings->where('status_filter', 'REGISTERED')->sum('adult');  
        $children = $this->bookings->where('status_filter', 'REGISTERED')->sum('child');  
        return $adults + $children;
    }

    public function getAvailablecovidAttribute()
    {
        return $this->getAvailableCovid(0);
    }

    public function getAvailableCovid($travellers)
    {
        $thisHold = $this->availabilityholds->where('reference', Cookie::get('cplocator'))->where('expiry', '>=', date('Y-m-d H:i:s'))->sum('travellers');
        $holds = $this->availabilityholds->where('expiry', '>=', date('Y-m-d H:i:s'))->sum('travellers');
        $available = $this->capacity - $this->registered - $holds + $thisHold;
        return $available < 0 ? 0 : $available;

        $usedStoves = $this->bookings->where('status_filter', 'REGISTERED')->reduce(function($carry, $item) {return $carry + ceil(($item->adult + $item->child)/2);});
        $oddBookings = $this->bookings->where('status_filter', 'REGISTERED')->reduce(function($carry, $item) {return $carry + ($item->adult + $item->child) % 2;});
        $singleBookings = $this->bookings->where('status_filter', 'REGISTERED')->reduce(function($carry, $item) {return $carry + (($item->adult + $item->child) == 1);});

        // don't leave too many half stoves
        if ($travellers == 1 && ($singleBookings >= 2 || $oddBookings >= 3)) {
            return -1;
        }

        // use one more stove if there are too many odd bookings and it is to occupy it fully
        $availableStoves = 6 + ($oddBookings >= 3 && $travellers != 1);

        $available = $this->capacity - $this->registered;
        $available = $available < 0 ? 0 : $available;
        return min($available, ($availableStoves - $usedStoves) * 2);
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
