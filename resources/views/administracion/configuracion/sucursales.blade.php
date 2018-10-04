@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue_sucursales">
	{!! $data_table !!}
	<!--Se crea la vista del modal que se va autilizar para cargar los datos para ingresar o para editar-->
	@include('administracion.configuracion.sucursales_edit')

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_sucursales.js')}}" ></script>
@endpush
