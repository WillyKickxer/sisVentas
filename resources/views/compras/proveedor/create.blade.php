@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Proveedor</h3>

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

{!! Form::open(array('url'=>'compras/proveedor', 'method'=>'POST', 'autocomplete'=>'off')) !!}
{{ Form::token() }} <!--esto es igual a @ csrf-->

	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{ old('nombre') }}" class="form-control" placeholder="Nombre..."> <!--required: que sea requerido, para que sea validado con html; value:devuelve el texto que se habia ingresado en caso de no ser validado (nombre muy grande) el objeto nombre (name="nombre") será recibido por PersonaFormRequest, tambien será usado por el controlador en el metodo store-->
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="direccion">Dirección</label>
				<input type="text" name="direccion" required value="{{ old('direccion') }}" class="form-control" placeholder="Dirección...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Documento</label>
				<select name="tipo_documento" class="form-control">
						<option selected="selected">Seleccione...</option>
						<option value="RUN">RUT (Rol Único Tributario)</option>
						<option value="RUN">RUN (Rol Único Nacional)</option>
						<option value="pasaporte">PASAPORTE</option>
				</select>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="num_documento">Número de documento</label>
				<input type="text" name="num_documento" value="{{ old('num_documento') }}" class="form-control" placeholder="Número del Documento...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="telefono">Teléfono</label>
				<input type="text" name="telefono" value="{{ old('telefono') }}" class="form-control" placeholder="Teléfono...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email...">
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">
					 <i class="bi bi-save" aria-hidden="true"></i> Guardar
				</button>
				<button class="btn btn-default" type="reset">
					<i class="bi bi-stars" aria-hidden="true"></i> Limpiar
				</button>
				<a href="../proveedor" class="btn btn-danger">
					<i class="fa fa-ban fa-fw"></i> Cancelar
				</a>
			</div>
		</div>
	</div>

{!! Form::close() !!}

@endsection <!--termina la seccion-->