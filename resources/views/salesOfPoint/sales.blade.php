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
                            ng-model="anio"
                            ng-change="filtros_anio()"
                            ng-options="value.id as value.descripcion for (key, value) in cmbAnios" >
                    </select>

                </div>

                <div class="col-sm-7">
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
                            ng-options="value.id as value.name +' '+value.first_surname for (key, value) in datos.usuarios">
                        <option value="">--Seleccione Opcion--</option>
                    </select>

                </div>

            </div>

        </form>

        @include('salesOfPoint.salesEdit')
    </div>
@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('js/salesOfBoxes/buildSalesController.js')}}" ></script>
@endpush
