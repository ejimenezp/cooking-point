<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendarevent extends Model
{
    protected $table = 'calendarevents';
	public $timestamps = false;
    protected $appends = array('registered');

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
        $children = $this->bookings->where('status_filter', '<>', 'REGISTERED')->sum('child');  
        return $adults + $children;
    }}
