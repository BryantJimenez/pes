@extends('layouts.auth')

@section('title', 'Registro de Usuario')

@section('content')

<div id="register">
    <aside>
        <figure>
            <a href="index.html">
                <img src="{{ asset('/web/img/logo_sticky.svg') }}" width="140" height="35" title="Logo" alt="Logo">
            </a>
        </figure>
        <form action="{{ route('register') }}" method="POST" id="formRegister">
            {{ csrf_field() }}

            @include('admin.partials.errors')

            <div class="form-group">
                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" required placeholder="Nombre" value="{{ old('name') }}">
                <i class="icon_pencil-edit"></i>
            </div>
            <div class="form-group">
                <input class="form-control @error('lastname') is-invalid @enderror" type="text" name="lastname" required placeholder="Apellido"  value="{{ old('lastname') }}">
                <i class="icon_pencil-edit"></i>
            </div>
            <div class="form-group">
                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required placeholder="Email" value="{{ old('email') }}">
                <i class="icon_mail_alt"></i>
            </div>
            <div class="form-group">
                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required placeholder="Contraseña" id="password">
                <i class="icon_lock_alt"></i>
            </div>
            <div class="form-group">
                <input type="checkbox" name="terms" required id="terms-conditions">
                <label class="small" for="terms-conditions">Acepto <a href="javascript:void(0);">Términos y condiciones</a></label>
            </div>
            <div id="pass-info" class="clearfix"></div>
            <button type="submit" class="btn_1 gradient full-width" action="register">Registrarse</button>
            <div class="text-center mt-2"><small>Ya tienes una cuenta? <strong><a href="{{ route('login') }}">Ingresa</a></strong></small></div>
        </form>
        <div class="copy">© 2020 FooYes</div>
    </aside>
</div>

@endsection