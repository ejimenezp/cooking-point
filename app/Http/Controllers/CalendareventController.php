<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests;
use App\Calendarevent;
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

        $ce = new Calendarevent;

        $ce->date = $request->date;
        $ce->type = $request->type;
        $ce->staff_id = $request->staff_id;
        $ce->secondstaff_id = $request->secondstaff_id;
        $ce->short_description = $request->short_description;
        $ce->info = (empty($request->info)) ? '' : $request->info;

    	switch ($request->type) {
    		case 'PAELLA':
                $ce->short_description = 'Paella Cooking Class';
    			$ce->time = '10:00:00';
    			$ce->duration = '04:00:00';
    			$ce->capacity = 12;
    			break;
    		
    		case 'TAPAS':
                $ce->short_description = 'Tapas Cooking Class';
                $ce->time = '17:30:00';
                $ce->duration = '04:00:00';
                $ce->capacity = 12;
    			break;
    		
    		case 'GROUP':
                $ce->time = $request->time;
                $ce->duration = $request->duration;
                $ce->capacity = $request->capacity;
    			break;
    		
    		case 'HOLIDAY':
            case 'FILLER':
            default:
                $ce->time = $request->time;
                $ce->duration = $request->duration;
                $ce->capacity = 0;
                break;
    	}

    	$ce->save();
    	return 'ok';    
	}

    function delete($id)
    {
        $ce = Calendarevent::find($id);
        if (!$ce) {
            return 'fail';
        } elseif ($ce->bookings()->count() > 0) {
            return 'fail';
        } else {
            $ce->delete();   
            return 'ok';
        }
    }

    function find ($id)
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
            $ce->info = (empty($request->info)) ? '' : $request->info;
            $ce->save();
            return 'ok';
        }
    }

	static function getIntervalSchedule($start_date, $end_date, $bookable_only = 0)
	{
		// devuelve colección de CE
        
        $ofuscate = base64_encode(Calendarevent::whereDate('date', '>=', $start_date)
                            ->whereDate('date', '<=', $end_date)
                            ->where('capacity', '>=', $bookable_only)
                            ->orderBy('date', 'ASC')
                            ->orderBy('time', 'ASC')->get());
        return str_replace("5", "x06", $ofuscate);
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
