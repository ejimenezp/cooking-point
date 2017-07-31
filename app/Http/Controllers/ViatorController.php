<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Controllers\CalendareventController;
use App\ViatorTourAvailability;
use App\ViatorBooking;

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

        $requestdata['ce_types'] = array();
        if (!isset($requestdata['TourOptions']['SupplierOptionCode'])) {
            $requestdata['ce_types'] = ['TG42' => 'TAPAS', 'TG43' => 'PAELLA'];
        } elseif ($requestdata['TourOptions']['SupplierOptionCode'] == 'TG42') {
            $requestdata['ce_types'] = ['TG42' => 'TAPAS'];
        } elseif ($requestdata['TourOptions']['SupplierOptionCode'] == 'TG43') {
            $requestdata['ce_types'] = ['TG43' => 'PAELLA'];            
        } else {
            $requestdata['ce_types'] = ['TG42' => 'TAPAS', 'TG43' => 'PAELLA'];            
        }

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
            default:
                # code...
                break;
        }
        return response()->json($this->resp);
    }

    private function availabilityrequest ($requestdata)
    {
        $this->resp->responseType = 'AvailabilityResponse';
        $this->resp->data->SupplierProductCode = '9161P1';

        $start = new Carbon($requestdata['StartDate']);
        $end = new Carbon($requestdata['EndDate']);
        $travellers = isset($requestdata['TravellerMix']['Total']) ? $requestdata['TravellerMix']['Total'] : 0;
        $calendareventcontroller = new CalendareventController;
        $hoy = Carbon::now('Europe/Madrid');

        for ($date = $start; $date->diffInDays($end, false) >= 0; $date->addDay())
        {
            foreach ($requestdata['ce_types'] as $viator_code => $ce_type)
            {
                $availability = new ViatorTourAvailability;
                $availability->Date = $date->toDateString();
                $availability->TourOptions->SupplierOptionCode = $viator_code;
                // Log::debug('fecha ' . $date . ' type ' . $ce_type);
                if ($date->lt($hoy)) {
                    $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                    $availability->AvailabilityStatus->UnavailabilityReason = 'PAST_CUTOFF_DATE';
                    $this->resp->data->ViatorTourAvailability[] = $availability;
                    continue;
                }
                $ce = $calendareventcontroller->findByDateAndType($date, $ce_type);
                if ($ce) {
                    $availability->TourOptions->SupplierOptionName = $ce->short_description;
                    $availability->TourOptions->TourDepartureTime = $ce->time;

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

        for ($date = $start; $date->diffInDays($end, false) >= 0; $date->addDay())
        {
            foreach ($requestdata['ce_types'] as $viator_code => $ce_type)
            {
                $availability = new ViatorTourAvailability;
                $availability->Date = $date->toDateString();
                $availability->TourOptions->SupplierOptionCode = $viator_code;
                $availability->SupplierProductCode = '9161P1';

                // Log::debug('fecha ' . $date . ' type ' . $ce_type);
                if ($date->lt($hoy)) {
                    $availability->AvailabilityStatus->Status = 'UNAVAILABLE';
                    $availability->AvailabilityStatus->UnavailabilityReason = 'PAST_CUTOFF_DATE';
                    $this->resp->data->ViatorTourAvailability[] = $availability;
                    continue;
                }
                $ce = $calendareventcontroller->findByDateAndType($date, $ce_type);
                if ($ce) {
                    $availability->TourOptions->SupplierOptionName = $ce->short_description;
                    $availability->TourOptions->TourDepartureTime = $ce->time;

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
        $ce_type = $requestdata['ce_types'];

        $ce = $calendareventcontroller->findByDateAndType($traveldate, $ce_type);

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
        $ce_type = $requestdata['ce_types'];

        $laravelbkg = $bookingcontroller->findBy($requestdata['SupplierConfirmationNumber']);
        if (!$laravelbkg) {
            $this->resp->data->RequestStatus['Status'] = 'ERROR';
            $this->resp->data->RequestStatus['ErrorCode'] = 'WRONG_SUPPLIER_CONFIRMATION_NUMBER';
            return;
        }
        $laravelrequest->id = $laravelbkg->id;

        $ce = $calendareventcontroller->findByDateAndType($traveldate, $ce_type);

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

        $laravel = $bookingcontroller->viatorCancel($requestdata['SupplierConfirmationNumber'], $requestdata['CancelDate']);
        if ($laravel['status'] == 'ok') {
            $this->resp->data->RequestStatus['Status'] = 'CONFIRMED';
        } else {
            $this->resp->data->RequestStatus['Status'] = 'REJECTED';
            $this->resp->data->RequestStatus['RejectedReason'] = $laravel['reason'];
            $this->resp->data->RequestStatus['RejectedReasonDetails'] = $laravel['details'];
        }
    }
}
