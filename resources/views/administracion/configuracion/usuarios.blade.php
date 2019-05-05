@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-controller="UsuarioController" ng-init="constructor()" ng-cloak >
  {{--{!! $data_table !!}--}}
  <div class="table-responsive">
    <table class="table table-striped table-responsive highlight table-hover fixed_header" id="datatable">
      <thead>
      <tr style="background-color: #337ab7; color: #ffffff;">
        <th>ID</th>
        <th>Nombre Completo</th>
        <th>Correo</th>
        <th>UserName</th>
        <th>Rol</th>
        <th>Conexion</th>
        <th>Tiempo Conexion</th>
        <th>Fecha Conexion</th>
        <th>Hace Cuanto</th>
        <th>Estatus</th>
        <th class="text-right"></th>
      </tr>
      </thead>
      <tbody>
      <tr ng-repeat="data in datos" id="tr_@{{data.id}}">
        <td style="cursor: pointer;" ng-click="edit_register(data)" ng-bind="data.id" ></td>
        <td style="cursor: pointer;" ng-click="edit_register(data)" ng-bind="data.perfil" ></td>
        <td style="cursor: pointer;" ng-click="edit_register(data)" ng-bind="data.clave_corta" ></td>
        <td>
          <span class="label label-success" ng-if="data.estatus == 1">Activo</span>
          <span class="label label-danger" ng-if="data.estatus == 0">Inactivo</span>
        </td>
        <td class="text-right">
          <button type="button" class="btn btn-danger btn-sm" ng-click="destroy_register(data.id)" title="Eliminar Registro" ng-if="permisos.DEL">
            <i class="glyphicon glyphicon-trash"></i>
          </button>
        </td>
      </tr>

      </tbody>
    </table>
  </div>

  @include('administracion.configuracion.usuarios_edit')
  {!! $seccion_reportes !!}
</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_usuarios.js')}}" ></script>
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/build_asigna_permisos.js')}}" ></script>
@endpush
