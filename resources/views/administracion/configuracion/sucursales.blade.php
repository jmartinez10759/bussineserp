@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-controller="GroupsController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
    <table-dashboard></table-dashboard>
	@include('administracion.configuracion.groupEdit')
</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/buildGroupsController.js')}}" ></script>
@endpush
