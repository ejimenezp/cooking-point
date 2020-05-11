<?php

namespace App\Console\Commands;

use App\Booking;

use \DateTime;
use Log;

use App\Http\Controllers\MailController;


class PaymentMethod extends Job {

	protected $class_type;

	function __construct($type)
	{
		$this->class_type = $type;
		parent::__construct("<PaymentMethod " . $type . ">");
	}

	protected function run_query()
	{
		$today = $this->now->format('Y-m-d');
		$ctype = $this->class_type;

		return Booking::where('status', 'PAY-ON-ARRIVAL')->
					whereHas('calendarevent', function($query) use ($today, $ctype) {
            			$query->where('date', $today)
            				  ->where('type', '=', $this->class_type); 
            		})->get();
	}

	function exec() {
		$staff = $this->result->first()->calendarevent->staff;
		Log::info('Enviado <Update PaymentMethod> a ' . $staff->name);
		MailController::send_mail($staff->email, $this->result->first(), 'staff_update_paymentmethod');
	}
}

