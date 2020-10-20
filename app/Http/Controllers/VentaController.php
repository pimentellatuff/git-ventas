<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\VentaFormRequest;
use App\Models\Venta;
use App\Models\DetalleVenta;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         if ($request)
        {
            $query =trim($request->get('searchText'));
            $ventas = DB::table('ventas as v')
                ->join('personas as p', 'v.idclientes','=','p.idpersonas')
                ->join('detalle_ventas as dv', 'v.idventas','=','dv.idventas')
            	->select('v.idventas',
                        'v.fecha_hora',
                        'p.nombre',
                        'v.tipo_comprobante',
                        'v.serie_comprobante',
                        'v.num_comprobante',
                        'v.impuesto',
                        'v.estado',
                        'v.total_ventas')
            ->where('v.num_comprobante','LIKE','%'.$query.'%')
            ->where('v.estado','=','A')
            ->orderBy('v.idventas','desc')
            ->paginate(7);
            return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
        }
    }

    public function create(){

    	$personas=DB::table('personas')->where('tipo_persona','=','Cliente')->get();
    	$articulos=DB::table('articulos as art')
    		->join('detalle_ventas as dv','art.idarticulos','=','dv.idarticulos')
    		->select(DB::raw('CONCAT(art.codigo,"-",art.nombre) as articulo'),'art.idarticulos','art.stock',
    				DB::raw('avg(dv.precio_venta) as precio_promedio'))
    		->where('art.estado','=','Activo')
    		->where('art.stock','>','0')
    		->groupBy('articulo','art.idarticulos','art.stock')
    		->get();
    	return view('ventas.venta.create',["personas"=>$personas,"articulos"=>$articulos]);
    }

     public function store(VentaFormRequest $request)
    {
        try{
        	DB::beginTransaction();
        		$ventas = new Venta;
        		$ventas->idclientes=$request->get('idclientes');
        		$ventas->tipo_comprobante=$request->get('tipo_comprobante');
        		$ventas->serie_comprobante=$request->get('serie_comprobante');
        		$ventas->num_comprobante=$request->get('num_comprobante');
        		$ventas->total_ventas=$request->get('total_ventas');
        		$mytime=Carbon::now('America/Caracas');
        		$ventas->fecha_hora=$mytime->toDateTimeString();
        		$ventas->impuesto='18';
        		$ventas->estado='A';
        		$ventas->save();
        		$idarticulos=$request->get('idarticulo');
        		$cantidad=$request->get('cantidad');
        		$descuento=$request->get('descuento');
        		$precio_venta=$request->get('precio_venta');
                echo "$idarticulos[0]";
        		$cont=0;
        		while($cont<count($idarticulos)){
        			$detalle=new DetalleVenta;
        			$detalle->idventas=$ventas->idventas;
        			$detalle->idarticulos=$idarticulos[$cont];
        			$detalle->cantidad=$cantidad[$cont];
        			$detalle->descuento=$descuento[$cont];
        			$detalle->precio_venta=$precio_venta[$cont];
        			$detalle->save();

        			$cont=$cont+1;
        		}

        	DB::commit();
        }catch(\Exception $e)
        {
        	DB::rollback();
            return($e);
        }
        return Redirect('ventas/venta');

    }

    public function show($id)
    {
    	$ventas = DB::table('ventas as v')
            	->join('personas as p', 'v.idclientes','=','p.idpersonas')
            	->join('detalle_ventas as dv', 'v.idventas','=','dv.idventas')
            	->select('v.idventas',
                    'v.fecha_hora',
                    'p.nombre',
                    'v.tipo_comprobante',
                    'v.serie_comprobante',
                    'v.num_comprobante',
                    'v.impuesto',
                    'v.estado',
                    'v.total_ventas')
            	->where('v.idventas','=',$id)
                ->orderBy('v.idventas','desc')
               
            	->first();

         $detalles=DB::table('detalle_ventas as d')
         		->join('articulos as a','d.idarticulos','=','a.idarticulos')
         		->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta')
         		->where('d.idventas','=',$id)
         		->get();
         return view("ventas.venta.show",["ventas"=>$ventas,"detalles"=>$detalles]);
    }

    public function destroy($id){
    	$ventas=Venta::findOrFail($id);
    	$ventas->estado='C';
    	$ventas->update();
    	return Redirect('ventas/venta');
    }

}
