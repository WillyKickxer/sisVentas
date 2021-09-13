<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use sisVentas\User;
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests\UsuarioFormRequest;
use DB;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //gestiona inicialmente el acceso auth (this: esta clase[ClienteController])
    }

    public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText')); //determinar cual va a ser el texto de busqueda para filtrar (tomando el objeto searchText que viene de search.blade.php)
            $usuarios=DB::table('users') //tabla de donde obtendrá los registros
            ->where('name', 'LIKE', '%'.$query.'%') //condiciones de busqueda..
            ->orderBy('id', 'asc')
            ->paginate(7);

            return view('seguridad.usuario.index', ["usuarios" => $usuarios, "searchText" => $query]); //retorna la vista ../index enviando los parametros de usuarios y el texto de busqueda
        }
    }

    public function create()
    {
        return view('seguridad.usuario.create'); //retorna a la vista create
    }

    public function store(UsuarioFormRequest $request) //almacena el objeto del modelo usuario en la tabla users de la base de datos con todos los datos recibidos del formulario
    {
        $usuario = new User; //crea un objeto nuevo del modelo Usuario (instancia)

        $usuario->name=$request->get('name'); //se envia el valor del objeto "name" del formulario
        $usuario->email=$request->get('email');
        $usuario->password=bcrypt($request->get('password'));//encripta el password del formulario y lo envia al password de la base de datos

        $usuario->save(); //almacena el objeto en la base de datos

        return Redirect::to('seguridad/usuario'); //redirecionar a la ruta usuario
    }

    public function show($id)
    {
        // //retorna la vista show de la vista cliente y envia la persona para que la muestre sus datos
        // return view('ventas.cliente.show', ["persona"=>Persona::findOrFail($id)]);
    }

    public function edit($id)
    {
        //redirecciona a la vista edit de la vista usuario y envia en un parametro "usuario" los datos del usuario que se quiere editar (los datos los obtiene del modelo "Usuario")
        return view('seguridad.usuario.edit', ["usuario"=>User::findOrFail($id)]);
    }

    public function update(UsuarioFormRequest $request, $id) //recibe todos los datos del usuario, los valida con el UsuarioFormRequest y tambien recibe el id del usuario que se quiere modificar
    {
        $usuario = User::findOrFail($id); //recupera el modelo de datos de usuario
        $usuario->name=$request->get('name'); //se envia el valor del objeto "name" del formulario
        $usuario->email=$request->get('email');
        $usuario->password=bcrypt($request->get('password'));//encripta el password del formulario y lo envia al password de la base de datos

        $usuario->update(); //actualiza al objeto

        return Redirect::to('seguridad/usuario');
    }

    public function destroy($id)
    {
        $usuario = DB::table('users')
        ->where('id', '=', $id)
        ->delete();
        //recupera el usuario cuyo id sea el mismo que se envia como parametro y luego lo elimina

        return Redirect::to('seguridad/usuario'); //redirecciona al index para mostrar el listado de todos los usuarios menos el que se acaba de eliminar (deshabilitar)
    }
}
