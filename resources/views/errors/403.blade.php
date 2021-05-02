@extends('layouts.error')

@section('title', 'Error 403')

@section('content')

<main class="bg_gray">
		<div id="error_page">
			<div class="container">
				<div class="row justify-content-center text-center">
					<div class="col-xl-7 col-lg-9">
						<figure><img src="{{ asset('/web/img/403.svg') }}" alt="" class="img-fluid" width="550" height="234"></figure>
						<p>Error de prohibición! No tienes permiso para acceder a este sitio!. Ir al <strong><a href="{{ route('home') }}">Inicio</a></strong> o ...</p>
						<form method="post" action="#">
                                <div class="row no-gutters custom-search-input">
                                    <div class="col-lg-10">
                                        <div class="form-group">
                                            <input class="form-control no_border_r" type="text" placeholder="¿Qué estás buscando?">
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <button class="btn_1 gradient" type="submit">Buscar</button>  
                                    </div>
                                </div>
                                <!-- /row -->
                            </form>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- /container -->
		</div>
		<!-- /error -->		
	</main>
	<!-- /main -->

@endsection