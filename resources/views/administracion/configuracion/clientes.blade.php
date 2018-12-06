@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-app="application" ng-controller="ClientesController" ng-init="constructor()" ng-cloak >

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#prospectos" id="prospectos_tabs" aria-expanded="false">Prospectos Registrados</a></li>
        <li><a data-toggle="tab" href="#clientes" id="clientes_tabs" aria-expanded="false">Clientes Registrados</a></li>
    </ul>

    <div class="tab-content">
       
        <div id="prospectos" class="tab-pane fade in active">
        <br>
            <div class="table-responsive">

                <table class="table table-striped table-responsive highlight table-hover fixed_header" id="datatable">
                    <thead>
                        <tr style="background-color: #337ab7; color: #ffffff;">
                            <th>Nombre Comercial</th>
                            <th>Razon Social</th>
                            <th>RFC</th>
                            <th>Direccion</th>
                            <th>Contacto</th>
                            <th>Telefono</th>
                            <th class="text-right">Estatus</th>
                            <th class="text-right"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr ng-repeat="data in datos.prospectos" id="tr_@{{data.id}}">
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.nombre_comercial}}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.razon_social }}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.rfc_receptor }}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">
                                @{{data.calle}} @{{data.colonia}} @{{data.municipio}}
                            </td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">
                                @{{ (data.contactos.length > 0)? data.contactos[0].correo: ""}}
                            </td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">
                                @{{ (data.contactos.length > 0)? data.contactos[0].telefono: ""}}
                            </td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">
                                @{{ (data.estatus == 1)? "Clientes":"Prospectos" }}
                            </td>
                            <td class="text-right">
                                <div class="col-sm-4">
                                    <button type="button" class="btn btn-primary btn-sm" title="Visualizar Comentarios" ng-click="see_activities(data.id)">
                                        <i class="glyphicon glyphicon-list-alt"></i>
                                    </button>
                                </div>
                                <div class="col-sm-4"></div>
                                <div class="col-sm-4"></div>

                                <button type="button" class="btn btn-info btn-sm" ng-click="update_estatus(data.id)" title="Convertir a Cliente">
                                    <i class="glyphicon glyphicon-sort"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" ng-click="destroy_register(data.id)" title="Eliminar Registro">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </button>
                            </td>
                            
                        </tr>

                    </tbody>
                </table>

            </div>



        </div>
        <div id="clientes" class="tab-pane fade">
           <br>
            <div class="table-responsive">

                <table class="table table-striped table-responsive highlight table-hover fixed_header" id="datatable_clientes">
                    <thead>
                        <tr style="background-color: #337ab7; color: #ffffff;">
                            <th>#</th>
                            <th>Nombre Comercial</th>
                            <th>Razon Social</th>
                            <th>RFC</th>
                            <th>Uso CFDI</th>
                            <th>Dirección</th>
                            <th>Contacto</th>
                            <th>Telefono</th>
                            <th>Empresas</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="data in datos.clientes" id="tr_@{{data.id}}">
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.id}}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.nombre_comercial}}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.razon_social }}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.rfc_receptor }}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">
                                @{{data.uso_cfdi.clave }} @{{data.uso_cfdi.descripcion }}
                            </td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">
                                @{{data.calle}} @{{data.colonia}} @{{data.municipio}}
                            </td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">
                                @{{ (data.contactos.length > 0)? data.contactos[0].correo: ""}}
                            </td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">
                                @{{ (data.contactos.length > 0)? data.contactos[0].telefono: ""}}
                            </td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">
                                @{{ (data.empresas.length > 0)? data.empresas[0].razon_social: ""}}
                            </td>

                            <td class="text-right">
                                <div class="col-sm-6">

                                    <button type="button" class="btn btn-primary btn-sm" title="Visualizar Comentarios" ng-click="see_activities(data.id)">
                                        <i class="glyphicon glyphicon-list-alt"></i>
                                    </button>

                                </div>
                                <div class="col-sm-6">
                                    
                                    <button type="button" class="btn btn-danger btn-sm" ng-click="destroy_register(data.id)" title="Eliminar Registro">
                                        <i class="glyphicon glyphicon-trash"></i>
                                    </button>
                                    
                                </div>
                            </td>
                            <td>
                                <div class="col-sm-12" {{$permisos}}>

                                    <select class="form-control" 
                                        chosen
                                        width="'100%'"
                                        ng-model="data.empresas[0].id" 
                                        ng-options="value.id as value.nombre_comercial for (key, value) in datos.empresas" ng-change="display_sucursales(data.id )" 
                                        id="cmb_empresas_@{{data.id}}">
                                    </select>

                                </div>
                            </td>
                            </tr>

                    </tbody>
                </table>
            </div>
        </div>
       
    </div>

    @include('administracion.configuracion.clientes_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_clientes.js')}}"></script>
@endpush