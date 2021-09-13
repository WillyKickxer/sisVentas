@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Categoría</h3>
			@if(count($errors) > 0)
			<div class="alert alert-danger alert-dismissible">
				<ul>
				@foreach ($errors->all() as $error) <!--recibirá todos los errores que son enviados por el formulario (el archivo request)-->
					<li>{{ $error }}</li> <!--muestra los errores encontrados-->
				@endforeach
				</ul>
			</div>
			@endif
			<br>
			{!! Form::open(array('url'=>'almacen/categoria', 'method'=>'POST', 'autocomplete'=>'off')) !!}
			{{ Form::token() }}
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" class="form-control" placeholder="Nombre..."><!--el objeto nombre (name="nombre") será recivido por CategoriaFormRequest, tambien será usado por el controlador en el metodo store-->
			</div>
			<div class="form-group">
				<label for="descripcion">Descripción</label>
				<input type="text" name="descripcion" class="form-control" placeholder="Descripción...">
			</div>
			<div class="form-group">
				<button class="btn btn-primary" type="submit">
					 <i class="bi bi-save" aria-hidden="true"></i> Guardar
				</button>
				<button class="btn btn-default" type="reset">
					<i class="bi bi-stars"></i> Limpiar
				</button>
				<a href="../categoria" class="btn btn-danger">
					<i class="fa fa-ban fa-fw"></i> Cancelar
				</a>
			</div>

			{!! Form::close() !!}

		</div>
	</div>
@endsection <!--termina la seccion-->