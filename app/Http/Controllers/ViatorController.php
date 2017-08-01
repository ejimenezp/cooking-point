<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon\Carbon;

use App\Http\Controllers\CalendareventController;

use App\Viator\ViatorRequestStatus;
use App\Viator\ViatorTourAvailability;
use App\Viator\ViatorBooking;
use App\Viator\ViatorTour;

use Log;

class ViatorController extends Controller
{
    private $resp;

    function main(Request $request)
    {

        $this->resp = (object) array();
        $this->resp->data = (object) array();
        $requestdata = $request->data;

        // Basic error checking

        // Fields common to all responses

        $this->resp->data->ApiKey = $requestdata['ApiKey'];
        $this->resp->data->ResellerId = $requestdata['ResellerId'];
        $this->resp->data->SupplierId = $requestdata['SupplierId'];
        $this->resp->data->ExternalReference = $requestdata['ExternalReference'];
        $this->resp->data->Timestamp = (new \DateTime)->format(DATE_ATOM);
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
        return response()->json($this->resp);
    }

    private function availabilityrequest ($requestdata)
    {
        $this->resp->responseType = 'AvailabilityResponse';

        $start = new Carbon($requestdata['StartDate']);
        $end = new Carbon($requestdata['EndDate']);
        $travellers = isset($requestdata['TravellerMix']['Total']) ? $requestdata['TravellerMix']['Total'] : 0;
        $calendareventcontroller = new CalendareventController;
        $hoy = Carbon::now('Europe/Madrid');

        if (!is_array($requestdata['SupplierProductCode'])) {
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
                // Log::debug('fecha ' . $date . ' type ' . $ce_type);
                if ($date->lt($hoy)) {
                    $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                    $availability->AvailabilityStatus->UnavailabilityReason = 'PAST_CUTOFF_DATE';
                    $this->resp->data->ViatorTourAvailability[] = $availability;
                    continue;
                }
                $ce = $calendareventcontroller->findByDateAndType($date, $ce_type);
                if ($ce) {
                    if ($ce->registered >= $ce->capacity) {
                        $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                        $availability->AvailabilityStatus->UnavailabilityReason = 'SOLD_OUT';
                    } elseif ($ce->registered + $travellers > $ce->capacity) {
                        $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                        $availability->AvailabilityStatus->UnavailabilityReason = 'TRAVELLER_MISMATCH';
                    } else {
                        $availability->AvailabilityStatus->Status = 'AVAILABLE';
                    }
                }
                else {
                    $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                    $availability->AvailabilityStatus->UnavailabilityReason = 'BLOCKED_OUT';
                }
                $this->resp->data->ViatorTourAvailability[] = $availability;
            }
        }

    }

    private function batchavailabilityrequest ($requestdata)
    {
        $this->resp->responseType = 'BatchAvailabilityResponse';

        $start = new Carbon($requestdata['StartDate']);
        $end = new Carbon($requestdata['EndDate']);
        $calendareventcontroller = new CalendareventController;
        $hoy = Carbon::now('Europe/Madrid');

        if (!is_array($requestdata['SupplierProductCode'])) {
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
                    $this->resp->data->ViatorTourAvailability[] = $availability;
                    continue;
                }
                $ce = $calendareventcontroller->findByDateAndType($date, $ce_type);
                if ($ce) {
                    if ($ce->registered >= $ce->capacity) {
                        $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                        $availability->AvailabilityStatus->UnavailabilityReason = 'SOLD_OUT';
                    } else {
                        if ($requestdata['Mode'] == 'BLOCKOUTS') {
                            continue;
                        }
                        $availability->AvailabilityStatus->Status = 'AVAILABLE';
                    }
                }
                else {
                    $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                    $availability->AvailabilityStatus->UnavailabilityReason = 'BLOCKED_OUT';
                }
                $this->resp->data->ViatorTourAvailability[] = $availability;
            }
        }
    }

    private function bookingrequest ($requestdata)
    {
        $this->resp->responseType = 'BookingResponse';

        $viatorbooking = new ViatorBooking;
        $laravelrequest = new Request;
        $calendareventcontroller = new CalendareventController;
        $bookingcontroller = new BookingController;

        $traveldate = new Carbon($requestdata['TravelDate']);
        $travellers = $requestdata['TravellerMix']['Total'];

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

            if ($ce->registered + $travellers > $ce->capacity) {
                $viatorbooking->TransactionStatus->Status = 'REJECTED';
                $viatorbooking->TransactionStatus->RejectedReason = 'BOOKED_OUT_ALT_DATES';
                $viatorbooking->TransactionStatus->RejectedReasonDetails = 'Please, check other dates';
            } else {
                // new booking
                $laravelrequest->calendarevent_id = $ce->id;
                $laravelrequest->source_id = 5; // MARKETPLACE: Viator (sources DB table)
                $laravelrequest->status = 'CONFIRMED';

                for ($i = count($requestdata['Traveller'])-1; !$requestdata['Traveller'][$i]['LeadTraveller'] && $i >= 0; $i--) {
                    # code...
                }
                $laravelrequest->name = $requestdata['Traveller'][$i]['GivenName'].' '.$requestdata['Traveller'][$i]['Surname'];

                $laravelrequest->email = $requestdata['ContactDetail']['ContactType'] == 'EMAIL' ? $requestdata['ContactDetail']['ContactValue'] : '';
                $laravelrequest->phone = $requestdata['ContactDetail']['ContactType'] == 'MOBILE' ? $requestdata['ContactDetail']['ContactValue'] : '';
                $laravelrequest->adult = $requestdata['TravellerMix']['Adult'];
                $laravelrequest->child = $requestdata['TravellerMix']['Child'];
                $laravelrequest->pay_method = 'N/A';
                $laravelrequest->food_requirements = isset($requestdata['SpecialRequirement']) ? $requestdata['SpecialRequirement'] : '';
                $laravelrequest->comments = 'BR-' . $requestdata['BookingReference'];
                if (isset($requestdata['SupplierNote'])) {
                    $laravelrequest->comments .= '; ' . $requestdata['SupplierNote'];
                }
                $laravelrequest->payment_date = '';
                $laravelrequest->crm = 'YES';
                $laravelrequest->hide_price = 'YES';

                $controllerresponse = $bookingcontroller->add($laravelrequest);

                $viatorbooking->TransactionStatus->Status = 'CONFIRMED';
                $viatorbooking->SupplierConfirmationNumber = $controllerresponse['data']['locator'];

            }
        } else {
            $viatorbooking->TransactionStatus->Status = 'REJECTED';
            $viatorbooking->TransactionStatus->RejectedReason = 'NOT_OPERATING';
            $viatorbooking->TransactionStatus->RejectedReasonDetails = 'Please, check other dates';
        }
        $this->resp->data->BookingResponse = $viatorbooking;
    }

    private function bookingamendmentrequest ($requestdata)
    {
        $this->resp->responseType = 'BookingAmendmentResponse';

        $viatorbooking = new ViatorBooking;
        $laravelrequest = new Request;
        $calendareventcontroller = new CalendareventController;
        $bookingcontroller = new BookingController;

        $traveldate = new Carbon($requestdata['TravelDate']);
        $travellers = $requestdata['TravellerMix']['Total'];

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
            if ($registered + $travellers > $ce->capacity) {
                $viatorbooking->TransactionStatus->Status = 'REJECTED';
                $viatorbooking->TransactionStatus->RejectedReason = 'BOOKED_OUT_ALT_DATES';
                $viatorbooking->TransactionStatus->RejectedReasonDetails = 'Please, check other dates';
            } else {
                $laravelrequest->calendarevent_id = $ce->id;
                $laravelrequest->source_id = 5; // MARKETPLACE: Viator (sources DB table)
                $laravelrequest->status = 'CONFIRMED';

                $laravelrequest->name = $requestdata['Traveller']['GivenName'].' '.$requestdata['Traveller']['Surname'];

                $laravelrequest->email = $requestdata['ContactDetail']['ContactType'] == 'EMAIL' ? $requestdata['ContactDetail']['ContactValue'] : '';
                $laravelrequest->phone = $requestdata['ContactDetail']['ContactType'] == 'MOBILE' ? $requestdata['ContactDetail']['ContactValue'] : '';
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
                $laravelrequest->hide_price = $laravelbkg->hide_price;

                $controllerresponse = $bookingcontroller->update($laravelrequest);

                $viatorbooking->TransactionStatus->Status = 'CONFIRMED';
                $viatorbooking->SupplierConfirmationNumber = $controllerresponse['data']['locator'];

            }
        } else {
            $viatorbooking->TransactionStatus->Status = 'REJECTED';
            $viatorbooking->TransactionStatus->RejectedReason = 'NOT_OPERATING';
            $viatorbooking->TransactionStatus->RejectedReasonDetails = 'Please, check other dates';
        }
        $this->resp->data->BookingResponse = $viatorbooking;
    }

    private function bookingcancellationrequest ($requestdata)
    {
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

        $paella = new ViatorTour;
        $tapas = new ViatorTour;

        $paella->SupplierProductCode = 'PAELLA';
        $paella->SupplierProductName = 'Paella Cooking Class';
        $paella->language->LanguageCode = 'EN';
        $paella->language->LanguageOption = 'GUIDE';
        $paella->CountryCode = 'ES';
        $paella->DestinationCode ='MAD';
        $paella->DestinationName ='Madrid';
        $paella->TourDescription = 'Market Tour + Hands-on cooking class of paella, gazpacho and sangria + Lunch';
        $paella->TourDepartureTime = '09:00:00';
        $paella->TourDuration = 'P4H';


        $tapas->SupplierProductCode = 'TAPAS';
        $tapas->SupplierProductName = 'Tapas Cooking Class';
        $tapas->language->LanguageCode = 'EN';
        $tapas->language->LanguageOption = 'GUIDE';
        $tapas->CountryCode = 'ES';
        $tapas->DestinationCode ='MAD';
        $tapas->DestinationName ='Madrid';
        $tapas->TourDescription = 'Hands-on cooking class of 6 traditional tapas and sangria + Dinner';
        $tapas->TourDepartureTime = '17:30:00';
        $tapas->TourDuration = 'P4H';

        $this->resp->data->tour[0] = $paella;
        $this->resp->data->tour[1] = $tapas;

    }


}
