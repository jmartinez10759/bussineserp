@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-app="ng-proveedores" ng-controller="ProveedoresController" ng-init="constructor()" ng-cloak>
    {!! $data_table !!}
    @include('administracion.configuracion.proveedores_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_proveedores.js')}}"></script>
@endpush