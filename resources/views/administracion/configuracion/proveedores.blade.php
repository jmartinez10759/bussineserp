@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-app="ng-proveedores" ng-controller="ProveedoresController" ng-init="constructor()" ng-cloak>
    {{-- {!! $data_table !!} --}}
    <div class="tab-content">
       
        <div id="proveedores" class="tab-pane fade in active">
        <br>
            <div class="table-responsive">
                <table class="table table-striped table-responsive highlight table-hover fixed_header" id="datatable">
                    <thead>
                        <tr style="background-color: #337ab7; color: #ffffff;">
                            <th>ID</th>
                            <th>Razon Social</th>
                            <th>RFC</th>
                            <th>Direccion</th>
                            <th>Contacto</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Estatus</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr ng-repeat="data in datos.proveedores" id="tr_@{{data.id}}">
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.id}}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.razon_social }}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.rfc }}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.calle}} @{{data.colonia}} @{{data.municipio}}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{ (data.contactos.length > 0)? data.contactos[0].nombre_completo: ""}}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{ (data.contactos.length > 0)? data.contactos[0].correo: ""}}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{ (data.contactos.length > 0)? data.contactos[0].telefono: ""}}</td>
                            <td>
                            <span class="label label-success" ng-if="data.estatus == 1">Activo</span>
                            <span class="label label-danger" ng-if="data.estatus == 0">Baja</span>
                            </td>
                            <td class="text-right">
                                <div class="dropdown">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Acciones
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                        <!-- <li>
                                            <a title="Editar" style="cursor:pointer;" ng-click="edit_register(data.id)">
                                                <i class="glyphicon glyphicon-edit"></i> Editar
                                            </a>
                                        </li> -->
                                        
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

    @include('administracion.configuracion.proveedores_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_proveedores.js')}}"></script>
@endpush