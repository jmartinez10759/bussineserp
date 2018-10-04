<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro de Productos </h3>
            </div>
            <div class="modal-body">

                <section class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <div id="load_img">
<!--                                <img class=" img-responsive" src="img/productos/product.png" alt="Bussines profile picture">-->
                                    </div>
                                    
                                    <div class="col-sm-10"></div>
                                    <input type="text" class="form-control" id="logo" v-model="insert.logo">
                                    
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->


                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <form class="form-horizontal" >

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#details" data-toggle="tab" aria-expanded="false">Detalles del Producto</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="resultados_ajax"></div>

                                        <div class="tab-pane active" id="details">

                                            <div class="form-group ">
                                                <label for="product_code" class="col-sm-2 control-label">Clave</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="clave" v-model="insert.clave_unidad">
                                                </div>
                                                <label for="model" class="col-sm-2 control-label">Código</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="codigo" v-model="insert.codigo">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="producto" class="col-sm-2 control-label">Producto</label>

                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="producto" v-model="insert.nombre">
                                                </div>
                                                <label for="modelo" class="col-sm-2 control-label">Stock</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="stock" v-model="insert.stock">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="note" class="col-sm-2 control-label">Descripción</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="descripcion"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="unidad_medida" class="col-sm-2 control-label">Unidad de Medida</label>

                                                <div class="col-sm-4">
                                                    <div v-html="fields.unidades"></div>
                                                </div>

                                                <label for="categoria" class="col-sm-2 control-label">Categoría</label>
                                                <div class="col-sm-4">
                                                    <div v-html="fields.categorias"></div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="subtotal" class="col-sm-2 control-label">Subtotal</label>

                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-usd"></i>
                                                        </div>
                                                        <input type="text" class="form-control" id="subtotal" v-model="insert.subtotal" v-on:blur="total_concepto()">
                                                    </div>
                                                </div>
                                                <label for="iva" class="col-sm-2 control-label">IVA</label>

                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <strong>%</strong>
                                                        </div>
                                                        <input type="text" class="form-control" id="iva" v-model='insert.iva' v-on:blur="total_concepto()">
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
                                                        <input type="text" class="form-control" id="total" v-model="insert.total" readonly>
                                                    </div>
                                                </div>


                                                <label for="estatus" class="col-sm-2 control-label">Estatus</label>

                                                <div class="col-sm-4">
                                                    <select class="form-control" id="estatus" v-model="insert.estatus">
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
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
                    <button type="button" class="btn btn-primary" v-on:click.prevent="insert_register()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="" id="modal_edit_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Actualización de Productos </h3>
            </div>
            <div class="modal-body">


                                            <section class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <div id="load_img">
<!--                                <img class=" img-responsive" src="img/productos/product.png" alt="Bussines profile picture">-->
                                    </div>
                                    
                                    <div class="col-sm-10"></div>
                                    <input type="text" class="form-control" id="logo" v-model="insert.logo">
                                    
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->


                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <form class="form-horizontal" >

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#details" data-toggle="tab" aria-expanded="false">Detalles del Producto</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="resultados_ajax"></div>

                                        <div class="tab-pane active" id="details">

                                            <div class="form-group ">
                                                <label for="product_code" class="col-sm-2 control-label">Clave</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="clave_edit" v-model="update.clave_unidad">
                                                </div>
                                                <label for="model" class="col-sm-2 control-label">Código</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="codigo_edit" v-model="update.codigo">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="producto" class="col-sm-2 control-label">Producto</label>

                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="producto_edit" v-model="update.nombre">
                                                </div>
                                                <label for="modelo" class="col-sm-2 control-label">Stock</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="stock_edit" v-model="update.stock">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="note" class="col-sm-2 control-label">Descripción</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="descripcion_edit"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="unidad_medida" class="col-sm-2 control-label">Unidad de Medida</label>

                                                <div class="col-sm-4">
                                                    <div v-html="fields.unidades_edit"></div>
                                                </div>

                                                <label for="categoria" class="col-sm-2 control-label">Categoría</label>
                                                <div class="col-sm-4">
                                                    <div v-html="fields.categorias_edit"></div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="subtotal" class="col-sm-2 control-label">Subtotal</label>

                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-usd"></i>
                                                        </div>
                                                        <input type="text" class="form-control" id="subtotal_edit" v-model="update.subtotal" v-on:blur="total_concepto_edit()">
                                                    </div>
                                                </div>
                                                <label for="iva" class="col-sm-2 control-label">IVA</label>

                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <div class="input-group-addon">
                                                            <strong>%</strong>
                                                        </div>
                                                        <input type="text" class="form-control" id="iva_edit" v-model='update.iva' v-on:blur="total_concepto_edit()">
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
                                                        <input type="text" class="form-control" id="total_edit" v-model="update.total" readonly>
                                                    </div>
                                                </div>


                                                <label for="estatus" class="col-sm-2 control-label">Estatus</label>

                                                <div class="col-sm-4">
                                                    <select class="form-control" id="estatus" v-model="update.estatus">
                                                        <option value="1">Activo</option>
                                                        <option value="0">Inactivo</option>
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
                    <button type="button" class="btn btn-info" v-on:click.prevent="update_register()" {{$update}}><i class="fa fa-save" ></i> Actualizar </button>
                </div>
            </div>

        </div>
    </div>
</div>