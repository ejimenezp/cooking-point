<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Calendarevent;
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
        $ce->short_description = $request->short_description;

    	switch ($request->type) {
    		case 'PAELLA':
                $ce->confirmed = false;
                $ce->short_description = 'Paella Cooking Class';
    			$ce->time = '10:00:00';
    			$ce->duration = '04:00:00';
    			$ce->capacity = 12;
    			break;
    		
    		case 'TAPAS':
                $ce->confirmed = false;
                $ce->short_description = 'Tapas Cooking Class';
                $ce->time = '17:30:00';
                $ce->duration = '04:00:00';
                $ce->capacity = 12;
    			break;
    		
    		case 'GROUP':
                $ce->confirmed = isset($request->confirmed);
                $ce->time = $request->time;
                $ce->duration = $request->duration;
                $ce->capacity = $request->capacity;
    			break;
    		
    		case 'HOLIDAY':
            case 'FILLER':
            default:
                $ce->confirmed = true;
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
            $ce->short_description = $request->short_description;
            $ce->confirmed = isset($request->confirmed);
            $ce->time = $request->time;
            $ce->duration = $request->duration;
            $ce->capacity = $request->capacity;
            $ce->save();
            return 'ok';
        }
    }

	static function getIntervalSchedule($start_date, $end_date, $bookable_only = 0)
	{
		// devuelve colección de CE
        
		return Calendarevent::whereDate('date', '>=', $start_date)
                            ->whereDate('date', '<=', $end_date)
                            ->where('capacity', '>=', $bookable_only)
                            ->orderBy('date', 'ASC')
                            ->orderBy('time', 'ASC')->get();
	}

}
