<div class="modal fade modal-slide-in-right" aria-hidden="true" role="dialog" tabindex="-1" id="modal-delete-{{ $art->idarticulo }}"><!--crea un modal para cada articulo mostrado en el index-->
	{{ Form::Open(array('action'=>array('ArticuloController@destroy', $art->idarticulo)/*a donde lo vamos a enviar, que le vamos a enviar*/, 'method'=>'delete')) }}<!--abre el formulario que contiene como primer parametro la accion (donde se enviarán los datos del form) que se enviará al metodo destroy del controlador(usando como parametro la id de categoria), tambien se envia el metodo correspondiente a destroy el cual es delete-->

	<div class="modal-dialog">
		<div class="modal-content"> <!--crea una alerta de confirmación-->
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				</button>
				<h4 class="modal-title">Eliminar Artículo</h4>
			</div>

			<div class="modal-body">
				<p>¿Desea eliminar el artículo: &nbsp;<b>{{ $art->nombre }}</b>?</p>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>

	{!! Form::close() !!}
</div>