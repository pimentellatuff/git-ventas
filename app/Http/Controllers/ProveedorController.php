<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PersonaFormRequest;
use DB;

class ProveedorController extends Controller
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
            $personas = DB::table('personas')->where('nombre','LIKE','%'.$query.'%')
            ->where('tipo_persona','=','Proveedor')
            ->orWhere('num_documento','LIKE','%'.$query.'%')
            ->where('tipo_persona','=','Proveedor')
            ->orderBy('idpersonas','desc')
            ->paginate(7);
            return view('compras.proveedor.index',["personas"=>$personas,"searchText"=>$query]);
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ("compras.proveedor.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonaFormRequest $request)
    {
        $personas=new Persona;
        $personas->tipo_persona='Proveedor';
        $personas->nombre=$request->get('nombre');
        $personas->tipo_documento=$request->get('tipo_documento');
        $personas->num_documento=$request->get('num_documento');
        $personas->direccion=$request->get('direccion');
        $personas->telefono=$request->get('telefono');
        $personas->email=$request->get('email');
        $personas->save();
        return redirect('compras/proveedor');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("compras.proveedor.show",["personas"=>Persona::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       return view("compras.proveedor.edit",["personas"=>Persona::findOrFail($id)]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PersonaFormRequest $request, $id)
    {
       $personas=Persona::findOrFail($id);
        $personas->nombre=$request->get('nombre');
        $personas->tipo_documento=$request->get('tipo_documento');
        $personas->num_documento=$request->get('num_documento');
        $personas->direccion=$request->get('direccion');
        $personas->telefono=$request->get('telefono');
        $personas->email=$request->get('email');
        $personas->update();
        return redirect('compras/proveedor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $personas=Persona::findOrFail($id);
        $personas->tipo_persona='Inactivo';
        $personas->update();
        return redirect('compras/proveedor');
    }
}
