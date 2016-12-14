<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableSources extends Migration
{

    public function up()
    {
        Schema::create('sources', function ($table) {
        $table->increments('id');
        $table->string('type'); // direct, user, marketplace, travel agent, hotel
        $table->string('name');
        $table->integer('priceplan_id');  // PricePlans foreign key
        });

        DB::table('sources')->insert(
            array(
                'type' => 'Z LEGACY',
                'name' => '(no usar)',
                'priceplan_id' => 1));
        DB::table('sources')->insert(
            array(
                'type' => 'ONLINE',
                'name' => 'cookingpoint.es',
                'priceplan_id' => 1));

        DB::table('sources')->insert(
            array(
                'type' => 'USER',
                'name' => 'Esta aplicación',
                'priceplan_id' => 1));

        DB::table('sources')->insert(
            array(
                'type' => 'AGENCIA',
                'name' => 'Century Incoming',
                'priceplan_id' => 3));

        DB::table('sources')->insert(
            array(
                'type' => 'MARKETPLACE',
                'name' => 'Viator',
                'priceplan_id' => 2));

        DB::table('sources')->insert(
            array(
                'type' => 'MARKETPLACE',
                'name' => 'GetYourGuide',
                'priceplan_id' => 1));

        DB::table('sources')->insert(
            array(
                'type' => 'MARKETPLACE',
                'name' => 'MadridCityTours',
                'priceplan_id' => 1));

        DB::table('sources')->insert(
            array(
                'type' => 'AGENCIA',
                'name' => 'All Ways Spain',
                'priceplan_id' => 3));
    }

    public function down()
    {
        Schema::drop('sources');
    }
}
