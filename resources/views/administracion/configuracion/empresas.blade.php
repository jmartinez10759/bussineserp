@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-app="ng-empresas" ng-controller="EmpresasController">
	{!! $data_table !!}
	@include('administracion.configuracion.empresas_edit')
</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_empresas.js')}}" ></script>
@endpush
