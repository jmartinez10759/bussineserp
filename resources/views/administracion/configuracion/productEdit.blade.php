<!-- Modal add register-->
<div class="modal fullscreen-modal fade" id="modal_add_register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3> Registro de Productos </h3>
            </div>
            <div class="modal-body">

                <section class="content">
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-sm-12">
                            <form class="form-horizontal">

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#details" data-toggle="tab" aria-expanded="false">Detalles del Producto</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="resultados_ajax"></div>

                                        <div class="tab-pane active" id="details">

                                            <div class="form-group ">
                                                <label for="model" class="col-sm-2 control-label">Código</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" ng-model="insert.codigo" capitalize>
                                                </div>

                                                <label for="producto" class="col-sm-2 control-label">Producto</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" ng-model="insert.nombre" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">

                                                <label for="modelo" class="col-sm-2 control-label">Stock</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" ng-model="insert.stock" >
                                                </div>

                                                <label for="unidad_medida" class="col-sm-2 control-label">Unidad de Medida</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-model="insert.id_unidadmedida"
                                                            ng-options="value.id as value.nombre for (key, value) in cmbUnits">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="note" class="col-sm-2 control-label">Descripción</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" ng-model="insert.descripcion" capitalize></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="product_code" class="col-sm-2 control-label">Clave Servicio</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-model="insert.id_servicio"
                                                            ng-options="value.id as value.clave+' - '+value.descripcion for (key, value) in cmbServices">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>


                                                <label for="categoria" class="col-sm-2 control-label">Categoría</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-model="insert.id_categoria"
                                                            ng-options="value.id as value.nombre for (key, value) in cmbCategories">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="product_code" class="col-sm-2 control-label">Tipo Factor</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-change="getTasas(insert.id_tipo_factor)"
                                                            ng-model="insert.id_tipo_factor"
                                                            ng-options="value.id as value.clave for (key, value) in cmbFactorType">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>


                                                <label for="categoria" class="col-sm-2 control-label">Tasa</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-change="getTaxes(insert.id_tasa)"
                                                            ng-model="insert.id_tasa"
                                                            ng-options="value.id as (value.valor_maximo +' - '+value.clave ) for (key, value) in cmbTasas">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="product_code" class="col-sm-2 control-label">Impuestos</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="insert.id_impuesto"
                                                            ng-disabled="true"
                                                            ng-options="value.id as value.clave for (key, value) in cmbTaxes">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                                <label for="subtotal" class="col-sm-2 control-label">Subtotal</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-usd"></i>
                                                        </div>
                                                        <input type="number" class="form-control" ng-model="insert.subtotal" ng-keyup="totalConcepts(insert.subtotal, insert.iva)">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="iva" class="col-sm-2 control-label">IVA</label>

                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <strong>%</strong>
                                                        </div>
                                                        <input type="text" class="form-control" ng-model="insert.iva" ng-keyup="totalConcepts(insert.subtotal,insert.iva)" readonly="">
                                                    </div>
                                                </div>

                                                <label for="selling_price" class="col-sm-2 control-label">Total</label>

                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-usd"></i>
                                                        </div>
                                                        <input type="text" class="form-control" id="total" ng-model="insert.total" readonly>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="estatus" class="col-sm-2 control-label">Estatus</label>

                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-model="insert.estatus"
                                                            ng-options="value.id as value.descripcion for (key, value) in cmbEstatusRoot">
                                                    </select>
                                                </div>
                                                <div ng-if="userLogged == 1">

                                                    <label class="col-sm-2 control-label">Empresas</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control"
                                                                chosen
                                                                width="'100%'"
                                                                ng-change="getGroupByCompany(insert.companyId)"
                                                                ng-model="insert.companyId"
                                                                ng-options="value.id as value.razon_social for (key, value) in rootCmbCompanies">
                                                            <option value="">--Seleccione Opcion--</option>
                                                        </select>
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="form-group" ng-if="userLogged == 1">
                                                <label class="col-sm-2 control-label">Sucursales</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="insert.groupId"
                                                            multiple
                                                            ng-options="value.groups.id as value.groups.descripcion for (key, value) in rootCmbGroups">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
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
                </section>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" ng-click="insertRegister()" ng-if="permisos.INS" ng-disabled="spinning">
                        <span ng-show="spinning"><i class="glyphicon glyphicon-refresh spinning"></i></span>
                        <span ng-hide="spinning"><i class="fa fa-save"></i></span> Registrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit register-->
<div class="modal fullscreen-modal fade" id="modal_edit_register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"> Detalles del Producto</h4>
            </div>
            <div class="modal-body">

                <section class="content">
                    <div class="row">
                        <div class="col-sm-3">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <center>
                                    <div class="box-body box-profile drop-shadow">
                                        <image-load image="update.logo"></image-load>
                                    </div>
                                </center>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-9">
                            <form class="form-horizontal">

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#details_edit" data-toggle="tab" aria-expanded="false">Detalles del Producto</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="resultados_ajax"></div>

                                        <div class="tab-pane active" id="details_edit">

                                            <div class="form-group ">
                                                <label for="model" class="col-sm-2 control-label">Código</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" ng-model="update.codigo" capitalize>
                                                </div>

                                                <label for="producto" class="col-sm-2 control-label">Producto</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" ng-model="update.nombre" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">

                                                <label for="modelo" class="col-sm-2 control-label">Stock</label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" id="stock" ng-model="update.stock" >
                                                </div>

                                                <label for="unidad_medida" class="col-sm-2 control-label">Unidad de Medida</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-model="update.id_unidadmedida"
                                                            ng-options="value.id as value.nombre for (key, value) in cmbUnits">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <label for="note" class="col-sm-2 control-label">Descripción</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" ng-model="update.descripcion" capitalize></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="product_code" class="col-sm-2 control-label">Clave Servicio</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-model="update.id_servicio"
                                                            ng-options="value.id as value.clave+' - '+value.descripcion for (key, value) in cmbServices">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>


                                                <label for="categoria" class="col-sm-2 control-label">Categoría</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-model="update.id_categoria"
                                                            ng-options="value.id as value.nombre for (key, value) in cmbCategories">
                                                            <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="product_code" class="col-sm-2 control-label">Tipo Factor</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-change="getTasas(update.id_tipo_factor)"
                                                            ng-model="update.id_tipo_factor"
                                                            ng-options="value.id as value.clave for (key, value) in cmbFactorType">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>


                                                <label for="categoria" class="col-sm-2 control-label">Tasa</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-change="getTaxes(update.id_tasa,true)"
                                                            ng-model="update.id_tasa"
                                                            ng-options="value.id as (value.valor_maximo +' - '+value.clave ) for (key, value) in cmbTasas">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="product_code" class="col-sm-2 control-label">Impuestos</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="update.id_impuesto"
                                                            ng-disabled="true"
                                                            ng-options="value.id as value.clave for (key, value) in cmbTaxes">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                                <label for="subtotal" class="col-sm-2 control-label">Subtotal</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-usd"></i>
                                                        </div>
                                                        <input type="number" class="form-control" ng-model="update.subtotal" ng-keyup="totalConcepts(update.subtotal, update.iva,true)">
                                                    </div>
                                                </div>


                                            </div>

                                            <div class="form-group">

                                                <label for="iva" class="col-sm-2 control-label">IVA</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <strong>%</strong>
                                                        </div>
                                                        <input type="text" class="form-control" ng-model="update.iva" ng-keyup="totalConcepts(update.subtotal,update.iva,true)" readonly="">
                                                    </div>
                                                </div>

                                                <label for="selling_price" class="col-sm-2 control-label">Total</label>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-usd"></i>
                                                        </div>
                                                        <input type="text" class="form-control" ng-model="update.total" readonly>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="estatus" class="col-sm-2 control-label">Estatus</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            width="'100%'"
                                                            chosen
                                                            ng-model="update.estatus"
                                                            ng-options="value.id as value.descripcion for (key, value) in cmbEstatusRoot">
                                                    </select>
                                                </div>

                                                <div ng-if="userLogged == 1">
                                                    <label class="col-sm-2 control-label">Empresas</label>
                                                    <div class="col-sm-4">
                                                        <select class="form-control"
                                                                chosen
                                                                width="'100%'"
                                                                ng-change="getGroupByCompany(update.companyId)"
                                                                ng-model="update.companyId"
                                                                ng-options="value.id as value.razon_social for (key, value) in rootCmbCompanies">
                                                            <option value="">--Seleccione Opcion--</option>
                                                        </select>
                                                    </div>
                                                </div>



                                            </div>

                                            <div class="form-group">
                                                <div ng-if="userLogged == 1"></div>
                                                <label class="col-sm-2 control-label">Sucursales</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="update.groupId"
                                                            multiple
                                                            ng-options="value.groups.id as value.groups.descripcion for (key, value) in rootCmbGroups">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                                <button type="button" class="btn btn-warning" ng-click="fileUpload(true)" ng-if="permisos.UPL">
                                                    <i class="fa fa-upload"></i> Cargar Imagen
                                                </button>

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
                </section>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true" >
                    <i class="fa fa-times-circle"></i> Cancelar
                </button>
                <button type="button" class="btn btn-info" ng-click="updateRegister()" ng-if="permisos.UPD" ng-disabled="spinning">
                    <span ng-show="spinning"><i class="glyphicon glyphicon-refresh spinning"></i></span>
                    <span ng-hide="spinning"><i class="fa fa-save"></i> </span>Actualizar
                </button>
            </div>
        </div>
    </div>
</div>

<div class="" id="upload_file" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Subir Imagen </h3>
            </div>
            <div class="modal-body">
                <div id="div_dropzone_file_productos"></div> 
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close>
                        <i class="fa fa-times-circle"></i> Cerrar
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>