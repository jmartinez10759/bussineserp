<!-- Modal add register-->
<div class="modal fullscreen-modal fade" id="modal_add_register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
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
                                                    <!-- Item slider-->
                                                    <div class="container-fluid ">

                                                        <div class="row">
                                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                                <div class="carousel carousel-showmanymoveone slide" id="itemslider">
                                                                    <div class="carousel-inner">

                                                                        <div class="item active">
                                                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                                                <a href="#"><img src="assets/imagenes/1.jpg" class="img-responsive center-block"></a>
                                                                                <h5 class="text-center">TEPANYAKY</h5>
                                                                                <p class="text-center">Precio <span class="label label-success">$75.00</span></p>

                                                                                <div class="row">
                                                                                    <div class="col-sm-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary btn-sm" id="btn1" name="btn1" value="1"><span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR</button>
                                                                                        <button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="item">
                                                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                                                <a href="#"><img src="assets/imagenes/2.jpg" class="img-responsive center-block"></a>
                                                                                <h5 class="text-center">ARROZ CON CARNE</h5>
                                                                                <p class="text-center">Precio <span class="label label-success">$75.00</span></p>

                                                                                <div class="row">
                                                                                    <div class="col-sm-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary btn-sm" id="btn1" name="btn1" value="1"><span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR</button>
                                                                                        <button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="item">
                                                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                                                <a href="#"><img src="assets/imagenes/3.jpg" class="img-responsive center-block"></a>
                                                                                <h5 class="text-center">ARROZ CON CAMARON</h5>
                                                                                <p class="text-center">Precio <span class="label label-success">$75.00</span></p>
                                                                                <span class="badgeejemplo">10%</span>
                                                                                <div class="row">
                                                                                    <div class="col-sm-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary btn-sm" id="btn1" name="btn1" value="1"><span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR</button>
                                                                                        <button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="item">
                                                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                                                <a href="#"><img src="assets/imagenes/4.jpg" class="img-responsive center-block"></a>
                                                                                <h5 class="text-center">RAMEN CON POLLO</h5>
                                                                                <p class="text-center">Precio <span class="label label-success">$75.00</span></p>

                                                                                <div class="row">
                                                                                    <div class="col-sm-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary btn-sm" id="btn1" name="btn1" value="1"><span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR</button>
                                                                                        <button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="item">
                                                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                                                <a href="#"><img src="assets/imagenes/5.jpg" class="img-responsive center-block"></a>
                                                                                <h5 class="text-center">CHUNKUN FRITO</h5>
                                                                                <p class="text-center">Precio <span class="label label-success">$75.00</span></p>

                                                                                <div class="row">
                                                                                    <div class="col-sm-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary btn-sm" id="btn1" name="btn1" value="1"><span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR</button>
                                                                                        <button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="item">
                                                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                                                <a href="#"><img src="assets/imagenes/6.jpg" class="img-responsive center-block"></a>
                                                                                <h5 class="text-center">CHUN KUN AL VAPOR</h5>
                                                                                <p class="text-center">Precio <span class="label label-success">$75.00</span></p>

                                                                                <div class="row">
                                                                                    <div class="col-sm-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary btn-sm" id="btn1" name="btn1" value="1"><span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR</button>
                                                                                        <button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="item">
                                                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                                                <a href="#"><img src="assets/imagenes/7.jpg" class="img-responsive center-block"></a>
                                                                                <h5 class="text-center">CERDO AGRIDULCE</h5>
                                                                                <p class="text-center">Precio <span class="label label-success">$75.00</span></p>

                                                                                <div class="row">
                                                                                    <div class="col-sm-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary btn-sm" id="btn1" name="btn1" value="1"><span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR</button>
                                                                                        <button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="item">
                                                                            <div class="col-xs-12 col-sm-6 col-md-2">
                                                                                <a href="#"><img src="assets/imagenes/8.jpg" class="img-responsive center-block"></a>
                                                                                <h5 class="text-center">TORTA ESPECIAL TEPANYAKI</h5>
                                                                                <p class="text-center">Precio <span class="label label-success">$75.00</span></p>

                                                                                <div class="row">
                                                                                    <div class="col-sm-12 text-center">
                                                                                        <button type="submit" class="btn btn-primary btn-sm" id="btn1" name="btn1" value="1"><span class="glyphicon glyphicon-shopping-cart"></span> AGREGAR</button>
                                                                                        <button class="btn btn-default btn-sm" id="btn2" name="btn2" value="2" type="submit"> <span class="glyphicon glyphicon-info-sign"></span> INFO</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>

                                                                    <div id="slider-control">
                                                                        <a class="left carousel-control" href="#itemslider" data-slide="prev"><img src="assets/imagenes/flecha_izq.png" alt="Left" class="img-responsive"></a>
                                                                        <a class="right carousel-control" href="#itemslider" data-slide="next"><img src="assets/imagenes/flecha_der.png" alt="Right" class="img-responsive"></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Item slider end-->
                                                </div>
                                            </div>--}}

                                            <div class="row">
                                                <div class="col-sm-9">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <angucomplete-alt id="products"
                                                                              placeholder="Ingrese producto y/o Codigo de Barras ... "
                                                                              pause="100"
                                                                              selected-object="findInsertOrder"
                                                                              local-data="products"
                                                                              search-fields="nombre,codigo"
                                                                              title-field="codigo"
                                                                              description-field="nombre"
                                                                              minlength="1"
                                                                              image-field="logo"
                                                                              clear-selected="true"
                                                                              input-class="form-control form-control-small"
                                                                              match-class="angucomplete-match"/>
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
                                                            <tr ng-repeat="item in concepts" id="tr_@{{concept.id}}">
                                                                <td style="cursor:pointer;"></td>
                                                                <td style="cursor:pointer;" ng-bind="item.products.nombre"></td>
                                                                <td style="cursor:pointer;" ng-bind="item.price | currency:$ "></td>
                                                                <td style="cursor:pointer;">
                                                                    <xeditable ng-model="item.quality" placeholder="Cantidad" title="Cantidad" />
                                                                </td>
                                                                <td style="cursor:pointer;">
                                                                    <xeditable ng-model="item.discount" placeholder="Descuento %" title="Descuento" /> %
                                                                </td>
                                                                <td style="cursor:pointer;" ng-bind="item.total | currency:$ "></td>
                                                                <td class="text-center">
                                                                    <button type="button" class="btn btn-danger btn-sm" ng-click="destroyConcept(item.id)" title="Eliminar Registro">
                                                                        <i class="glyphicon glyphicon-trash"></i>
                                                                    </button>
                                                                </td>

                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row">
                                                        <table class="table-hover col-sm-10">
                                                            <tr>
                                                                <td>
                                                                    <h3 ng-bind="'Subtotal:'"></h3>
                                                                </td>
                                                                <td>
                                                                    <h3 ng-bind="(subtotal)? '$ '+subtotal : '$ 0.00'"></h3>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h3 ng-bind="'Iva (16%):'"></h3>
                                                                </td>
                                                                <td>
                                                                    <h3 ng-bind="(iva)? '$ '+iva: '$ 0.00'"></h3>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <h3 ng-bind="'Total:'"></h3>
                                                                </td>
                                                                <td>
                                                                    <h3 ng-bind="(total)? '$ '+total: '$ 0.00'"></h3>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </div>
                                                    <div class="row">
                                                        <label class="control-label">Comentarios</label>
                                                        <textarea class="form-control" ng-model="insert.comments" capitalize></textarea>
                                                    </div>
                                                    <div class="row">
                                                        <br><br>
                                                        <div class="pull-right">
                                                            <button type="button" class="btn btn-warning btn-sm" ng-click="paymentOrderCancel()" ng-disabled="payment">
                                                                <i class="fa fa-times-circle"></i> Cancelar Pago
                                                            </button>
                                                            <button type= "button" class="btn btn-success btn-sm" ng-click="paymentOrderSuccess()" ng-disabled="payment">
                                                                <span><i class="glyphicon glyphicon-usd"></i> </span> Realizar Pago
                                                            </button>
                                                        </div>

                                                    </div>

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
                </div>
            </div>
        </div>
    </div>
</div>




<!-- modal para pago -->
<div id="paymentForm" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Forma de pago</h4>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form role="form" class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for=""># Orden</label>
                                <input type="text" class="form-control" ng-model="insert.orderId" ng-disabled="true">
                            </div>
                            <div class="col-sm-3">
                                <label for="">Total Orden </label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input type="text" class="form-control" placeholder="Ingresa monto recibido" ng-model="totalMount" ng-disabled="true">
                                </div>
                            </div>
                            {{--<div class="col-sm-3">
                                <label for="">Cliente</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input type="text" class="form-control" placeholder="Nombre cliente">
                                </div>
                            </div>--}}
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label for="">Monto Recibido</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input type="number" class="form-control" placeholder="Ingresa monto recibido" ng-model="mount" ng-keyup="calculateSwap()">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="">Cambio del Cliente</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-usd"></i></span>
                                    <input type="text" class="form-control" ng-model="insert.swap" ng-disabled="true">
                                </div>
                            </div>

                            {{--<div class="col-sm-3">
                                <label for="">Consumo Cliente</label>
                                <select class="form-control" id="opcionConsumo">
                                    <option disabled selected value> -- Seleciona una opcion -- </option>
                                    <option value="1">COMER AQUI</option>
                                    <option value="2">LLEVAR</option>
                                </select>
                            </div>--}}
                        </div>

                        <div class="form-group" ng-show="false">
                            <div class="col-sm-3">
                                <label for="">Direccion</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-road"></i></span>
                                    <input type="text" class="form-control" placeholder="Ingresa direccion,calle y #">
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <label for="">Telefono</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                    <input type="text" class="form-control" placeholder="Ingresa el telefono">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="">Detalles pedido</label>
                                <textarea class="form-control" ng-model="insert.comments" capitalize ></textarea>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type= "button" class="btn btn-success btn-sm" ng-click="updateRegister()" ng-if="permisos.UPD" ng-disabled="spinning">
                        <span ng-show="spinning"><i class="glyphicon glyphicon-refresh spinning"></i></span>
                        <span ng-hide="spinning"><i class="glyphicon glyphicon-shopping-cart"></i> </span> Pagar Pedido
                    </button>
                </div>
                </form>
            </div>

        </div>
    </div>

    <!-- end modal para pago -->