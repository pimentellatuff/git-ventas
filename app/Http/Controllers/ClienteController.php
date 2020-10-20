<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PersonaFormRequest;
use DB;

class ClienteController extends Controller
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
            ->where('tipo_persona','=','Cliente')
            ->orWhere('num_documento','LIKE','%'.$query.'%')
            ->where('tipo_persona','=','Cliente')
            ->orderBy('idpersonas','desc')
            ->paginate(7);
            return view('ventas.cliente.index',["personas"=>$personas,"searchText"=>$query]);
            
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ("ventas.cliente.create");
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
        $personas->tipo_persona='Cliente';
        $personas->nombre=$request->get('nombre');
        $personas->tipo_documento=$request->get('tipo_documento');
        $personas->num_documento=$request->get('num_documento');
        $personas->direccion=$request->get('direccion');
        $personas->telefono=$request->get('telefono');
        $personas->email=$request->get('email');
        $personas->save();
        return redirect('ventas/cliente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view("ventas.cliente.show",["personas"=>Persona::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       return view("ventas.cliente.edit",["personas"=>Persona::findOrFail($id)]);

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
        return redirect('ventas/cliente');
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
        return redirect('ventas/cliente');
    }
}
