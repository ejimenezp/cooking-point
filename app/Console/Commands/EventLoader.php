<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\CalendareventController;
use Illuminate\Http\Request;

class EventLoader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cookingpoint:eventloader';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cooking Point Calendarevent Bulk Loader';

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
        $controller = new CalendareventController();
        $request = new Request();

        $fh = fopen(storage_path('app/eventbatch.txt'),'r');
        while ($li = fgets($fh)) {
            if (strlen(trim($li))) {
                $line = preg_split("/[\s,]+/", $li);
                $j = 2;
                while ($j <= 10 && !empty($line[$j])) {
                    $request['date'] = $line[1];
                    $request['type'] = $line[$j];
                    $request['staff_id'] = 3;
                    $request['secondstaff_id'] = 2;
                    switch ($request['type']) {
                        case 'HOLIDAY':
                            $request['time'] = '09:00:00';
                            $request['duration'] = '00:00:00';
                            $request['short_description'] = '';                        
                            break; 
                        default:
                            # code...
                    }



                    // begin provision 

                    if ($controller->add($request) == 'fail') {
                        echo 'Error provisioning ' . $request['date'] . ' ' . $request['type'] . "\n";
                    } else {
                        echo 'Provisioned ' . $request['date'] . ' ' . $request['type'] . "\n";
                    }

                    // end provision
                    $j++;
                }
            }


        }
        fclose($fh);
    }
}
