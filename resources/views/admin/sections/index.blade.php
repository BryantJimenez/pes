@extends('layouts.admin')

@section('title', 'Lista de Secciones')

@section('links')
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/custom_dt_html5.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('/admins/vendor/table/datatable/dt-global_style.css') }}">
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
						<h4>Lista de Secciones</h4>
					</div>                 
				</div>
			</div>
			<div class="widget-content widget-content-area shadow-none">

				<div class="row">
					<div class="col-12">
						@can('sections.create')
						<div class="text-right">
							<a href="{{ route('secciones.create') }}" class="btn btn-primary">Agregar</a>
						</div>
						@endcan

						<div class="table-responsive mb-4 mt-4">
							<table class="table table-hover table-export">
								<thead>
									<tr>
										<th>#</th>
										<th>Nombre</th>
										<th>Colonias</th>
										<th>Códigos Postales</th>
										<th>Estado</th>
										@if(auth()->user()->can('sections.edit') || auth()->user()->can('sections.active') || auth()->user()->can('sections.deactive') || auth()->user()->can('sections.delete'))
										<th>Acciones</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@foreach($sections as $section)
									<tr>
										<td>{{ $loop->iteration }}</td>
										<td>{{ $section->name }}</td>
										<td>
											@if($section['colonies']->count()>0)
											@foreach($section['colonies'] as $colony)
											{{ $colony->name }}@if(!$loop->last)<br>@endif
											@endforeach
											@else
											{{ 'No Ingresado' }}
											@endif
										</td>
										<td>
											@if($section['colonies']->count()>0)
											@foreach($section['colonies']->pluck('zip')->unique('id')->values() as $zip)
											{{ $zip->name }}@if(!$loop->last)<br>@endif
											@endforeach
											@else
											{{ 'No Ingresado' }}
											@endif
										</td>
										<td>{!! state($section->state) !!}</td>
										@if(auth()->user()->can('sections.edit') || auth()->user()->can('sections.active') || auth()->user()->can('sections.deactive') || auth()->user()->can('sections.delete'))
										<td>
											<div class="btn-group" role="group">
												@can('sections.edit')
												<a href="{{ route('secciones.edit', ['slug' => $section->slug]) }}" class="btn btn-info btn-sm bs-tooltip" title="Editar"><i class="fa fa-edit"></i></a>
												@endcan
												@if($section->state==1)
												@can('sections.deactive')
												<button type="button" class="btn btn-danger btn-sm bs-tooltip" title="Desactivar" onclick="deactiveSection('{{ $section->slug }}')"><i class="fa fa-power-off"></i></button>
												@endcan
												@else
												@can('sections.active')
												<button type="button" class="btn btn-success btn-sm bs-tooltip" title="Activar" onclick="activeSection('{{ $section->slug }}')"><i class="fa fa-check"></i></button>
												@endcan
												@endif
												@can('sections.delete')
												<button type="button" class="btn btn-danger btn-sm bs-tooltip" title="Eliminar" onclick="deleteSection('{{ $section->slug }}')"><i class="fa fa-trash"></i></button>
												@endcan
											</div>
										</td>
										@endif
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>                                        
				</div>

			</div>
		</div>
	</div>

</div>

@can('sections.delete')
<div class="modal fade" id="deleteSection" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres eliminar esta sección?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeleteSection">
					@csrf
					@method('DELETE')
					<button type="submit" class="btn btn-primary">Eliminar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@can('sections.deactive')
<div class="modal fade" id="deactiveSection" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres desactivar esta sección?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formDeactiveSection">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Desactivar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@can('sections.active')
<div class="modal fade" id="activeSection" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">¿Estás seguro de que quieres activar esta sección?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn" data-dismiss="modal">Cancelar</button>
				<form action="#" method="POST" id="formActiveSection">
					@csrf
					@method('PUT')
					<button type="submit" class="btn btn-primary">Activar</button>
				</form>
			</div>
		</div>
	</div>
</div>
@endcan

@endsection

@section('scripts')
<script src="{{ asset('/admins/vendor/table/datatable/datatables.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/jszip.min.js') }}"></script>    
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/table/datatable/button-ext/buttons.print.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admins/vendor/sweetalerts/custom-sweetalert.js') }}"></script>
<script src="{{ asset('/admins/vendor/lobibox/Lobibox.js') }}"></script>
@endsection