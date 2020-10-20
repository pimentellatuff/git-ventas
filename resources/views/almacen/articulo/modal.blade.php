<div class="modal fade modal-slide-in-rigth" aria-hidden="true" role="dialog" tabindex="-1" 
id="modal-delete-{{$art->idarticulos}}">
	{!! Form::model($articulos,['method'=>'DELETE','action'=>['App\Http\Controllers\ArticuloController@destroy',$art->idarticulos]]) !!}
	{{Form::token()}}

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">x</span>
				</button>
				<h4 class="modal-title">Eliminar Articulo</h4>
			</div>
			<div class="modal-body">
				<p>Confirme si desea Eliminar el articulo</p>
			</div>
			<div class="modal-footer">	
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary">Confirmar</button>
			</div>
		</div>
	</div>
	{{Form::Close()}}


	
	
</div>
