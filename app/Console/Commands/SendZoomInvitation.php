<?php

namespace App\Console\Commands;

use App\Booking;

use \DateTime;
use Log;

use App\Http\Controllers\MailController;


class SendZoomInvitation extends Job {

	function __construct()
	{
		parent::__construct("<SendZoomInvitation>");
	}

	protected function run_query()
	{

		$in2days = $this->now->modify('+2 days')->format('Y-m-d');


		$bs = Booking::where('email','<>', '')
					->where('status_filter', 'REGISTERED')
					->whereHas('calendarevent', function($query) use ($in2days) {
            			$query->where('date', $in2days)
            					->where('online', 1);})
           ->get();
		return $bs;
	}

	protected function action($bkg) {

		if (!empty($bkg->calendarevent->invitation_link)) {
			Log::info('Enviado <ZoomInvitation> a ' . $bkg->name);
			MailController::send_mail($bkg->email, $bkg, 'user_zoom_invitation');			
		 } else {
			Log::info('Error en <ZoomInvitation>. No hay link');
			MailController::send_mail('info@cookingpoint.es', $bkg, 'admin_cron_error');
		 }

	}
}

