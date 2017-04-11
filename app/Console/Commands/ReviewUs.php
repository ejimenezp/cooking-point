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
            			$query->where('date', $yesterday)
            				  ->where('type', '<>', 'GROUP'); 
            		})->get();
	}

	protected function action($bkg) {

		Log::debug('checking ' . $bkg->name);
		switch ($bkg->source->name) {
			case 'Viator':
				Log::info('Enviado <ReviewUs on Viator> a ' . $bkg->name);
			 	MailController::send_mail($bkg->email, $bkg, 'review_viator');
				break;
			
			default:
				Log::info('Enviado <ReviewUs> a ' . $bkg->name);
			 	MailController::send_mail($bkg->email, $bkg, 'user_review');
				break;
		}
	 	$bkg->crm = "REVIEW_ASKED";
	 	$bkg->save();

	}
}

