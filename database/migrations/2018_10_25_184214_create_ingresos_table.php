<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proveedorid')->unsigned();
            $table->foreign('proveedorid')->references('id')->on('proveedores');
            $table->integer('usuarioid')->unsigned();
            $table->foreign('usuarioid')->references('id')->on('users');
            $table->string('tipocomprobante',20);
            $table->string('seriecomprobante',7)->nullable();
            $table->string('numerocomprobante',10);
            $table->dateTime('fechahora');
            $table->decimal('impuesto',4,2);
            $table->decimal('total',11,2);
            $table->string('estado',20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos');
    }
}
