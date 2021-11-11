<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Cookie;
use stdClass;
use DateTime;
use DateInterval;
use DateTimeZone;

use App\Booking;
use App\Source;
use App\Priceplan;
use App\CalendarEvent;
use App\Timezone;

use Log;

class BookingController extends Controller
{

    function get(Request $request)
    {
        if (!$request->locator) {
            $date = new DateTime(isset($request->date) ? $request->date : "now", new DateTimeZone('Europe/Madrid'));
            $bkg = new stdClass();
            $bkg->calendarevent_id = 0;
            $bkg->locator = '';
            $bkg->adult = 0;
            $bkg->child = 0;
            $bkg->type = isset($request->class) ? $request->class : 'PAELLA';
            $bkg->onlineclass = (int) isset($request->onlineclass);
            $bkg->source_id = 2;
            $bkg->phone = '';
            $bkg->status = 'PENDING';
            $bkg->status_filter = 'DO_NOT_COUNT';
            $bkg->pay_method = 'N/A';
            $bkg->crm = 'YES';
            $bkg->comments = '';
            $bkg->food_requirements = '';
            $bkg->date = $date->format('Y-m-d');
            return view('booking.index', ['param' => json_encode($bkg)]);
        } else {
            $bkg = Booking::where('locator', $request->locator)->first()->makeVisible('calendarevent');
            if (!$bkg) {    
                return view('errors.wrongLocator');          
            } else {
                if (isset($request->tpv_result)) {
                    $bkg->tpv_result = $request->tpv_result;
                }
                return response()->view('booking.index', ['param' => json_encode($bkg, JSON_NUMERIC_CHECK)])->cookie('cplocator', $bkg->locator, 525600);
            }
        }
    }


    function add(Request $request)
    {

        $bkg = new Booking();
        $bkg->calendarevent_id = $request->calendarevent_id;
        $bkg->source_id = $request->source_id;
        $bkg->status = $request->status;
        switch ($bkg->status) {
            case 'PENDING':
            case 'CANCELED':
                $bkg->status_filter = 'DO_NOT_COUNT';
                break;          
            default:
                $bkg->status_filter = 'REGISTERED';
                break;
        }
        $bkg->locator = $this->newLocator();
        $bkg->name = $request->name;
        $bkg->email = $request->email;
        $bkg->phone = $request->phone;
        $bkg->adult = $request->adult;
        $bkg->child = $request->child;
        $bkg->pay_method = $request->pay_method;        
        $bkg->payment_date = $request->payment_date;        
        $bkg->food_requirements = $request->food_requirements;
        $bkg->comments = $request->comments;
        $bkg->payment_date = (empty($request->payment_date)) ? null : $request->payment_date;
        $bkg->crm = $request->crm;

        $source = Source::find($request->source_id);
        $bkg->iva = $source->iva;
        $bkg->price = $request->price;
        $bkg->hide_price = !empty($request->hide_price);
        if ($bkg->calendarevent->type == 'GROUP') {
            $bkg->fixed_date = true;    
        } else {
            $bkg->fixed_date = !empty($request->fixed_date);           
        }
        $bkg->invoice = $request->invoice;

        $bkg->tz = $request->tz;
        $bkg->onlineclass = (empty($request->onlineclass)) ? 0 : $request->onlineclass;
        $bkg->save();
        Cookie::queue(Cookie::forever('cplocator', $bkg->locator));
        return $bkg->makeVisible('calendarevent');

    }
    

    function update(Request $request)
    {
        $bkg = Booking::find($request->id);
        if (!$bkg) {
            return response()->json('Esta reserva ya no existe', 350);;
        } else {
            $bkg->calendarevent_id = $request->calendarevent_id;
            $bkg->source_id = $request->source_id;
            $bkg->status = $request->status;
            switch ($bkg->status) {
                case 'PENDING':
                case 'CANCELED':
                    $bkg->status_filter = 'DO_NOT_COUNT';
                    break;          
                default:
                    $bkg->status_filter = 'REGISTERED';
                    break;
            }
            $bkg->locator = $request->locator;
            $bkg->name = $request->name;
            $bkg->email = $request->email;
            $bkg->phone = $request->phone;
            $bkg->adult = $request->adult;
            $bkg->child = $request->child;
            $bkg->pay_method = $request->pay_method;                    
            $bkg->payment_date = (empty($request->payment_date)) ? null : $request->payment_date;
            $bkg->food_requirements = $request->food_requirements;
            $bkg->comments = $request->comments;
            $bkg->crm = $request->crm;
            $bkg->iva = !empty($request->iva);
            $bkg->price = $request->price;
            $bkg->hide_price = !empty($request->hide_price);
            $bkg->fixed_date = !empty($request->fixed_date);
            $bkg->invoice = $request->invoice;
            $bkg->tz = empty($request->tz) ? null : $request->tz;
            $bkg->onlineclass = $request->onlineclass;

            $bkg->save();
            return $bkg->makeVisible('calendarevent');
        }
    }


    function delete($id)
    {
        $ce = Booking::find($id);
        if (!$ce) {
            return response()->json(['msg' => 'Not Found'], 404);
        } else {
            $ce->delete();   
            return;
        }
    }

    function findBy($locator)
    {
        return Booking::where('locator', $locator)->first();
    }
    
    function index($ce_id)
    {
        return Booking::where('calendarevent_id', $ce_id)
                        ->orderBy('created_at', 'ASC')
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


    function emailIt(Request $request) {
        $bkg = Booking::find($request->id);
        if ($bkg->onlineclass) {
           MailController::send_mail($bkg->email, $bkg, 'user_voucher_onlineclass');           
        } else {
           MailController::send_mail($bkg->email, $bkg, 'user_voucher');           
        }
    }

    function cancelIt(Request $request) {
        $request->status = 'CANCELED';
        $bkg = $this->update($request);
        MailController::send_mail($bkg->email, $bkg, 'user_cancellation');
        MailController::send_mail('info@cookingpoint.es', $bkg, 'admin_cancel_request');
        return $bkg;
    }

    function viatorCancel($locator, $cdate)
    {

        $canceldate = new DateTime($cdate);

        $bkg = Booking::where('locator', $locator)->first();
        if (!$bkg) {
            return ['status' => 'fail', 'reason' => 'OTHER', 'details' => 'Wrong Supplier Confirmation Number'];
        } else {
            // Log::debug('travel: ' . $bkg->calendarevent->date . ' cancel ' . $cdate);
            $traveldate = new DateTime($bkg->calendarevent->date);
            if ($canceldate > $traveldate) {
                return ['status' => 'fail', 'reason' => 'PAST_TOUR_DATE', 'details' => 'Tour Already Done'];
            } elseif ($canceldate->add(new DateInterval('P2D')) > $traveldate) {
                return ['status' => 'fail', 'reason' => 'PAST_CANCEL_DATE', 'details' => 'Too Late to Cancel'];
            } else {
                $bkg->status = 'CANCELED';
                $bkg->status_filter = 'DO_NOT_COUNT';
                $bkg->save();
                MailController::send_mail('info@cookingpoint.es', $bkg, 'admin_cancel_request');
                return ['status' => 'ok'];
            }
        }
    }


    function thirdpartypaymentget(Request $request)
    {
        $bkg = Booking::where('locator', $request->locator)->first();
        if (!$bkg) {    
            return view('errors.wrongLocator');          
        } else {
            $tpv_result = isset($request->tpv_result) ? $request->tpv_result : '';
            return response()->view('pages.paymentrequest', ['bkg' => $bkg, 'tpv_result' => $tpv_result]);
        }
    }


    function forget(Request $request)
    {
        $bkg = $this->findBy($request->cookie('cplocator'));
        if (isset($bkg->onlineclass) && $bkg->onlineclass) {
            return redirect('/booking?onlineclass')->withCookie(Cookie::forget('cplocator'));
        } else {
            return redirect('/booking')->withCookie(Cookie::forget('cplocator'));
        }
    }

    function timezones()
    {
        return response()->json(Timezone::get());
    }

}
