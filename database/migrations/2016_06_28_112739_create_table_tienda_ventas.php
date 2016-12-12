<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTiendaVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tienda_ventas', function ($table) {
            $table->increments('id');
            $table->date('fecha'); 
            $table->integer('staff_id');
            $table->boolean('anulado'); 
            $table->decimal('total', 6, 2);
            $table->decimal('base4', 6, 2);
            $table->decimal('iva4', 6, 2);
            $table->decimal('base10', 6, 2);
            $table->decimal('iva10', 6, 2);
            $table->decimal('base21', 6, 2);
            $table->decimal('iva21', 6, 2);
            $table->string('pago'); // tarjeta, efectivo
            $table->integer('linea0');
            $table->integer('linea1')->nullable();
            $table->integer('linea2')->nullable();
            $table->integer('linea3')->nullable();
            $table->integer('linea4')->nullable();
            $table->integer('linea5')->nullable();
            $table->integer('linea6')->nullable();
            $table->integer('linea7')->nullable();
            $table->integer('linea8')->nullable();
            $table->integer('linea9')->nullable();
            $table->date('created_at'); 
            $table->date('updated_at'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tienda_ventas');
    }
}
