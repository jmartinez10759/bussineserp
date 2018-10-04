@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue_empresas">
	{!! $data_table !!}
	<br><br>
	<!--Se crea la vista del modal que se va autilizar para cargar los datos para ingresar o para editar-->
	@include('administracion.configuracion.empresas_edit')
</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_empresas.js')}}" ></script>
@endpush
