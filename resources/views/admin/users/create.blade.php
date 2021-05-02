@extends('layouts.admin')

@section('title', 'Crear Usuario')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/dropify/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">

	<div class="col-12 layout-spacing">
		<div class="statbox widget box box-shadow">
			<div class="widget-header">
				<div class="row">
					<div class="col-xl-12 col-md-12 col-sm-12 col-12">
						<h4>Crear Usuario</h4>
					</div>                 
				</div>
			</div>
			<div class="widget-content widget-content-area">

				<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('usuarios.store') }}" method="POST" class="form" id="formUser" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Foto (Opcional)</label>
									<input type="file" name="photo" accept="image/*" class="dropify" data-height="125" data-max-file-size="20M" data-allowed-file-extensions="jpg png jpeg web3" />
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<div class="row">
										<div class="form-group col-lg-12 col-md-12 col-12">
											<label class="col-form-label">Nombre<b class="text-danger">*</b></label>
											<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required placeholder="Introduzca un nombre" value="{{ old('name') }}">
										</div>

										<div class="form-group col-lg-12 col-md-12 col-12">
											<label class="col-form-label">Apellido<b class="text-danger">*</b></label>
											<input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" required placeholder="Introduzca un apellido" value="{{ old('lastname') }}">
										</div>
									</div> 
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Teléfono<b class="text-danger">*</b></label>
									<input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" required placeholder="Introduzca un teléfono" value="{{ old('phone') }}" minlength="5" maxlength="15" id="phone">
								</div>

								@if(!Auth::user()->hasRole(['Coordinador de Ruta', 'Seccional', 'Líder']) && is_null(Auth::user()->section))
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Colonia<b class="text-danger">*</b></label>
									<select class="form-control @error('colony_id') is-invalid @enderror" name="colony_id" required id="selectColonies">
										<option value="">Seleccione</option>
										@foreach($colonies as $colony)
										<option value="{{ $colony->slug }}" @if(old('colony_id')==$colony->slug) selected @endif>{{ $colony->name }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Sección<b class="text-danger">*</b></label>
									<select class="form-control @error('section_id') is-invalid @enderror" name="section_id" required id="selectSections">
										<option value="">Seleccione</option>
										@if(!empty(old('colony_id')) && !empty(old('section_id')))
										{!! selectSection($colonies, old('section_id'), old('colony_id')) !!}
										@endif
									</select>
								</div>
								@else
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Código Postal / Colonia / Sección</label>
									<input class="form-control" type="text" disabled value="@if(!is_null(Auth::user()->section) && !is_null(Auth::user()->section->colony) && !is_null(Auth::user()->section->colony->zip)){{ Auth::user()->section->colony->zip->name }}@else{{ "Desconocido" }}@endif / @if(!is_null(Auth::user()->section) && !is_null(Auth::user()->section->colony)){{ Auth::user()->section->colony->name }}@else{{ "Desconocido" }}@endif / {{ Auth::user()->section->name }}">
								</div>
								@endif
								
								@if(!Auth::user()->hasRole('Líder'))
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Tipo<b class="text-danger">*</b></label>
									<select class="form-control @error('type') is-invalid @enderror" name="type" required id="selectTypeRol">
										@foreach($roles as $role)
										<option @if(old('type')==$role) selected @endif>{{ $role }}</option>
										@endforeach
									</select>
								</div>
								@else
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Tipo</label>
									<input class="form-control" type="text" disabled value="Promovido">
								</div>
								@endif

								<div class="form-group col-lg-6 col-md-6 col-12 @if(is_null(old('promoter')) && empty(old('promoter'))) d-none @endif" id="divPromoter">
									<label class="col-form-label">Promotor<b class="text-danger">*</b></label>
									<select class="form-control @error('promoter') is-invalid @enderror" name="promoter" required  @if(is_null(old('promoter')) && empty(old('promoter'))) disabled @endif id="selectPromoters">
										<option value="">Seleccione</option>
										@if (!is_null(old('promoter')) && !empty(old('promoter')))
										{!! selectPromoter(old('promoter'), old('type')) !!}
										@endif
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12" id="divEmail">
									<label class="col-form-label">Correo Electrónico @if(!Auth::user()->hasRole('Líder'))<b class="text-danger">*</b>@else{{ "(Opcional)" }}@endif</label>
									<input class="form-control @error('email') is-invalid @enderror" type="email" name="email" @if(!Auth::user()->hasRole('Líder')) required @endif placeholder="Introduzca un correo electrónico" value="{{ old('email') }}">
								</div>
								
								@if(!Auth::user()->hasRole('Líder'))
								<div class="form-group col-lg-6 col-md-6 col-12 @if(!is_null(old('promoter')) && !empty(old('promoter')) && old('type')=="Promovido") d-none @endif" id="divPassword">
									<label class="col-form-label">Contraseña<b class="text-danger">*</b></label>
									<input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required placeholder="********" id="password">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12 @if(!is_null(old('promoter')) && !empty(old('promoter')) && old('type')=="Promovido") d-none @endif" id="divPasswordConfirmation">
									<label class="col-form-label">Confirmar Contraseña<b class="text-danger">*</b></label>
									<input class="form-control" type="password" name="password_confirmation" required placeholder="********">
								</div>
								@endif

								<div class="form-group col-12">
									<div class="btn-group" role="group">
										<button type="submit" class="btn btn-primary" action="user">Guardar</button>
										<a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
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
<script src="{{ asset('/admins/vendor/dropify/dropify.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection