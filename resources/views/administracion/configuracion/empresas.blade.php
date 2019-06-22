@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-controller="CompaniesController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
	<table-dashboard></table-dashboard>
	@include('administracion.configuracion.empresasEdit')
</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/buildCompaniesController.js')}}" ></script>
@endpush
