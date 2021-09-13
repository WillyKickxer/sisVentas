@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido" de la plantilla-->
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Ventas
				<a href="venta/create"><!--href: carpeta/vista-->
					<button class="btn btn-success">
						<i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo
					</button>
				</a>
			</h3>
			@include('ventas.venta.search')<!--Carpeta:ventas; Subcarpeta:venta; Vista:search-->
		</div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
			<a href="{{ route('descargarPDF') }}" class="btn btn-default">Reporte</a> <!--llama a la ruta 'descargarPDF'-->
		<div>

		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead> <!--cabecera de la tabla-->
						<th>Fecha</th>
						<th>Cliente</th>
						<th>Comprobante</th>
						<th>Impuesto(%)</th>
						<th>Total</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
					@foreach ($ventas as $ven) <!--recorre todos las ventas declarados en el controlador(index) y los almacena en la variable ven de manera independiente y las muestra abajo-->
					<tr> <!--segunda fila que muestra el total de ventas-->
						<td>{{ $ven->fecha_hora }}</td>
						<td>{{ $ven->nombre }}</td>
						<td>{{ $ven->tipo_comprobante.': '.$ven->serie_comprobante.'-'.$ven->num_comprobante }}</td>
						<td>{{ $ven->impuesto }}</td>
						<td>${{ $ven->total_venta }}</td>
						<td>{{ $ven->estado }}</td>

						<td>
							<a href="{{ URL::action('VentaController@show', $ven->idventa) }}"><button class="btn btn-primary">Detalles</button></a><!--llama al controlador para mostrar los detalles con el metodo que trabajará (show), enviando como parametro el idventa.-->
							<a href="" data-target="#modal-delete-{{ $ven->idventa }}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a> <!--obtiene el id de la venta que se quiere elimar-->
						</td>
					</tr>
					@include('ventas.venta.modal') <!--por cada venta se asigna un modal-->
					@endforeach
				</table>
			</div>
			{{ $ventas->render() }} <!--muestra la paginación, llamando al metodo render que permite paginar-->
		</div>
	</div>
@endsection <!--Fin seccion-->