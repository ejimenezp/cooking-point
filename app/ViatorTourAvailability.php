<?php

namespace App;

class ViatorTourAvailability 
{
    public $Date;
    public $TourOptions;
    public $AvailabilityStatus;

    function __construct() {
    	$this->TourOptions = new \stdClass();
    	$this->AvailabilityStatus = new \stdClass();
    }
}
