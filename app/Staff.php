<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
	protected $table = 'staff';
	public $timestamps = false;
	protected $hidden = ['auth_name', 'auth_role', 'auth_password', 'active']; 
	
    public function calendarevents()
    {
        return $this->hasMany('App\CalendarEvent');
    }
}
