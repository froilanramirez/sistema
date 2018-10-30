<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresosDetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingresos_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ingresoid')->unsigned();
            $table->foreign('ingresoid')->
            references('id')->on('ingresos')->onDelete('cascade');
            $table->integer('articuloid')->unsigned();
            $table->foreign('articuloid')->
            references('articulosid')->on('articulos');
            $table->integer('cantidad');
            $table->decimal('precio',11,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ingresos_detalle');
    }
}
