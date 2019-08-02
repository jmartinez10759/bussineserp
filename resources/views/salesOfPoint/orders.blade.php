@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
    <div ng-controller="OrdersController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
        <div class="container" ng-if="datos.length > 0">
            <div class="page-header">
                <h1>
                    <small>Seleccione una caja para iniciar ventas</small>
                </h1>
            </div>

            <div class="col-md-4" ng-repeat="boxes in datos | orderBy:id:true" ng-if="datos">
                <div class="thumbnail">
                    <a ng-click="boxOpen(boxes)" style="cursor: pointer;">
                        <h4 ng-bind="boxes.name"></h4>
                        <p><small >MONTO INICIAL: @{{ boxes.init_mount | currency : "$" : 2 }}</small></p>
                        <hr>
                        <div class="caption">
                            <small>
                                <p ng-bind="boxes.description"></p>
                            </small>
                        </div>
                    </a>
                </div>
            </div>

        </div>
        <div class="container" ng-if="datos.length < 1">
            <h2>
                <small>No cuenta con cajas asignadas, favor de contactar a un administrador</small>
            </h2>
        </div>
        @include('salesOfPoint.ordersEdit')
    </div>

@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('js/salesOfBoxes/buildOrdersController.js')}}" ></script>
@endpush

