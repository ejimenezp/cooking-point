<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Booking;
use Cookie;
use Log;

use \DateTimeZone;
use \DateTime;

class TPVControllerStub extends Controller
{

	public function pay($id)
	{
		// backwards compatibility
		if (is_numeric($id)) {
			$bkg = Booking::find($id);
		} else {
			$controller = new BookingController;
			$bkg = $controller->findByHash($id);			
		}
		if (!$bkg) { 	
			// esta reserva no está en la base de datos
			return view('errors.wrongLocator');	 		
		} else {
			Cookie::queue(Cookie::forever('cplocator', $bkg->locator));
			if ($bkg->status != 'PENDING') {
				if ($bkg->calendarevent->type == 'PAYREQUEST') {
					return view('pages.paymentrequest', ['bkg'=> $bkg, 'tpv_result' =>'']);
				} else {
					return view('booking.index', ['page' => 'booking', 'tpv_result' =>'']);
				}
			} else {
				return view('tpv.pay-stub')->with('bkg', $bkg);
			}
    	}
    }



    public function callback(Request $request)
    {

		$Ds_Response = $request->Ds_Response;
		$Ds_MerchantData = $request->Ds_MerchantData;
		$Ds_Date = $request->Ds_Date;
		$Ds_Hour = $request->Ds_Hour;

		// to the log
		// Log::info("Redsys callback received: locator $Ds_MerchantData, response $Ds_Response");

		$a = "$Ds_Date $Ds_Hour";
		//error_log("la fecha y hora es: $a");
		$madridTz = new DateTimeZone("Europe/Madrid");
		$timestamp = DateTime::createFromFormat("d/m/Y H:i", $a, $madridTz);

		Log::info($request);

				$bookingcontroller = new BookingController;

        $bkg = $bookingcontroller->findBy($Ds_MerchantData);
        if ($Ds_Response < 100) {
            $bkg->status = 'PAID';
            $bkg->status_filter = 'REGISTERED';
            $bkg->pay_method = 'ONLINE';
            $bkg->payment_date = $timestamp->format('Y-m-d H:i:s');
            if ($bkg->crm != 'NO') {
            	$bkg->crm = 'YES';
            }
	        $bkg->save();
	        if ($bkg->calendarevent->type == 'PAYREQUEST') {
							MailController::send_mail('info@cookingpoint.es', $bkg, 'admin_3rdpartypayment');
	        } else if ($bkg->onlineclass) {
							MailController::send_mail($bkg->email, $bkg, 'user_voucher_onlineclass');
							MailController::send_mail('info@cookingpoint.es', $bkg, 'admin_new_booking');
	        } else {
							MailController::send_mail($bkg->email, $bkg, 'user_voucher');
							MailController::send_mail('info@cookingpoint.es', $bkg, 'admin_new_booking');
	        }
        } else {
            $bkg->status = 'PENDING';
            $bkg->status_filter = 'DO_NOT_COUNT';
	        $bkg->save();
	        // send recovery mail only first time
            if ($bkg->crm != 'NO') {
            	if ($bkg->crm != 'PAYMENT_KO') {
            			MailController::send_mail($bkg->email, $bkg, 'payment_ko');
            			$bkg->crm = 'PAYMENT_KO';
            			$bkg->save();
            	}
            }
        }
    	return view('tpv.callback');
    }


    public function tpvstub (Request $request)
    {
    	return view('tpv.tpv-stub', ['Ds_MerchantParameters' => $request->Ds_MerchantParameters]);
    }
}
