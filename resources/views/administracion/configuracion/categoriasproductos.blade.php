@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-app="ng-categoriasproductos" ng-controller="categoriasproductosController" ng-init="constructor()" ng-cloak>
    {!! $data_table !!}
    @include('administracion.configuracion.categoriasproductos_edit')
    {!! $seccion_reportes !!}
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_categoriasproductos.js')}}"></script>
@endpush