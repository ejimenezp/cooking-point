<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Http\Requests;
use App\Booking;
use App\Calendarevent;
use App\Eventtype;
use App\Staff;

use Log;

class CalendareventController extends Controller
{
    function adminSchedule (Request $request)
    {
        Log::info('date: '. $request->date);
        Log::info('ceId:  ' . $request->ceId);
        Log::info('any: ' . $request->any);


        if ($request->bkgId) {
            if ($bkg = Booking::find($request->bkgId)) {
                return view('admin.adminbookings', ['param' => json_encode($this->getScheduleForReactRoot($bkg->calendarevent->date), JSON_NUMERIC_CHECK)]);
            } else {
                return view('admin.errors.generic', ['message' => 'No existe reserva (' . $request->bkgId .')']);
  
            }
        }
        if ($request->ceId) {
            if ($ceId = Calendarevent::find($request->ceId)) {
                return view('admin.adminbookings', ['param' => json_encode($this->getScheduleForReactRoot($ceId->date), JSON_NUMERIC_CHECK)]);
            } else {
                return view('admin.errors.generic', ['message' => 'No existe evento (' . $request->ceId .')']);
  
            }        }
        if ($request->date) {
            list($year, $month, $day) = sscanf($request->date, "%d-%d-%d");
                if (checkdate($month, $day, $year)) {
                        return view('admin.adminbookings', ['param' => json_encode($this->getScheduleForReactRoot($request->date), JSON_NUMERIC_CHECK)]);
                } else {
                    return view('admin.errors.generic', ['message' => 'Fecha no válida (' . $request->date .')']);
                }        
        }
        if ($request->any) {
            return view('admin.errors.generic', ['message' => 'No existe (' . $request->any .')']);
        }
        return view('admin.errors.generic', ['message' => 'No encue (' . $request->any .')']);
 
    }



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
        $ce->invitation_link = $eventtype->invitation_link;


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
            $ce->invitation_link = $request->invitation_link;
            $ce->info = (empty($request->info)) ? '' : $request->info;
            $ce->save();
            return $ce;
        }
    }


    function getScheduleForReactRoot($date)
    {
        return Calendarevent::whereDate('date', '>=', $date)
                            ->whereDate('date', '<=', $date)
                            ->orderBy('date')
                            ->orderBy('time')
                            ->orderBy('type')
                            ->get()->makeVisible(['bookings','availablecovid', 'registered']);
    }


    function getSchedule($date)
    {
        return response()->json($this->getScheduleForReactRoot($date));
    }


    function getAvailability(Request $request)
    {
        $today = (new Carbon())->toDateString();
        $ces = Calendarevent::whereDate('date', '>=', $request->start)
                            ->whereDate('date', '<=', $request->end)
                            ->whereDate('date', '>=', $today)
                            ->where('online', $request->online)
                            ->where('bookable_by_clients', true)
                            ->orderBy('date')
                            ->orderBy('time')
                            ->orderBy('type')
                            ->get()->makeVisible('registered');

        $subset = $ces->map->only(['id', 'type', 'short_description', 'date', 'time', 'startdateatom', 'duration', 'capacity', 'registered', 'availablecovid', 'online']);

        $obfuscate = base64_encode(json_encode($subset->toArray(), JSON_NUMERIC_CHECK));
        return str_replace("5", "x06", $obfuscate);
        // return $subset;
    }


    static function getIntervalSchedule($start_date, $end_date, $bookable_only = 0)
    {
        // no es del API. Devuelve colección de CE para añadir Coming classes en las views
        
        return Calendarevent::whereDate('date', '>=', $start_date)
                            ->whereDate('date', '<=', $end_date)
                            ->where('capacity', '>=', $bookable_only)
                            ->orderBy('date')
                            ->orderBy('time')
                            ->orderBy('type')
                            ->get();
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
