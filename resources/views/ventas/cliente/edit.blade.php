@extends("layouts.admin")
@section("contenido")
	<div class="row">
		<div class="col-lg-6 dol-md-6 col-sm-6 col-xs-12">
			<h3>Editar Cliente:{{$personas->nombre}}</h3>
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
			{!! Form::model($personas,['method'=>'PATCH','action'=>['App\Http\Controllers\ClienteController@update',$personas->idpersonas]]) !!}
			{{Form::token()}}
	<div class="row">

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="nombre">Nombre</label>
				<input type="text" name="nombre" required value="{{$personas->nombre}}" class="form-control" placeholder="nombre...">
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="direccion">Direccion</label>
				<input type="text" name="direccion" required value="{{$personas->direccion}}" class="form-control" placeholder="direccion...">
			</div>
		</div>
		
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label>Documento</label>
				<select name="tipo_documento" class="form-control">
					@if ($personas->tipo_documento=='DNI')
						<option value="DNI" selected>DNI</option>
						<option value="RUC">RUC</option>
						<option value="PAS">PAS</option>
					@elseif ($personas->tipo_documento=='RUC')
						<option value="DNI">DNI</option>
						<option value="RUC" selected>RUC</option>
						<option value="PAS">PAS</option>
					@else
						<option value="DNI">DNI</option>
						<option value="RUC">RUC</option>
						<option value="PAS" selected>PAS</option>
					@endif
				</select>
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="num_documento">Numero Documento</label>
				<input type="text" name="num_documento" required value="{{$personas->num_documento}}" class="form-control" placeholder="Numero Documento...">
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="telefono">telefono</label>
				<input type="text" name="telefono" required value="{{$personas->telefono}}" class="form-control" placeholder="Telefono...">
			</div>
		</div>

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" name="email" required value="{{$personas->email}}" class="form-control" placeholder="Email...">
			</div>
		</div>

		
	</div>		
			
	<div class="form-group">
		<button class="btn btn-primary" type="submit">Guardar</button>		
		<button class="btn btn-danger" type="reset">Cancelar</button>		
	</div>	

	{!!Form::close()!!}

@endsection