<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use \DateTime;
use \DateTimeZone;

use Log;

class CalendareventControllerOnline extends CalendareventController
{
    function paella()
    {
        $now = new DateTime(null, new DateTimeZone('Europe/Madrid'));
        $today = $now->format('Y-m-d');
        $in5days = $now->modify('+5 days')->format('Y-m-d');

        $events = $this->getIntervalSchedule($today, $in5days, true)->where('type', 'PAELLA');

        return view('pages.paella', ['events' => $events] );
    }

    function tapas()
    {
        $now = new DateTime(null, new DateTimeZone('Europe/Madrid'));
        $today = $now->format('Y-m-d');
        $in5days = $now->modify('+5 days')->format('Y-m-d');

        $events = $this->getIntervalSchedule($today, $in5days, true)->where('type', 'TAPAS');

        return view('pages.tapas', ['events' => $events] );
    }

}
