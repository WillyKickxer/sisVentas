<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\ArticuloFormRequest;
use sisVentas\Articulo;
use DB;

class ArticuloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //gestiona inicialmente el acceso auth
    }

    public function index(Request $request)
    {
        if ($request) {
            $query=trim($request->get('searchText')); //determinar cual va a ser el texto de busqueda para filtrar los articulos (tomando el objeto searchText que viene de search.blade.php)
            $articulos=DB::table('articulo as a') //tabla de donde obtendrá los registros
            ->join('categoria as c', 'a.idcategoria', '=', 'c.idcategoria')
            ->select('a.idarticulo', 'a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.estado')
            ->where('a.nombre', 'LIKE', '%'.$query.'%') //condiciones de busqueda..
            ->orwhere('a.codigo', 'LIKE', '%'.$query.'%')
            ->orderBy('a.idarticulo', 'asc')
            ->paginate(7);

            return view('almacen.articulo.index', ["articulos" => $articulos, "searchText" => $query]); //retorna la vista ../index con los parametros categorias y el texto de busqueda
        }
    }

    public function create()
    {
        $categorias = DB::table('categoria')->where('condicion', '=', '1')->get();//seleccionar todas las categorias de la base de datos donde la condicion sea igual a 1 (las que esten activas)
        return view('almacen.articulo.create', ["categorias"=>$categorias]); //retorna a la vista create enviando como parametro todas las categorias.
    }

    public function store(ArticuloFormRequest $request) //almacena el objeto del modelo categoria en la tabla categoria de la base de datos
    {
        $articulo = new Articulo; //crea un objeto nuevo del modelo Categoria (instancia)
        $articulo->idcategoria=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock=$request->get('stock');
        $articulo->descripcion=$request->get('descripcion');
        $articulo->estado='1';

        if(Input::hasFile('imagen')){ //si existe un archivo imagen
            $file = Input::file('imagen');//almacena la imagen obtenida en la variable $file(objeto del formulario)
            $file->move(public_path().'/imagenes/articulos/', $file->getClientOriginalName());//mueve los archivos a la carpeta "articulos" que está dentro de una carpeta publica (imagenes), los archivos que se moverán son los que se encuentran almacenados en la variable $file (la imagen que se obtiene del formulario) obteniendo el nombre (getClient...)
            $articulo->imagen = $file->getClientOriginalName();
        }

        $articulo->save(); //almacena el objeto en la base de datos

        return Redirect::to('almacen/articulo'); //redirecionar al listado de todas las categorias
    }

    public function show($id)
    {
        //retorna la vista show, pero envia la categoria para que la muestre
        return view('almacen.articulo.show', ["articulo"=>Articulo::findOrFail($id)]);
    }

    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id); //recupera un articulo especifico (detallado por id)
        $categorias = DB::table('categoria')->where('condicion', '=', '1')->get(); //recupera todas las categorias activas
        return view('almacen.articulo.edit', ["articulo"=>$articulo, "categorias"=>$categorias]); //a la vista le envia articulo y categorias como parametros
    }

    public function update(ArticuloFormRequest $request, $id) //primero valido los datos luego de recibirlos y despues el id que se quiere actualizar
    {
        $articulo = Articulo::findOrFail($id); //recupera el articulo que se quiere modificar

        $articulo->idcategoria=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock=$request->get('stock');
        $articulo->descripcion=$request->get('descripcion');

        if(Input::hasFile('imagen')){ //si existe un archivo imagen
            $file = Input::file('imagen');//almacena la imagen obtenida en la variable $file(objeto del formulario)
            $file->move(public_path().'/imagenes/articulos/', $file->getClientOriginalName());
            $articulo->imagen = $file->getClientOriginalName();
        }

        $articulo->update(); //actualiza al objeto

        return Redirect::to('almacen/articulo');
    }

    public function destroy($id)
    {
        $articulo = Articulo::findOrFail($id); //selecciona el articulo cuyo id sea igual al parametro
        $articulo->estado='0'; //cambia el estado del articulo

        $articulo->update();

        return Redirect::to('almacen/articulo');
    }
}
