<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Controllers\AvailabilityHoldController;
use App\Booking;
use App\Calendarevent;

use Cookie;
use Log;

use \DateTimeZone;
use \DateTime;

class TPVController extends Controller
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
					return redirect()->route('booking', ['param' => json_encode($bkg, JSON_NUMERIC_CHECK)]);
				}
			} else {
				// comprobar disponibilidad una última vez antes de pagar
				$travellers = $bkg->adult + $bkg->child;
				$reference = Cookie::get('laravel_session');
				if (Calendarevent::find($bkg->calendarevent_id)->getAvailableCovid($travellers, $reference) >= $travellers)
				{
					AvailabilityHoldController::addOrRefresh($bkg->calendarevent_id, $reference, $travellers, 'PT300S');
					return view('tpv.pay')->with('bkg', $bkg);
				} else {
					AvailabilityHoldController::remove($reference);
					return redirect()->route('booking', ['param' => json_encode($bkg, JSON_NUMERIC_CHECK), 'tpv_result' =>'NOAVAILABILITY']);
				}
			}
    	}
    }

    public function callback(Request $request)
    {
    	$version = $request->input('Ds_SignatureVersion');
    	$params = $request->input('Ds_MerchantParameters');
    	$signatureRecibida = $request->input('Ds_Signature');

    	$Secret = config('cookingpoint.redsys.firma');

		$myObj = new RedsysAPI;
		$bookingcontroller = new BookingController;

		$expected_signature = $myObj->createMerchantSignatureNotif($Secret, $params);
		$decodec = $myObj->decodeMerchantParameters($params);

		$Ds_Date = $myObj->getParameter('Ds_Date');
		$Ds_Hour = $myObj->getParameter('Ds_Hour');
		$Ds_Amount = $myObj->getParameter('Ds_Amount');
		$Ds_Order = $myObj->getParameter('Ds_Order');
		$Ds_Response = $myObj->getParameter('Ds_Response');
		$Ds_MerchantData = $myObj->getParameter('Ds_MerchantData');
		$Ds_AuthorisationCode = $myObj->getParameter('Ds_AuthorisationCode');

		if ($expected_signature != $signatureRecibida) {
			Log::error("Signature not valid (locator: $Ds_MerchantData");
			exit();
		}

		// to the log
		// Log::info("Redsys callback received: locator $Ds_MerchantData, response $Ds_Response");

		$a = "$Ds_Date $Ds_Hour";
		//error_log("la fecha y hora es: $a");
		$madridTz = new DateTimeZone("Europe/Madrid");
		$timestamp = DateTime::createFromFormat("d/m/Y H:i", $a, $madridTz);

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
			AvailabilityHoldController::remove(Cookie::get('laravel_session'));
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

}
