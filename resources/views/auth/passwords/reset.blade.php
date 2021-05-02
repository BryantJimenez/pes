@extends('layouts.auth')

@section('title', 'Restaurar Contraseña')

@section('content')

<div id="register">
    <aside>
        <figure>
            <img src="{{ asset('/admins/img/logo.png') }}" width="120" height="100" title="Logo" alt="Logo">
        </figure>
        {{-- <h1 class="text-center font-weight-bold">LOGO</h1> --}}
        <form action="{{ route('password.update') }}" method="POST" id="formReset">
            {{ csrf_field() }}

            @include('admin.partials.errors')

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group">
                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required placeholder="Email" autocomplete="email" autofocus value="{{ old('email') }}">
                <i class="icon_mail_alt"></i>
            </div>
            <div class="form-group">
                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required placeholder="Nueva Contraseña" autocomplete="new-password" id="password">
                <i class="icon_lock_alt"></i>
            </div>
            <div class="form-group">
                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password_confirmation" required placeholder="Confirmar Contraseña" autocomplete="new-password" id="password-confirm">
                <i class="icon_lock_alt"></i>
            </div>
            <div id="pass-info" class="clearfix"></div>
            <button type="submit" class="btn_1 gradient full-width" action="reset">Enviar</button>
            <div class="text-center mt-2"><small>Ya tienes una cuenta? <strong><a href="{{ route('login') }}">Ingresa</a></strong></small></div>
        </form>
        <div class="copy">© PES {{ date('Y') }} - Todos los derechos reservados</div>
    </aside>
</div>

@endsection