<div class="col-sm-12" id="modal_add_register" style="display:none;">
    <div class="modal-header">
        <h3> Registro de Planes </h3>
    </div>
    <div class="modal-body" style="overflow-y:scroll; height:500px;">
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <div id="load_img">
                                <!--<img class=" img-responsive" src="img/productos/product.png" alt="Bussines profile picture">-->
                            </div>

                            <div class="col-sm-10"></div>
                            <input type="text" class="form-control" id="logo" ng-model="insert.logo">

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <form class="form-horizontal">

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#details" data-toggle="tab" aria-expanded="false">Detalles del Plan</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="resultados_ajax"></div>

                                <div class="tab-pane active" id="details">

                                    <div class="form-group ">
                                        <label for="model" class="col-sm-2 control-label">Código</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" ng-model="insert.codigo" ng-change="insert.codigo = (insert.codigo | uppercase)">
                                        </div>
                                        
                                        <label for="producto" class="col-sm-2 control-label">Producto</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="producto" ng-model="insert.nombre" ng-change="insert.nombre = (insert.nombre | uppercase)">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label for="modelo" class="col-sm-2 control-label">Stock</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="stock" ng-model="insert.stock">
                                        </div>
                                        
                                        <label for="unidad_medida" class="col-sm-2 control-label">Unidad de Medida</label>
                                        <div class="col-sm-4">
                                            {!! $unidades !!}
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="note" class="col-sm-2 control-label">Descripción</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="descripcion" ng-model="insert.descripcion" ng-change="insert.descripcion = (insert.descripcion | uppercase)"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_code" class="col-sm-2 control-label">Clave Servicio</label>
                                        <div class="col-sm-4">
                                            {!! $servicios !!}
                                        </div>

                                        <label for="product_code" class="col-sm-2 control-label">Tipo Factor</label>
                                        <div class="col-sm-4">
                                            
                                            <select class="form-control" 
                                            ng-change="tipo_factor()"
                                            ng-model="insert.id_tipo_factor" 
                                            ng-options="value.id as value.clave for (key, value) in datos.cmb_tipo_factor"> 
                                            </select>

                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="categoria" class="col-sm-2 control-label">Tasa</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" 
                                            ng-change="clave_impuesto()"
                                            ng-model="insert.id_tasa" 
                                            ng-options="value.id as value.clave for (key, value) in cmb_tasas"> 
                                            </select>
                                        </div>

                                        <label for="product_code" class="col-sm-2 control-label">Impuestos</label>
                                        <div class="col-sm-4">

                                            <select class="form-control cmb_impuestos"  
                                            ng-model="insert.id_impuesto" 
                                            ng-options="value.id as value.descripcion for (key, value) in cmb_impuestos" disabled=""> 
                                            </select>
                                            
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="subtotal" class="col-sm-2 control-label">Subtotal</label>

                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-usd"></i>
                                                </div>
                                                <input type="text" class="form-control" id="subtotal" ng-model="insert.subtotal" ng-blur="total_concepto()">
                                            </div>
                                        </div>
                                        <label for="iva" class="col-sm-2 control-label">IVA</label>

                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <strong>%</strong>
                                                </div>
                                                <input type="text" class="form-control" id="iva" ng-model="insert.iva" ng-blur="total_concepto()" readonly="">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="selling_price" class="col-sm-2 control-label">Total</label>

                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-usd"></i>
                                                </div>
                                                <input type="text" class="form-control" id="total" ng-model="insert.total" readonly>
                                            </div>
                                        </div>


                                        <label for="estatus" class="col-sm-2 control-label">Estatus</label>

                                        <div class="col-sm-4">  
                                            <select class="form-control" 
                                            ng-model="insert.estatus" 
                                            ng-options="value.id as value.descripcion for (key, value) in cmb_estatus">
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
            <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
            <button type="button" class="btn btn-primary" ng-click="insert_register()" {{ $insertar }}><i class="fa fa-save"></i> Registrar </button>
        </div>
    </div>
</div>

<div class="" id="modal_edit_register" style="display:none;">
    <div class="modal-header">
        <h3> Detalles de Planes </h3>
    </div>
    <div class="modal-body" style="overflow-y:scroll; height:500px;">
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <div id="load_img">
                                <!--<img class=" img-responsive" src="img/productos/product.png" alt="Bussines profile picture">-->
                            </div>

                            <div class="col-sm-10"></div>
                            <input type="text" class="form-control" id="logo_edit" ng-model="update.logo">

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <form class="form-horizontal">

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#details_edit" data-toggle="tab" aria-expanded="false">Detalles del Plan</a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="resultados_ajax"></div>

                                <div class="tab-pane active" id="details_edit">

                                    <div class="form-group ">
                                        <label for="model" class="col-sm-2 control-label">Código</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" ng-model="update.codigo" ng-change="update.codigo = (update.codigo | uppercase)">
                                        </div>
                                        
                                        <label for="producto" class="col-sm-2 control-label">Producto</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="producto" ng-model="update.nombre" ng-change="update.nombre = (update.nombre | uppercase)">
                                        </div>
                                    </div>

                                    <div class="form-group">

                                        <label for="modelo" class="col-sm-2 control-label">Stock</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="stock" ng-model="update.stock" ng-change="update.stock = (update.stock | uppercase)">
                                        </div>
                                        
                                        <label for="unidad_medida" class="col-sm-2 control-label">Unidad de Medida</label>
                                        <div class="col-sm-4">
                                            {!! $unidades_edit !!}
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="note" class="col-sm-2 control-label">Descripción</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" id="descripcion" ng-model="update.descripcion" ng-change="update.descripcion = (update.descripcion | uppercase)"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_code" class="col-sm-2 control-label">Clave Servicio</label>
                                        <div class="col-sm-4">
                                            {!! $servicios_edit !!}
                                        </div>

                                        <label for="product_code" class="col-sm-2 control-label">Tipo Factor</label>
                                        <div class="col-sm-4">
                                            <select class="form-control"
                                            ng-change="tipo_factor_edit()" 
                                            ng-model="update.id_tipo_factor" 
                                            ng-options="value.id as value.clave for (key, value) in datos.cmb_tipo_factor">
                                            </select>
                                        </div>
                                        

                                    </div>

                                    <div class="form-group">

                                        <label for="categoria" class="col-sm-2 control-label">Tasa</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" 
                                            ng-change="clave_impuesto_edit()"
                                            ng-model="update.id_tasa" 
                                            ng-options="value.id as value.clave for (key, value) in cmb_tasas"> 
                                            </select>
                                        </div>

                                        <label for="product_code" class="col-sm-2 control-label">Impuestos</label>
                                        <div class="col-sm-4">
                                            <select class="form-control cmb_impuestos" 
                                            ng-model="update.id_impuesto" 
                                            ng-options="value.id as value.descripcion for (key, value) in cmb_impuestos" disabled=""> 
                                            </select>
                                        </div>


                                    </div>

                                    <div class="form-group">
                                        <label for="subtotal" class="col-sm-2 control-label">Subtotal</label>

                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-usd"></i>
                                                </div>
                                                <input type="text" class="form-control" id="subtotal" ng-model="update.subtotal" ng-blur="total_concepto_edit()">
                                            </div>
                                        </div>
                                        <label for="iva" class="col-sm-2 control-label">IVA</label>

                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <strong>%</strong>
                                                </div>
                                                <input type="text" class="form-control" id="iva" ng-model="update.iva" ng-blur="total_concepto_edit()" readonly="" >
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="selling_price" class="col-sm-2 control-label">Total</label>

                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-usd"></i>
                                                </div>
                                                <input type="text" class="form-control" id="total" ng-model="update.total" readonly>
                                            </div>
                                        </div>


                                        <label for="estatus" class="col-sm-2 control-label">Estatus</label>

                                        <div class="col-sm-4">
                                            <select class="form-control" 
                                            ng-model="update.estatus" 
                                            ng-options="value.id as value.descripcion for (key, value) in cmb_estatus">
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
            <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
            <button type="button" class="btn btn-info" ng-click="update_register()" {{ $update }}><i class="fa fa-save"></i> Actualizar </button>
        </div>
    </div>
</div>

<div class="" id="permisos" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Asigne Sucursales </h3>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_producto">
                <input type="hidden" id="id_empresa">
                <div id="sucursal_empresa"></div>
                <!-- <div v-html="sucursales.tabla_sucursales" id="sucursal_empresa"></div> -->
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="insert_permisos()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button>
                </div>
            </div>

        </div>
    </div>
</div>


<input type="hidden" id="id_plan" />   
<div class="" id="modal_asing_producto" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Listado de Productos</h3>
            </div>
            <div class="modal-body">
                {!! $data_table_producto !!}
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="save_asign_producto()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
</div>
