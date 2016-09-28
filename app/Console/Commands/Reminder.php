<?php

namespace App\Console\Commands;

use \DateTime;
use Log;

use App\Http\Controllers\Legacy\LegacyMail;
use App\Http\Controllers\Legacy\LegacyModel;


class Reminder extends Job {

	function __construct()
	{
		parent::__construct("<Reminder>");
	}

	protected function set_condition()
	{
		$today = $this->now->format('Y-m-d');
		$in2days = $this->now->modify('+2 days')->format('Y-m-d');

		$this->condition = "SELECT * from legacy_bookings where 
			status = 'PE' and 
			crm <> 'NO' and 
			crm <> 'RE' and
			activityDate >= '{$today}' and
			activityDate <= '{$in2days}'";
	}

	protected function action($booking) {
		// para testing solo escribe en el log
		Log::info('Cumple con la condición ' . $booking->name);

	 	$booking->crm = "RE";
	 	LegacyModel::update_admin_booking(get_object_vars($booking));
	 	LegacyMail::mail_to_user(get_object_vars($booking), "legacy/reminder");
	}
}

