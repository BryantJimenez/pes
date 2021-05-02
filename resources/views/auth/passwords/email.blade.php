@extends('layouts.auth')

@section('title', 'Recuperar Contraseña')

@section('content')

<div id="register">
  <aside>
    <figure>
        <img src="{{ asset('/admins/img/logo.png') }}" width="120" height="100" title="Logo" alt="Logo">
    </figure>
    {{-- <h1 class="text-center font-weight-bold">LOGO</h1> --}}
    <form action="{{ route('password.email') }}" method="POST" id="formRecovery">
      {{ csrf_field() }}

      @include('admin.partials.errors')

      <div class="form-group">
        <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required placeholder="Email"  autocomplete="email" autofocus value="{{ old('email') }}">
        <i class="icon_mail_alt"></i>
      </div>
      <div id="pass-info" class="clearfix"></div>
      <button type="submit" class="btn_1 gradient full-width" action="recovery">Enviar</button>
      <div class="text-center mt-2"><small>Ya tiene una cuenta? <strong><a href="{{ route('login') }}">Ingresa</a></strong></small></div>
    </form>
    <div class="copy">© PES {{ date('Y') }} - Todos los derechos reservados</div>
  </aside>
</div>

@endsection