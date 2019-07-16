@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
    <div ng-controller="SalesController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
        <form class="form-horizontal">
            <div class="form-group row">
                <div class="col-sm-2">
                    <select class="form-control input-sm"
                            width="'50%'"
                            chosen
                            ng-model="year"
                            ng-change="yearFilter(year)"
                            ng-options="value.id as value.descripcion for (key, value) in cmbAnios" >
                    </select>

                </div>

                <div class="col-sm-7">
                    <pagination-filter></pagination-filter>
                </div>
                <div class="col-sm-2">
                    <select class="form-control input-sm"
                            width="'100%'"
                            chosen
                            ng-model="user"
                            ng-change="userFilter(user)"
                            ng-options="value.id as value.name +' '+value.first_surname for (key, value) in cmbUsers">
                        <option value="">--Seleccione Opcion--</option>
                    </select>

                </div>

            </div>

        </form>
        <div class="table-responsive">
            <table class="table table-striped table-responsive highlight table-hover table-container" id="datatable">
                <thead>
                <tr style="background-color: #337ab7; color: #ffffff;">
                    <th>N° Orden</th>
                    <th>Fecha</th>
                    <th>Empresa</th>
                    <th>Grupo</th>
                    <th>Usuario</th>
                    <th>Forma de Pago</th>
                    <th>Estatus</th>
                    <th class="text-right">Subtotal</th>
                    <th class="text-right">Iva</th>
                    <th class="text-right">Total</th>
                    <th class="text-right"></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="data in datos" id="tr_@{{ data.id }}" >
                    <td style="cursor:pointer;" ng-click="edit_register(data)" ng-bind="data.id"></td>
                    <td style="cursor:pointer;" ng-click="edit_register(data)" ng-bind="data.created_at"></td>
                    <td style="cursor:pointer;" ng-click="edit_register(data)" ng-bind="data.razon_social"></td>
                    <td style="cursor:pointer;" ng-click="edit_register(data)" ng-bind="data.grupo"></td>
                    <td style="cursor:pointer;" ng-click="edit_register(data)" ng-bind="data.full_name"></td>
                    <td style="cursor:pointer;" ng-click="edit_register(data)" ng-bind="data.forma_pago"></td>
                    <td style="cursor:pointer;" ng-click="edit_register(data)" >
                        <span class="label label-warning" ng-if="data.status_id == 6" ng-bind="data.status"></span>
                        <span class="label label-success" ng-if="data.status_id != 6" ng-bind="data.status"></span>
                    </td>
                    <td class="text-right" style="cursor:pointer;" ng-click="edit_register(data)">
                        $ @{{ data.subtotal.toLocaleString() }}
                    </td>
                    <td class="text-right" style="cursor:pointer;" ng-click="edit_register(data)">
                        $ @{{  data.iva.toLocaleString() }}
                    </td>
                    <td class="text-right" style="cursor:pointer;" ng-click="edit_register(data)">
                        $ @{{  data.total.toLocaleString() }}
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-primary btn-sm" title="Visualizar Ticket" ng-click="ticketWatch(data.file_path)" ng-disabled="(data.file_path)? false: true">
                            <i class="fa fa-eye"></i>
                        </button>
                        {{--<div class="col-sm-6">
                            <button type="button" class="btn btn-success btn-sm" title="Aprobada" ng-click="update_estatus(data.id, 5 )" ng-disabled="(data.id_estatus == 5)? true : false">
                                <i class="glyphicon glyphicon-ok"></i>
                            </button>

                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-danger btn-sm" title="Cancelada" ng-click="update_estatus(data.id, 4)" ng-disabled="(data.id_estatus == 5)? true : false">
                                <i class="glyphicon glyphicon-remove"></i>
                            </button>
                        </div>--}}
                    </td>
                </tr>
                </tbody>
            </table>
            <table>
                <tr>
                    <td style="background-color:#eee" class="text-right">
                        SUBTOTAL: <strong>$ @{{ subtotal }} </strong>
                    </td>
                    <td style="background-color:#eee" class="text-right">
                        IVA: <strong>$ @{{ iva }} </strong>
                    </td>
                    <td style="background-color:#eee" class="text-right">
                        TOTAL: <strong>$ @{{ total }} </strong>
                    </td>
                </tr>
            </table>
        </div>

        @include('salesOfPoint.salesEdit')
    </div>
@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('js/salesOfBoxes/buildSalesController.js')}}" ></script>
@endpush
