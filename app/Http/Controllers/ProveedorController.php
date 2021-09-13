<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use sisVentas\Persona;
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests\PersonaFormRequest;
use DB;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //gestiona inicialmente el acceso auth
    }

    public function index(Request $request)
    {
        if ($request) {
            $query=trim($request->get('searchText')); //determinar cual va a ser el texto de busqueda para filtrar las personas (tomando el objeto searchText que viene de search.blade.php)
            $personas=DB::table('persona') //tabla de donde obtendrá los registros
            ->where('nombre', 'LIKE', '%'.$query.'%') //condiciones de busqueda..
            ->where('tipo_persona', '=', 'Proveedor')
            ->orwhere('num_documento', 'LIKE', '%'.$query.'%')
            ->where('tipo_persona', '=', 'Proveedor')
            ->orderBy('idpersona', 'asc')
            ->paginate(7);

            return view('compras.proveedor.index', ["personas" => $personas, "searchText" => $query]); //retorna la vista ../index enviando los parametros de personas y el texto de busqueda
        }
    }

    public function create()
    {
        return view('compras.proveedor.create'); //retorna a la vista create de la carpeta proveedor que está en la carpeta compras.
    }

    public function store(PersonaFormRequest $request) //almacena el objeto del modelo persona en la tabla persona de la base de datos con todos los datos recibidos del formulario
    {
        $persona = new Persona; //crea un objeto nuevo del modelo persona (instancia)
        $persona->tipo_persona='Proveedor'; //todos los datos que se envien desde el formulario serán de tipo "Proveedor"
        $persona->nombre=$request->get('nombre'); //se envia el valor del objeto "nombre" del formulario
        $persona->tipo_documento=$request->get('tipo_documento');
        $persona->num_documento=$request->get('num_documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');

        $persona->save(); //almacena el objeto en la base de datos

        return Redirect::to('compras/proveedor'); //redirecionar al listado de todos los proveedores
    }

    public function show($id)
    {
        //retorna la vista show de la vista proveedor y envia la persona para que la muestre sus datos
        return view('compras.proveedor.show', ["persona"=>Persona::findOrFail($id)]);
    }

    public function edit($id)
    {
        //redirecciona a la vista edit de la vista proveedor y envia en un parametro "persona" los datos de la persona que se quiere editar (los datos los obtiene del modelo)
        return view('compras.proveedor.edit', ["persona"=>Persona::findOrFail($id)]);
    }

    public function update(PersonaFormRequest $request, $id)
    {
        $persona = Persona::findOrFail($id); //recupera el modelo de datos de persona
        $persona->nombre=$request->get('nombre'); //recupera la propiedad 'nombre' del objeto del formulario
        $persona->tipo_documento=$request->get('tipo_documento');
        $persona->num_documento=$request->get('num_documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');

        $persona->update(); //actualiza al objeto

        return Redirect::to('compras/proveedor');
    }

    public function destroy($id)
    {
        $persona = Persona::findOrFail($id); //seleccione la persona cuyo id sea igual al parametro
        $persona->tipo_persona='Inactivo'; //donde su condicion sea igual a

        $persona->update();

        return Redirect::to('compras/proveedor'); //redirecciona al index para mostrar el listado de todas las personas menos las que se encuentran inactivas
    }
}
