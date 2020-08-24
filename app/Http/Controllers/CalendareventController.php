<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Http\Requests;
use App\Calendarevent;
use App\Eventtype;
use App\Staff;

use Log;

class CalendareventController extends Controller
{
    function add(Request $request)
    {
    	// check event does not exist already
        if ( Calendarevent::where('type', $request->type)->
                            where('date', $request->date)->
                            where('time', $request->time)->count() > 0 ) {
            return 'fail';
        }

        // check event type really exists
        $eventtype = Eventtype::where('type', $request->type)->first();
        if (!$eventtype) {
            return 'fail';
        }

        $ce = new Calendarevent;

        $ce->date = $request->date;
        $ce->type = $request->type;
        $ce->staff_id = $request->staff_id;
        $ce->secondstaff_id = $request->secondstaff_id;
        $ce->short_description = $request->short_description;
        $ce->info = (empty($request->info)) ? '' : $request->info;
        $ce->short_description = $eventtype->short_description;
        $ce->time = $eventtype->time;
        $ce->duration = $eventtype->duration;
        $ce->capacity = $eventtype->capacity;
        $ce->online = $eventtype->online;
        $ce->bookable_by_clients = $eventtype->bookable_by_clients;
        $ce->startdatetime = $request->date . ' ' . $request->time;
        $st = new Carbon($ce->startdatetime);
        $ce->enddatetime = $st->add(CarbonInterval::createFromFormat('H:i:s', $ce->duration));

    	$ce->save();
    	return $ce;    
	}

    function delete($id)
    {
        $ce = Calendarevent::find($id);
        if (!$ce) {
            return response()->json(['msg' => 'Not Found'], 404);
        } elseif ($ce->bookings()->count() > 0) {
            return response()->json(['msg' => 'Este evento tiene reservas'], 403);
        } else {
            $ce->delete();   
            return;
        }
    }

    function get ($id)
    {
        return Calendarevent::find($id);
    }

    function findByDateAndType ($date, $type)
    {
        return Calendarevent::where('date', $date)->where('type', $type)->first();
    }


    function update(Request $request)
    {
        $ce = Calendarevent::find($request->id);
        if (!$ce) {
            return 'fail';
        } else {
            $ce->date = $request->date;
            $ce->type = $request->type;
            $ce->staff_id = $request->staff_id;
            $ce->secondstaff_id = $request->secondstaff_id;
            $ce->short_description = $request->short_description;
            $ce->time = $request->time;
            $ce->duration = $request->duration;
            $ce->capacity = $request->capacity;
            $ce->startdatetime = $request->date . ' ' . $request->time;
            $st = new Carbon($ce->startdatetime);
            $ce->enddatetime = $st->add(CarbonInterval::createFromFormat('H:i:s', $ce->duration));
            $ce->info = (empty($request->info)) ? '' : $request->info;
            $ce->save();
            return $ce;
        }
    }


    function getSchedule(Request $request)
    {
        return response()->json(Calendarevent::whereDate('date', '>=', $request->start)
                            ->whereDate('date', '<=', $request->end)
                            ->orderBy('date', 'ASC')
                            ->orderBy('time', 'ASC')->get()->makeHidden('bookings'));
    }


    function getAvailability(Request $request)
    {
        $ces = Calendarevent::whereDate('date', '>=', $request->start)
                            ->whereDate('date', '<=', $request->end)
                            ->where('online', $request->online == 'true')
                            ->where('bookable_by_clients', true)
                            ->orderBy('date', 'ASC')
                            ->orderBy('time', 'ASC')->get();

        $subset = $ces->map->only(['id', 'type', 'short_description', 'date', 'time', 'startdateatom', 'duration', 'capacity', 'registered']);

        // $ofuscate = base64_encode($subset);
        // return str_replace("5", "x06", $ofuscate);
        return $subset;
    }


    static function getIntervalSchedule($start_date, $end_date, $bookable_only = 0)
    {
        // no es del API. Devuelve colección de CE para añadir Coming classes en las views
        
        return Calendarevent::whereDate('date', '>=', $start_date)
                            ->whereDate('date', '<=', $end_date)
                            ->where('capacity', '>=', $bookable_only)
                            ->get()
                            ->makeHidden('bookings');
    }

    function importStaffing (Request $request)
    {

        $st = StaffController::getCooks();

        foreach ($st as $value) {
            $staff[$value->name] = $value->id;
        }

        $handle = fopen(storage_path('app/' . $request->fichero), "r");

        while ($line = fgetcsv($handle, 1000, ",")) {

            // pointer points to the event's first column 
            // number of events per day is limited to 2
            $pointer = 0;
            $line_length = sizeof($line);
            while ($line_length > 1 && $pointer < 2) {
                // pointer + 7 = calendarevent_id
                $ce = Calendarevent::find($line[$pointer + 7]);

                if ($ce) {
                    // pointer + 1 cook's name
                    // pointer + 3 second cook's name
                    $staff_name = ($line[$pointer + 1] ? $line[$pointer + 1] : 'n.a.');
                    $secondstaff_name = ($line[$pointer + 3] ? $line[$pointer + 3] : 'n.a.');

                    $ce->staff_id = $staff[$staff_name];
                    $ce->secondstaff_id = $staff[$secondstaff_name];
                    $ce->save();
                }
                $pointer ++;
            }
        }
    }

}
