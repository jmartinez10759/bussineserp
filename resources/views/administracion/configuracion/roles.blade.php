@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-controller="RolesController" ng-init="constructor()" ng-cloak >

	<div class="table-responsive table-container">
	    <table class="table table-striped table-responsive highlight table-hover" id="datatable">
	        <thead>
	            <tr style="background-color: #337ab7; color: #ffffff;">
	                <th>ID</th>
	                <th>Perfil</th>
	                <th>Nombre Corto</th>
	                <th>Estatus</th>
	                <th class="text-right"></th>
	                <th class="text-right"></th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr ng-repeat="data in datos" id="tr_@{{data.id}}">
	                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.id" ></td>
	                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.perfil" ></td>
	                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.clave_corta" ></td>
	                <td>
		                <span class="label label-success" ng-if="data.estatus == 1">Activo</span>
	                	<span class="label label-danger" ng-if="data.estatus == 0">Inactivo</span>
					</td>
	                <td class="text-right">
	                    <button type="button" class="btn btn-danger btn-sm" ng-click="destroyRegister(data.id)" title="Eliminar Registro" ng-if="permisos.DEL">
                        <i class="glyphicon glyphicon-trash"></i>
                      </button>
	                </td>
					<td class="text-right"></td>
	            </tr>

	        </tbody>
	    </table>
	</div>
	@include('administracion.configuracion.roles_edit')
	<!-- <div class="modal fade" id="modal_add_register" role="dialog" aria-hidden="true"> -->
</div>
@stop
@push('scripts')
  <script type="text/javascript" src="{{ asset('js/administracion/configuracion/buildRolesController.js')}}" ></script>
@endpush
