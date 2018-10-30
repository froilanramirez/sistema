<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ingreso;
use App\IngresoDetalle;

class IngresoController extends Controller
{
    //
    public function index(Request $request)
    {
        //
         if(!$request->ajax()) return redirect('/');
         $buscar = $request->buscar;
         $criterio = $request->criterio;

         if($buscar == '')
         {
            $ingreso = Ingreso::join('personas','ingresos.proveedorid','=','personas.id')
            ->join('users','ingresos.usuarioid','=','users.id')
            ->select('ingresos.id','ingresos.tipocomprobante','ingresos.seriecomprobante','ingresos.numerocomprobante',
            'ingresos.fechahora','ingresos.impuesto','ingresos.total','ingresos.estado',
            'personas.nombre','users.usuario')
            ->orderBy('ingresos.id','desc')->paginate(2);
         }
         else
         {
            $ingreso = Ingreso::join('personas','ingresos.proveedorid','=','personas.id')
            ->join('users','ingresos.usuarioid','=','users.id')
            ->select('ingresos.id','ingresos.tipocomprobante','ingresos.seriecomprobante','ingresos.numerocomprobante',
            'ingresos.fechahora','ingresos.impuesto','ingresos.total','ingresos.estado',
            'personas.nombre','users.usuario')
            ->where('ingresos.'.$criterio,'like','%'. $buscar . '%')
            ->orderBy('ingresos.id','desc')->paginate(2);
         }

        return[
            'pagination' =>[
                'total' =>  $ingreso->total(),
                'current_page' =>  $ingreso->currentPage(),
                'per_page' =>  $ingreso->perPage(),
                'last_page' =>  $ingreso->lastPage(),
                'from' =>  $ingreso->firstItem(),
                'to' =>  $ingreso->lastItem(),
            ],
            'ingresos'    =>  $ingreso
        ];
    }

    public function obtenerCabecera(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id = $request->id;

        $ingreso = Ingreso::join('personas','ingresos.proveedorid','=','personas.id')
        ->join('users','ingresos.usuarioid','=','users.id')
        ->select('ingresos.id','ingresos.tipocomprobante','ingresos.seriecomprobante','ingresos.numerocomprobante',
        'ingresos.fechahora','ingresos.impuesto','ingresos.total','ingresos.estado',
        'personas.nombre','users.usuario')
        ->where('ingresos.id','=',$id)
        ->orderBy('ingresos.id','desc')->take(1)->get();

        return['ingresos' => $ingreso];
    }

    public function obtenerDetalles(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id = $request->id;

        $detalles = IngresoDetalle::join('articulos','ingresos_detalle.articuloid','=','articulos.articulosid')
        ->select('ingresos_detalle.cantidad','ingresos_detalle.precio','articulos.articulosnombre as articulo')
        ->where('ingresos_detalle.ingresoid','=',$id)
        ->orderBy('ingresos_detalle.id','desc')->take(1)->get();

        return['detalles' => $detalles];
    }

    public function store(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');
        try{
            DB::beginTransaction();

            $mytime = Carbon::now('America/Phoenix');

            $ingreso = new Ingreso();
            $ingreso->proveedorid = $request->proveedorid;
            $ingreso->usuarioid = \Auth::user()->id;
            $ingreso->tipocomprobante = $request->tipocomprobante;
            $ingreso->seriecomprobante = $request->seriecomprobante;
            $ingreso->numerocomprobante = $request->numerocomprobante;
            $ingreso->fechahora = $mytime->toDateString();
            $ingreso->impuesto = $request->impuesto;
            $ingreso->total = $request->total;
            $ingreso->estado = 'Registrado';
            $ingreso->save();

            $detalles = $request->data;
            foreach($detalles as $ep=>$det)
            {
                $detalle = new IngresoDetalle();
                $detalle->ingresoid = $ingreso->id;
                $detalle->articuloid = $det['articuloid'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->save();
            }

            DB::commit();

        } catch (Exception $e){
            DB::rollBack();
        }
        
    }

    public function desactivar(Request $request)
    {
        //
        if(!$request->ajax()) return redirect('/');

        $ingreso = Ingreso::findOrFail($request->id);
        $ingreso->estado = 'Anulado';
        $ingreso->save();
    }
}
