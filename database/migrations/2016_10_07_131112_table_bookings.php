<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function ($table) {
        $table->increments('id');
        $table->integer('calendarevent_id');  // calendarevent foreign key
        $table->integer('source_id');  // source foreign key
        $table->string('status_major'); // CREATED, CANCELLED, PAID
        $table->string('status_minor'); 
        $table->string('locator', 6);
        $table->string('name');  // client name
        $table->string('email');  // client email
        $table->string('phone');  // client phone
        $table->integer('adult'); 
        $table->integer('child'); 
        $table->float('price'); // retail price
        $table->boolean('iva');
        $table->string('pay_method'); // online, viator, transfer, cash
        $table->string('food_requirements');
        $table->string('comments');
        $table->string('crm');
        // backwards compatibility
        $table->string('hash');
        });

    }  // class end
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bookings');
    }
}
