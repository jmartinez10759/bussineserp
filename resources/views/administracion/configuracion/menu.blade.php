
@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-controller="MenusController" ng-init="constructor()" ng-cloak >

    <div class="table-responsive table-container">
        <table class="table table-striped table-responsive highlight table-hover" id="datatable">
            <thead>
            <tr style="background-color: #337ab7; color: #ffffff;">
                <th class="text-center">ID</th>
                <th class="text-center">Menu</th>
                <th class="text-center">Url</th>
                <th class="text-center">Tipo Menu</th>
                <th class="text-center">Icono</th>
                <th class="text-center">Estatus</th>
                <th class="text-center"></th>
            </tr>
            </thead>
            <tbody>
            <tr ng-repeat="data in datos | filter: searching" id="tr_@{{data.id}}">
                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.id" ></td>
                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.texto" ></td>
                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.link" ></td>
                <td style="cursor: pointer;" class="text-center" ng-click="editRegister(data)" ng-bind="data.tipo" ></td>
                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.icon" ></td>
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
@include('administracion.configuracion.menuEdit')

</div>


@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/buildMenusController.js')}}" ></script>
@endpush
