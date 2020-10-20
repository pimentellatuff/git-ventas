<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\IngresoFormRequest;
use App\Models\Ingreso;
use App\Models\DetalleIngreso;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
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
            $ingresos = DB::table('ingresos as i')
                ->join('personas as p', 'i.idproveedor','=','p.idpersonas')
                ->join('detalle_ingresos as di', 'di.idingresos','=','i.idingresos')
            	->select('i.idingresos',
                        'i.fecha_hora',
                        'p.nombre',
                        'i.tipo_comprobante',
                        'i.serie_comprobante',
                        'i.num_comprobante',
                        'i.impuesto',
                        'i.estado',
                        DB::raw('sum(di.cantidad*precio_compra) as total'))
            ->where('i.num_comprobante','LIKE','%'.$query.'%')
            ->where('i.estado','=','A')
            ->orderBy('i.idingresos','desc')
            ->groupBy('i.idingresos',
                    'i.fecha_hora',
                    'p.nombre',
                    'i.tipo_comprobante',
                    'i.serie_comprobante',
                    'i.num_comprobante',
                    'i.impuesto',
                    'i.estado')
            ->paginate(7);
            return view('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
        }
    }

    public function create(){

    	$personas=DB::table('personas')->where('tipo_persona','=','Proveedor')->get();
    	$articulos=DB::table('articulos as art')
    		->select(DB::raw('CONCAT(art.codigo," ",art.nombre) AS articulo'),'art.idarticulos')
    		->where('art.estado','=','Activo')
    		->get();
    	return view('compras.ingreso.create',["personas"=>$personas,"articulos"=>$articulos]);
    }

     public function store(IngresoFormRequest $request)
    {
        try{
        	DB::beginTransaction();
        		$ingresos = new Ingreso;
        		$ingresos->idproveedor=$request->get('idproveedor');
        		$ingresos->tipo_comprobante=$request->get('tipo_comprobante');
        		$ingresos->serie_comprobante=$request->get('serie_comprobante');
        		$ingresos->num_comprobante=$request->get('num_comprobante');
        		$mytime=Carbon::now('America/Caracas');
        		$ingresos->fecha_hora=$mytime->toDateTimeString();
        		$ingresos->impuesto='18';
        		$ingresos->estado='A';
        		$ingresos->save();
        		$idarticulos=$request->get('idarticulo');
        		$cantidad=$request->get('cantidad');
        		$precio_compra=$request->get('precio_compra');
        		$precio_venta=$request->get('precio_venta');

        		$cont=0;
        		while($cont<count($idarticulos)){
        			$detalle=new DetalleIngreso();
        			$detalle->idingresos=$ingresos->idingresos;
        			$detalle->idarticulos=$idarticulos[$cont];
        			$detalle->cantidad=$cantidad[$cont];
        			$detalle->precio_compra=$precio_compra[$cont];
        			$detalle->precio_venta=$precio_venta[$cont];
        			$detalle->save();

        			$cont=$cont+1;
        		}

        	DB::commit();
        }catch(\Exception $e)
        {
        	DB::rollback();
        }
        return Redirect('compras/ingreso');
    }

    public function show($id)
    {
    	$ingresos = DB::table('ingresos as i')
            	->join('personas as p', 'i.idproveedor','=','p.idpersonas')
            	->join('detalle_ingresos as di', 'di.idingresos','=','i.idingresos')
            	->select('i.idingresos',
                    'i.fecha_hora',
                    'p.nombre',
                    'i.tipo_comprobante',
                    'i.serie_comprobante',
                    'i.num_comprobante',
                    'i.impuesto',
                    'i.estado',
                    DB::raw('sum(di.cantidad*precio_compra) as total'))
            	->where('i.idingresos','=',$id)
                ->orderBy('i.idingresos','desc')
                ->groupBy('i.idingresos',
                    'i.fecha_hora',
                    'p.nombre',
                    'i.tipo_comprobante',
                    'i.serie_comprobante',
                    'i.num_comprobante',
                    'i.impuesto',
                    'i.estado')
            	->first();

         $detalles=DB::table('detalle_ingresos as d')
         		->join('articulos as a','d.idarticulos','=','a.idarticulos')
         		->select('a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta')
         		->where('d.idingresos','=',$id)
         		->get();
         return view("compras.ingreso.show",["ingresos"=>$ingresos,"detalles"=>$detalles]);
    }

    public function destroy($id){
    	$ingresos=Ingreso::findOrFail($id);
    	$ingresos->estado='C';
    	$ingresos->update();
    	return Redirect('compras/ingreso');
    }

}
