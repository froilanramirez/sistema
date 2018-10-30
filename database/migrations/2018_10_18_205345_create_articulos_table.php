<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->increments('articulosid');
            $table->integer('categoriasid')->unsigned();
            $table->string('articuloscodigo',50)->nullable();
            $table->string('articulosnombre')->unique();
            $table->decimal('articulosprecioventa',11,2);
            $table->integer('articulosstock');
            $table->string('articulosdescripcion',256)->nullable();
            $table->boolean('articuloscondicion')->default(1);
            $table->timestamps();
            $table->foreign('categoriasid')->references('categoriasid')->on('categorias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articulos');
    }
}
