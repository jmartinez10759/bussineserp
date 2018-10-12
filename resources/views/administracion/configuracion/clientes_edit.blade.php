<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Registro de Prospectos</h3>
            </div>
            <div class="modal-body" style="overflow-y: scroll; height: 450px;">
                <form class="form-horizontal">

                    <div>
                        <font size="4" color="green"> DATOS DE CONTACTO </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" v-model="register.contacto">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-sm-3">Departamento: </label>
                        <div class="col-sm-7">
                            <input type="text" id="departamento" class="form-control" placeholder="Ingrese departamento o cargo " v-model="register.departamento">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" v-model="register.telefono">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Correo: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="correo" class="form-control" placeholder="Ingrese un correo valido" v-model="register.correo">
                        </div>

                    </div>

                    <div>
                        <font size="4" color="green"> DATOS DE FACTURACIÓN </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="nombre_comercial" class="form-control" placeholder="" v-model="register.nombre_comercial">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Razón social: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="razon_social" class="form-control" placeholder="" v-model="register.razon_social">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">RFC: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="rfc_receptor" class="form-control" placeholder="" v-model="register.rfc_receptor">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Calle y Número: </label>
                        <div class="col-sm-7">
                            <input type="text" id="calle" class="form-control" placeholder="" v-model="register.calle">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Colonia: </label>
                        <div class="col-sm-7">
                            <input type="text" id="colonia" class="form-control" placeholder="" v-model="register.colonia">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Delegación/Municipio: </label>
                        <div class="col-sm-7">
                            <input type="text" id="municipio" class="form-control" placeholder="" v-model="register.municipio">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Código Postal: </label>
                        <div class="col-sm-7">
                            <input type="text" id="cp" class="form-control" placeholder="" maxlength="5" v-model="register.cp">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estado: </label>
                        <div class="col-sm-7">
                            {!! $estados !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Giro Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="giro_comercial" class="form-control" placeholder="" v-model="register.giro_comercial">
                        </div>
                    </div>



                </form>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click="register_cliente()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="" id="modal_edit_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Registro de Prospectos</h3>
            </div>
            <div class="modal-body" style="overflow-y: scroll; height: 450px;">
                <form class="form-horizontal">

                    <div>
                        <font size="4" color="green"> DATOS DE CONTACTO </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto_edit" class="form-control" placeholder="Ingrese Nombre de contacto" v-model="edit.contacto">
                            <input type="hidden" v-model="edit.id">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-sm-3">Departamento: </label>
                        <div class="col-sm-7">
                            <input type="text" id="departamento_edit" class="form-control" placeholder="Ingrese departamento o cargo " v-model="edit.departamento">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" id="telefono_edit" class="form-control" placeholder="Lada + número" v-model="edit.telefono">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Correo: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="correo_edit" class="form-control" placeholder="Ingrese un correo valido" v-model="edit.correo">
                        </div>

                    </div>

                    <div>
                        <font size="4" color="green"> DATOS DE FACTURACIÓN </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="nombre_comercial_edit" class="form-control" placeholder="" v-model="edit.nombre_comercial">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Razón social: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="razon_social_edit" class="form-control" placeholder="" v-model="edit.razon_social">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">RFC: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="rfc_receptor_edit" class="form-control" placeholder="" v-model="edit.rfc_receptor">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Calle y Número: </label>
                        <div class="col-sm-7">
                            <input type="text" id="calle_edit" class="form-control" placeholder="" v-model="edit.calle">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Colonia: </label>
                        <div class="col-sm-7">
                            <input type="text" id="colonia_edit" class="form-control" placeholder="" v-model="edit.colonia">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Delegación/Municipio: </label>
                        <div class="col-sm-7">
                            <input type="text" id="municipio_edit" class="form-control" placeholder="" v-model="edit.municipio">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Código Postal: </label>
                        <div class="col-sm-7">
                            <input type="text" id="cp_edit" class="form-control" placeholder="" maxlength="5" v-model="edit.cp">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estado: </label>
                        <div class="col-sm-7">
                            {!! $estados_edit !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Giro Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="giro_comercial_edit" class="form-control" placeholder="" v-model="edit.giro_comercial">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estatus: </label>
                        <div class="col-sm-7">
                            <select class="form-control" id="cmb_estatus_edit">
                                <option value="0">Prospecto</option>
                                <option value="1">Cliente</option>
                            </select>
                        </div>
                    </div>



                </form>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click="update_cliente()" {{$update}}><i class="fa fa-save"></i> Actualizar </button>
                </div>
            </div>

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
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click.prevent="insert_permisos()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button>
                </div>
            </div>

        </div>
    </div>
</div>