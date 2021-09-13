@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Categorías
				<a href="categoria/create"><!--href: carpeta/vista-->
					<button class="btn btn-success">
						<i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo
					</button>
				</a>
			</h3>
			@include('almacen.categoria.search')<!--Carpeta:almacen; Subcarpeta:categoria; Vista:search-->
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead> <!--cabecera de la tabla-->
						<th>Id</th>
						<th>Nombre</th>
						<th>Descripción</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
					@foreach ($categorias as $cat) <!--recorre todas las categorias que las almacena en la variable cat de manera independiente y las muestra abajo-->
					<tr> <!--segunda fila que muestra el total de registros-->
						<td>{{ $cat->idcategoria }}</td>
						<td>{{ $cat->nombre }}</td>
						<td>{{ $cat->descripcion }}</td>
						<td>{{ $cat->condicion }}</td>
						<td>
							<a href="{{ URL::action('CategoriaController@edit', $cat->idcategoria) }}"><!--llama al controlador y el metodo que trabajará será el edit, tomando como parametro el idcategoria-->
								<button class="btn btn-warning">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
								</button>
							</a>
							<a href="" data-target="#modal-delete-{{ $cat->idcategoria }}" data-toggle="modal">
								<button class="btn btn-danger">
									<i class="fa fa-trash" aria-hidden="true"></i> Eliminar
								</button>
							</a>
						</td>
					</tr>
					@include('almacen.categoria.modal') <!--por cada categoria se asigna un modal-->
					@endforeach
				</table>
			</div>
			{{ $categorias->render() }} <!--muestra la paginación, llamando al metodo render que permite paginar-->
		</div>
	</div>
@endsection <!--Fin seccion-->