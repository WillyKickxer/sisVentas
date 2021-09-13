{!! Form::open(array('url' => 'ventas/venta', 'method'=>'GET', 'autocomplete'=>'off', 'role'=>'search')) !!}
<!--abre el formulario y le envia los siguientes parametros:
URL = será la direccion donde se redireccionará el formulario (que será index.blade.php) para enviar el parametro de busqueda que se quiere realizar
METHOD = envia el parametro en la url, permite filtrar los datos enviadas
-->
<div class="form-group">
	<div class="input-group">
		<input type="text" class="form-control" name="searchText" placeholder="Buscar..." value="{{ $searchText }}">
		<span class="input-group-btn">
			<button type="submit" class="btn btn-primary">
				<i class="fa fa-search" aria-hidden="true"></i> Buscar
			</button>
		</span>
	</div>
</div>

{{ Form::close() }} <!--cierre del formulario-->