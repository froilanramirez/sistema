<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    //
    protected $fillable = [
        'proveedorid',
        'usuarioid',
        'tipocomprobante',
        'seriecomprobante',
        'numerocomprobante',
        'fechahora',
        'impuesto',
        'total',
        'estado'
    ];
    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }
}
