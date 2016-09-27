<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CookingPoint_cron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cookingpoint:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cooking Point Cron Jobs';

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
        // Remainder mail
        $a = new Reminder;
        if ($a->query()) { $a->exec(); }
    }
}
