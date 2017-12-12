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

		$yesterday = $this->now->modify('-1 days')->format('Y-m-d');

		$pending = Booking::where('email','<>', '')
					->whereDate('created_at', $yesterday)
					->where('status', 'PENDING')
					->where(function ($query) {
                		$query->where('crm', 'YES')
                      			->orWhere('crm', 'PAYMENT_KO');
						})->get()->unique('email');

		$pending->each(function($pen, $key) use ($pending) {
			$already_booked = Booking::where('email', $pen->email)
						->where('calendarevent_id', $pen->calendarevent_id)
						->where('status_filter', 'REGISTERED')->count();
			if ($already_booked) {
				$pending->forget($key);
				Booking::find($pen->id)->delete();
			} else {
				// Log::info( 'Reminder a '. $pen->email );
			}

		});
		return $pending;
	}

	protected function action($bkg) {

		Log::info('Enviado <Reminder> a ' . $bkg->name);

	 	MailController::send_mail($bkg->email, $bkg, 'user_reminder');
	 	$bkg->crm = "REMINDED";
	 	$bkg->save();
	}
}

