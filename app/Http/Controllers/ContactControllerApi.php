<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Booking;
use App\Calendarevent;

class ContactControllerApi extends Controller
{
    function contactoeventos(Request $request)
    {
        try {
            $bkg = new Booking();
            $ce = Calendarevent::first();
            $bkg->name = $request->name;
            $bkg->email = $request->email;
            $bkg->comments = $request->message;
            $bkg->calendarevent = $ce;

            MailController::send_mail($bkg->email, $bkg, 'user_message');
            MailController::send_mail('info@cookingpoint.es', $bkg, 'admin_new_message');
            
        } catch (Exception $e) 
        {
            return Response::json('Parece que hay problemas. Por favor, envíanos un correo a info@cookingpoint.es', 403);
        }



    }

}
