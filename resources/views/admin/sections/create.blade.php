@extends('layouts.admin')

@section('title', 'Crear Sección')

@section('links')
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/select2/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">

	<div class="col-12 layout-spacing">
		<div class="statbox widget box box-shadow">
			<div class="widget-header">
				<div class="row">
					<div class="col-xl-12 col-md-12 col-sm-12 col-12">
						<h4>Crear Sección</h4>
					</div>                 
				</div>
			</div>
			<div class="widget-content widget-content-area">

				<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('secciones.store') }}" method="POST" class="form" id="formSection">
							@csrf
							<div class="row">
								<div class="form-group col-12">
									<label class="col-form-label">Colonias<b class="text-danger">*</b></label>
									<select class="form-control select2 @error('colony_id') is-invalid @enderror" name="colony_id[]" required multiple>
										<option value="">Seleccione</option>
										@if(is_null(old('colony_id')))
										@foreach($colonies as $colony)
										<option value="{{ $colony->slug }}">{{ $colony->name }}</option>
										@endforeach
										@else
										{!! selectArray($colonies, old('colony_id')) !!}
										@endif
									</select>
								</div>

								<div class="form-group col-12">
									<label class="col-form-label">Nombre<b class="text-danger">*</b></label>
									<input class="form-control int @error('name') is-invalid @enderror" type="text" name="name" required placeholder="Introduzca un nombre" value="{{ old('name') }}" maxlength="4" minlength="4">
								</div>

								<div class="form-group col-12">
									<div class="btn-group" role="group">
										<button type="submit" class="btn btn-primary" action="section">Guardar</button>
										<a href="{{ route('secciones.index') }}" class="btn btn-secondary">Volver</a>
									</div>
								</div> 
							</div>
						</form>
					</div>                                        
				</div>

			</div>
		</div>
	</div>

</div>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/select2/select2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection