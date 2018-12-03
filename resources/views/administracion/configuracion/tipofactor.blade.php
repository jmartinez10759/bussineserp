@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush

<div ng-app="application" ng-controller="TipoFactorController" ng-init="constructor()" ng-cloak >   
            
            <div class="table-responsive">
                <table class="table table-striped table-responsive highlight table-hover fixed_header" id="datatable">
                    <thead>
                        <tr style="background-color: #337ab7; color: #ffffff;">
                            <th>#</th>
                        <th>Clave</th>
                        <th>Descripcion</th>
                        <th>Fecha Inicio Vigencia</th>
                        <th>Fecha Fin Vigencia</th>
                        
                        <th class="text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr ng-repeat="data in datos.tipofactor" id="tr_@{{data.id}}">
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.id}}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.clave }}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.descripcion }}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.fecha_inicio_vigencia}}</td>
                            <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.fecha_final_vigencia}}</td>
                            
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
    @include('administracion.configuracion.tipofactor_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_tipofactor.js')}}"></script>
@endpush