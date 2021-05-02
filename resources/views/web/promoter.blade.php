@extends('layouts.web')

@section('title', 'Registro de Usuario')

@section('links')
<link href="{{ asset('/web/css/template/home.css') }}" rel="stylesheet">
<link href="{{ asset('/web/css/template/order-sign_up.css') }}" rel="stylesheet">
<link href="{{ asset('/web/css/template/detail-page.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/admins/vendor/dropify/dropify.min.css') }}">
<link rel="stylesheet" href="{{ asset('/admins/vendor/lobibox/Lobibox.min.css') }}">
@endsection

@section('content')

<div class="container margin_60_20">
	<form action="{{ route('web.promoter.store', ['slug' => $user->slug]) }}" method="POST" class="row" id="formPromoter" enctype="multipart/form-data">
		@csrf
		<div class="col-12">
			<h3 class="text-center">Registrate con el {{ $user->roles[0]->name }}: {{ $user->name." ".$user->lastname }}</h3>
			<div class="box_order_form">
				<div class="head">
					<div class="title">
						<h3>Datos Personales</h3>
					</div>
				</div>
				<div class="main">
					<div class="row">
						<div class="col-12">
							@include('admin.partials.errors')
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label class="col-form-label">Foto</label>
							<input type="file" name="photo" accept="image/*" class="dropify" data-height="105" data-max-file-size="20M" data-allowed-file-extensions="jpg png jpeg web3" />
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<div class="row">
								<div class="form-group col-12">
									<label>Nombre</label>
									<input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required placeholder="Introduzca su nombre" value="{{ old('name') }}">
								</div>

								<div class="form-group col-12">
									<label>Apellido</label>
									<input type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" required placeholder="Introduzca su apellido" value="{{ old('lastname') }}">
								</div>
							</div> 
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label>Teléfono</label>
							<input type="text" class="form-control int @error('phone') is-invalid @enderror" name="phone" required placeholder="Introduzca un teléfono" value="{{ old('phone') }}">
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label>Código Postal / Colonia / Sección</label>
							<input class="form-control" type="text" disabled value="@if(!is_null($user['colony']) && !is_null($user['colony']['zip'])){{ $user['colony']['zip']->name }}@else{{ "Desconocido" }}@endif / @if($user['colony']){{ $user['colony']->name }}@else{{ "Desconocido" }}@endif / @if(!is_null($user['section'])){{ $user['section']->name }}@else{{ "Desconocido" }}@endif">
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label class="col-form-label">Tipo</label>
							<input class="form-control" type="text" disabled value="@if($user->roles[0]->name=="Coordinador de Ruta"){{ 'Seccional' }}@elseif($user->roles[0]->name=="Seccional"){{ 'Líder' }}@else{{ 'Promovido' }}@endif" id="disabledType">
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label class="col-form-label">Correo Electrónico @if($user->roles[0]->name=="Líder"){{ "(Opcional)" }}@endif</label>
							<input class="form-control @error('email') is-invalid @enderror" type="email" name="email" @if($user->roles[0]->name!="Líder") required @endif placeholder="Introduzca un correo electrónico" value="{{ old('email') }}">
						</div>

						@if($user->roles[0]->name!="Líder")
						<div class="form-group col-lg-6 col-md-6 col-12">
							<label class="col-form-label">Contraseña</label>
							<input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required placeholder="********" id="password">
						</div>

						<div class="form-group col-lg-6 col-md-6 col-12">
							<label class="col-form-label">Confirmar Contraseña</label>
							<input class="form-control" type="password" name="password_confirmation" required placeholder="********">
						</div>
						@endif

						<div class="form-group col-12">
							<button type="submit" class="btn_1 gradient full-width mb_5" action="promoter">Registrarse</button>
						</div>
					</div>	
				</div>
			</div>
		</div>

	</form>
</div>

<div id="toTop"></div>

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/dropify/dropify.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/jquery.validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/additional-methods.js') }}"></script>
<script src="{{ asset('/admins/vendor/validate/messages_es.js') }}"></script>
<script src="{{ asset('/admins/js/validate.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection