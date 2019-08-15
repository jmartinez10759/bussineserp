<!-- Modal add register-->
<div class="modal fullscreen-modal fade" id="modal_add_register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3> Registro de Empresas </h3>
            </div>
            <div class="modal-body">

                <section class="content">
                    <div class="row">
                        <div class="col-sm-12">
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
                                                    <input type="text" class="form-control" placeholder="Ingrese Nombre de contacto" ng-model="insert.contacto" capitalize>
                                                </div>
                                                <label for="model" class="col-sm-2 control-label">Departamento:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="Ingrese departamento o cargo " ng-model="insert.departamento" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="producto" class="col-sm-2 control-label">Teléfono:</label>

                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="Lada + número" ng-model="insert.telefono" minlength="15" maxlength="15" ng-pattern="/^(?:[0-9]\d*|\d)$/">
                                                </div>

                                                <label for="modelo" class="col-sm-2 control-label">Correo:<font size="3" color="red">* </font></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="Ingrese un correo valido" ng-model="insert.correo">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane active" id="detalles">
                                            <div class="form-group ">
                                                <label for="product_code" class="col-sm-2 control-label">Nombre Comercial: </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="" ng-model="insert.nombre_comercial" capitalize>
                                                </div>
                                                <label for="model" class="col-sm-2 control-label">Razón Social: <font size="3" color="red">* </font></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="" ng-model="insert.razon_social" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="producto" class="col-sm-2 control-label">RFC: <font size="3" color="red">* </font> </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="" ng-model="insert.rfc_emisor" capitalize ng-pattern="/^([a-zA-Z\u00f1\u00d1]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])([a-zA-Z\u00f1\u00d1]|[0-9]){2}([A]|[0-9]){1})?$/">
                                                </div>
                                                <label for="modelo" class="col-sm-2 control-label">Calle y Número: </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" ng-model="insert.calle" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Codigo Postal: </label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" placeholder="" ng-model="insert.postalCode" ng-keyup="actionCodePostal(insert.postalCode)">
                                                </div>

                                                <label for="iva" class="col-sm-2 control-label">Pais: </label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="insert.id_country"
                                                            ng-disabled="true"
                                                            ng-options="value.id as value.descripcion for (key, value) in cmbCountries">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group">

                                                <label for="iva" class="col-sm-2 control-label">Estado: </label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="insert.id_estado"
                                                            ng-disabled="true"
                                                            ng-options="value.id as value.estados for (key, value) in cmbStates">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                                <label for="subtotal" class="col-sm-2 control-label">Municipios/Alcadias: </label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="insert.id_municipay"
                                                            ng-options="value.idMunicipio as (value.municipio+' - '+value.asentamiento) for (key, value) in cmbMunicipalities">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>


                                            </div>

                                            <div class="form-group">

                                                <label for="iva" class="col-sm-2 control-label">Regimen Fiscal: </label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="insert.id_regimen_fiscal"
                                                            ng-options="value.id as (value.clave +' - '+value.descripcion) for (key, value) in cmbTaxRegime">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                                <label for="subtotal" class="col-sm-2 control-label">Giro Comercial: </label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="insert.id_servicio_comercial"
                                                            ng-options="value.id as value.nombre for (key, value) in cmbTradeService">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>


                                            </div>

                                            <div class="form-group">

                                                <label for="iva" class="col-sm-2 control-label">Iva</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="" ng-model="insert.iva">
                                                </div>

                                                <label for="estatus" class="col-sm-2 control-label">Estatus</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="insert.estatus"
                                                            ng-options="value.id as value.descripcion for (key, value) in cmbEstatusRoot">
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
                    <button-register method="insertRegister()" permission="permisos" spinning="spinning"></button-register>
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
                <h4 class="modal-title" id="myModalLabel"> Detalles de la Empresa</h4>
            </div>
            <div class="modal-body">

                <section class="content">
                    <div class="row">
                        <div class="col-sm-2">
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
                        <div class="col-md-10">
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
                                                    <input type="text"class="form-control" placeholder="Ingrese Nombre de contacto" ng-model="update.contacto" capitalize>
                                                </div>
                                                <label for="model" class="col-sm-2 control-label">Departamento:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="Ingrese departamento o cargo" ng-model="update.departamento" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="producto" class="col-sm-2 control-label">Teléfono:</label>

                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="Lada + número" ng-model="update.telefono" minlength="15" maxlength="15" ng-pattern="/^(?:[0-9]\d*|\d)$/">
                                                </div>
                                                <label for="modelo" class="col-sm-2 control-label">Correo:<font size="3" color="red">* </font></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="Ingrese un correo valido" ng-model="update.correo">
                                                </div>
                                            </div>

                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane active" id="detalles_edit">
                                            <div class="form-group ">
                                                <label for="product_code" class="col-sm-2 control-label">Nombre Comercial: </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="" ng-model="update.nombre_comercial" capitalize>
                                                </div>
                                                <label for="model" class="col-sm-2 control-label">Razón Social: <font size="3" color="red">* </font></label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="" ng-model="update.razon_social" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">RFC: <font size="3" color="red">* </font> </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="Ingresa RFC" ng-model="update.rfc_emisor" capitalize ng-pattern="/^([a-zA-Z\u00f1\u00d1]{3,4}([0-9]{2})(0[1-9]|1[0-2])(0[1-9]|1[0-9]|2[0-9]|3[0-1])([a-zA-Z\u00f1\u00d1]|[0-9]){2}([A]|[0-9]){1})?$/">
                                                </div>
                                                <label for="modelo" class="col-sm-2 control-label">Calle y Número: </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="" ng-model="update.calle" capitalize>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label">Codigo Postal: </label>
                                                <div class="col-sm-4">
                                                    <input type="number" class="form-control" placeholder="" ng-model="update.codigo" ng-keyup="actionCodePostal(update.codigo,true)" min="0">
                                                </div>

                                                <label for="country" class="col-sm-2 control-label">Pais: </label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="update.id_country"
                                                            ng-disabled="true"
                                                            ng-options="value.id as value.descripcion for (key, value) in cmbCountries">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">


                                                <label for="estado" class="col-sm-2 control-label">Estado: </label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="update.id_estado"
                                                            ng-disabled="true"
                                                            ng-options="value.id as value.estados for (key, value) in cmbStates">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                                <label for="subtotal" class="col-sm-2 control-label">Municipios/Alcadias: </label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="update.id_municipay"
                                                            ng-options="value.idMunicipio as (value.municipio+' - '+value.asentamiento) for (key, value) in cmbMunicipalities">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group">


                                                <label for="regimen_fiscal" class="col-sm-2 control-label">Regimen Fiscal: </label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="update.id_regimen_fiscal"
                                                            ng-options="value.id as (value.descripcion)  for (key, value) in cmbTaxRegime">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                                <label for="subtotal" class="col-sm-2 control-label">Giro Comercial: </label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="update.id_servicio_comercial"
                                                            ng-options="value.id as value.nombre for (key, value) in cmbTradeService">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>


                                            </div>

                                            <div class="form-group">

                                                <label for="iva" class="col-sm-2 control-label">Iva</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" placeholder="" ng-model="update.iva">
                                                </div>

                                                <label for="estatus" class="col-sm-2 control-label">Estatus</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control"
                                                            chosen
                                                            width="'100%'"
                                                            ng-model="update.estatus"
                                                            ng-options="value.id as value.descripcion for (key, value) in cmbEstatusRoot">
                                                        <option value="">--Seleccione Opcion--</option>
                                                    </select>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <div class="pull-left">
                                                    <button type="button" class="btn btn-warning" ng-click="fileUpload(true)" ng-if="permisos.UPL">
                                                        <i class="fa fa-upload"></i> Cargar Logo
                                                    </button>
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
                <button-update method="updateRegister()" permission="permisos" spinning="spinning"></button-update>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="upload_file" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Cargar Logo Empresa </h3>
            </div>
            <div class="modal-body">
                <div id="fileCompany"></div>
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true" >
                        <i class="fa fa-times-circle"></i> Cerrar
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>


