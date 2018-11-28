@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-app="ng-proyectos" ng-controller="proyectosController" ng-init="constructor()" ng-cloak>
    {!! $data_table !!}
    @include('development.proyectos_edit')
    {!! $seccion_reportes !!}
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/development/build_proyectos.js')}}"></script>
@endpush