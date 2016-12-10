<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableStaff extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('auth_name');
            $table->string('role');
            $table->string('auth_role');
            $table->string('auth_password');
            $table->boolean('active');
        });


        DB::table('staff')->insert(
            array(
                'name' => 'Eduardo',
                'auth_name' => 'eduardo',
                'role' => 'admin',
                'auth_role' => 3,
                'auth_password' => '1000',
                'active' => true));

        DB::table('staff')->insert(
            array(
                'name' => 'no asignado',
                'auth_name' => 'eduardo-no-usar',
                'role' => 'cook',
                'auth_role' => 0,
                'auth_password' => 'zdgsdgdg',
                'active' => true));

        DB::table('staff')->insert(
            array(
                'name' => 'Eduardo',
                'auth_name' => 'eduardo-no-usar',
                'role' => 'cook',
                'auth_role' => 0,
                'auth_password' => 'zdgsdgdg',
                'active' => true));

        DB::table('staff')->insert(
            array(
                'name' => 'Laura',
                'auth_name' => 'laura',
                'role' => 'cook',
                'auth_role' => 2,
                'auth_password' => '1905',
                'active' => true));

        DB::table('staff')->insert(
            array(
                'name' => 'Ligia',
                'auth_name' => 'ligia',
                'role' => 'cook',
                'auth_role' => 2,
                'auth_password' => '2222',
                'active' => true));

        DB::table('staff')->insert(
            array(
                'name' => 'Cook03',
                'auth_name' => 'cook03',
                'role' => 'cook',
                'auth_role' => 2,
                'auth_password' => '1001',
                'active' => true));

        DB::table('staff')->insert(
            array(
                'name' => 'Paulina',
                'auth_name' => 'paulina',
                'role' => 'staff',
                'auth_role' => 1,
                'auth_password' => '2123',
                'active' => true));

        DB::table('staff')->insert(
            array(
                'name' => 'Dalia',
                'auth_name' => 'dalia',
                'role' => 'staff',
                'auth_role' => 1,
                'auth_password' => '2123',
                'active' => true));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('staff');
    }
}
