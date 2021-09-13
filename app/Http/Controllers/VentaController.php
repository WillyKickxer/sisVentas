<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use sisVentas\Venta;
use sisVentas\DetalleVenta;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\VentaFormRequest;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //gestiona inicialmente el acceso auth
    }

    public function index(Request $request) // $request: valida la cadena de busqueda que se filtrará cuando se listen todos las ventas
    {
        if ($request)
        {
            $query = trim($request->get('searchText')); //la variable será igual a lo que se envia del formulario (objeto searchText) que será el texto que se quiere filtrar en todos las ventas|    trim: borra los espacios al inicio y al final
            $ventas = DB::table('venta as v')
                ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
                ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
                ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
                ->where('v.num_comprobante', 'LIKE', '%'.$query.'%')
                ->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado')
                ->orderBy('v.idventa', 'DESC')
                ->paginate(7);
            /*SELECT 'v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'total_venta'
            FROM persona as p JOIN venta as v ON p.idpersona = v.idcliente
            JOIN detalle_ingreso as dv ON v.idventa = dv.idventa
            WHERE 'v.num_comprobante' LIKE %$query%
            GROUP BY 'v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado'
            ORDER BY 'v.idventa' DESC; */
            return view('ventas.venta.index', ["ventas"=>$ventas, "searchText"=>$query]);//retorna la vista enviando al index todas las ventas de la variable "ventas" y el texto que se está filtrando
        }
    }

    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona', '=', 'Cliente')->get();//realiza una consulta a la tabla persona donde el tipo de persona sea igual a "cliente"
        $articulos = DB::table('articulo as art')
            ->join('detalle_ingreso as di', 'art.idarticulo', '=', 'di.idarticulo')
            ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'), 'art.idarticulo', 'art.stock', DB::raw('avg(di.precio_venta) as precio_promedio'))
            ->where('art.estado', '=', 'Activo')
            ->where('art.stock', '>', '0')
            ->groupBy('articulo', 'art.idarticulo', 'art.stock')
            ->get(); //consulta a la tabla articulo, obteniendo el id del articulo, el stock, el precio promedio de ventas y la concadenación del codigo con el nombre del articulo, cuando el estado del mismo se encuentre activo y el stock sea mayor a 0

            return view('ventas.venta.create', ["personas"=>$personas, "articulos"=>$articulos]);
    }

    public function store(VentaFormRequest $request) //almacena el modelo en la tabla venta de la base de datos con todos los datos recibidos del formulario
    {
        try //se crea una transaccion por si ocurre un proble al registrar las ventas y sus detalles, en caso de que se registre uno pero el otro no, se anula la transaccion
        {
            DB::beginTransaction();

            $venta = new Venta; //instancia del modelo venta
            //get(): objeto "name" del fomulario asignado a las tablas de la base de datos
            $venta->idcliente = $request->get('idcliente');
            $venta->tipo_comprobante = $request->get('tipo_comprobante');
            $venta->serie_comprobante = $request->get('serie_comprobante');
            $venta->num_comprobante = $request->get('num_comprobante');
            $venta->total_venta = $request->get('total_venta');

            $mytime = Carbon::now('America/Santiago'); //obtiene la fecha actual de la region

            $venta->fecha_hora = $mytime->toDateTimeString();
            $venta->impuesto = '19';
            $venta->estado = 'A';

            $venta->save(); //guarda los datos obtenidos en la base de datos

            //contenido del array de detalles de venta.
            //asigna una variable para cada objeto del formulario
            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precio_venta = $request->get('precio_venta');
            $cont = 0; //contador que recorre el array de cada detalle

            while($cont < count($idarticulo)){ //recorre hasta que el contador sea menor a la cantidad de articulos
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->idventa; //mismo id generado para el idventa de detalles
                $detalle->idarticulo = $idarticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->descuento = $descuento[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont = $cont + 1;
            }

            DB::commit();

        }catch(\Exception $e)
        {
            DB::rollback();
        }

        return Redirect::to('ventas/venta');
    }

    public function show($id)
    {
        //muestra un registro en especifico
        $venta = DB::table('venta as v')
            ->join('persona as p', 'v.idcliente', '=', 'p.idpersona')
            ->join('detalle_venta as dv', 'v.idventa', '=', 'dv.idventa')
            ->select('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante', 'v.num_comprobante', 'v.impuesto', 'v.estado', 'v.total_venta')
            ->where('v.idventa', '=', $id) //donde el id de venta sea igual a la variable id que se obtiene de la funcion show(parametro)
            ->first();//obtiene el primer registro de venta que cumpla con la condicion cuyo id sea el que se recibe por parametro

        //muestra todos los detalles de una venta en especifico
        $detalles = DB::table('detalle_venta as d')
            ->join('articulo as a', 'd.idarticulo', '=', 'a.idarticulo')
            ->select('a.nombre as articulo', 'd.cantidad', 'd.descuento', 'd.precio_venta')
            ->where('d.idventa', '=', $id)->get();//get(): obtiene todos los detalles

            return view('ventas.venta.show', ["venta"=>$venta, "detalles"=>$detalles]);

    }

    public function edit($id)
    {

    }

    public function update(PersonaFormRequest $request, $id)
    {

    }

    public function destroy($id)
    {
        //instancia un objeto de la clase ingreso para poder modificar su estado
        $venta = Venta::findOrFail($id);
        $venta->estado = 'C';

        $venta->update();

        return Redirect::to('ventas/venta');
    }
}
