@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
{{-- <div id="vue-codigopostal"> --}}
    {{-- {!! $data_table !!} --}}
    <div ng-app="application" ng-controller="CodigoPostal" ng-init="Controlador()" ng-cloak>

	<div class="table-responsive">
            <table class="table highlight table-hover fixed_header" id="datatable">
                <thead>
                    <tr style="background-color: #337ab7; color: #ffffff;">
                        <th>#</th>
                        <th>Codigo Postal</th>
                        <th>Estado</th>
                        <th>Municipio</th>
                        <th>Localidad</th>
                        <th class="text-left"></th>                        
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="data in datos">
                        <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.id}}</td>
                        <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.codigo_postal}}</td>
                        <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.estado}}</td>
                        <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.municipio}}</td>
                        <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.localidad}}</td>
                        <td>
                        	{{-- <button type="button" class="btn btn-primary" ng-click="edit_register(data.id)">
                        	 	<i class="fa fa-edit"> Editar </i>
                        	</button> --}}
                        	{{-- <button type="button" class="btn btn-danger" ng-click="destroy_register(data.id)">
                        		<i class="fa fa-trash"> Borrar</i>
                        	</button>
                        </td> --}}
                        <td class="text-right col-sm-1">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Acciones
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                    {{-- <li>
                                        <a title="Editar" style="cursor:pointer;" ng-click="insert_register(data.id)">
                                            <i class="glyphicon glyphicon-edit"></i> Editar
                                        </a>
                                    </li>
                                    <li {{$reportes}}>
                                        <a href="#" title="Imprimir cotización" ng-click="descargar();">
                                            <i class="glyphicon glyphicon-print"></i> Imprimir
                                        </a>
                                    </li>
                                    <li {{$email}}>
                                        <a title="Enviar Correo">
                                            <i class="glyphicon glyphicon-envelope"></i> Enviar Email
                                        </a>
                                    </li> --}}
                                    <li {{$eliminar}}>
                                        <a style="cursor:pointer;" title="Borrar" ng-click="destroy_register(data.id)" >
                                            <i class="glyphicon glyphicon-trash"></i> Eliminar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

    @include('administracion.configuracion.codigopostal_edit')
    {{-- {!! $seccion_reportes !!} --}}
    
</div>
{{-- </div> --}}
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_codigopostal.js')}}"></script>
@endpush