@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Editar Usuario: {{ $usuario->name }}</h3>
			@if(count($errors) > 0)
			<div class="alert alert-danger alert-dismissible">
				<ul>
				@foreach ($errors->all() as $error) <!--recibirá todos los errores que son enviados por el formulario (el archivo request)-->
					<li>{{ $error }}</li> <!--muestra los errores encontrados-->
				@endforeach
				</ul>
			</div>
			@endif

			{!! Form::model($usuario, ['method'=>'PATCH', 'route'=>['seguridad.usuario.update', $usuario->id]]) !!} <!--recibe la categoria, envia la variable con la id de la categoria recibida como parametro a la ruta de update-->
			{{ Form::token() }}
			<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
		        <label for="name" class="col-md-4 control-label">Nombre</label>

		        <div class="col-md-6">
		            <input id="name" type="text" class="form-control" name="name" value="{{ $usuario->name }}">

		            @if ($errors->has('name'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('name') }}</strong>
		                </span>
		            @endif
		        </div>
		    </div>

		    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
		        <label for="email" class="col-md-4 control-label">E-Mail</label>

		        <div class="col-md-6">
		            <input id="email" type="email" class="form-control" name="email" value="{{ $usuario->email }}">

		            @if ($errors->has('email'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('email') }}</strong>
		                </span>
		            @endif
		        </div>
		    </div>

		    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
		        <label for="password" class="col-md-4 control-label">Contraseña</label>

		        <div class="col-md-6">
		            <input id="password" type="password" class="form-control" name="password">

		            @if ($errors->has('password'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('password') }}</strong>
		                </span>
		            @endif
		        </div>
		    </div>

		    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
		        <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

		        <div class="col-md-6">
		            <input id="password-confirm" type="password" class="form-control" name="password_confirmation">

		            @if ($errors->has('password_confirmation'))
		                <span class="help-block">
		                    <strong>{{ $errors->first('password_confirmation') }}</strong>
		                </span>
		            @endif
		        </div>
		    </div>

			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<div class="form-group">
					<button class="btn btn-primary" type="submit">Guardar</button>
					<a href="../" class="btn btn-danger"><i class="fa fa-ban fa-fw"></i>Cancelar</a>
				</div>
			</div>

			{!! Form::close() !!}

		</div>
	</div>
@endsection <!--termina la seccion-->