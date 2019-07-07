@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
    <div ng-controller="SalesController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
        <table-dashboard></table-dashboard>
        @include('salesOfPoint.salesEdit')
    </div>
@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('js/salesOfBoxes/buildSalesController.js')}}" ></script>
@endpush
