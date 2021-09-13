@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
			<h3>Listado de Artículos
				<a href="articulo/create"><!--href: carpeta/vista-->
					<button class="btn btn-success">
						<i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo
					</button>
				</a>
			</h3>
			@include('almacen.articulo.search')<!--Carpeta:almacen; Subcarpeta:articulo; Vista:search-->
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-condensed table-hover">
					<thead> <!--cabecera de la tabla-->
						<th>Id</th>
						<th>Nombre</th>
						<th>Código</th>
						<th>Categoría</th>
						<th>Stock</th>
						<th>Imagen</th>
						<th>Estado</th>
						<th>Opciones</th>
					</thead>
					@foreach ($articulos as $art) <!--recorre todos los articulos declarados en el controlador(index) y los almacena en la variable art de manera independiente y las muestra abajo-->
					<tr> <!--segunda fila que muestra el total de registros-->
						<td>{{ $art->idarticulo }}</td>
						<td>{{ $art->nombre }}</td>
						<td>{{ $art->codigo }}</td>
						<td>{{ $art->categoria }}</td>
						<td>{{ $art->stock }}</td>
						<td>
							<img src="{{ asset('imagenes/articulos/' . $art->imagen) }}" alt="{{ $art->nombre }}" height="100px" width="100px" class="img-thumbnail">
						</td>
						<td>{{ $art->estado }}</td>
						<td>
							<a href="{{ URL::action('ArticuloController@edit', $art->idarticulo) }}">
								<button class="btn btn-warning">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar
								</button>
							</a><!--llama al controlador y el metodo que trabajará será el edit, tomando como parametro el idarticulo-->
							<a href="" data-target="#modal-delete-{{ $art->idarticulo }}" data-toggle="modal">
								<button class="btn btn-danger">
									<i class="fa fa-trash" aria-hidden="true"></i> Eliminar
								</button>
							</a>
						</td>
					</tr>
					@include('almacen.articulo.modal') <!--por cada articulo se asigna un modal-->
					@endforeach
				</table>
			</div>
			{{ $articulos->render() }} <!--muestra la paginación, llamando al metodo render que permite paginar-->
		</div>
	</div>
@endsection <!--Fin seccion-->