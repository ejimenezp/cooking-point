<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;

use App\Http\Controllers\CalendareventController;
use App\Http\Controllers\AvailabilityHoldController;

use App\Viator\ViatorRequestStatus;
use App\Viator\ViatorTourAvailability;

use Log;

class ViatorController extends Controller
{
    private $resp;

    function main(Request $request)
    {
        $this->resp = (object) array();
        $this->resp->data = (object) array();
        $requestdata = $request->data;
        // Log::info($request);

        // Basic error checking

        // Fields common to all responses

        $this->resp->data->ApiKey = $requestdata['ApiKey'];
        $this->resp->data->ResellerId = $requestdata['ResellerId'];
        $this->resp->data->SupplierId = $requestdata['SupplierId'];
        if (isset($requestdata['ExternalReference']))
            $this->resp->data->ExternalReference = $requestdata['ExternalReference'];
        $atom_time = (new \DateTime)->format(DATE_ATOM);
        $micro = microtime(true);
        $milliseconds = sprintf('%03d', round(($micro - floor($micro)) * 1000));
        $this->resp->data->Timestamp = str_replace('+', ".{$milliseconds}+", $atom_time);
        $this->resp->data->RequestStatus['Status'] = 'SUCCESS';

        if (isset($requestdata['StartDate']) && !isset($requestdata['EndDate']))
            $requestdata['EndDate'] = $requestdata['StartDate'];

        switch ($request->requestType) {
            case 'AvailabilityRequest':
                $this->availabilityrequest($requestdata);
                break;
            case 'BatchAvailabilityRequest':
                $this->batchavailabilityrequest($requestdata);
                break;
            case 'BookingRequest':
                $this->bookingrequest($requestdata);
                break;
            case 'BookingAmendmentRequest':
                $this->bookingamendmentrequest($requestdata);
                break;
            case 'BookingCancellationRequest':
                $this->bookingcancellationrequest($requestdata);
                break;
            case 'TourListRequest':
                $this->tourlistrequest();
                break;

            default:
                $error = new ViatorRequestStatus;
                $error->Status = 'ERROR';
                $error->Error->ErrorCode = 'UNSUPPORTED_API';
                $error->Error->ErrorMessage = 'Function Not Supported (' . $request->requestType . ')';
                $this->resp->data->RequestStatus = $error;
        }
        // Log::debug(json_encode($this->resp));
        return response()->json($this->resp);
    }

    private function availabilityrequest ($requestdata)
    {
        $this->resp->responseType = 'AvailabilityResponse';

        $start = new Carbon($requestdata['StartDate']);
        $end = new Carbon($requestdata['EndDate']);
        $travellers = isset($requestdata['TravellerMix']['Total']) ? $requestdata['TravellerMix']['Total'] : 0;
        $reference = isset($requestdata['AvailabiltyHoldReference']) ? $requestdata['AvailabiltyHoldReference'] : $requestdata['ExternalReference'];
        $calendareventcontroller = new CalendareventController;
        $hoy = Carbon::now('Europe/Madrid');

        $ce_type = $requestdata['SupplierProductCode'];
        if (!in_array($ce_type, ['PAELLA', 'TAPAS'])) {
            $error = new ViatorRequestStatus;
            $error->Status = 'ERROR';
            $error->Error->ErrorCode = 'WRONG_SUPPLIER_PRODUCT_CODE';
            $error->Error->ErrorMessage = 'Product Code Does Not Exist (' . $ce_type . ')';
            $this->resp->data->RequestStatus = $error;
            return;
        } else {
            $this->resp->data->SupplierProductCode = $requestdata['SupplierProductCode'];
        }

        for ($date = $start; $date->diffInDays($end, false) >= 0; $date->addDay())
        {
            $availability = new ViatorTourAvailability;
            // Log::debug('fecha ' . $date . ' type ' . $ce_type);
            if ($date->lt($hoy)) {
                $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                $availability->AvailabilityStatus->UnavailabilityReason = 'PAST_CUTOFF_DATE';
                unset($availability->AvailabilityHold);
                $this->resp->data->TourAvailability[] = $availability;
                continue;
            }
            $ce = $calendareventcontroller->findByDateAndType($date, $ce_type);
            if ($ce) {
                list($availability->BookingCutoff['DateTime'],
                    $availability->AvailabilityStatus->Capacity,
                    $availability->AvailabilityStatus->Status,
                    $availability->AvailabilityStatus->UnavailabilityReason) 
                = $ce->checkAvailabilityAsOfNow($travellers, $reference);
                if ($availability->AvailabilityStatus->Status == 'AVAILABLE') {
                    unset($availability->AvailabilityStatus->UnavailabilityReason);
                    if (isset($requestdata['AvailabilityHold']['Expiry'])) {
                        $availability->AvailabilityHold->Expiry = $requestdata['AvailabilityHold']['Expiry'];
                        $availability->AvailabilityHold->Reference = $reference;
                        AvailabilityHoldController::addOrRefresh(
                            $ce->id,
                            $reference,
                            $travellers,
                            $requestdata['AvailabilityHold']['Expiry']);
                    } else {
                        unset($availability->AvailabilityHold);
                    }
                }
            } else {
                $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                $availability->AvailabilityStatus->UnavailabilityReason = 'BLOCKED_OUT';
                unset($availability->AvailabilityHold);
            }
            $availability->Date = $date->toDateString();
            $this->resp->data->TourAvailability[] = $availability;
        }
    }

    private function batchavailabilityrequest ($requestdata)
    {
        $this->resp->responseType = 'BatchAvailabilityResponse';

        $start = new Carbon($requestdata['StartDate']);
        $end = new Carbon($requestdata['EndDate']);
        $travellers = isset($requestdata['TravellerMix']['Total']) ? $requestdata['TravellerMix']['Total'] : 0;
        $reference = isset($requestdata['ExternalReference']) ? $requestdata['ExternalReference'] : $requestdata['ApiKey'];
        $calendareventcontroller = new CalendareventController;
        $hoy = Carbon::now('Europe/Madrid');

        if (!isset($requestdata['SupplierProductCode'])) {
            $requestdata['SupplierProductCode'] = ['PAELLA', 'TAPAS'];   
        } elseif (!is_array($requestdata['SupplierProductCode'])) {
            $requestdata['SupplierProductCode'] = (array) $requestdata['SupplierProductCode'];
        }

        for ($date = $start; $date->diffInDays($end, false) >= 0; $date->addDay())
        {
            foreach ($requestdata['SupplierProductCode'] as $ce_type)
            {
                if (!in_array($ce_type, ['PAELLA', 'TAPAS'])) {
                    $error = new ViatorRequestStatus;
                    $error->Status = 'ERROR';
                    $error->Error->ErrorCode = 'WRONG_SUPPLIER_PRODUCT_CODE';
                    $error->Error->ErrorMessage = 'Product Code Does Not Exist (' . $ce_type . ')';
                    $this->resp->data->RequestStatus = $error;
                    return;
                }
                $availability = new ViatorTourAvailability;
                $availability->Date = $date->toDateString();
                $availability->SupplierProductCode = $ce_type;

                if ($date->lt($hoy)) {
                    $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                    $availability->AvailabilityStatus->UnavailabilityReason = 'PAST_CUTOFF_DATE';
                    $this->resp->data->BatchTourAvailability[] = $availability;
                    continue;
                }
                $ce = $calendareventcontroller->findByDateAndType($date, $ce_type);
                if ($ce) {
                    list($availability->BookingCutoff['DateTime'],
                        $availability->AvailabilityStatus->Capacity,
                        $availability->AvailabilityStatus->Status,
                        $availability->AvailabilityStatus->UnavailabilityReason) 
                    = $ce->checkAvailabilityAsOfNow($travellers, $reference);
                } else {
                    $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                    $availability->AvailabilityStatus->UnavailabilityReason = 'BLOCKED_OUT';
                }
                if ($availability->AvailabilityStatus->UnavailabilityReason == '') {
                    unset($availability->AvailabilityStatus->UnavailabilityReason);
                }
                $this->resp->data->BatchTourAvailability[] = $availability;
            }
        }
    }

    private function bookingrequest ($requestdata)
    {
        $this->resp->responseType = 'BookingResponse';

        $laravelrequest = new Request;
        $calendareventcontroller = new CalendareventController;
        $bookingcontroller = new BookingController;

        $traveldate = new Carbon($requestdata['TravelDate']);
        $travellers = $requestdata['TravellerMix']['Total'];
        $reference = isset($requestdata['AvailabilityHoldReference']) ? $requestdata['AvailabilityHoldReference'] : $requestdata['ExternalReference'];

        if (!in_array($requestdata['SupplierProductCode'], ['PAELLA', 'TAPAS'])) {
            $error = new ViatorRequestStatus;
            $error->Status = 'ERROR';
            $error->Error->ErrorCode = 'WRONG_SUPPLIER_PRODUCT_CODE';
            $error->Error->ErrorMessage = 'Product Code Does Not Exist (' . $requestdata['SupplierProductCode'] . ')';
            $this->resp->data->RequestStatus = $error;
            return;
        }

        $ce = $calendareventcontroller->findByDateAndType($traveldate, $requestdata['SupplierProductCode']);

        if ($ce) {

            if ($travellers > $ce->getAvailableCovid($travellers, $reference)) {
                // Log::info('no existe reference ' . $reference);
                $this->resp->data->TransactionStatus['Status'] = 'REJECTED';
                $this->resp->data->TransactionStatus['RejectedReason'] = 'BOOKED_OUT_ALT_DATES';
                $this->resp->data->TransactionStatus['RejectedReasonDetails'] = 'Please, check other dates';
            } else {
                // new booking
                $laravelrequest->calendarevent_id = $ce->id;
                $laravelrequest->source_id = 5; // MARKETPLACE: Viator (sources DB table)
                $laravelrequest->status = 'CONFIRMED';

                for ($i = count($requestdata['Traveller'])-1; !$requestdata['Traveller'][$i]['LeadTraveller'] && $i >= 0; $i--) {
                    # code...
                }
                if (array_key_exists('GivenName', $requestdata['Traveller'][$i])) {
                    $laravelrequest->name = $requestdata['Traveller'][$i]['GivenName'].' '.$requestdata['Traveller'][$i]['Surname'];
                } else {
                     $laravelrequest->name = $requestdata['Traveller'][$i]['Surname'];
                }

                $laravelrequest->email = $requestdata['ContactDetail']['ContactType'] == 'EMAIL' ? $requestdata['ContactDetail']['ContactValue'] : '';
                $laravelrequest->phone = $requestdata['ContactDetail']['ContactType'] == 'ALTERNATE' ? $requestdata['ContactDetail']['ContactValue'] : '';
                $laravelrequest->adult = $requestdata['TravellerMix']['Adult'];
                $laravelrequest->child = $requestdata['TravellerMix']['Child'];
                $laravelrequest->price = $requestdata['Amount'];
                $laravelrequest->pay_method = 'N/A';
                $laravelrequest->food_requirements = isset($requestdata['SpecialRequirement']) ? $requestdata['SpecialRequirement'] : '';
                $laravelrequest->comments = 'BR-' . $requestdata['BookingReference'];
                if (isset($requestdata['SupplierNote'])) {
                    $laravelrequest->comments .= '; ' . $requestdata['SupplierNote'];
                }
                $laravelrequest->payment_date = '';
                $laravelrequest->crm = 'YES';
                $laravelrequest->invoice = '';
                $laravelrequest->hide_price = 'YES';

                $controllerresponse = $bookingcontroller->add($laravelrequest);

                AvailabilityHoldController::remove($reference);
                $bkg = $bookingcontroller->findBy($controllerresponse['locator']);
                if ($bkg) {
                    MailController::send_mail('info@cookingpoint.es', $bkg, 'admin_new_booking');
                }

                $this->resp->data->TransactionStatus['Status'] = 'CONFIRMED';
                $this->resp->data->SupplierConfirmationNumber = $controllerresponse['locator'];

            }
        } else {
            $this->resp->data->TransactionStatus['Status'] = 'REJECTED';
            $this->resp->data->TransactionStatus['RejectedReason'] = 'NOT_OPERATING';
            $this->resp->data->TransactionStatus['RejectedReasonDetails'] = 'Please, check other dates';
        }
    }

    private function bookingamendmentrequest ($requestdata)
    {
        // Log::debug(print_r($requestdata, true));
        $this->resp->responseType = 'BookingAmendmentResponse';

        $laravelrequest = new Request;
        $calendareventcontroller = new CalendareventController;
        $bookingcontroller = new BookingController;

        $traveldate = new Carbon($requestdata['TravelDate']);
        $travellers = $requestdata['TravellerMix']['Total'];
        $reference = isset($requestdata['AvailabilityHoldReference']) ? $requestdata['AvailabilityHoldReference'] : $requestdata['ExternalReference'];

        if (!in_array($requestdata['SupplierProductCode'], ['PAELLA', 'TAPAS'])) {
            $error = new ViatorRequestStatus;
            $error->Status = 'ERROR';
            $error->Error->ErrorCode = 'WRONG_SUPPLIER_PRODUCT_CODE';
            $error->Error->ErrorMessage = 'Product Code Does Not Exist (' . $requestdata['SupplierProductCode'] . ')';
            $this->resp->data->RequestStatus = $error;
            return;
        }

        $laravelbkg = $bookingcontroller->findBy($requestdata['SupplierConfirmationNumber']);
        if (!$laravelbkg) {
            $error = new ViatorRequestStatus;
            $error->Status = 'ERROR';
            $error->Error->ErrorCode = 'WRONG_SUPPLIER_CONFIRMATION_NUMBER';
            $error->Error->ErrorMessage = 'Confirmation Number Does Not Exist (' . $requestdata['SupplierConfirmationNumber'] . ')';
            $this->resp->data->RequestStatus = $error;
            return;
        }

        $laravelrequest->id = $laravelbkg->id;

        $ce = $calendareventcontroller->findByDateAndType($traveldate, $requestdata['SupplierProductCode']);

        if ($ce) {

            $registered = $ce->registered;
            if ($ce->id == $laravelbkg->calendarevent_id) {
                $registered = $registered - $laravelbkg->adult - $laravelbkg->child;
            }
            if ($travellers > $ce->getAvailableCovid($travellers, $reference)) {
                $this->resp->data->TransactionStatus['Status'] = 'REJECTED';
                $this->resp->data->TransactionStatus['RejectedReason'] = 'BOOKED_OUT_ALT_DATES';
                $this->resp->data->TransactionStatus['RejectedReasonDetails'] = 'Please, check other dates';
            } else {
                $laravelrequest->calendarevent_id = $ce->id;
                $laravelrequest->source_id = 5; // MARKETPLACE: Viator (sources DB table)
                $laravelrequest->status = 'CONFIRMED';

                if (array_key_exists('GivenName', $requestdata['Traveller'][0])) {
                    $laravelrequest->name = $requestdata['Traveller'][0]['GivenName'].' '.$requestdata['Traveller'][0]['Surname'];
                } else {
                    $laravelrequest->name = $requestdata['Traveller'][0]['Surname'];                    
                }

                $laravelrequest->email = $requestdata['ContactDetail']['ContactType'] == 'EMAIL' ? $requestdata['ContactDetail']['ContactValue'] : '';
                $laravelrequest->phone = $requestdata['ContactDetail']['ContactType'] == 'ALTERNATE' ? $requestdata['ContactDetail']['ContactValue'] : '';
                $laravelrequest->adult = $requestdata['TravellerMix']['Adult'];
                $laravelrequest->child = $requestdata['TravellerMix']['Child'];
                $laravelrequest->pay_method = 'N/A';
                $laravelrequest->food_requirements = isset($requestdata['SpecialRequirement']) ? $requestdata['SpecialRequirement'] : '';
                $laravelrequest->comments = 'BR-' . $requestdata['BookingReference'];
                if (isset($requestdata['SupplierNote'])) {
                    $laravelrequest->comments .= '; ' . $requestdata['SupplierNote'];
                }
                $laravelrequest->price = $requestdata['Amount'];
                $laravelrequest->locator = $laravelbkg->locator;
                $laravelrequest->payment_date = $laravelbkg->payment_date;
                $laravelrequest->crm = $laravelbkg->crm;
                $laravelrequest->invoice = $laravelbkg->invoice;
                $laravelrequest->hide_price = $laravelbkg->hide_price;
                $laravelrequest->onlineclass = 0;

                $controllerresponse = $bookingcontroller->update($laravelrequest);

                $this->resp->data->TransactionStatus['Status'] = 'CONFIRMED';
                $this->resp->data->SupplierConfirmationNumber = $controllerresponse['locator'];
                MailController::send_mail('info@cookingpoint.es', $laravelrequest, 'admin_viator_amendment');


            }
        } else {
            $this->resp->data->TransactionStatus['Status'] = 'REJECTED';
            $this->resp->data->TransactionStatus['RejectedReason'] = 'NOT_OPERATING';
            $this->resp->data->TransactionStatus['RejectedReasonDetails'] = 'Please, check other dates';
        }
    }

    private function bookingcancellationrequest ($requestdata)
    {
        // Log::debug($requestdata);
        $this->resp->responseType = 'BookingCancellationResponse';

        $bookingcontroller = new BookingController;

        $laravelbkg = $bookingcontroller->findBy($requestdata['SupplierConfirmationNumber']);
        if (!$laravelbkg) {
            $error = new ViatorRequestStatus;
            $error->Status = 'ERROR';
            $error->Error->ErrorCode = 'WRONG_SUPPLIER_CONFIRMATION_NUMBER';
            $error->Error->ErrorMessage = 'Confirmation Number Does Not Exist (' . $requestdata['SupplierConfirmationNumber'] . ')';
            $this->resp->data->RequestStatus = $error;

            return;
        }

        $controllerresponse = $bookingcontroller->viatorCancel($requestdata['SupplierConfirmationNumber'], $requestdata['CancelDate']);
        if ($controllerresponse['status'] == 'ok') {
            $this->resp->data->RequestStatus['Status'] = 'CONFIRMED';
        } else {
            $this->resp->data->RequestStatus['Status'] = 'REJECTED';
            $this->resp->data->RequestStatus['RejectedReason'] = $controllerresponse['reason'];
            $this->resp->data->RequestStatus['RejectedReasonDetails'] = $controllerresponse['details'];
        }
    }

    private function tourlistrequest ()
    {
        $this->resp->responseType = 'TourListResponse';

        $paella['SupplierProductCode'] = 'PAELLA';
        $paella['SupplierProductName'] = 'Paella Cooking Class';
        $paella['Language']['LanguageCode'] = 'EN';
        $paella['Language']['LanguageOption'] = 'GUIDE';
        $paella['CountryCode'] = 'ES';
        $paella['DestinationCode'] ='MAD';
        $paella['DestinationName'] ='Madrid';
        $paella['TourDescription'] = 'Market Tour + Hands-on cooking class of paella, gazpacho and sangria + Lunch';
        $paella['TourDepartureTime'] = '09:00:00';
        $paella['TourDuration'] = 'PT4H';


        $tapas['SupplierProductCode'] = 'TAPAS';
        $tapas['SupplierProductName'] = 'Tapas Cooking Class';
        $tapas['Language']['LanguageCode'] = 'EN';
        $tapas['Language']['LanguageOption'] = 'GUIDE';
        $tapas['CountryCode'] = 'ES';
        $tapas['DestinationCode'] ='MAD';
        $tapas['DestinationName'] ='Madrid';
        $tapas['TourDescription'] = 'Hands-on cooking class of 6 traditional tapas and sangria + Dinner';
        $tapas['TourDepartureTime'] = '17:30:00';
        $tapas['TourDuration'] = 'PT4H';

        $this->resp->data->Tour[0] = $paella;
        $this->resp->data->Tour[1] = $tapas;

    }


}
