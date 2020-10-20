<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Requests\CategoriaFormRequest;

use App\Http\Controllers\CategoriaController;

use App\Categoria;
use App\resources\view\layouts;

use App\resources\view\almacen;

use Illuminate\Support\Facades\Redirect;

use DB;

use Illuminate\Support\Facades\Session;

use Illuminate\Routing\UrlGenerator;

use Illuminate\Support\Facades\URL;
class CategoriaController extends Controller
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
            $categorias = DB::table('categorias')->where('nombre','LIKE','%'.$query.'%')
            ->where('condicion','=','1')
            ->orderBy('idcategorias','desc')
            ->paginate(7);
            return view('almacen.categoria.index',["categorias"=>$categorias,"searchText"=>$query]);
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ("almacen.categoria.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoriaFormRequest $request)
    {
        $categorias=new Categoria;
        $categorias->nombre=$request->get('nombre');
        $categorias->descripcion=$request->get('descripcion');
        $categorias->condicion='1';
        $categorias->save();
        return redirect('almacen/categoria');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("almacen.categoria.show",["categorias"=>Categoria::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       return view("almacen.categoria.edit",["categorias"=>Categoria::findOrFail($id)]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriaFormRequest $request, $id)
    {
       $categorias=Categoria::findOrFail($id);
        $categorias->nombre=$request->get('nombre');
        $categorias->descripcion=$request->get('descripcion');
        $categorias->update();
        return redirect('almacen/categoria');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categorias=Categoria::findOrFail($id);
        $categorias->condicion='0';
        $categorias->update();
        return redirect('almacen/categoria');
    }
}
