<?php

namespace App\Console\Commands;

use App\Booking;
use App\Crmstrategy;

use \DateTime;
use Log;

use App\Http\Controllers\MailController;
use App\Http\Controllers\CRMstrategyController;


class ReviewUs extends Job {

	private $strategy;
	private $sent_so_far;

	function __construct()
	{
		$this->strategy = Crmstrategy::orderBy('prio')->get();
		$this->total_sent = Crmstrategy::where('prio', '>', '0')->sum('cummulated');
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

		// prio 0 is to force send out with associated template. They don't modify total_sent
		// maximum_pct 100 makes that option default

		$this->strategy->each(function ($item, $key) use ($bkg) {
   			if (eval("return " . $item->check_expression . ";")) {
   				if (($item->cummulated / max($this->total_sent, 1)) * 100 < $item->maximum_pct) {
					MailController::send_mail($bkg->email, $bkg, $item->template);
					Log::info("Enviado ReviewUs (" . $item->template . ") a " . $bkg->name);
					// echo "Enviado ReviewUs " . $item->template . " a " . $bkg->name . "\r\n";
					$this->total_sent++;
					$item->cummulated++;
					$item->save();
					$bkg->crm = "REVIEW_ASKED";
					$bkg->save();
					return false;
   				}
   			}
		});
	}
}

