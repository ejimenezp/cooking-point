<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Booking;
use App\Source;

use Log;

class BookingController extends Controller
{

    function add(Request $request)
    {
    	// check event does not exist already
        // if ( CalendarEvent::where('type', $request->type)->
        //                     where('date', $request->date)->
        //                     where('time', $request->time)->count() > 0 ) {
        //     return 'fail';
        // }

    	$bkg = new Booking();
    	$bkg->calendarevent_id = $request->calendarevent_id;
    	$bkg->source_id = $request->source_id;
    	$bkg->status_major = $request->status_major;
    	$bkg->status_minor = $request->status_minor;
    	$bkg->locator = $this->newLocator();
    	$bkg->name = $request->name;
    	$bkg->email = $request->email;
    	$bkg->phone = $request->phone;
    	$bkg->adult = $request->adult;
    	$bkg->child = $request->child;
    	$bkg->pay_method = $request->pay_method;    	
    	$bkg->food_requirements = $request->food_requirements;
    	$bkg->comments = $request->comments;
        $bkg->payment_date = $request->payment_date;
        $bkg->crm = (isset($request->hash) ? $request->crm : 'YES');

    	$source = Source::find($request->source_id);
    	$bkg->iva = $source->priceplan->iva;
    	$bkg->price = $source->priceplan->adult * $request->adult + $source->priceplan->child * $request->child;
        // backwards compatibility
        $bkg->hash = (isset($request->hash) ? $request->hash : '');
    	$bkg->save();
    	return ['status' => 'ok', 'data' => $bkg];

    }

    function delete($id)
    {
        $ce = Booking::find($id);
        if (!$ce) {
            return 'fail';
        } else {
            $ce->delete();   
            return 'ok';
        }
    }

    function findBy($locator)
    {
        return Booking::where('locator', $locator)->first();
    }

    function index($ce_id)
    {
    	return Booking::where('calendarevent_id', $ce_id)
	    				->orderBy('adult', 'DESC')
	    				->orderBy('child', 'DESC')
	    				->orderBy('name', 'ASC')
	    				->get();
    }

    function newLocator()
    {
    	$locator = '';
    	$letters = str_split('ABCDEFGHJKLMNPQRSTUVWXYZ');
    	$digits = str_split('0123456789');
    	$count_letters = count($letters) - 1;
    	$count_digits = count($digits) - 1;

    	for ($i = 1; $i <= 3; $i++) {
    		$k = random_int(0, $count_letters);
    		$locator .= $letters[$k];
    	}
    	for ($i = 1; $i <= 3; $i++) {
    		$k = random_int(0, $count_digits);
    		$locator .= $digits[$k];
    	}

    	return $locator;
    }

    function update(Request $request)
    {
        $bkg = Booking::find($request->id);
        if (!$bkg) {
            return ['status' => 'fail', 'data' => 'wrong bkg->id'];
        } else {
            $bkg->calendarevent_id = $request->calendarevent_id;
            $bkg->source_id = $request->source_id;
            $bkg->status_minor = $request->status_minor;
            $bkg->locator = $request->locator;
            $bkg->name = $request->name;
            $bkg->email = $request->email;
            $bkg->phone = $request->phone;
            $bkg->adult = $request->adult;
            $bkg->child = $request->child;
            $bkg->phone = $request->phone;
            $bkg->pay_method = $request->pay_method;        
            $bkg->food_requirements = $request->food_requirements;
            $bkg->comments = $request->comments;
            $bkg->crm = $request->crm;
            $bkg->iva = $request->iva;
            $bkg->price = $request->price;
            $bkg->save();
            return ['status' => 'ok', 'data' => $bkg];
        }
    }

    function email($bkg) {
        MailController::send_mail($bkg->email, $bkg, 'voucher');
        MailController::send_mail('eduardo@cookingpoint.es', $bkg, 'admin_notice_PA');
    }

}
