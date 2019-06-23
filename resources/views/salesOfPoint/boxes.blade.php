@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
    <div ng-controller="BoxesController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
        <table-dashboard></table-dashboard>
        @include('salesOfPoint.boxesEdit')
    </div>

@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('js/salesOfBoxes/buildBoxesController.js')}}" ></script>
@endpush
