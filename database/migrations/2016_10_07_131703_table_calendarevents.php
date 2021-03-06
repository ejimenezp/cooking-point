<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableCalendarevents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendarevents', function ($table) {
        $table->increments('id');
        $table->string('type'); // PAELLA, TAPAS, GROUP, HOLIDAY, FILLER,...
        $table->text('short_description');
        $table->date('date');
        $table->time('time');  
        $table->time('duration');  
        $table->integer('capacity');
        $table->integer('staff_id'); // Staff foreign key
        $table->text('info')->default('');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('calendarevents');
    }
}
