<?php

namespace App\Console\Commands;

use App\AvailabilityHold;

class PurgeAvailabilityHolds extends Job {

	function __construct()
	{
		parent::__construct("<PurgeAvailabilityHolds>");
	}

	protected function run_query()
	{
    AvailabilityHold::where('expiry', '<', date('Y-m-d H:i:s'))->delete();
    return collect(); // empty collection
	}

}
