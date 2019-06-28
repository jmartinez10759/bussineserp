<!-- Modal add register-->
<div class="modal fullscreen-modal fade" id="modal_add_register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
                <h3> Punto de Venta </h3>
            </div>
            <div class="modal-body">

                    <div class="row">
                        <!-- /.col -->
                        <div class="col-sm-12">
                            <form class="form-horizontal">

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#details" data-toggle="tab" aria-expanded="false">@{{ boxName }}</a></li>
                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="details">

                                            <div class="container">

                                            </div>

                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <angucomplete-alt id="products"
                                                                              placeholder="Ingrese producto ... "
                                                                              pause="100"
                                                                              selected-object="findInsertOrder"
                                                                              local-data="products"
                                                                              search-fields="nombre"
                                                                              title-field="nombre"
                                                                              minlength="1"
                                                                              image-field="logo"
                                                                              clear-selected="true"
                                                                              input-class="form-control form-control-small"/>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <select class="form-control"
                                                                    chosen
                                                                    width="'100%'"
                                                                    ng-model="insert.paymentForm"
                                                                    ng-options="value.id as (value.clave+' '+value.descripcion) for (key, value) in cmbPaymentForm">
                                                                <option disabled>--Seleccione Opcion--</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <select class="form-control"
                                                                    chosen
                                                                    width="'100%'"
                                                                    ng-model="insert.paymentMethod"
                                                                    ng-options="value.id as (value.clave+' '+value.descripcion) for (key, value) in cmbPaymentMethod">
                                                                <option disabled>--Seleccione Opcion--</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="col-sm-3">
                                                    <input type="hidden" ng-model="insert.orderId" />
                                                    <div class="btn-group pull-right">
                                                        <button type="button" class="btn btn-danger" title="Cerrar caja" ng-click="boxClosed()">
                                                            <i class="fa fa-sign-out pull-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-9">
                                                    <div class="table-responsive table-container">
                                                        <table class="table table-striped table-responsive highlight table-hover" id="datatable">
                                                            <thead>
                                                            <tr style="background-color: #337ab7; color: #ffffff;">
                                                                <th></th>
                                                                <th>Producto</th>
                                                                <th>Precio</th>
                                                                <th>Cantidad</th>
                                                                <th>% Descuento</th>
                                                                <th>Total</th>
                                                                <th></th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr ng-repeat="concept in concepts" id="tr_@{{concept.id}}">
                                                                <td style="cursor:pointer;"></td>
                                                                <td style="cursor:pointer;" ng-bind="concept.products.nombre"></td>
                                                                <td style="cursor:pointer;" ng-bind="concept.price"></td>
                                                                <td style="cursor:pointer;">
                                                                    <input type="number" ng-keyup="sumConcepts(concept.quality,concept.total)" ng-bind="concept.quality" class="form-control col-sm-1">
                                                                </td>
                                                                <td style="cursor:pointer;">
                                                                    <input type="number" ng-model="insert.discoun" ng-bind="concept.discount" class="form-control col-sm-1">
                                                                </td>
                                                                <td style="cursor:pointer;" ng-bind="concept.total"></td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-danger btn-sm" ng-click="destroyConcept(concept.id)" title="Eliminar Registro">
                                                                        <i class="glyphicon glyphicon-trash"></i>
                                                                    </button>
                                                                </td>

                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <h1 ng-bind="'Subtotal: '+subtotal"></h1>
                                                    <h1 ng-bind="'Iva: '+iva"></h1>
                                                    <h1 ng-bind="'total: '+total"></h1>
                                                </div>
                                            </div>



                                        </div>
                                        <!-- /.tab-pane -->

                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- /.nav-tabs-custom -->

                            </form>

                        </div>
                        <!-- /.col -->
                    </div>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    {{--<button-register method="insertRegister()" permission="permisos" spinning="spinning"></button-register>--}}
                </div>
            </div>
        </div>
    </div>
</div>