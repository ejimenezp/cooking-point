<?php

namespace App\Http\Controllers;

use App\AvailabilityHold;
use DateTime;
use DateInterval;

class AvailabilityHoldController extends Controller
{
    public function add($calendarevent_id, $reference, $travellers, $duration)
    {
        $hold = new AvailabilityHold;
        $hold->calendarevent_id = $calendarevent_id;
        $hold->reference = $reference;
        $hold->travellers = $travellers;
        $interval = new DateInterval($duration);
        $expiry = (new DateTime())->add($interval);
        $hold->expiry = $expiry->format('Y-m-d H:i:s');
        $hold->save();
    }

    public function remove($reference)
    {
        AvailabilityHold::where('reference', $reference)->delete();
    }

    public function isValid($reference, $calendarevent_id = null, $travellers = 1000)
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
