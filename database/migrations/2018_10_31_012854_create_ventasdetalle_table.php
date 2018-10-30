<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVentasdetalleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventasdetalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ventaid')->unsigned();
            $table->foreign('ventaid')->references('id')->on('ventas')->onDelete('cascade');
            $table->integer('articuloid')->unsigned();
            $table->foreign('articuloid')->references('articulosid')->on('articulos');
            $table->integer('cantidad');
            $table->decimal('precio',11,2);
            $table->decimal('descuento',11,2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventasdetalle');
    }
}
