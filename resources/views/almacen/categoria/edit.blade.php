<!--
| NOTA:
| La vista edit funciona a la perfección, corregir el boton eliminar para que elimine la categoria y
| no como funciona actualmente que solo le cambia el estado, ademas si se elimina la categoria,
| deberá ajustar los id de las categorias vigentes para que sean consecutivos
-->

@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Categoría: &nbsp;"<b>{{ $categoria->nombre }}</b>"</h3>
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

		{!! Form::model($categoria, ['method'=>'PATCH', 'route'=>['almacen.categoria.update', $categoria->idcategoria]]) !!} <!--recibe la categoria, envia la variable con la id de la categoria recibida como parametro a la ruta de update-->
		{{ Form::token() }}

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" class="form-control" value="{{ $categoria->nombre }}" placeholder="Nombre..."><!--el objeto nombre (name="nombre") será recivido por CategoriaFormRequest, tambien será usado por el controlador en el metodo store-->
			</div>
			<div class="form-group">
				<label for="descripcion">Descripción</label>
				<input type="text" name="descripcion" class="form-control" value="{{ $categoria->descripcion }}" placeholder="Descripción...">
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
			<div class="form-group">
				<label for="condicion">Estado</label>
				<select name="condicion" class="form-control">
					@if($categoria->condicion == '1')
						<option selected>Activo (1)</option>
						<option>Inactivo (0)</option>
					@else($categoria->condicion == '0')
						<option>Activo (1)</option>
						<option selected>Inactivo (0)</option>
					@endif
				</select>
			</div>
		</div>



	</div>
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">
					<i class="fa fa-check" aria-hidden="true"></i> Guardar
				</button>
				<a href="../" class="btn btn-danger">
					<i class="fa fa-ban fa-fw"></i> Cancelar
				</a>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
@endsection <!--termina la seccion-->