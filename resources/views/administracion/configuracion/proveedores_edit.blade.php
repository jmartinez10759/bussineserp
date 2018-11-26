<div class="col-sm-12" id="modal_add_register" style="display:none;">
    <div class="modal-header">
                <h3> Registro de Proveedores </h3>
            </div>
  <div class="modal-body" style="overflow-y:scroll; height:500px;">

        <section class="content">
            <div class="row">
                
                <div class="col-md-12">
                    <form class="form-horizontal">

                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">

                                <li class="active">
                                    <a href="#detalles" data-toggle="tab" aria-expanded="false">
                                        Detalles de Proveedores
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
                                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" ng-model="insert.contacto" capitalize>
                                        </div>
                                        <label for="model" class="col-sm-2 control-label">Departamento:</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="departamento" class="form-control" placeholder="Ingrese departamento o cargo " ng-model="insert.departamento" capitalize>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="producto" class="col-sm-2 control-label">Teléfono:</label>

                                        <div class="col-sm-4">
                                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" ng-model="insert.telefono" maxlength="15">
                                        </div>
                                        
                                        <label for="modelo" class="col-sm-2 control-label">Correo:<font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="correo" class="form-control" placeholder="Ingrese un correo valido" ng-model="insert.correo">
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane active" id="detalles">
                                    <div class="form-group ">
                                        <label for="product_code" class="col-sm-2 control-label">Nombre Comercial: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="nombre_comercial" class="form-control" placeholder="" ng-model="insert.nombre_comercial" capitalize>
                                        </div>
                                        <label for="model" class="col-sm-2 control-label">Razón Social: <font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="razon_social" class="form-control" placeholder="" ng-model="insert.razon_social" capitalize>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="producto" class="col-sm-2 control-label">RFC: <font size="3" color="red">* </font> </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="rfc" class="form-control" placeholder="" ng-model="insert.rfc" capitalize>
                                        </div>
                                        <label for="modelo" class="col-sm-2 control-label">Calle y Número: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="calle" class="form-control" placeholder="" ng-model="insert.calle" capitalize>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="unidad_medida" class="col-sm-2 control-label">Colonia: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="colonia" class="form-control" placeholder="" ng-model="insert.colonia" capitalize>
                                        </div>

                                        <label for="categoria" class="col-sm-2 control-label">Delegación/ Municipio: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="municipio" class="form-control" placeholder="" ng-model="insert.municipio" capitalize>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        
                                        <label for="iva" class="col-sm-2 control-label">Pais:<font size="3" color="red">* </font> </label>
                                        <div class="col-sm-4">
                                            <select class="form-control"
                                            chosen
                                            width="'100%'" 
                                            ng-change="select_estado()" 
                                            ng-model="insert.id_country" 
                                            ng-options="value.id as value.descripcion for (key, value) in datos.paises">
                                            <option value="">--Seleccione Opcion--</option>  
                                            </select>  
                                        </div>
                                        
                                        <label for="iva" class="col-sm-2 control-label">Estado:<font size="3" color="red">* </font> </label>
                                        <div class="col-sm-4">
                                            <select class="form-control select_chosen"
                                            chosen
                                            width="'100%'" 
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
                                            <select class="form-control select_chosen"
                                            chosen
                                            width="'100%'"  
                                            ng-model="insert.id_codigo" 
                                            ng-options="value.id as value.codigo_postal for (key, value) in cmb_codigos"> 
                                            <option value="">--Seleccione Opcion--</option> 
                                            </select>    
                                        </div>

                                        <label for="subtotal" class="col-sm-2 control-label">Servicio Comercial: <font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <select class="form-control select_chosen"
                                            chosen
                                            width="'100%'" 
                                            ng-model="insert.id_servicio_comercial" 
                                            ng-options="value.id as value.nombre for (key, value) in datos.servicio_comercial">
                                            <option value="">--Seleccione Opcion--</option> 
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="iva" class="col-sm-2 control-label">Regimen Fiscal: <font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <select class="form-control select_chosen"
                                            chosen
                                            width="'100%'" 
                                            ng-model="insert.id_regimen_fiscal" 
                                            ng-options="value.id as value.descripcion for (key, value) in datos.regimen_fiscal"> 
                                            <option value="">--Seleccione Opcion--</option> 
                                            </select>    
                                        </div>

                                        <label for="estatus" class="col-sm-2 control-label">Estatus:<font size="3" color="red">* </label>
                                        <div class="col-sm-4">
                                            <select class="form-control select_chosen"
                                                 chosen
                                                 width="'100%'" 
                                                 ng-model="insert.estatus" 
                                                 ng-options="value.id as value.descripcion for (key, value) in cmb_estatus">
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
                        <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                        <button type="button" class="btn btn-primary" ng-click="insert_register()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button>
                    </div>
                </div>

</div>

    <div class="col-sm-12" id="modal_edit_register" style="display:none;">
        
                <div class="modal-header">
                    <h3>Detalles de Proveedores</h3>
                </div>
                <div class="modal-body" style="overflow-y:scroll; height:500px;">

        <section class="content">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="box box-primary">
                        <center>
                        <div class="box-body box-profile">
                            <div id="load_img" class="col-sm-12">
                                <div id="imagen_edit"></div>
                            </div>
                            <input type="hidden" class="form-control" ng-model="update.logo">
                        </div>
                        </center>
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
                                        Detalles de Proveedores
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
                                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" ng-model="update.contacto" capitalize>
                                        </div>
                                        <label for="model" class="col-sm-2 control-label">Departamento:</label>
                                        <div class="col-sm-4">
                                            <input type="text" id="departamento" class="form-control" placeholder="Ingrese departamento o cargo " ng-model="update.departamento" capitalize>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="producto" class="col-sm-2 control-label">Teléfono:</label>

                                        <div class="col-sm-4">
                                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" ng-model="update.telefono" maxlength="15">
                                        </div>
                                        
                                        <label for="modelo" class="col-sm-2 control-label">Correo:<font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="correo" class="form-control" placeholder="Ingrese un correo valido" ng-model="update.correo">
                                        </div>
                                    </div>
                                    
                                    
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane active" id="detalles_edit">
                                    <div class="form-group ">
                                        <label for="product_code" class="col-sm-2 control-label">Nombre Comercial: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="nombre_comercial" class="form-control" placeholder="" ng-model="update.nombre_comercial" capitalize>
                                        </div>
                                        <label for="model" class="col-sm-2 control-label">Razón Social: <font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <input type="text" id="razon_social" class="form-control" placeholder="" ng-model="update.razon_social" capitalize>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="producto" class="col-sm-2 control-label">RFC: <font size="3" color="red">* </font> </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="rfc" class="form-control" placeholder="" ng-model="update.rfc" capitalize>
                                        </div>
                                        <label for="modelo" class="col-sm-2 control-label">Calle y Número: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="calle" class="form-control" placeholder="" ng-model="update.calle" capitalize>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="unidad_medida" class="col-sm-2 control-label">Colonia: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="colonia" class="form-control" placeholder="" ng-model="update.colonia" capitalize>
                                        </div>

                                        <label for="categoria" class="col-sm-2 control-label">Delegación/ Municipio: </label>
                                        <div class="col-sm-4">
                                            <input type="text" id="municipio" class="form-control" placeholder="" ng-model="update.municipio" capitalize>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        
                                        <label for="iva" class="col-sm-2 control-label">Pais:<font size="3" color="red">* </font> </label>
                                        <div class="col-sm-4">
                                            <select class="form-control select_chosen"
                                            chosen
                                            ng-change="select_estado(1)" 
                                            ng-model="update.id_country" 
                                            ng-options="value.id as value.descripcion for (key, value) in datos.paises">
                                            <option value="">--Seleccione Opcion--</option>  
                                            </select>  
                                        </div>
                                        
                                        <label for="iva" class="col-sm-2 control-label">Estado: <font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <select class="form-control select_chosen"
                                            chosen
                                            ng-change="select_codigos(1)" 
                                            ng-model="update.id_estado" 
                                            ng-options="value.id as value.nombre for (key, value) in cmb_estados">
                                            <option value="">--Seleccione Opcion--</option>  
                                            </select>  
                                        </div>

                                    </div>

                                    <div class="form-group">

                                        <label for="subtotal" class="col-sm-2 control-label">Código Postal:</label>
                                        <div class="col-sm-4">
                                            <select class="form-control select_chosen"
                                            chosen 
                                            ng-model="update.id_codigo" 
                                            ng-options="value.id as value.codigo_postal for (key, value) in cmb_codigos"> 
                                            <option value="">--Seleccione Opcion--</option> 
                                            </select>    
                                        </div>

                                        <label for="subtotal" class="col-sm-2 control-label">Servicio Comercial:<font size="3" color="red">* </font> </label>
                                        <div class="col-sm-4">
                                            <select class="form-control select_chosen"
                                            chosen 
                                            ng-model="update.id_servicio_comercial" 
                                            ng-options="value.id as value.nombre for (key, value) in datos.servicio_comercial">
                                            <option value="">--Seleccione Opcion--</option> 
                                            </select>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        
                                        <label for="iva" class="col-sm-2 control-label">Regimen Fiscal:<font size="3" color="red">* </font> </label>
                                        <div class="col-sm-4">
                                            <select class="form-control select_chosen"
                                            chosen
                                            ng-model="update.id_regimen_fiscal" 
                                            ng-options="value.id as value.descripcion for (key, value) in datos.regimen_fiscal"> 
                                            <option value="">--Seleccione Opcion--</option> 
                                            </select>    
                                        </div>

                                        <label for="estatus" class="col-sm-2 control-label">Estatus: <font size="3" color="red">* </font></label>
                                        <div class="col-sm-4">
                                            <select class="form-control"
                                             chosen
                                             width="'100%'" 
                                             ng-model="update.estatus" 
                                             ng-options="value.id as value.descripcion for (key, value) in cmb_estatus">
                                             <option value="">--Seleccione Opcion--</option>   
                                            </select>
                                        </div>


                                    </div>
                                    <div class="form-group">

                                        <button type="button" class="btn btn-info" ng-click="upload_file(1)">
                                            <i class="fa fa-upload"></i> Subir Imagen  
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
                    <div class="btn-toolbar pull-right">
                        <button type= "button" class="btn btn-danger" data-fancybox-close>
                            <i class="fa fa-times-circle"></i> Cancelar
                        </button>
                        <button type="button" class="btn btn-info" ng-click="update_register()" {{$update}}>
                        <i class="fa fa-save"></i> Actualizar 
                        </button>
                    </div>
                </div>

</div>

    {{-- <div class="modal fade" id="modal_proveedores_register" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h3>Asignacion de Proveedores</h3>
                </div>

                <div class="modal-body panel-body">
                        {!! $data_table_proveedores !!}
                </div>  
                </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    {!! $button_insertar !!}
                </div>
            </div>

        </div>
</div>
    </div> --}}
    <div class="" id="upload_file" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Subir Imagen </h3>
            </div>
            <div class="modal-body">
                <div id="div_dropzone_file_proveedores"></div> 
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-success" data-fancybox-close>
                        <i class="fa fa-times-circle"></i> Aceptar
                    </button>
                    <!-- <button type="button" class="btn btn-primary" ng-click="insert_permisos()" {{$insertar}}>
                        <i class="fa fa-save"></i> Aceptar 
                    </button> -->
                </div>
            </div>

        </div>
    </div>
</div>


