@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
    <div ng-controller="BoxesController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
        <div class="table-responsive">
            <table class="table table-striped highlight table-hover" id="datatable">
                <thead>
                <tr style="background-color: #337ab7; color: #ffffff;">
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Monto Inicial</th>
                    <th>Caja</th>
                    <th>Estatus</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="data in datos | filter: searching" id="tr_@{{ data.id }}" >
                    <td style="cursor:pointer;" ng-click="editRegister(data.id)" ng-bind="data.name"></td>
                    <td class="col-sm-3" style="cursor:pointer;" ng-click="editRegister(data.id)" ng-bind="data.description"></td>
                    <td style="cursor:pointer;" ng-click="editRegister(data.id)" ng-bind="data.init_mount | currency:$:2"></td>
                    <td style="cursor:pointer;" ng-click="editRegister(data.id)">
                        <span class="label label-success" ng-if="data.is_active == 1">Abierta</span>
                        <span class="label label-danger" ng-if="data.is_active == 0">Cerrada</span>
                    </td>
                    <td class="col-sm-1" style="cursor:pointer;" ng-click="editRegister(data.id)">
                        <span class="label label-success" ng-if="data.status == 1"> Activo</span>
                        <span class="label label-danger" ng-if="data.status == 0">Inactivo</span>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-info btn-sm" title="Retiros Realizados" ng-click="editRegister(data.id,true)">
                            <i class="fa fa-eye"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" ng-click="destroyRegister(data.id)" title="Eliminar Registro" ng-if="permisos.DEL" >
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>

                    </td>
                </tr>
                </tbody>
            </table>

        </div>

        @include('salesOfPoint.boxesEdit')
    </div>

@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('js/salesOfBoxes/buildBoxesController.js')}}" ></script>
@endpush
