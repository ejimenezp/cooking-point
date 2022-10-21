<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailabilityHold extends Model
{
    protected $table = 'availabilityholds';
	public $timestamps = false;
	protected $fillable = ['calendarevent_id', 'travellers', 'reference', 'expiry'];
}
