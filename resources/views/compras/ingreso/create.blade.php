@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Ingreso</h3>
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

{!! Form::open(array('url'=>'compras/ingreso', 'method'=>'POST', 'autocomplete'=>'off')) !!}
{{ Form::token() }} <!--esto es igual a @ csrf-->

	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div class="form-group">
				<label for="idproveedor">Proveedor</label>
				<select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
					<option selected="selected">Seleccione...</option>
					@foreach ($personas as $persona)
						<option value="{{ $persona->idpersona }}">{{ $persona->nombre }}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label>Tipo Comprobante</label>
				<select name="tipo_comprobante" class="form-control">
						<option selected="selected">Seleccione...</option>
						<option value="Boleta">Boleta</option>
						<option value="Factura">Factura</option>
						<option value="Ticket">Ticket</option>
				</select>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="serie_comprobante">Serie Comprobante</label>
				<input type="text" name="serie_comprobante" value="{{ old('serie_comprobante') }}" class="form-control" placeholder="Ingrese Serie Comprobante...">
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="num_comprobante">Número Comprobante</label>
				<input type="text" name="num_comprobante" required value="{{ old('num_comprobante') }}" class="form-control" placeholder="Ingrese Número Comprobante...">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<label>Artículo</label>
						<select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true"><!--pidarticulo no es el array de articulo, es un auxiliar para que previamente se seleccione un articulo, cantidad, etc y luego se agrega al array-->
							<option selected="selected">Seleccione...</option>
							@foreach($articulos as $articulo)
								<option value="{{ $articulo->idarticulo }}">
									{{ $articulo->articulo }}
								</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<label for="cantidad">Cantidad</label>
						<input type="number" name="pcantidad" id="pcantidad" class="form-control">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<label for="precio_compra">Precio Compra</label>
						<input type="number" name="pprecio_compra" id="pprecio_compra" class="form-control" placeholder="$">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<label for="precio_venta">Precio Venta</label>
						<input type="number" name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="$">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<button type="button" id="bt_add" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar</button>
					</div>
				</div>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
							<!--Cabecera de la tabla-->
							<thead style="background-color:#A9D0F5">
								<th>Opciones</th>
								<th>Artículo</th>
								<th>Cantidad</th>
								<th>Precio Compra</th>
								<th>Precio Venta</th>
								<th>Subtotal</th>
							</thead>
							<tbody>

							</tbody>
							<tfoot>
								<th>TOTAL</th>
								<th></th>
								<th></th>
								<th></th>
								<th></th>
								<th><h4 id="total"><b>$ 0.00</b></h4></th><!--el id es para especificar que en el h4 se vaya actualizando dependiendo del total-->
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" >
			<div class="form-group">
				<input type="hidden" name="_token" value="{{ csrf_token() }}"><!--permite proteger las transacciones-->
				<button class="btn btn-primary" type="submit" id="guardar">
					<i class="fa fa-check" aria-hidden="true"></i> Guardar
				</button>
				<a href="../ingreso" class="btn btn-danger">
					<i class="fa fa-ban fa-fw"></i> Cancelar
				</a>
			</div>

		</div>
	</div>

{!! Form::close() !!}

@push('scripts')<!--se usa el stack 'scripts' para indicar que todo el js que se escriba dentro del push se pondrá como si estuviera trabajando en la plantilla admin.blade, como si estuviera trabajando en el stack de dicha plantilla-->
<script>
	var cont = 0; //variable contador
	subtotal = []; //array para capturar todos los subtotales de cada detalle
	total = 0;
	$("#guardar").hide(); //cuando inicie el documento el boton guardar estará oculto

	//funcion que lee todos los valores de los objetos del formulario para agregarlos a la tabla detalle
	function agregar(){
		idarticulo = $("#pidarticulo").val();
		articulo = $("#pidarticulo option:selected").text(); //del pidarticulo tomará el valor seleccionado y asigna el texto a la variable
		cantidad = $("#pcantidad").val();
		precio_compra = $("#pprecio_compra").val();
		precio_venta = $("#pprecio_venta").val();

		if(idarticulo != "" && cantidad != "" && cantidad > 0
			&& precio_compra != "" && precio_venta != "")
		{
			subtotal[cont] = (cantidad * precio_compra);
			total = total + subtotal[cont];

			//evalua que fila eliminar, asigna un boton que permite eliminar la fila del detalle
			var fila =
			'<tr class="selected" id="fila'+cont+'">'+
				'<td>'+
					'<button type="button" class="btn btn-danger" onclick="eliminar('+cont+');"><i class="fa fa-trash-o fa-lg"></i></button>'+
				'</td>'+
				'<td>'+
					'<input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+
				'</td>'+
				'<td>'+
					'<input type="number" name="cantidad[]" value="'+cantidad+'">'+
				'</td>'+
				'<td>'+
					'<input type="number" name="precio_compra[]" value="'+precio_compra+'">'+
				'</td>'+
				'<td>'+
					'<input type="number" name="precio_venta[]" value="'+precio_venta+'">'+
				'</td>'+
				'<td>'+
					subtotal[cont] +
				'</td>'+
			'</tr>'; //al hacer click llama a la funcion eliminar enviando como parametro el contador

			cont++;
			limpiar(); //llama a la funcion limpiar para limpiar las cajas
			$("#total").html("$" + total).css( "font-weight","bold" ); //con la funcion html escribe el total en la casilla correspondiente
			evaluar(); //llama a la funcion para que muestre los botones en caso de hayan detalles
			$("#detalles").append(fila); //en el identificador detalles (la tabla) agrega la fila
		}
		else{
			alert("Error al ingresar el detalle del ingreso, revise los datos del artículo");
		}
	}

	//funcion para el boton agregar, utiliza la funcion agregar cuando se haga click en el boton
	$(document).ready(function(){
		$("#bt_add").click(function() {
			agregar();
		})
	})

	//funcion para el boton guardar, utiliza la funcion evaluarInput cuando se haga click en el boton
	$(document).ready(function(){
		$("#guardar").click(function() {
			evaluarInput();
		})
	})

	// funcion que permite limpiar las cajas de texto antes que se guarden a los detalles
	function limpiar(){
		$("#pcantidad").val(""); //al objeto (pcantidad) del formulario se le envia el valor vacio.
		$("#pprecio_compra").val("");
		$("#pprecio_venta").val("");
	}

	//funcion que oculta el boton guardar si no hay un detalle en la tabla
	function evaluar(){
		(total > 0 ) ? $("#guardar").show() : $("#guardar").hide();
	}

	function evaluarInput(){
		let idproveedor = document.getElementById('idproveedor');
		let guardar = document.getElementById('guardar');

		guardar.addEventListener("click", (event) => {
			event.preventDefault();

			if(idproveedor.value === "Seleccione...")
			{
				idproveedor.focus();
			}
		})

	}

	//funcion que recibe como parametro el indice del contador y que permite elimiar un detalle en especifico
	function eliminar(index){
		total = total - subtotal[index]; //obtener el subtotal del indice
		$("#total").html("$/. " + total); //actualiza el total
		$("#fila" + index).remove(); //remueve la fila correspondiente a su indice
		evaluar();
	}
</script>
@endpush
@endsection <!--termina la seccion-->