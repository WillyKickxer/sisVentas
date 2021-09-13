<?php

namespace sisVentas\Http\Controllers;

use Illuminate\Http\Request;

use sisVentas\Http\Requests;
use sisVentas\Ingreso;
use sisVentas\DetalleIngreso;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisVentas\Http\Requests\IngresoFormRequest;
use DB;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); //gestiona inicialmente el acceso auth
    }

    public function index(Request $request) // $request: valida la cadena de busqueda que se filtrará cuando se listen todos los ingresos a almacen
    {
        if ($request)
        {
            $query = trim($request->get('searchText')); //la variable será igual a lo que se envia del formulario (objeto searchText) que será el texto que se quiere filtrar en todos los ingresos|    trim: borra los espacios al inicio y al final
            $ingresos = DB::table('ingreso as i')
                ->join('persona as p', 'i.idproveedor', '=', 'p.idpersona')
                ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
                ->select('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado',
                    DB::raw('sum(di.cantidad*di.precio_compra) as total'))
                ->where('i.num_comprobante', 'LIKE', '%'.$query.'%')
                ->groupBy('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado')
                ->orderBy('i.idingreso', 'desc')
                ->paginate(7);
            /*SELECT 'i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado', sum(di.cantidad*di.precio_compra) as total
            FROM persona as p JOIN ingreso as i ON p.idpersona = i.idproveedor
            JOIN detalle_ingreso as di ON i.idingreso = di.idingreso
            WHERE 'i.num_comprobante' LIKE %$query%
            GROUP BY 'i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado'
            ORDER BY 'i.idingreso' DESC; */
            return view('compras.ingreso.index', ["ingresos"=>$ingresos, "searchText"=>$query]);//retorna la vista enviando al index todos los ingresos de la variable "ingresos" y el texto que se está filtrando
        }
    }

    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona', '=', 'Proveedor')->get();//realiza una consulta a la tabla persona de la base de datos donde el tipo de persona sea igual a "proveedor"
        $articulos = DB::table('articulo as art')
            ->select(DB::raw('CONCAT(art.codigo, " ", art.nombre) AS articulo'), 'art.idarticulo')
            ->where('art.estado', '=', '1')
            ->get(); //consulta a la tabla articulo, obteniendo el id del articulo y concadenando el codigo con el nombre del articulo cuando el estado del mismo se encuentre activo

            return view('compras.ingreso.create', ["personas"=>$personas, "articulos"=>$articulos]);
    }

    public function store(IngresoFormRequest $request) //almacena el modelo en la tabla ingreso de la base de datos con todos los datos recibidos del formulario
    {
        try //se crea una transaccion por si ocurre un proble al registrar los ingresos y sus detalles, en caso de que se registre uno pero el otro no, se anula la transaccion
        {
            DB::beginTransaction();

            $ingreso = new Ingreso; //instancia del modelo ingreso
            //get(): objeto "name" del fomulario asignado a las tablas de la base de datos
            $ingreso->idproveedor = $request->get('idproveedor');
            $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
            $ingreso->serie_comprobante = $request->get('serie_comprobante');
            $ingreso->num_comprobante = $request->get('num_comprobante');

            $mytime = Carbon::now('America/Santiago'); //obtiene la fecha actual de la region

            $ingreso->fecha_hora = $mytime->toDateTimeString();
            $ingreso->impuesto = '19';
            $ingreso->estado = '1';

            $ingreso->save(); //guarda los datos obtenidos en la base de datos

            //contenido del array de detalles de ingreso.
            //asigna una variable para cada objeto del formulario
            $idarticulo = $request->get('idarticulo');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');

            $cont = 0; //contador que recorre el array de cada detalle

            while($cont < count($idarticulo)){ //recorre hasta que el contador sea menor a la cantidad de articulos
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->idingreso; //mismo id generado para el idingreso de detalles
                $detalle->idarticulo = $idarticulo[$cont];
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_compra = $precio_compra[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save();
                $cont = $cont + 1;
            }

            DB::commit();

        }catch(\Exception $e)
        {
            DB::rollback();
        }

        return Redirect::to('compras/ingreso');
    }

    public function show($id)
    {
        //muestra un registro en especifico
        $ingreso = DB::table('ingreso as i')
            ->join('persona as p', 'i.idproveedor', '=', 'p.idpersona')
            ->join('detalle_ingreso as di', 'i.idingreso', '=', 'di.idingreso')
            ->select('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante', 'i.num_comprobante', 'i.impuesto', 'i.estado', DB::raw('sum(di.cantidad*di.precio_compra) as total'))
            ->where('i.idingreso', '=', $id) //donde el id de ingreso sea igual a la variable id que se obtiene de la funcion show(parametro)
            ->first();//obtiene el primer ingreso que cumpla con la condicion cuyo id sea el que se recibe por parametro

        //muestra todos los detalles de un ingreso en especifico
        $detalles = DB::table('detalle_ingreso as d')
            ->join('articulo as a', 'd.idarticulo', '=', 'a.idarticulo')
            ->select('a.nombre as articulo', 'd.cantidad', 'd.precio_compra', 'd.precio_venta')
            ->where('d.idingreso', '=', $id)->get();//get(): obtiene todos los detalles

            return view('compras.ingreso.show', ["ingreso"=>$ingreso, "detalles"=>$detalles]);

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
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->estado = '0';

        $ingreso->update();

        return Redirect::to('compras/ingreso');
    }
}
