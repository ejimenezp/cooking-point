<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Log;

class Booking extends Model
{
    
    protected $table = 'bookings';
	public $timestamps = false;
    protected $appends = array('type', 'date');

    function calendarevent()
    {
        return $this->belongsTo('App\Calendarevent');
    }

    function source()
    {
    	return $this->belongsTo('App\Source');
    }

    public function getDateAttribute()
    {
        return $this->calendarevent->makeHidden('registered')->date;
    }

        public function getTypeAttribute()
    {
        return $this->calendarevent->makeHidden('registered')->type;
    }
}
