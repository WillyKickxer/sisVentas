@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido" de la plantilla-->
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Ingresos
				<a href="ingreso/create"><!--href: carpeta/vista-->
					<button class="btn btn-success">
						<i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo
					</button>
				</a>
			</h3>
			@include('compras.ingreso.search') <!--Carpeta:compras; Subcarpeta:ingreso; Vista:search-->
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead> <!--cabecera de la tabla-->
						{{-- <th>Id</th> --}}
						<th>Fecha</th>
						<th>Proveedor</th>
						<th>Comprobante</th>
						<th>Impuesto(%)</th>
						<th>Total</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
					@foreach ($ingresos as $ing) <!--recorre todos los ingresos declarados en el controlador(index) y los almacena en la variable per de manera independiente y las muestra abajo-->
					<tr> <!--segunda fila que muestra el total de ingresos-->
						{{-- <td>{{ $ing->idingreso }}</td> --}}
						<td>{{ $ing->fecha_hora }}</td>
						<td>{{ $ing->nombre }}</td>
						<td>{{ $ing->tipo_comprobante.': '.$ing->serie_comprobante.'-'.$ing->num_comprobante }}</td>
						<td>{{ $ing->impuesto }}</td>
						<td>${{ $ing->total }}</td>
						<td>{{ $ing->estado }}</td>

						<td>
							<a href="{{ URL::action('IngresoController@show', $ing->idingreso) }}"><!--llama al controlador para mostrar los detalles con el metodo que trabajará (show), enviando como parametro el idingreso.-->
								<button class="btn btn-primary">
									<i class="bi bi-info-circle" aria-hidden="true"></i> Detalles
								</button>
							</a>
							<a href="" data-target="#modal-delete-{{ $ing->idingreso }}" data-toggle="modal">
								<button class="btn btn-danger">
									<i class="fa fa-trash" aria-hidden="true"></i> Anular
								</button>
							</a> <!--obtiene el id del ingreso que se quiere elimar-->
						</td>
					</tr>
					@include('compras.ingreso.modal') <!--por cada persona se asigna un modal-->
					@endforeach
				</table>
			</div>
			{{ $ingresos->render() }} <!--muestra la paginación, llamando al metodo render que permite paginar-->
		</div>
	</div>
@endsection <!--Fin seccion-->