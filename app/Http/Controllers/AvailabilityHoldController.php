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
        $hold = AvailabilityHold::where('calendarevent_id', $calendarevent_id)
                                ->where('reference', $reference)
                                ->where('travellers', '<=', $travellers)->first();
        if (!$hold) {
            AvailabilityHold::create(
                ['calendarevent_id' => $calendarevent_id, 'reference' => $reference, 'travellers' => $travellers, 'expiry' => $expiry->format('Y-m-d H:i:s')]);
        } else {
            $hold->expiry = $expiry->format('Y-m-d H:i:s');
            $hold->save();
        }
    }

    public function remove($reference)
    {
        AvailabilityHold::where('reference', $reference)->delete();
    }

    public function isValid($calendarevent_id, $reference, $travellers)
    {
        return AvailabilityHold::where('calendarevent_id', $calendarevent_id)
                                ->where('expiry', '>=', date('Y-m-d H:i:s'))
                                ->where('reference', $reference)
                                ->where('travellers', '<=', $travellers)
                                ->exists();
    }

    // public function onHold($calendarevent_id)
    // {
    //     return AvailabilityHold::where('calendarevent_id', $calendarevent_id)
    //                             ->where('expiry', '>=', date('Y-m-d H:i:s'))
    //                             ->sum('travellers');
    // }
}
