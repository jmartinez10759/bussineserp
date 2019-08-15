@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-controller="UsuarioController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
  <div class="table-responsive" >
    <table class="table table-striped highlight table-hover table-container" id="datatable">
      <thead>
      <tr style="background-color: #337ab7; color: #ffffff;">
        <th>Nombre Completo</th>
        <th>UserName</th>
        <th>Rol</th>
        <th>Conexion</th>
        <th>Tiempo Conexion</th>
        <th>Fecha Conexion</th>
        <th>Estatus</th>
        <th class="text-right"></th>
      </tr>
      </thead>
      <tbody>
      <tr ng-repeat="data in datos | filter: searching | startFromGrid: currentPage * pageSize | limitTo: pageSize" id="tr_@{{data.id}}">
        <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.name+' '+ data.first_surname+' '+data.second_surname"></td>
        <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.username" title="@{{ data.email }}"></td>
        <td style="cursor: pointer;" ng-click="editRegister(data)">
            <span class="label label-info" ng-bind="data.roles[0].perfil"></span>
        </td>
        <td style="cursor: pointer;" ng-click="editRegister(data)">
            <span class="label label-primary" ng-if="data.binnacle.conect == 1">Conectado</span>
            <span class="label label-danger" ng-if="data.binnacle.conect  == 0">Desconectado</span>
        </td>
          <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.binnacle.time_conected" ></td>
          <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.binnacle.created_at" ></td>
        <td>
          <span class="label label-success" ng-if="data.estatus == 1">Activo</span>
          <span class="label label-danger" ng-if="data.estatus == 0">Inactivo</span>
        </td>
          <td class="text-left">
              <button type="button" class="btn btn-info btn-sm" ng-click="permissionMenuUsers(data.id)" title="Asignar Menus" ng-if="data.roles[0].id > 0 || permisos.PER">
                  <i class="glyphicon glyphicon-wrench"></i>
              </button>
              <button type="button" class="btn btn-danger btn-sm" ng-click="destroyRegister(data.id)" title="Eliminar Registro" ng-if="permisos.DEL">
                <i class="glyphicon glyphicon-trash"></i>
              </button>

          </td>
      </tr>

      </tbody>
    </table>
    <table-pagination></table-pagination>
  </div>

  @include('administracion.configuracion.usersEdit')

</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/buildUsersController.js')}}" ></script>
@endpush
