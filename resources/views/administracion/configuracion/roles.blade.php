@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush

<div id="vue_roles">

	{!! $data_table !!}
	<!--Se crea la vista del modal que se va autilizar para cargar los datos para ingresar o para editar-->
	@include('administracion.configuracion.roles_edit')
	<!-- <div class="modal fade" id="modal_add_register" role="dialog" aria-hidden="true"> -->
</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_roles.js')}}" ></script>
@endpush
