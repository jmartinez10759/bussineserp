@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-app="application" ng-controller="servicioscomercialesController" ng-init="constructor()" ng-cloak>
    {{-- {!! $data_table !!} --}}
    <div class="table-responsive">
            <table class="table table-striped table-responsive highlight table-hover fixed_header" id="datatable">
                <thead>
                    <tr style="background-color: #337ab7; color: #ffffff;">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th class="text-right">Acciones</th>                        
                    </tr>
                </thead>
                <tbody>
                	{{-- Se crea una accion repetitiva donde data es el array que fue declarado en la funcion all de ServiciosComercialesController  en  datos que fue declarado en buil_servicioscomerciales asignando los datos dentron del array data mediate 'servicioscomerciales' para mostrar todos los datos de la tabla --}}
                    <tr ng-repeat="data in datos.servicioscomerciales"  id="tr_@{{data.id}}">
                    	{{-- Permite darle clic al elemento recuperando los datos de los registros al selecionar uno de estos --}}
                     <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.id}}</td>
                     <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.nombre}}</td>
                     <td ng-click="edit_register(data.id)" style="cursor: pointer;">@{{data.descripcion}}</td>                       
                    <td class="text-right">
                        <div class="dropdown">
                        	{{-- Se hace un boton que funciona como una lista desplegable que permite mostrar el boton de eliminar --}}
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Acciones
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-left" aria-labelledby="dropdownMenu1">
                                    
                                    
                                    <li {{$eliminar}}>
                                    	{{-- Manda a llamar a la funcion destroy_register con el id del registro --}}
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

    @include('administracion.configuracion.servicioscomerciales_edit')
    {!! $seccion_reportes !!}
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/administracion/configuracion/build_servicioscomerciales.js')}}"></script>
@endpush