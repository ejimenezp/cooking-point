<?php

namespace App\Console\Commands;

use App\Booking;

use \DateTime;
use Log;

use App\Http\Controllers\MailController;


class Reminder extends Job {

	function __construct()
	{
		parent::__construct("<Reminder>");
	}

	protected function run_query()
	{
		$today = $this->now->format('Y-m-d');
		$in2days = $this->now->modify('+2 days')->format('Y-m-d');

		return Booking::where('email', '<>', '')->
						where('hash', '<>', '')->
						where('status', 'PENDING')->
						where('crm', 'YES')->
						whereHas('calendarevent', function($query) use ($today, $in2days) {
            				$query->where('date', '>=', $today)->
            						where('date', '<=', $in2days);
            			})->get(); 
	}

	protected function action($bkg) {
		// para testing solo escribe en el log
		Log::info('Enviado <Reminder> a ' . $bkg->name);

	 	MailController::send_mail($bkg->email, $bkg, 'user_reminder');
	 	$bkg->crm = "REMINDED";
	 	$bkg->save();
	}
}

