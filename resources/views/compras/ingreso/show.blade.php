@extends ('layouts.admin') <!--la plantilla va a externderse de la plantilla admin-->
@section ('contenido') <!--se mostrará en la seccion de "contenido"-->

	<div class="row">
		<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
			<div class="form-group">
				<label for="proveedor">Proveedor</label>
				<p>{{ $ingreso->nombre }}</p>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label>Tipo Comprobante</label>
				<p>{{ $ingreso->tipo_comprobante }}</p>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="serie_comprobante">Serie Comprobante</label>
				<p>{{ $ingreso->serie_comprobante }}</p>
			</div>
		</div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
			<div class="form-group">
				<label for="num_comprobante">Número Comprobante</label>
				<p>{{ $ingreso->num_comprobante }}</p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="panel panel-primary">
			<div class="panel-body">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
							<!--Cabecera de la tabla-->
							<thead style="background-color:#A9D0F5">
								<th>Artículos</th>
								<th>Cantidad</th>
								<th>Precio Compra</th>
								<th>Precio Venta</th>
								<th>Subtotal</th>
							</thead>
							<tbody>
								@foreach($detalles as $det)
								<tr>
									<td>{{ $det->articulo }}</td>
									<td>{{ $det->cantidad }}</td>
									<td>{{ $det->precio_compra }}</td>
									<td>{{ $det->precio_venta }}</td>
									<td>${{ $det->cantidad * $det->precio_compra }}</td><!--subtotal-->
								</tr>
								@endforeach
							</tbody>
							<tfoot>
								<th>TOTAL</th>
								<th></th>
								<th></th>
								<th></th>
								<th><h4 id="total"><b>${{ $ingreso->total }}</b></h4></th><!--el id es para especificar que en el h4 se vaya actualizando dependiendo del total-->
							</tfoot>
						</table>
				</div>

			</div>
		</div>
	</div>


@endsection <!--termina la seccion-->