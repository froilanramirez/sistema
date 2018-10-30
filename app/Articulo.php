<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    //
    protected $primaryKey = "articulosid";
    protected $fillable = ['categoriasid','articuloscodigo','articulosnombre','articulosprecioventa','articulosstock','articuloscondicion'];
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
}
