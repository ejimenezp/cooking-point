<?php

namespace App;

class ViatorBooking 
{
    public $TransactionStatus;

    function __construct() {
    	$this->TransactionStatus = new \stdClass();
    }
}
