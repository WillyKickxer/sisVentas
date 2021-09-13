<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use sisVentas\Categoria;
use Illuminate\Support\Facades\Redirect;
use sisVentas\Http\Requests\CategoriaFormRequest;
use DB;

class CategoriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //gestiona inicialmente el acceso auth
    }

    public function index(Request $request)
    {
        if ($request) {
            $query=trim($request->get('searchText')); //determinar cual va a ser el texto de busqueda para filtrar las categorias (tomando el objeto searchText que viene de search.blade.php)
            $categorias=DB::table('categoria') //tabla de donde obtendrá los registros
            ->where('nombre', 'LIKE', '%'.$query.'%') //condiciones de busqueda..
            ->orwhere('descripcion', 'LIKE', '%'.$query.'%')
            ->orderBy('idcategoria', 'asc')
            ->paginate(7);

            return view('almacen.categoria.index', ["categorias" => $categorias, "searchText" => $query]); //retorna la vista ../index con los parametros categorias y el texto de busqueda
        }
    }

    public function create()
    {
        return view('almacen.categoria.create'); //retorna a la vista create de la carpeta categoria que está en la carpeta almacen.
    }

    public function store(CategoriaFormRequest $request) //almacena el objeto del modelo categoria en la tabla categoria de la base de datos
    {
        $categoria = new Categoria; //crea un objeto nuevo del modelo Categoria (instancia)
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->condicion='1';

        $categoria->save(); //almacena el objeto en la base de datos

        return Redirect::to('almacen/categoria'); //redirecionar al listado de todas las categorias
    }

    public function show($id)
    {
        //retorna la vista show, pero envia la categoria para que la muestre
        return view('almacen.categoria.show', ["categoria"=>Categoria::findOrFail($id)]);
    }

    public function edit($id)
    {
        return view('almacen.categoria.edit', ["categoria"=>Categoria::findOrFail($id)]);
    }

    public function update(CategoriaFormRequest $request, $id)
    {
        $categoria = Categoria::findOrFail($id); //recupera la categoria que se quiere modificar
        $categoria->nombre = $request->get('nombre'); //recupera la propiedad nombre del objeto del formulario 'nombre'
        $categoria->descripcion = $request->get('descripcion');
        $categoria->condicion = trim($request->get('condicion'), "Activo Inactivo ()"); // recupera la propiedad condicion del objeto del formulario 'condicion' (name=condicion) y borra las palabras "Activo", "Inactivo" y los parentesis (trim(objeto, borrado))

        $categoria->update(); //actualiza al objeto

        return Redirect::to('almacen/categoria');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id); //seleccione la categoria cuyo id sea igual al parametro
        $categoria->condicion='0'; //donde su condicion sea igual a 0

        $categoria->update();

        return Redirect::to('almacen/categoria');
    }
}
