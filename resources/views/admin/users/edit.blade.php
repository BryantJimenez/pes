@extends('layouts.admin')

@section('title', 'Editar Usuario')

@section('links')
<link rel="stylesheet" href="{{ asset('/admins/vendor/dropify/dropify.min.css') }}">
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/vendor/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('/admins/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="row layout-top-spacing">

	<div class="col-12 layout-spacing">
		<div class="statbox widget box box-shadow">
			<div class="widget-header">
				<div class="row">
					<div class="col-xl-12 col-md-12 col-sm-12 col-12">
						<h4>Editar Usuario</h4>
					</div>                 
				</div>
			</div>
			<div class="widget-content widget-content-area">

				<div class="row">
					<div class="col-12">

						@include('admin.partials.errors')

						<p>Campos obligatorios (<b class="text-danger">*</b>)</p>
						<form action="{{ route('usuarios.update', ['slug' => $user->slug]) }}" method="POST" class="form" id="formUserEdit" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<div class="row">
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Foto (Opcional)</label>
									<input type="file" name="photo" accept="image/*" class="dropify" data-height="125" data-max-file-size="20M" data-allowed-file-extensions="jpg png jpeg web3" data-default-file="{{ image_exist('/admins/img/users/', $user->photo, true) }}" />
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<div class="row">
										<div class="form-group col-lg-12 col-md-12 col-12">
											<label class="col-form-label">Nombre<b class="text-danger">*</b></label>
											<input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required placeholder="Introduzca un nombre" value="{{ $user->name }}">
										</div>

										<div class="form-group col-lg-12 col-md-12 col-12">
											<label class="col-form-label">Apellido<b class="text-danger">*</b></label>
											<input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" required placeholder="Introduzca un apellido" value="{{ $user->lastname }}">
										</div>
									</div> 
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Teléfono<b class="text-danger">*</b></label>
									<input class="form-control @error('phone') is-invalid @enderror" type="text" name="phone" required placeholder="Introduzca un teléfono" value="{{ $user->phone }}" id="phone">
								</div>

								@if(Auth::user()->hasRole(['Super Admin']))
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Colonia<b class="text-danger">*</b></label>
									<select class="form-control @error('colony_id') is-invalid @enderror" name="colony_id" required id="selectColonies">
										<option value="">Seleccione</option>
										@foreach($colonies as $colony)
										<option value="{{ $colony->slug }}" @if($user->colony_id==$colony->id) selected @endif>{{ $colony->name }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Sección<b class="text-danger">*</b></label>
									<select class="form-control @error('section_id') is-invalid @enderror" name="section_id" required id="selectSections">
										<option value="">Seleccione</option>
										@if(!is_null($user['colony']) && !is_null($user['section']))
										{!! selectSection($colonies, $user['section']->slug, $user['colony']->slug) !!}
										@endif
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Tipo<b class="text-danger">*</b></label>
									<select class="form-control @error('type') is-invalid @enderror" name="type" required id="selectTypeRol">
										@foreach($roles as $role)
										<option @if($user->hasRole([$role])) selected @endif>{{ $role }}</option>
										@endforeach
									</select>
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12 @if($user->roles[0]->name!="Promovido" && $user->roles[0]->name!="Líder" && $user->roles[0]->name!="Seccional") d-none @endif" id="divPromoter">
									<label class="col-form-label">Promotor<b class="text-danger">*</b></label>
									<select class="form-control @error('promoter') is-invalid @enderror" name="promoter" @if($user->roles[0]->name!="Promovido" && $user->roles[0]->name!="Líder" && $user->roles[0]->name!="Seccional") disabled @else required @endif id="selectPromoters">
										<option value="">Seleccione</option>
										@if($user->roles[0]->name=="Promovido" || $user->roles[0]->name=="Líder" || $user->roles[0]->name=="Seccional")
										{!! selectPromoter($user->user->leader->slug, $user->roles[0]->name) !!}
										@endif
									</select>
								</div>
								@else
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Código Postal / Colonia / Sección</label>
									<input class="form-control" type="text" disabled value="@if(!is_null($user['colony']) && !is_null($user['colony']['zip'])){{ $user['colony']['zip']->name }}@else{{ "Desconocido" }}@endif / @if($user['colony']){{ $user['colony']->name }}@else{{ "Desconocido" }}@endif / @if(!is_null($user['section'])){{ $user['section']->name }}@else{{ "Desconocido" }}@endif">
								</div>

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Tipo</label>
									<input class="form-control" type="text" disabled value="{{ $user->roles[0]->name }}">
								</div>
								@endif

								@if(empty($user->email))
								<div class="form-group col-lg-6 col-md-6 col-12" id="divEmail">
									<label class="col-form-label">Correo Electrónico @if($user->roles[0]->name!="Promovido")<b class="text-danger">*</b>@else{{ "(Opcional)" }}@endif</label>
									<input class="form-control @error('email') is-invalid @enderror" type="email" name="email" @if($user->roles[0]->name!="Promovido") required @endif placeholder="Introduzca un correo electrónico" value="{{ $user->email }}">
								</div>
								@else
								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Correo Electrónico</label>
									<input class="form-control" type="text" disabled value="{{ $user->email }}">
								</div>
								@endif

								<div class="form-group col-lg-6 col-md-6 col-12">
									<label class="col-form-label">Estado<b class="text-danger">*</b></label>
									<select class="form-control @error('state') is-invalid @enderror" name="state" required>
										<option value="1" @if($user->state=="1") selected @endif>Activo</option>
										<option value="0" @if($user->state=="0") selected @endif>Inactivo</option>
									</select>
								</div>

								@if(Auth::user()->hasRole(['Super Admin']))
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
										<button type="submit" class="btn btn-primary" action="user">Actualizar</button>
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
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection