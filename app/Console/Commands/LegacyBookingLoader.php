<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


use App\Http\Controllers\CalendarEventController;
use App\Http\Controllers\BookingController;
use Illuminate\Http\Request;
use App\Booking;
use Carbon\Carbon;

class LegacyBookingLoader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cookingpoint:bookingloader';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Legacy bookings loader';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // bookings file has to start with return Array(....)
        $legacy_bookings = include storage_path('app/legacy_bookings.php');

        $calendar = new CalendarEventController();
        $controller = new BookingController();

        foreach ($legacy_bookings as $booking) {


            $ce = $calendar->findByDateAndType($booking['activityDate'], $booking['activity']);
            if (!$ce) {
                echo 'CalendarEvent not found '. $booking['activityDate'] . ' ' . $booking['activity'] . "\n";
                continue;
            }
            $b = Booking::where('calendarevent_id', $ce->id)->where('name', $booking['name'])->count();
            if ($b) {
                echo 'Booking already provisioned (' . $booking['activityDate'] . ' ' . $booking['name'] .")\n";
                continue;
            }
            $request = new Request();
            $request->date = $booking['activityDate'];
            $request->type = $booking['activity'];
            $request->name = $booking['name'];
            $request->email = $booking['email'];
            $request->phone = $booking['phone'];
            $request->calendarevent_id = $ce->id;
            $request->source_id = 1;
            $request->status_major = ($booking['status'] == 'PA' ? 'PAID' : 'PENDING');
            $request->status_minor = '';
            $request->adult = $booking['numAdults'];
            $request->child = $booking['numChildren'];
            $request->pay_method = 'ONLINE';
            $request->food_requirements = $booking['foodRestrictions'];
            $request->comments = $booking['comments'];
            if ($booking['paymentDate']) {
                $request->payment_date = Carbon::createFromFormat('Y-m-d H:i:s', $booking['paymentDate']);
            }
            $request->hash = $booking['hash'];
            $request->crm = 'YES';
            if ($controller->add($request)['status'] != 'ok') {
                echo 'Failed adding booking (' . $booking['activityDate'] . ' ' . $booking['name'] .")\n";
            }
            unset($request);
        }
    }
}
