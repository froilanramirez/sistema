<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;

class ArticuloController extends Controller
{
    //
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
         $buscar = $request->buscar;
         $criterio = $request->criterio;

         if($buscar == '')
         {
            $articulos = Articulo::join('categorias','articulos.categoriasid','=','categorias.categoriasid')
            ->select('articulosid','articulos.categoriasid','articulos.articuloscodigo','articulos.articulosnombre','categorias.categoriasnombre','articulos.articulosprecioventa','articulos.articulosstock','articulos.articulosdescripcion','articulos.articuloscondicion')
            ->orderBy('articulosid','desc')->paginate(2);
         }
         else
         {
            $articulos = Articulo::join('categorias','articulos.categoriasid','=','categorias.categoriasid')
            ->select('articulosid','articulos.categoriasid','articulos.articuloscodigo','articulos.articulosnombre','categorias.categoriasnombre','articulos.articulosprecioventa','articulos.articulosstock','articulos.articulosdescripcion','articulos.articuloscondicion')
            ->where($criterio,'like','%'. $buscar . '%')
            ->orderBy('articulosid','desc')->paginate(2);

         }
        // $categorias = Categoria::all();
        // $categorias = DB::table('categorias')->paginate(2);
        // $categorias = Categoria::paginate(2);
        // return $categorias;
        return[
            'pagination' =>[
                'total' =>  $articulos->total(),
                'current_page' =>  $articulos->currentPage(),
                'per_page' =>  $articulos->perPage(),
                'last_page' =>  $articulos->lastPage(),
                'from' =>  $articulos->firstItem(),
                'to' =>  $articulos->lastItem(),
            ],
            'articulos'    =>  $articulos
        ];
    }

    public function listarArticulo(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
         $buscar = $request->buscar;
         $criterio = $request->criterio;

         if($buscar == '')
         {
            $articulos = Articulo::join('categorias','articulos.categoriasid','=','categorias.categoriasid')
            ->select('articulosid','articulos.categoriasid','articulos.articuloscodigo','articulos.articulosnombre','categorias.categoriasnombre','articulos.articulosprecioventa','articulos.articulosstock','articulos.articulosdescripcion','articulos.articuloscondicion')
            ->orderBy('articulosid','desc')->paginate(10);
         }
         else
         {
            $articulos = Articulo::join('categorias','articulos.categoriasid','=','categorias.categoriasid')
            ->select('articulosid','articulos.categoriasid','articulos.articuloscodigo','articulos.articulosnombre','categorias.categoriasnombre','articulos.articulosprecioventa','articulos.articulosstock','articulos.articulosdescripcion','articulos.articuloscondicion')
            ->where($criterio,'like','%'. $buscar . '%')
            ->orderBy('articulosid','desc')->paginate(10);

         }
        return[
            // 'pagination' =>[
            //     'total' =>  $articulos->total(),
            //     'current_page' =>  $articulos->currentPage(),
            //     'per_page' =>  $articulos->perPage(),
            //     'last_page' =>  $articulos->lastPage(),
            //     'from' =>  $articulos->firstItem(),
            //     'to' =>  $articulos->lastItem(),
            // ],
            'articulos'    =>  $articulos
        ];
    }

    public function buscarArticulo(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $articulos = Articulo::where('articuloscodigo','=',$filtro)
        ->select('articulosid','articulosnombre')->orderBy('articulosnombre','asc')->take(1)->get();
        return ['articulos' => $articulos];
    }

    public function store(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $articulo = new Articulo();
        $articulo->categoriasid = $request->categoriasid;
        $articulo->articuloscodigo = $request->articuloscodigo;
        $articulo->articulosnombre = $request->articulosnombre;
        $articulo->articulosprecioventa = $request->articulosprecioventa;
        $articulo->articulosstock = $request->articulosstock;
        $articulo->articulosdescripcion = $request->articulosdescripcion;
        $articulo->articuloscondicion = '1';
        $articulo->save();
    }

    public function update(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->articulosid);
        $articulo->categoriasid = $request->categoriasid;
        $articulo->articuloscodigo = $request->articuloscodigo;
        $articulo->articulosnombre = $request->articulosnombre;
        $articulo->articulosprecioventa = $request->articulosprecioventa;
        $articulo->articulosstock = $request->articulosstock;
        $articulo->articulosdescripcion = $request->articulosdescripcion;
        $articulo->articuloscondicion = '1';
        $articulo->save();
    }

    public function desactivar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->articulosid);
        $articulo->articuloscondicion = '0';
        $articulo->save();
    }

    public function activar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $articulo = Articulo::findOrFail($request->articulosid);
        $articulo->articuloscondicion = '1';
        $articulo->save();
    }
}
