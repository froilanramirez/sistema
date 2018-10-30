<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Persona;

class UserController extends Controller
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
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.rolid','=','roles.id')
            ->select('personas.id','personas.nombre','personas.tipodocumento','personas.numerodocumento',
            'personas.direccion','personas.telefono','personas.email',
            'users.usuario','users.password','users.condicion',
            'users.condicion','users.rolid','roles.nombre as rol')
            ->orderBy('personas.id','desc')->paginate(2);
         }
         else
         {
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.rolid','=','roles.id')
            ->select('personas.id','personas.nombre','personas.tipodocumento','personas.numerodocumento',
            'personas.direccion','personas.telefono','personas.email',
            'users.usuario','users.password','users.condicion',
            'users.condicion','users.rolid','roles.nombre as rol')
            ->where('personas.'.$criterio,'like','%'. $buscar . '%')
            ->orderBy('personas.id','desc')->paginate(2);
         }

        return[
            'pagination' =>[
                'total' =>  $personas->total(),
                'current_page' =>  $personas->currentPage(),
                'per_page' =>  $personas->perPage(),
                'last_page' =>  $personas->lastPage(),
                'from' =>  $personas->firstItem(),
                'to' =>  $personas->lastItem(),
            ],
            'personas'    =>  $personas
        ];
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
        try{
            DB::beginTransaction();
            $persona = new Persona();
            $persona->nombre = $request->nombre;
            $persona->tipodocumento = $request->tipodocumento;
            $persona->numerodocumento = $request->numerodocumento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

             $user = new User();
             $user->usuario = $request->usuario;
             $user->password = bcrypt($request->password);
             $user->condicion = '1';
             $user->rolid = $request->rolid;
             $user->id = $persona->id;
             $user->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
        
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
        try{
            DB::beginTransaction();
            $user = User::findOrFail($request->id);
            $persona = Persona::findOrFail($user->id);

            $persona->nombre = $request->nombre;
            $persona->tipodocumento = $request->tipodocumento;
            $persona->numerodocumento = $request->numerodocumento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->condicion = '1';
            $user->rolid = $request->rolid;
            $user->save();

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
    }

    public function desactivar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}
