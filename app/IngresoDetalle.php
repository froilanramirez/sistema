<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IngresoDetalle extends Model
{
    //
    protected $table = 'ingresos_detalle';
    protected $fillable = [
        'ingresoid',
        'articuloid',
        'cantidad',
        'precio'
    ];
    public $timestamps = false;
}
