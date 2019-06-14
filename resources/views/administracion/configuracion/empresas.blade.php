@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-controller="CompaniesController" ng-init="constructor()" ng-cloak >
	<div class="table-responsive table-container">
	    <table class="table table-striped table-responsive highlight table-hover" id="datatable">
	        <thead>
	            <tr style="background-color: #337ab7; color: #ffffff;">
	                <th>Nombre Comercial</th>
	                <th>Razon Social</th>
	                <th>RFC</th>
	                <th>Servicio Comercial</th>
	                <th>Contacto</th>
	                <th>Telefono</th>
	                <th>Estatus</th>
	                <th class="text-right"></th>
	            </tr>
	        </thead>
	        <tbody>

	            <tr ng-repeat="data in datos | filter: searching" id="tr_@{{data.id}}">
	                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.nombre_comercial"></td>
	                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.razon_social"></td>
	                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.rfc_emisor"></td>
	                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="data.comerciales"></td>
	                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="(data.contactos.length > 0)? data.contactos[0].correo: ''"></td>
	                <td style="cursor: pointer;" ng-click="editRegister(data)" ng-bind="(data.contactos.length > 0)? data.contactos[0].telefono: ''"></td>
	                <td>
		                <span class="label label-success" ng-if="data.estatus == 1">Activo</span>
	                	<span class="label label-danger" ng-if="data.estatus == 0">Inactivo</span>
	            	</td>
	                <td class="text-center">
						<button type="button" class="btn btn-danger btn-sm" ng-click="destroyRegister(data.id)" title="Eliminar Registro" ng-if="permisos.DEL">
							<i class="glyphicon glyphicon-trash"></i>
	                </td>
				</tr>

	        </tbody>
	    </table>
	</div>
	@include('administracion.configuracion.empresasEdit')
</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administracion/configuracion/buildCompaniesController.js')}}" ></script>
@endpush
