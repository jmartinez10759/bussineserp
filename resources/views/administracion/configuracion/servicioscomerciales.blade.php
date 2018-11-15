@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-app="ng-servicioscomerciales" ng-controller="servicioscomercialesController" ng-init="constructor()" ng-cloak>
    {!! $data_table !!}
    @include('administracion.configuracion.servicioscomerciales_edit')
    {!! $seccion_reportes !!}
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_servicioscomerciales.js')}}"></script>
@endpush