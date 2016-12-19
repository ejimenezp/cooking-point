<?php

namespace App\Console\Commands;

use App\Booking;

use \DateTime;
use Log;

use App\Http\Controllers\MailController;


class ReviewUs extends Job {

	function __construct()
	{
		parent::__construct("<ReviewUs>");
	}

	protected function run_query()
	{
		$yesterday = $this->now->modify('-1 days')->format('Y-m-d');

		return Booking::where('email','<>', '')->
					where('status_filter', 'REGISTERED')->
					where('crm', 'YES')->
					whereHas('calendarevent', function($query) use ($yesterday) {
            			$query->where('date', $yesterday); 
            		})->get();
	}

	protected function action($bkg) {
		// para testing solo escribe en el log
		Log::info('Cumple con la condición ' . $bkg->name);

	 	// MailController::send_mail($bkg->email, $bkg, 'user_review');
	 	$bkg->crm = "REVIEW_ASKED";
	 	$bkg->save();

	}
}

