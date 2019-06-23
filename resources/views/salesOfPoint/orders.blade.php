@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
    <div ng-controller="OrdersController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
        <table-dashboard></table-dashboard>
        @include('salesOfPoint.ordersEdit')
    </div>

@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('js/salesOfBoxes/buildOrdersController.js')}}" ></script>
@endpush

