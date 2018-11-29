@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-app="ng-proyectos" ng-controller="proyectosController" ng-init="constructor()" ng-cloak>
    {!! $data_table !!}
    <div class="panel-body">
        <form class="form-horizontal">

            <div class="form-group row">
                <div class="col-sm-2">
                    <select class="form-control input-sm"
                    width="'50%'"
                    chosen
                    ng-model="anio" 
                    ng-change="filtros_anio()"
                    ng-options="value.id as value.descripcion for (key, value) in cmb_anios" >
                        <!-- <option value="">--Seleccione Opcion--</option> -->
                    </select>

                </div>

                <div class="col-sm-6">
                    
                    <ul class="pagination pagination-sm">
                        <li ng-repeat="filtros in filtro" class="@{{filtros.class}}" >                    
                            <a style="cursor: pointer" ng-click="filtros_mes(filtros)"> 
                                @{{filtros.nombre}}
                            </a>
                        </li>
                    </ul>

                </div>
                <div class="col-sm-2">
                    <select class="form-control input-sm"
                    width="'100%'"
                    chosen
                    ng-model="usuarios" 
                    ng-change="filtros_usuarios()"
                    ng-options="value.id as value.name +' '+value.first_surname for (key, value) in datos.usuarios" {{ $permisos }}>
                        <option value="">--Seleccione Opcion--</option>
                    </select>

                </div>

            </div>

        </form>

        <div class="table-responsive">
            <table class="table table-striped table-responsive highlight table-hover fixed_header" id="datatable">
                <thead>
                    <tr style="background-color: #337ab7; color: #ffffff;">
                        <th>#</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha Cierre</th>
                        <th>Responsable</th>
                        <th>Estatus</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <tr ng-repeat="data in datos" id="tr_@{{ data.id }}" >
                        <td style="cursor:pointer;" ng-click="edit_register(data)" >@{{ data.id_proyecto }}</td>
                        <td style="cursor:pointer;" ng-click="edit_register(data)" >@{{ data.titulo }}</td>
                        <td style="cursor:pointer;" ng-click="edit_register(data)" >@{{ data.descripcion }}
                            </td>
                        <td style="cursor:pointer;" ng-click="edit_register(data)" >
                            @{{ data.fecha_cierre }}
                        </td>
                        <td class="text-right" style="cursor:pointer;" ng-click="edit_register(data)">
                            David Reyes Valeriano 
                        </td>
                        <td style="cursor:pointer;" ng-click="edit_register(data)" >
                            <span class="label label-warning" ng-if="data.id_estatus == 1">Pendiente</span>
                            <span class="label label-danger" ng-if="data.id_estatus == 4"></span>
                            <span class="label label-success" ng-if="data.id_estatus == 5"></span>
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
                                    <li {{$reportes}}>
                                        <a href="#" title="Imprimir cotización" ng-click="descargar();">
                                            <i class="glyphicon glyphicon-print"></i> Reporte
                                        </a>
                                    </li>
                                    <li {{$email}}>
                                        <a title="Enviar Correo">
                                            <i class="glyphicon glyphicon-envelope"></i> Enviar Email
                                        </a>
                                    </li>
                                    <li {{$eliminar}} ng-if="data.id_estatus != 5">
                                        <a style="cursor:pointer;" title="Borrar" ng-click="destroy_register(data.id)" >
                                            <i class="glyphicon glyphicon-trash"></i> Eliminar
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td> 
                            TOTAL PROYECTOS: @{{ datos.length }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    @include('development.proyectos_edit')
    {!! $seccion_reportes !!}
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/development/build_proyectos.js')}}"></script>
@endpush