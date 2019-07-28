@extends('layouts.template.app')
@section('content')
    @push('styles')
    @endpush
    <div ng-controller="CutsController" ng-init="constructor()" ng-cloak ng-if="permisos.GET">
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
                        <th>Empresa</th>
                        <th>Grupo</th>
                        <th>Cajero</th>
                        <th>Corte</th>
                        <th>Fecha</th>
                        <th>Caja</th>
                        <th>Ordenes</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-right">Iva</th>
                        <th class="text-right">Total</th>
                        <th class="text-right"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="data in datos | filter: searching" id="tr_@{{ data.id }}" >
                        <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="data.razon_social"></td>
                        <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="data.grupo"></td>
                        <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="data.full_name"></td>
                        <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="data.n_cuts"></td>
                        <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="data.created_at"></td>
                        <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="data.caja"></td>
                        <td style="cursor:pointer;" ng-click="editRegister(data)" ng-bind="data.n_orders"></td>
                        <td class="text-right" style="cursor:pointer;" ng-click="editRegister(data)">
                            $ @{{ data.subtotal.toLocaleString() }}
                        </td>
                        <td class="text-right" style="cursor:pointer;" ng-click="editRegister(data)">
                            $ @{{  data.iva.toLocaleString() }}
                        </td>
                        <td class="text-right" style="cursor:pointer;" ng-click="editRegister(data)">
                            $ @{{  data.total.toLocaleString() }}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm" title="Visualizar Ticket" ng-click="ticketWatch(data.file_path)" ng-disabled="(data.file_path)? false: true">
                                <i class="fa fa-eye"></i>
                            </button>
                            {{--<button type="button" class="btn btn-danger btn-sm" title="Cancelar Pedido" ng-click="cancelOrders(data.id)"ng-disabled="(data.status_id == 4 || data.status_id == 7)? true :false">
                                <i class="fa fa-times-circle"></i>
                            </button>--}}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <table class="table">
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

        @include('salesOfPoint.cutsEdit')
    </div>
@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('js/salesOfBoxes/buildCutsController.js')}}" ></script>
@endpush
