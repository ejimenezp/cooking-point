<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priceplan extends Model
{
    function sources()
    {
    	return $this->hasMany('App\Sources');
    }    	
}
