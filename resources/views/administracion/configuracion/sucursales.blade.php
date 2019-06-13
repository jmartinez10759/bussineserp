@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-controller="GroupsController" ng-init="constructor()" ng-cloak >
            
    <div class="table-responsive table-container">

        <table class="table table-striped table-responsive highlight table-hover" id="datatable">
            <thead>
                <tr style="background-color: #337ab7; color: #ffffff;">
                    <th>#</th>
                    <th>Código</th>
                    <th>Sucursal</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th class="text-right">Estatus</th>
                    <th class="text-right"></th>
                </tr>
            </thead>
            <tbody>

                <tr ng-repeat="data in datos | filter: searching" id="tr_@{{data.id}}">
                    <td ng-click="editRegister(data)" style="cursor: pointer;" ng-bind="data.id"></td>
                    <td ng-click="editRegister(data)" style="cursor: pointer;" ng-bind="data.codigo"></td>
                    <td ng-click="editRegister(data)" style="cursor: pointer;" ng-bind="data.sucursal"></td>
                    <td ng-click="editRegister(data)" style="cursor: pointer;" ng-bind="data.direccion"></td>
                    <td ng-click="editRegister(data)" style="cursor: pointer;" ng-bind="data.telefono"></td>
                    <td>
                        <span class="label label-success" ng-if="data.estatus == 1">Activo</span>
                        <span class="label label-danger" ng-if="data.estatus == 0">Inactivo</span>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm" ng-click="destroyRegister(data.id)" title="Eliminar Registro" ng-if="permisos.DEL">
                            <i class="glyphicon glyphicon-trash"></i>
                        </button>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

	@include('administracion.configuracion.groupEdit')
</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/buildGroupsController.js')}}" ></script>
@endpush
