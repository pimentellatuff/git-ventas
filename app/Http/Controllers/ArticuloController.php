<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\ArticuloFormRequest;
use App\Http\Controllers\ArticuloController;
use App\Models\Articulo;
use App\resources\view\layouts;
use App\resources\view\almacen;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;


class ArticuloController extends Controller
{
    public function __construct()
    {
        $this->Middleware('App\Http\Middleware\Authenticate');
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
            $articulos = DB::table('articulos as a')
            ->join('categorias as c','a.idcategorias','=','c.idcategorias')
            ->select('a.idarticulos','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado')
            ->where('a.nombre','LIKE','%'.$query.'%')
            ->orwhere('a.codigo','LIKE','%'.$query.'%')
            ->orderBy('a.idarticulos','desc')
            ->paginate(7);
            return view('almacen.articulo.index',["articulos"=>$articulos,"searchText"=>$query]);
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias=DB::table('categorias')->where('condicion','=','1')->get();
        return view ("almacen.articulo.create",["categorias"=>$categorias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticuloFormRequest $request)
    //public function store(Request $request)
    {
        $articulos=new Articulo;
        $articulos->idcategorias=$request->get('idcategorias');
        $articulos->codigo=$request->get('codigo');
        $articulos->nombre=$request->get('nombre');
        $articulos->stock=$request->get('stock');
        $articulos->descripcion=$request->get('descripcion');
        $articulos->estado='Activo';
        $entrada=$request->all();  
        if($file=$request->file('imagen')){
            $fileName = $file->getClientOriginalName() ;
            $destinationPath = 'imagenes/articulos' ;
            $file->move($destinationPath,$fileName);
            $entrada['imagen']=$fileName;
            $articulos->imagen=$fileName;  
        }
        $articulos->save();
        return redirect('almacen/articulo');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("almacen.articulo.show",["articulos"=>Articulo::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $articulos=Articulo::findOrfail($id);
        $categorias=DB::table('categorias')->where('condicion','=','1')->get();


        return view("almacen.articulo.edit",["articulos"=>$articulos,"categorias"=>$categorias]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticuloFormRequest $request, $id)
    {
        $articulos=Articulo::findOrFail($id);
        $articulos->idcategorias=$request->get('idcategorias');
        $articulos->codigo=$request->get('codigo');
        $articulos->nombre=$request->get('nombre');
        $articulos->stock=$request->get('stock');
        $articulos->descripcion=$request->get('descripcion');
        $articulos->estado='Activo';
        if (Input::hasFile('imagen')){

            $file=Input::file('imagen');
            $file->move(public_path().'imagenes/articulos/',$file->getClientOriginalName());
            $articulo->imagen=$file->getClientOriginalName();
        }
        $articulos->update();
        return redirect('almacen/articulo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articulos=Articulo::findOrFail($id);
        $articulos->estado='Inactivo';
        $articulos->update();
        return redirect('almacen/articulo');
    }
}
