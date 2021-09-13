@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nueva Venta</h3>
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

{!! Form::open(array('url'=>'ventas/venta', 'method'=>'POST', 'autocomplete'=>'off')) !!}
{{ Form::token() }} <!--esto es igual a @ csrf-->

	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div class="form-group">
				<label for="proveedor">Cliente</label>
				<select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
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
						<option value="Boleta">Boleta</option>
						<option value="Factura">Factura</option>
						<option value="Ticket">Ticket</option>
				</select>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="serie_comprobante">Serie Comprobante</label>
				<input type="text" name="serie_comprobante" value="{{ old('serie_comprobante') }}" class="form-control" placeholder="Serie Comprobante...">
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="num_comprobante">Número Comprobante</label>
				<input type="text" name="num_comprobante" required value="{{ old('num_comprobante') }}" class="form-control" placeholder="Número Comprobante...">
			</div>
		</div>
	</div>

	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<label>Artículo</label>
						<select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true"><!--pidarticulo no es el array de articulo, es un auxiliar para que previamente se seleccione un articulo, cantidad, etc y luego se agrega al array-->
							@foreach($articulos as $articulo)
								<option value="{{ $articulo->idarticulo }}_{{ $articulo->stock }}_{{ $articulo->precio_promedio }}"><!--el "_" sirve para concadenar en js(split0: idarticulo; split1: stock; split2:precio_promedio)-->
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
						<label for="stock">Stock</label>
						<input type="number" disabled name="pstock" id="pstock" class="form-control">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<label for="precio_venta">Precio Venta</label>
						<input type="number" disabled name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="$">
					</div>
				</div>
				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<label for="descuento">Descuento</label>
						<input type="number" name="pdescuento" id="pdescuento" class="form-control">
					</div>
				</div>

				<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
					<div class="form-group">
						<button type="button" id="bt_add" class="btn btn-primary">
							<i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar
						</button>
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
								<th>Precio Venta</th>
								<th>Descuento</th>
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
								<th>
									<h4 id="total"><b>$ 0.00</b></h4><!--el id se usará para especificar que en el h4 se vaya actualizando dependiendo del total-->
									<input type="hidden" name="total_venta" id="total_venta"><!--el valor que tiene h4 tambien se almacenará en el input para enviarlo al controlador y almacenarlo a la tabla-->
								</th>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
			<div class="form-group">
				<input type="hidden" name="_token" value="{{ csrf_token() }}"><!--permite proteger las transacciones-->
				<button class="btn btn-primary" type="submit">
					<i class="fa fa-check" aria-hidden="true"></i> Guardar
				</button>
				<a href="../venta" class="btn btn-danger">
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
	$("#pidarticulo").change(mostrarValores); //cada vez que se seleccione un articulo, muestra sus valores

	function mostrarValores(){
		datosArticulo = document.getElementById('pidarticulo').value.split('_'); //obtiene los valores de pidarticulo y separandolos con un "_" (valor 1 del split idarticulo_)
		$("#pprecio_venta").val(datosArticulo[2]); //obtiene el valor del input, en la ubicacion 2 del split (_precio_promedio)
		$("#pstock").val(datosArticulo[1]); //obtiene el valor del input, en la ubicacion 1 del split (_stock)
	}

	//funcion que lee todos los valores de los objetos del formulario para agregarlos a la tabla detalle
	function agregar(){
		datosArticulo = document.getElementById('pidarticulo').value.split('_');

		idarticulo = datosArticulo[0];
		articulo = $("#pidarticulo option:selected").text(); //del pidarticulo tomará el valor seleccionado y asigna el texto a la variable
		cantidad = $("#pcantidad").val();
		descuento = $("#pdescuento").val();
		precio_venta = $("#pprecio_venta").val();
		stock = $("#pstock").val();

		if(idarticulo != "" && cantidad != "" && cantidad > 0
			&& descuento != "" && precio_venta != "")
		{
			if(stock>=cantidad)
			{
				subtotal[cont] = (cantidad * precio_venta - descuento);
				total = total + subtotal[cont];

				//muestra el detalle de la venta en una tabla. Asigna un boton que permite eliminar la fila del detalle
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
						'<input type="number" name="precio_venta[]" value="'+precio_venta+'">'+
					'</td>'+
					'<td>'+
						'<input type="number" name="descuento[]" value="'+descuento+'">'+
					'</td>'+
					'<td>'+
						subtotal[cont] +
					'</td>'+
				'</tr>'; //al hacer click en el boton, llama a la funcion eliminar enviando como parametro el contador

				cont++;
				limpiar(); //llama a la funcion limpiar para limpiar las cajas
				$("#total").html("$" + total); //con la funcion html escribe el total en la casilla correspondiente .css( "font-weight","bold" )
				$("#total_venta").val(total); //al input total_venta se le envia el total de la venta
				evaluar(); //llama a la funcion para que muestre los botones en caso de hayan detalles
				$("#detalles").append(fila); //en el identificador detalles (la tabla) agrega la fila
			} else
			{
				alert("La cantidad a vender supera al stock disponible");
			}
		}
		else{
			alert("Error al ingresar el detalle de la venta, revise los datos del artículo");
		}
	}

	//funcion para el boton agregar, utiliza la funcion agregar cuando se haga click en el boton
	$(document).ready(function(){
		$("#bt_add").click(function() {
			agregar();
		})
	})

	// funcion que permite limpiar las cajas de texto antes que se guarden a los detalles
	function limpiar(){
		$("#pcantidad").val(""); //al objeto (pcantidad) del formulario se le envia el valor vacio.
		$("#pdescuento").val("");
		$("#pprecio_venta").val("");
	}

	//funcion que oculta el boton guardar si no hay un detalle en la tabla
	function evaluar(){
		if(total > 0){
			$("#guardar").show();
		} else{
			$("#guardar").hide();
		}

		// (total > 0 ) ? $("#guardar").show() : $("#guardar").hide();
	}

	//funcion que recibe como parametro el indice del contador y que permite elimiar un detalle en especifico
	function eliminar(index){
		total = total - subtotal[index]; //obtener el subtotal del indice
		$("#total").html("$/. " + total); //actualiza el total
		$("#total_venta").val(total);
		$("#fila" + index).remove(); //remueve la fila correspondiente a su indice
		evaluar();
	}
</script>
@endpush
@endsection <!--termina la seccion-->