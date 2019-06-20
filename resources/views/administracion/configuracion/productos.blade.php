@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-controller="ProductosController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
    <div class="table-responsive table-container">
	    <table class="table table-striped table-responsive highlight table-hover" id="datatable">
	        <thead>
	            <tr style="background-color: #337ab7; color: #ffffff;">
	                <th>Categoria</th>
	                <th>Codigo Producto</th>
	                <th>Unidad de Medida</th>
	                <th>Producto</th>
	                <th>Stock</th>
	                <th>SubTotal</th>
	                <th>Total</th>
	                <th>Estatus</th>
	                <th class="text-right"></th>
	            </tr>
	        </thead>
	        <tbody>
	            <tr ng-repeat="data in datos | filter: searching" id="tr_@{{data.id}}">
	                <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="(data.categories)? data.categories.nombre : '' "></td>
	                <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="data.codigo"></td>
	                <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="(data.units)? data.units.clave+' - '+data.units.descripcion : ''"></td>
	                <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="data.nombre"></td>
	                <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="data.stock "></td>
	                <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="'$ '+data.subtotal.toLocaleString()"></td>
	                <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="'$ '+data.total.toLocaleString()"></td>
	                <td style="cursor:pointer;" ng-click="editRegister(data)">
	                	<span class="label label-success" ng-if="data.estatus == 1">Activo</span>
	                	<span class="label label-danger" ng-if="data.estatus == 0">Inactivo</span>
	                </td>
	                <td class="text-right">
						<button type="button" class="btn btn-danger btn-sm" ng-click="destroyRegister(data.id)" title="Eliminar Registro" ng-if="permisos.DEL">
							<i class="glyphicon glyphicon-trash"></i>
						</button>
	                </td>
				</tr>
	        </tbody>
	    </table>
	</div>
    @include('administracion.configuracion.productEdit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/buildProductsController.js')}}"></script>
<script type="text/javascript" src="{{asset('js/administracion/configuracion/directives/image-load.js')}}"></script>
@endpush