@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
    <div ng-controller="OrdersController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
        <div class="container">
            <div class="page-header">
                <h2> Seleccione una caja para iniciar venta </h2>
            </div>

            <div class="col-md-4" ng-repeat="boxes in datos | orderBy:id:true">
                <div class="thumbnail">
                    <a ng-click="BoxOpen(boxes)" style="cursor: pointer;">
                        <h4 ng-bind="boxes.name"></h4>
                        <div class="caption">
                            <p ng-bind="boxes.description"></p>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        @include('salesOfPoint.ordersEdit')
    </div>

@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('js/salesOfBoxes/buildOrdersController.js')}}" ></script>
    <script>
        $(document).ready(function() {
            $('#Carousel').carousel({
                interval: 5000
            })
        });
    </script>
@endpush

