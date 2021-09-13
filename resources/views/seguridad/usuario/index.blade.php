@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Usuarios <a href="usuario/create"><button class="btn btn-success">Nuevo</button></a></h3>
			@include('seguridad.usuario.search') <!--Carpeta:seguridad; Subcarpeta:usuario; Vista:search-->
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead> <!--cabecera de la tabla-->
						<th>Id</th>
						<th>Nombre</th>
						<th>Email</th>
						<th>Opciones</th>
					</thead>
					@foreach ($usuarios as $usu) <!--recorre todos los usuarios y los almacena en la variable usu de manera independiente y las muestra abajo-->
					<tr> <!--segunda fila que muestra el total de registros-->
						<td>{{ $usu->id }}</td>
						<td>{{ $usu->name }}</td>
						<td>{{ $usu->email }}</td>
						<td>
							<a href="{{ URL::action('UsuarioController@edit', $usu->id) }}">
								<button class="btn btn-warning" title="Editar Usuario">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
								</button>
							</a><!--llama al controlador y el metodo que trabajará será el edit, enviando como parametro el idpersona-->
							<a href="" data-target="#modal-delete-{{ $usu->id }}" data-toggle="modal">
								<button class="btn btn-danger" title="Eliminar Usuario">
									<i class="fa fa-trash" aria-hidden="true"></i> Eliminar
								</button></a> <!--obtiene el id de la persona que se quiere elimar-->
						</td>
					</tr>
					@include('seguridad.usuario.modal') <!--por cada usuario se asigna un modal-->
					@endforeach
				</table>
			</div>
			{{ $usuarios->render() }} <!--muestra la paginación, llamando al metodo render que permite paginar-->
		</div>
	</div>
@endsection <!--Fin seccion-->