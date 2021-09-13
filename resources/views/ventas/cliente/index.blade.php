@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Clientes
				<a href="cliente/create"><!--href: carpeta/vista-->
					<button class="btn btn-success">
						<i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo
					</button>
				</a>
			</h3>
			@include('ventas.cliente.search')<!--Carpeta:ventas; Subcarpeta:cliente; Vista:search-->
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead> <!--cabecera de la tabla-->
						<th>Id</th>
						<th>Nombre</th>
						<th>Tipo de Doc.</th>
						<th>Número Doc.</th>
						<th>Teléfono</th>
						<th>Email</th>
						<th>Opciones</th>
					</thead>
					@foreach ($personas as $per) <!--recorre todas las personas declarados en el controlador(index) y los almacena en la variable per de manera independiente y las muestra abajo-->
					<tr> <!--segunda fila que muestra el total de registros-->
						<td>{{ $per->idpersona }}</td>
						<td>{{ $per->nombre }}</td>
						<td>{{ $per->tipo_documento }}</td>
						<td>{{ $per->num_documento }}</td>
						<td>{{ $per->telefono }}</td>
						<td>{{ $per->email }}</td>

						<td>
							<a href="{{ URL::action('ClienteController@edit', $per->idpersona) }}">
								<button class="btn btn-warning" title="Editar Cliente">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
								</button>
							</a><!--llama al controlador y el metodo que trabajará será el edit, enviando como parametro el idpersona-->
							<a href="" data-target="#modal-delete-{{ $per->idpersona }}" data-toggle="modal">
								<button class="btn btn-danger" title="Eliminar Cliente">
									<i class="fa fa-trash" aria-hidden="true"></i> Eliminar
								</button></a> <!--obtiene el id de la persona que se quiere elimar-->
						</td>
					</tr>
					@include('ventas.cliente.modal') <!--por cada persona se asigna un modal-->
					@endforeach
				</table>
			</div>
			{{ $personas->render() }} <!--muestra la paginación, llamando al metodo render que permite paginar-->
		</div>
	</div>
@endsection <!--Fin seccion-->