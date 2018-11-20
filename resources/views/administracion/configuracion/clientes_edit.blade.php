<div class="col-sm-12" id="modal_add_register" style="display:none;">
    <div class="modal-header">
        <h3> Registro de Prospectos </h3>
    </div>
    <div class="modal-body" style="overflow-y:scroll; height:500px;">
        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <div id="load_img">
                                <img class=" img-responsive" src="" alt="Bussines profile picture">
                            </div>

                            <div class="col-sm-12">
                                <div id="div_dropzone_file_clientes"></div> 
                            </div>
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

                                <li class="active">
                                    <a href="#detalles" data-toggle="tab" aria-expanded="false">
                                        Detalles de Facturación
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#contactos" data-toggle="tab" aria-expanded="false">
                                        Detalles del Contacto
                                    </a>
                                </li>


                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane" id="contactos">
                                    <div class="form-group ">
                                        <label for="product_code" class="col-sm-2 control-label">Nombre:</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" ng-model="insert.contacto" ng-change="insert.contacto = (insert.contacto | uppercase)">
                                        </div>
                                        <label for="model" class="col-sm-2 control-label">Departamento:</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="departamento" class="form-control" placeholder="Ingrese departamento o cargo " ng-model="insert.departamento" ng-change="insert.departamento = (insert.departamento | uppercase)">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="producto" class="col-sm-2 control-label">Teléfono:</label>

                                        <div class="col-sm-4">
                                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" ng-model="insert.telefono" maxlength="15">
                                        </div>
                                        
                                        <label for="modelo" class="col-sm-2 control-label">Correo:<font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="correo" class="form-control" placeholder="Ingrese un correo valido" ng-model="insert.correo" >
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="col-sm-6">
                                            <div id="div_dropzone_file_empresa"></div> 
                                        </div>
                                    </div> -->
                                    
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane active" id="detalles">
                                    <div class="form-group ">
                                        <label for="product_code" class="col-sm-2 control-label">Nombre Comercial: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="nombre_comercial" class="form-control" placeholder="" ng-model="insert.nombre_comercial" ng-change="insert.nombre_comercial = (insert.nombre_comercial | uppercase)">
                                        </div>
                                        <label for="model" class="col-sm-2 control-label">Razón Social: <font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="razon_social" class="form-control" placeholder="" ng-model="insert.razon_social" ng-change="insert.razon_social = (insert.razon_social | uppercase)">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="producto" class="col-sm-2 control-label">RFC: <font size="3" color="red">* </font> </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="rfc_receptor" class="form-control" placeholder="" ng-model="insert.rfc_receptor" ng-change="insert.rfc_receptor = (insert.rfc_receptor | uppercase)">
                                        </div>
                                        <label for="modelo" class="col-sm-2 control-label">Calle y Número: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="calle" class="form-control" ng-model="insert.calle" ng-change="insert.calle = (insert.calle | uppercase)">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="note" class="col-sm-2 control-label">Descripción</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control .uppercase" id="descripcion"></textarea>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="unidad_medida" class="col-sm-2 control-label">Colonia: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="colonia" class="form-control .uppercase" placeholder="" ng-model="insert.colonia" ng-change="insert.colonia = (insert.colonia | uppercase)">
                                        </div>

                                        <label for="categoria" class="col-sm-2 control-label">Delegación/ Municipio: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="municipio" class="form-control .uppercase" placeholder="" ng-model="insert.municipio" ng-change="insert.municipio = (insert.municipio | uppercase)">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        
                                        <label for="iva" class="col-sm-2 control-label">Pais: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control"
                                            ng-change="select_estado()" 
                                            ng-model="insert.id_country" 
                                            ng-options="value.id as value.descripcion for (key, value) in datos.paises">
                                            <option value="">--Seleccione Opcion--</option>  
                                            </select>  
                                        </div>
                                        
                                        <label for="iva" class="col-sm-2 control-label">Estado: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control"
                                            ng-change="select_codigos()" 
                                            ng-model="insert.id_estado" 
                                            ng-options="value.id as value.nombre for (key, value) in cmb_estados">
                                            <option value="">--Seleccione Opcion--</option>  
                                            </select>  
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="subtotal" class="col-sm-2 control-label">Código Postal: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control"
                                            chosen="codigo_postal" 
                                            ng-model="insert.id_codigo" 
                                            ng-options="value.id as value.codigo_postal for (key, value) in cmb_codigos"> 
                                            <option value="">--Seleccione Opcion--</option> 
                                            </select>    
                                        </div>

                                        <label for="subtotal" class="col-sm-2 control-label">Servicio Comercial: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" 
                                            ng-model="insert.id_servicio_comercial" 
                                            ng-options="value.id as value.nombre for (key, value) in datos.servicio_comercial">
                                            <option value="">--Seleccione Opcion--</option> 
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="subtotal" class="col-sm-2 control-label">Uso CFDI: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" 
                                            ng-model="insert.id_uso_cfdi" 
                                            ng-options="value.id as value.descripcion for (key, value) in datos.uso_cfdi">
                                                <option value="">--Seleccione Opcion--</option> 
                                            </select>
                                        </div>

                                        <label for="estatus" class="col-sm-2 control-label">Estatus</label>
                                        <div class="col-sm-4">
                                             <select class="form-control" 
                                            ng-model="insert.estatus" 
                                            ng-options="value.id as value.nombre for (key, value) in cmb_estatus"> 
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

<div class="col-sm-12" id="modal_edit_register" style="display:none;">
    <div class="modal-header">
        <h3> Detalles del Cliente </h3>
    </div>
    <div class="modal-body" style="overflow-y:scroll; height:500px;">

        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <div class="box-body box-profile">
                            <div id="load_img">
                                <img class=" img-responsive" src="" alt="Bussines profile picture">
                            </div>

                            <div class="col-sm-12">
                                <div id="div_dropzone_file_clientes_dit"></div> 
                            </div>
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

                                <li class="active">
                                    <a href="#detalles_edit" data-toggle="tab" aria-expanded="false">
                                        Detalles de Facturación
                                    </a>
                                </li>

                                <li class="">
                                    <a href="#contactos_edit" data-toggle="tab" aria-expanded="false">
                                        Detalles del Contacto
                                    </a>
                                </li>


                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane" id="contactos_edit">
                                    <div class="form-group ">
                                        <label for="product_code" class="col-sm-2 control-label">Nombre:</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="contacto_edit" class="form-control" placeholder="Ingrese Nombre de contacto" ng-model="update.contacto" ng-change="update.contacto = (update.contacto | uppercase)">
                                        </div>
                                        <label for="model" class="col-sm-2 control-label">Departamento:</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="departamento_edit" class="form-control" placeholder="Ingrese departamento o cargo " ng-model="update.departamento" ng-change="update.departamento = (update.departamento | uppercase)">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="producto" class="col-sm-2 control-label">Teléfono:</label>

                                        <div class="col-sm-4">
                                            <input type="text" id="telefono_edit" class="form-control .uppercase" placeholder="Lada + número" ng-model="update.telefono" maxlength="15">
                                        </div>
                                        <label for="modelo" class="col-sm-2 control-label">Correo:<font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="correo_edit" class="form-control .uppercase" placeholder="Ingrese un correo valido" ng-model="update.correo">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <div class="col-sm-6">
                                            <div id="div_dropzone_file_empresa"></div> 
                                        </div>
                                    </div> -->
                                    
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane active" id="detalles_edit">
                                    <div class="form-group ">
                                        <label for="product_code" class="col-sm-2 control-label">Nombre Comercial: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="nombre_comercial_edit" class="form-control" placeholder="" ng-model="update.nombre_comercial" ng-change="update.nombre_comercial=(update.nombre_comercial|uppercase)">
                                        </div>
                                        <label for="model" class="col-sm-2 control-label">Razón Social: <font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="razon_social_edit" class="form-control" placeholder="" ng-model="update.razon_social" ng-change="update.razon_social=(update.razon_social|uppercase)">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="producto" class="col-sm-2 control-label">RFC: <font size="3" color="red">* </font> </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="rfc_receptor_edit" class="form-control" placeholder="" ng-model="update.rfc_receptor" ng-change="update.rfc_receptor=(update.rfc_receptor|uppercase)">
                                        </div>
                                        <label for="modelo" class="col-sm-2 control-label">Calle y Número: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="calle_edit" class="form-control" placeholder="" ng-model="update.calle" ng-change="update.calle=(update.calle|uppercase)">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="note" class="col-sm-2 control-label">Descripción</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control .uppercase" id="descripcion"></textarea>
                                        </div>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="unidad_medida" class="col-sm-2 control-label">Colonia: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="colonia_edit" class="form-control .uppercase" placeholder="" ng-model="update.colonia" ng-change="update.colonia=(update.colonia|uppercase)">
                                        </div>

                                        <label for="categoria" class="col-sm-2 control-label">Delegación/ Municipio: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="municipio_edit" class="form-control .uppercase" placeholder="" ng-model="update.municipio" ng-change="update.municipio=(update.municipio|uppercase)">
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        
                                        <label for="iva" class="col-sm-2 control-label">Pais: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control"
                                            ng-change="select_estado(1)" 
                                            ng-model="update.id_country" 
                                            ng-options="value.id as value.descripcion for (key, value) in datos.paises">
                                            <option value="">--Seleccione Opcion--</option>  
                                            </select>  
                                        </div>
                                        
                                        <label for="iva" class="col-sm-2 control-label">Estado: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control"
                                            ng-change="select_codigos(1)" 
                                            ng-model="update.id_estado" 
                                            ng-options="value.id as value.nombre for (key, value) in cmb_estados">
                                            <option value="">--Seleccione Opcion--</option>  
                                            </select>  
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="subtotal" class="col-sm-2 control-label">Código Postal: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control"
                                            chosen="codigo_postal" 
                                            ng-model="update.id_codigo" 
                                            ng-options="value.id as value.codigo_postal for (key, value) in cmb_codigos"> 
                                            <option value="">--Seleccione Opcion--</option> 
                                            </select>    
                                        </div>

                                        <label for="subtotal" class="col-sm-2 control-label">Servicio Comercial: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" 
                                            ng-model="update.id_servicio_comercial" 
                                            ng-options="value.id as value.nombre for (key, value) in datos.servicio_comercial">
                                            <option value="">--Seleccione Opcion--</option> 
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="subtotal" class="col-sm-2 control-label">Uso CFDI: </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" 
                                            ng-model="update.id_uso_cfdi" 
                                            ng-options="value.id as value.descripcion for (key, value) in datos.uso_cfdi">
                                                <option value="">--Seleccione Opcion--</option> 
                                            </select>
                                        </div>

                                        <label for="estatus" class="col-sm-2 control-label">Estatus</label>
                                        <div class="col-sm-4">
                                             <select class="form-control" 
                                            ng-model="update.estatus" 
                                            ng-options="value.id as value.nombre for (key, value) in cmb_estatus"> 
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
            <button type="button" class="btn btn-danger" data-fancybox-close> 
                <i class="fa fa-times-circle"></i> Cancelar
            </button>
            <button type="button" class="btn btn-primary" ng-click="update_register()" {{$update}}>
                <i class="fa fa-save"></i> Actualizar 
            </button>
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
                <input type="hidden" id="id_empresa">
                <input type="hidden" id="id_cliente">
                <div id="sucursal_empresa"></div>
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close>
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" ng-click="insert_permisos()" {{$insertar}}>
                        <i class="fa fa-save"></i> Registrar 
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>