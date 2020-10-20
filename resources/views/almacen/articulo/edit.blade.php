@extends("layouts.admin")
@section("contenido")
	<div class="row">
		<div class="col-lg-6 dol-md-6 col-sm-6 col-xs-12">
			<h3>Editar Aticulos:{{$articulos->nombre}}</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach($errors->all() as $error)	
					<li>{{$error}}</li>
				@endforeach	
				</ul>
			</div>
			@endif
		</div>
	</div>		
			{!! Form::model($articulos,['method'=>'POST','action'=>['App\Http\Controllers\ArticuloController@store',$articulos->idarticulos],'files'=>'true']) !!}
			{{Form::token()}}
	<div class="row">

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{$articulos->nombre}}" class="form-control">
			</div>
		</div>
		
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Categoria</label>
				<select name="idcategorias" class="form-control">
					@foreach ($categorias as $cat)
						@if ($cat->idcategorias==$articulos->idcategorias)
							<option value="{{$cat->idcategorias}}"selected>{{$cat->nombre}}</option>
						@else
							<option value="{{$cat->idcategorias}}">{{$cat->nombre}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="codigo">Codigo</label>
				<input type="text" name="codigo" required value="{{$articulos->codigo}}" class="form-control">
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="stock">Stock</label>
				<input type="text" name="stock" required value="{{$articulos->stock}}" class="form-control">
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="stock">Descripcion</label>
				<input type="text" name="descripcion" required value="{{$articulos->descripcion}}" class="form-control">
			</div>
		</div>
		
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="imagen">Imagen</label>
				<input type="file" name="imagen"  class="form-control">
				@if ($articulos->imagen)!="")
					<img src="{{asset('imagenes/articulos/'.$articulos->imagen)}}" height="300px" width="300px">
				@endif
			</div>
		</div>

		
	</div>		
			
	<div class="form-group">
		<button class="btn btn-primary" type="submit">Guardar</button>		
		<button class="btn btn-danger" type="reset">Cancelar</button>		
	</div>	

	{!!Form::close()!!}

@endsection