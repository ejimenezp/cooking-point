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
        $in15days = $now->modify('+15 days')->format('Y-m-d');

        $events = $this->getIntervalSchedule($today, $in15days, true)->where('type', 'PAELLA');

        return view('pages.paella', ['events' => $events] );
    }

    function tapas()
    {
        $now = new DateTime(null, new DateTimeZone('Europe/Madrid'));
        $today = $now->format('Y-m-d');
        $in15days = $now->modify('+15 days')->format('Y-m-d');

        $events = $this->getIntervalSchedule($today, $in15days, true)->where('type', 'TAPAS');

        return view('pages.tapas', ['events' => $events] );
    }

    function home()
    {
        $now = new DateTime(null, new DateTimeZone('Europe/Madrid'));
        $today = $now->format('Y-m-d');
        $in15days = $now->modify('+15 days')->format('Y-m-d');

        $events = $this->getIntervalSchedule($today, $in15days, true)->whereIn('type', ['PAELLA', 'TAPAS']);

        return view('pages.home', ['events' => $events, 'page' => 'home'] );
    }

    function online()
    {
        $now = new DateTime(null, new DateTimeZone('Europe/Madrid'));
        $today = $now->format('Y-m-d');
        $in15days = $now->modify('+15 days')->format('Y-m-d');

        $events = $this->getIntervalSchedule($today, $in15days, true)->whereIn('type', ['ONLINE-EVENING-SELECTION', 'ONLINE-EVENING-PAELLA', 'ONLINE-LATENIGHT-SELECTION', 'ONLINE-LATENIGHT-PAELLA']);

        return view('pages.online', ['events' => $events] );
    }
}
