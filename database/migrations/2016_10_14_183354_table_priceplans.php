<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TablePriceplans extends Migration
{

    public function up()
    {
        Schema::create('priceplans', function ($table) {
        $table->increments('id');
        $table->string('plan');
        $table->boolean('iva');
        $table->decimal('adult', 6, 2);  // retail prices
        $table->decimal('child', 6, 2);
        $table->string('description');
       });

        DB::table('priceplans')->insert(
            array(
                'plan' => 'standard',
                'description' => 'Online, marketplaces por comision',
                'iva' => 1,
                'adult' => 70,
                'child' => 35));

        DB::table('priceplans')->insert(
            array(
                'plan' => 'viator',
                'description' => 'Viator',
                'iva' => 0,
                'adult' => 52.50,
                'child' => 26.25));


        DB::table('priceplans')->insert(
            array(
                'plan' => 'agency',
                'description' => 'Neto -15%',
                'iva' => 1,
                'adult' => 59.50,
                'child' => 29.75));

    }

    public function down()
    {
        Schema::drop('priceplans');
    }
}
