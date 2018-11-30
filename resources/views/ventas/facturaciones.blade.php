@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div ng-controller="FacturacionController" ng-init="constructor()" ng-cloak >

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
                        <th>#Factura</th>
                        <th>Fecha</th>
                        <th>Contacto</th>
                        <th>Cliente</th>
                        <th>Usuario</th>
                        <th>Estatus</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-right">Iva</th>
                        <th class="text-right">Total</th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th class="text-right"></th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="data in datos.response" id="tr_@{{ data.id }}" >
                        <td style="cursor:pointer;" ng-click="edit_register(data)" >@{{"A"+data.id}}</td>
                        <td style="cursor:pointer;" ng-click="edit_register(data)" >@{{ format_date(data.created_at,'yyyy-mm-dd') }}</td>
                        <td style="cursor:pointer;" ng-click="edit_register(data)" >
                            @{{(data.id_contacto != null)? data.contactos.nombre_completo:"" }}</td>
                        <td style="cursor:pointer;" ng-click="edit_register(data)" >
                            @{{(data.id_cliente != null)?data.clientes.nombre_comercial:"" }}
                        </td>
                        <td style="cursor:pointer;" ng-click="edit_register(data)">
                            @{{(data.usuarios != 0)? data.usuarios[0].name+" "+data.usuarios[0].first_surname: "" }}
                        </td>
                        <td style="cursor:pointer;" ng-click="edit_register(data)" >
                            <span class="label label-warning" ng-if="data.id_estatus == 6">
                                @{{(data.id_estatus != null )? data.estatus.nombre: ""}}
                            </span>
                            <span class="label label-danger" ng-if="data.id_estatus == 4">
                                @{{(data.id_estatus != null )? data.estatus.nombre: ""}}
                            </span>
                            <span class="label label-success" ng-if="data.id_estatus == 8">
                                @{{(data.id_estatus != null )? data.estatus.nombre: ""}}
                            </span>
                        </td>
                        <td class="text-right" style="cursor:pointer;" ng-click="edit_register(data)">
                            $ @{{(data.subtotal)?data.subtotal.toLocaleString(): 0.00}}
                        </td>
                        <td class="text-right" style="cursor:pointer;" ng-click="edit_register(data)">
                            $ @{{(data.iva)?data.iva.toLocaleString(): 0.00}}
                        </td>
                        <td class="text-right" style="cursor:pointer;" ng-click="edit_register(data)">
                            $ @{{(data.total)? data.total.toLocaleString(): 0.00 }}
                        </td>
                        <td class="text-right">
                                <select class="form-control" 
                                width="'60%'"
                                chosen
                                ng-model="id_estatus" 
                                ng-options="value.id as value.nombre for (key, value) in datos.estatus" 
                                ng-change="update_estatus(data.id )" 
                                id="cmb_estatus_@{{data.id}}" ng-if="data.id_estatus != 8" >
                                    <option value="">--Seleccione Opcion--</option>
                                </select>
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
                                        <a style="cursor:pointer;" title="Imprimir cotización" ng-click="see_reporte(data)">
                                            <i class="glyphicon glyphicon-print"></i> Reporte
                                        </a>
                                    </li>
                                    <li {{ $email }}>
                                        <a title="Enviar Correo" style="cursor:pointer;" ng-click="send_reporte(data)">
                                            <i class="glyphicon glyphicon-envelope"></i> Enviar Email
                                        </a>
                                    </li>
                                    <li {{$eliminar}} ng-if="data.id_estatus != 8">
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
                        <!-- <td style="background-color:#eee"> 
                            TOTAL FACTURAS: <strong> @{{ datos.total_pedidos }} </strong>
                        </td> -->
                    </tr>
                </tfoot>
            </table>
            <table class="table table-responsive table-striped table-hover">
                <tr>
                  <td class="text-center col-xs-1" style="background-color:#eee">
                        TOTAL FACTURAS: <strong> @{{ datos.total_pedidos }} </strong>
                  </td>
                  <td class="text-center col-xs-1" style="background-color:#eee">
                        TOTAL: <strong>  </strong>
                  </td>
                </tr>
            </table>

        </div>
    </div>



    @include('ventas.facturaciones_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/ventas/build_facturaciones.js')}}"></script>
@endpush