<?php

namespace App\Http\Controllers;

use App\AvailabilityHold;
use DateTime;
use DateInterval;

class AvailabilityHoldController extends Controller
{
    public function addOrRefresh($calendarevent_id, $reference, $travellers, $duration)
    {
        $interval = new DateInterval($duration);
        $expiry = (new DateTime())->add($interval);
        $hold = AvailabilityHold::where('reference', $reference)->first();
        if (!$hold) {
            AvailabilityHold::create(
                ['calendarevent_id' => $calendarevent_id, 'reference' => $reference, 'travellers' => $travellers, 'expiry' => $expiry->format('Y-m-d H:i:s')]);
        } else {
            $hold->calendarevent_id = $calendarevent_id;
            $hold->travellers = $travellers;
            $hold->expiry = $expiry->format('Y-m-d H:i:s');
            $hold->save();
        }
    }

    public function remove($reference)
    {
        AvailabilityHold::where('reference', $reference)->delete();
    }
}
