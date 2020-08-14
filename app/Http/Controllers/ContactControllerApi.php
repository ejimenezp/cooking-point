<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Booking;
use App\Calendarevent;
// use Log;

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

    function contactonlineclasses(Request $request)
    {
        try {
            $bkg = new Booking();
            $ce = Calendarevent::first();
            $bkg->name = $request->name;
            $bkg->email = $request->email;
            $bkg->comments = $request->message;
            $bkg->calendarevent = $ce;

            MailController::send_mail($bkg->email, $bkg, 'user_message_online_classes');
            MailController::send_mail('info@cookingpoint.es', $bkg, 'admin_new_message');
            
        } catch (Exception $e) 
        {
            return Response::json('Oops! Something went wrong. Please email us at info@cookingpoint.es', 403);
        }
    } 

    function googleadswebhook(Request $request)
    {
        try {
            // Log::info($request);
            $gname = $request->user_column_data[0]['string_value'];
            $gemail = $request->user_column_data[1]['string_value'];

            $bkg = new Booking();
            $ce = Calendarevent::first();
            $bkg->name = $request->user_column_data[0]['string_value'];
            $bkg->email = $request->user_column_data[1]['string_value'];
            $bkg->comments = "(Vacío. Notificación automática desde el buscador de Google)";
            $bkg->calendarevent = $ce;

            MailController::send_mail($bkg->email, $bkg, 'user_message');
            MailController::send_mail('info@cookingpoint.es', $bkg, 'admin_new_message');
            
        } catch (Exception $e) 
        {
            return Response::json('Parece que hay problemas. Por favor, envíanos un correo a info@cookingpoint.es', 403);
        }
    }
}
