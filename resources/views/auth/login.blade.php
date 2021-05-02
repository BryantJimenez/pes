@extends('layouts.auth')

@section('title', 'Ingresar')

@section('content')

<div id="register">
  <aside>
    <figure>
        <img src="{{ asset('/admins/img/logo.png') }}" width="120" height="100" title="Logo" alt="Logo">
    </figure>
    {{-- <h1 class="text-center font-weight-bold">LOGO</h1> --}}
    <form action="{{ route('login') }}" method="POST" id="formLogin">
      {{ csrf_field() }}

      @include('admin.partials.errors')

      <div class="form-group">
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required placeholder="Email" value="{{ old('email') }}">
        <i class="icon_mail_alt"></i>
      </div>
      <div class="form-group">
        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" required placeholder="Contraseña" id="password">
        <i class="icon_lock_alt"></i>
      </div>
      <div id="pass-info" class="clearfix"></div>
      <button type="submit" class="btn_1 gradient full-width" action="login">Ingresar</button>
      <div class="text-center mt-2"><small>Olvidaste tu contraseña? <strong><a href="{{ route('password.request') }}">Recuperala</a></strong></small></div>
    </form>
    <div class="copy">© PES {{ date('Y') }} - Todos los derechos reservados</div>
  </aside>
</div>

@endsection