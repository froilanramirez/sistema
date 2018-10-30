<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //
    protected $primaryKey = "categoriasid";
    protected $fillable = ['categoriasnombre','categoriasdescripcion','categoriacondicion'];

    public function articulos(){
        return $this->hasMany('App\Articulo');
    }
    
}
