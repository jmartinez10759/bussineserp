@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-app="ng-pais" ng-controller="PaisesController">
    {!! $data_table !!}
    @include('administracion.configuracion.pais_edit')
    @{{datos}}
    <select ng-model="insert.cmb_nombres">
    	<option ng-repeat="nombres in datos" value="@{{nombres.nombre}}">@{{nombres.nombre}}</option>
    </select>
</div>
@stop
@push('scripts')
 {!!$script!!}
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_pais.js')}}"></script>
@endpush