@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Artículo: "<b>{{ $articulo->nombre }}</b>"</h3>
			@if(count($errors) > 0)
			<div class="alert alert-danger alert-dismissible">
				<ul>
				@foreach ($errors->all() as $error) <!--recibirá todos los errores que son enviados por el formulario (el archivo request)-->
					<li>{{ $error }}</li> <!--muestra los errores encontrados-->
				@endforeach
				</ul>
			</div>
			@endif
		</div>
	</div>
	<br>
	{!! Form::model($articulo, ['method'=>'PATCH', 'route'=>['almacen.articulo.update', $articulo->idarticulo], 'files'=>'true']) !!} <!--recibe el articulo con el motodo patch para que pueda enviar la funcion edit del controlador, envia como parametro la id del articulo y permite enviar archivos de imagen con filesrecibida para la ruta de update-->
	{{ Form::token() }}

	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{ $articulo->nombre }}" class="form-control">
			</div>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<div class="form-group">
				<label for="codigo">Código</label>
				<input type="text" name="codigo" required value="{{ $articulo->codigo }}" class="form-control">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Categoría</label>
				<select name="idcategoria" class="form-control">
					@foreach($categorias as $cat)
						@if($cat->idcategoria == $articulo->idcategoria)
							<option value="{{ $cat->idcategoria }}" selected>{{ $cat->nombre }}</option>
						@else
							<option value="{{ $cat->idcategoria }}">{{ $cat->nombre }}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
			<div class="form-group">
				<label for="stock">Stock</label>
				<input type="text" name="stock" required value="{{ $articulo->stock }}" class="form-control">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="descripcion">Descripción</label>
				<input type="text" name="descripcion" value="{{ $articulo->descripcion }}" class="form-control" placeholder="Descripción del artículo...">
			</div>
		</div>

		<div class="col-lg-5 col-sm-5 col-md-5 col-xs-12">
			<div class="form-group">
				<label for="imagen">Imagen</label>
				<input type="file" name="imagen" class="form-control">
				<br>
				@if( ($articulo->imagen) != "" )
					<img src="{{ asset('imagenes/articulos/' . $articulo->imagen ) }}" height="180px" width="180px">
				@endif
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">
					<i class="bi bi-save" aria-hidden="true"></i> Guardar
				</button>
				<a href="../" class="btn btn-danger">
					<i class="fa fa-ban fa-fw"></i> Cancelar
				</a>
			</div>
		</div>
	</div>

	{!! Form::close() !!}

@endsection <!--termina la seccion-->