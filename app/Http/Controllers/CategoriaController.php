<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Categoria;

class CategoriaController extends Controller
{
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
            $categorias = Categoria::orderBy('categoriasid','desc')->paginate(2);
         }
         else
         {
            $categorias = Categoria::where($criterio,'like','%'. $buscar . '%')->orderBy('categoriasid','desc')->paginate(2);
         }
        // $categorias = Categoria::all();
        // $categorias = DB::table('categorias')->paginate(2);
        // $categorias = Categoria::paginate(2);
        // return $categorias;
        return[
            'pagination' =>[
                'total' =>  $categorias->total(),
                'current_page' =>  $categorias->currentPage(),
                'per_page' =>  $categorias->perPage(),
                'last_page' =>  $categorias->lastPage(),
                'from' =>  $categorias->firstItem(),
                'to' =>  $categorias->lastItem(),
            ],
            'categorias'    =>  $categorias
        ];
    }

    public function selectCategoria(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('categoriacondicion','=','1')->select('categoriasid','categoriasnombre')
        ->get();

        return['categorias' => $categorias];

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $categoria = new Categoria();
        $categoria->categoriasnombre = $request->categoriasnombre;
        $categoria->categoriasdescripcion = $request->categoriasdescripcion;
        $categoria->categoriacondicion = '1';
        $categoria->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->categoriasid);
        $categoria->categoriasnombre = $request->categoriasnombre;
        $categoria->categoriasdescripcion = $request->categoriasdescripcion;
        $categoria->categoriacondicion = '1';
        $categoria->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function desactivar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->categoriasid);
        $categoria->categoriacondicion = '0';
        $categoria->save();
    }

    public function activar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $categoria = Categoria::findOrFail($request->categoriasid);
        $categoria->categoriacondicion = '1';
        $categoria->save();
    }
}
