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
                                            {{--<div class="row">

                                                <div class="container">
                                                    <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                                        <!-- Wrapper for slides -->
                                                        <div class="carousel-inner">

                                                            <div class="item active" ng-repeat="product in products" ng-if="$first">
                                                                <div class="col-sm-4">
                                                                    <a href="#">
                                                                        <image-load image="product.logo"></image-load>
                                                                    </a>
                                                                    <h5 class="text-center" ng-bind="product.nombre"></h5>
                                                                    <p class="text-center">
                                                                        Precio <span class="label label-success" ng-bind="'$ '+product.total"></span>
                                                                    </p>

                                                                    <div class="row">
                                                                        <div class="col-sm-12 text-center">
                                                                            <button type="button" class="btn btn-primary btn-sm">
                                                                                <span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR
                                                                            </button>
                                                                            <button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="item " ng-repeat="product in products" ng-if="!$first">
                                                                <div class="col-xs-12 col-sm-6 col-md-2">
                                                                    <a href="#">
                                                                        <image-load image="product.logo"></image-load>
                                                                    </a>
                                                                    <h5 class="text-center" ng-bind="product.nombre"></h5>
                                                                    <p class="text-center">
                                                                        Precio <span class="label label-success" ng-bind="'$ '+product.total"></span>
                                                                    </p>

                                                                    <div class="row">
                                                                        <div class="col-sm-12 text-center">
                                                                            <button type="button" class="btn btn-primary btn-sm">
                                                                                <span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR
                                                                            </button>
                                                                            <button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- Left and right controls -->
                                                        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="right carousel-control" href="#myCarousel" data-slide="next">
                                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>

                                                </div>

                                            </div>--}}

                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <select class="form-control"
                                                                    chosen
                                                                    width="'100%'"
                                                                    ng-change="insertOrder(insert.productId)"
                                                                    ng-model="insert.productId"
                                                                    ng-options="value.id as (value.codigo+' '+value.nombre ) for (key, value) in products">
                                                                <option disabled>--Seleccione Opcion--</option>
                                                            </select>
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
                                                    <button type="text" class="btn btn-danger">Cerrar Caja</button>
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
                                                            <tr ng-repeat="data in datos.register" id="tr_@{{data.id}}">
                                                                <td style="cursor:pointer;" ng-bind=""></td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-danger btn-sm" ng-click="destroyRegister(data.id)" title="Eliminar Registro" ng-if="permisos.DEL" >
                                                                        <i class="glyphicon glyphicon-trash"></i>
                                                                    </button>
                                                                </td>

                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <h1>aqui va la seccion</h1>
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