@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Cliente: {{ $persona->nombre }}</h3>
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

	{!! Form::model($persona, ['method'=>'PATCH', 'route'=>['ventas.cliente.update', $persona->idpersona]]) !!} <!--recibe la persona (cliente) con el motodo patch para que pueda enviar la funcion edit del controlador, envia como parametro la id de la persona-->
	{{ Form::token() }}

	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{ $persona->nombre }}" class="form-control"> <!--required: que sea requerido, para que sea validado con html; value:devuelve el texto que se habia ingresado en caso de no ser validado (nombre muy grande) el objeto nombre (name="nombre") será recibido por PersonaFormRequest, tambien será usado por el controlador en el metodo store-->
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="direccion">Dirección</label>
				<input type="text" name="direccion" required value="{{ $persona->direccion }}" class="form-control">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Documento</label>
				<select name="tipo_documento" class="form-control">
					@if($persona->tipo_documento == 'RUN')
						<option value="RUN" selected>RUN</option>
						<option value="pasaporte">PASAPORTE</option>
					@else($persona->tipo_documento == 'PASAPORTE')
						<option value="RUN">RUN</option>
						<option value="pasaporte" selected>PASAPORTE</option>
					@endif
				</select>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="num_documento">Número de documento</label>
				<input type="text" name="num_documento" value="{{ $persona->num_documento }}" class="form-control" placeholder="Número del Documento...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="telefono">Teléfono</label>
				<input type="text" name="telefono" value="{{ $persona->telefono }}" class="form-control" placeholder="Teléfono...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" name="email" value="{{ $persona->email }}" class="form-control" placeholder="Email...">
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">Guardar</button>
				<a href="../" class="btn btn-danger"><i class="fa fa-ban fa-fw"></i>Cancelar</a>
			</div>
		</div>
	</div>

	{!! Form::close() !!}

@endsection <!--termina la seccion-->