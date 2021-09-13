@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Artículo</h3>
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

{!! Form::open(array('url'=>'almacen/articulo', 'method'=>'POST', 'autocomplete'=>'off', 'files'=>'true')) !!} <!--files: permite enviar archivos-->
{{ Form::token() }} <!--esto es igual a @ csrf-->

	<div class="row">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{ old('nombre') }}" class="form-control" placeholder="Nombre..."> <!--required: que sea requerido, para que sea validado con html; value:devuelve el texto que se habia ingresado en caso de no ser validado (nombre muy grande) el objeto nombre (name="nombre") será recivido por CategoriaFormRequest, tambien será usado por el controlador en el metodo store-->
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="codigo">Código</label>
				<input type="text" name="codigo" required value="{{ old('codigo') }}" class="form-control" placeholder="Código del artículo...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Categoría</label>
				<select name="idcategoria" class="form-control">
					<option selected="selected">Seleccione...</option>
					@foreach($categorias as $cat) <!--muestra el nombre de las categorias como opciones, se envia al request el id de la categoria y se pasa al modelo para almacenarlo en la DB-->
						<option value="{{ $cat->idcategoria }}">{{ $cat->nombre }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="stock">Stock</label>
				<input type="text" name="stock" required value="{{ old('stock') }}" class="form-control" placeholder="Stock del artículo...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="descripcion">Descripción</label>
				<input type="text" name="descripcion" value="{{ old('descripcion') }}" class="form-control" placeholder="Descripción del artículo...">
			</div>
		</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="imagen">Imagen</label>
				<input type="file" name="imagen" class="form-control" >
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<button class="btn btn-primary" type="submit">
					 <i class="bi bi-save" aria-hidden="true"></i> Guardar
				</button>
				<button class="btn btn-default" type="reset">
					<i class="bi bi-stars"></i> Limpiar
				</button>
				<a href="../articulo" class="btn btn-danger">
					<i class="fa fa-ban fa-fw"></i> Cancelar
				</a>
			</div>
		</div>
	</div>

{!! Form::close() !!}

@endsection <!--termina la seccion-->