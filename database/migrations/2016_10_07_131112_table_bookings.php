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
        $table->boolean('fixed_date')->default(0); // can't change calendarevent  
        $table->string('status'); // CREATED, CANCELLED, PAID
        $table->string('status_filter'); 
        $table->string('locator', 6);
        $table->string('name');  // client name
        $table->string('email');  // client email
        $table->string('phone');  // client phone
        $table->integer('adult'); 
        $table->integer('child'); 
        $table->float('price'); // retail price
        $table->boolean('iva')->default(1);
        $table->boolean('hide_price')->default(0);
        $table->string('pay_method'); // online, viator, transfer, cash
        $table->text('food_requirements');
        $table->text('comments');
        $table->string('crm');
        $table->datetime('payment_date')->nullable();
        $table->string('hash')->nullable();
        $table->timestamps();
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
