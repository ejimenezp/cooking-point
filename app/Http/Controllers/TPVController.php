<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Booking;
use Cookie;
use Log;
use RedsysAPI;

class TPVController extends Controller
{

	public function pay($id)
	{
		Log::info("llegados a pay, reserva con id $id");

		$bkg = Booking::find($id);
		if (!$bkg) { 	
			// esta reserva no está en la base de datos
			Log::error("la reserva con id $id no existe");
			return view('errors.wrongLocator');	 		
		} else {
			Cookie::queue(Cookie::forever('cplocator', $bkg->locator));
			if ($bkg->status_major != 'PENDING') {
			return view('booking.index')->with('page', 'booking');
			} else {
				Log::info("llamamos a tpv.pay ");
				return view('tpv.pay')->with('bkg', $bkg);
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
			Log::error("Signature not valid (hash: $Ds_MerchantData");
			exit();
		}

		// to the log

		$a = "$Ds_Date $Ds_Hour";
		//error_log("la fecha y hora es: $a");
		$madridTz = new DateTimeZone("Europe/Madrid");
		$timestamp = DateTime::createFromFormat("d/m/Y H:i", $a, $madridTz);

		// LegacyModel::to_tpv_log ( $Ds_Order, '', $Ds_MerchantData, $Ds_Amount, $Ds_Response, $Ds_AuthorisationCode, $tpvDate );

        $bkg = self::findByLocator($Ds_MerchantData);
        if ($Ds_Response < 100) {
            $bkg->status_major = 'PAID';
            $bkg->payment_date = $timestamp->format('Y-m-d H:i:s');
        } else {
            $bkg->status_major = 'PENDING';
        }
        $bkg->save();

		LegacyMail::mail_to_user($bkg, "legacy/status_PA");
		 $admin_mail_subject = "$bkg->type on $bkg->date for $bkg->adult +$bkg->child";
		LegacyMail::mail_to_admin($bkg, 'Payment', 'eduardo@cookingpoint.es', $admin_mail_subject, "legacy/admin_notice_PA.html");

    	return view('tpv.callback');
    }

}
