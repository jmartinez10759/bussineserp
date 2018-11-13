<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro de Proveedores </h3>
            </div>
                <div class="modal-body"style="overflow-y: scroll; height: 500px;">
                    <form class="form-horizontal">

                        <div>
                            <font size="4" color="green"> DATOS DE CONTACTO </font>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Nombre: </label>
                            <div class="col-sm-7">
                                <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" v-model=" insert.contacto">
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-sm-3">Departamento: </label>
                            <div class="col-sm-7">
                                <input type="text" id="departamento" class="form-control" placeholder="Ingrese departamento o cargo " v-model="insert.departamento">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Teléfono: </label>
                            <div class="col-sm-7">
                                <input type="text" id="telefono" class="form-control" placeholder="Lada + número" v-model="insert.telefono">
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Correo: <font size="3" color="red">* </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="correo" class="form-control" placeholder="Ingrese un correo valido" v-model="insert.correo">
                            </div>

                        </div>

                        <div>
                            <font size="4" color="green"> DATOS DE FACTURACIÓN </font>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Nombre Comercial: </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre_comercial" class="form-control" placeholder="" v-model="insert.nombre_comercial">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Razón social: <font size="3" color="red">* </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="razon_social" class="form-control" placeholder="" v-model="insert.razon_social">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">RFC: <font size="3" color="red">* </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="rfc" class="form-control" placeholder="" v-model="insert.rfc">
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Calle y Número: </label>
                            <div class="col-sm-7">
                                <input type="text" id="calle" class="form-control" placeholder="" v-model="insert.calle">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Colonia: </label>
                            <div class="col-sm-7">
                                <input type="text" id="colonia" class="form-control" placeholder="" v-model="insert.colonia">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Delegación/Municipio: </label>
                            <div class="col-sm-7">
                                <input type="text" id="municipio" class="form-control" placeholder="" v-model="insert.municipio">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Código Postal: </label>
                            <div class="col-sm-7">
                                <input type="text" id="cp" class="form-control" placeholder="" maxlength="5" v-model="insert.cp">
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
                                {!! $giro_comercial !!}
                                <!-- <input type="text" id="giro_comercial" class="form-control" placeholder="" v-model="insert.giro_comercial"> -->
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-3">Estatus: </label>
                            <div class="col-sm-7">
                                <select class="form-control" v-model="insert.estatus">
                                    <option value="0">Baja</option>
                                    <option value="1">Activo</option>
                                </select>
                            </div>
                        </div>
                        


                    </form>

                </div>
                <div class="modal-footer">
                    <div class="btn-toolbar pull-right">
                        <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                        <button type="button" class="btn btn-primary" v-on:click="insert_register()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_edit_register" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h3>Detalles de Proveedores</h3>
                </div>
                <div class="modal-body" style="overflow-y: scroll; height: 500px;">
                    <form class="form-horizontal">

                        <div>
                            <font size="4" color="green"> DATOS DE CONTACTO </font>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Nombre: </label>
                            <div class="col-sm-7">
                                <input type="text" id="contacto_edit" class="form-control" placeholder="Ingrese Nombre de contacto">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Departamento: </label>
                            <div class="col-sm-7">
                                <input type="text" id="departamento_edit" class="form-control" placeholder="Ingrese departamento o cargo " >
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Teléfono: </label>
                            <div class="col-sm-7">
                                <input type="text" id="telefono_edit" class="form-control" placeholder="Lada + número" >
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Correo: <font size="3" color="red">* </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="correo" class="form-control" placeholder="Ingrese un correo valido" v-model="edit.correo">
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
                                <input type="text" id="rfc_edit" class="form-control" placeholder="" v-model="edit.rfc">
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Calle y Número: </label>
                            <div class="col-sm-7">
                                <input type="text" id="calle_edit" class="form-control" placeholder=""{{--  v-model="edit.calle" --}}>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Colonia: </label>
                            <div class="col-sm-7">
                                <input type="text" id="colonia_edit" class="form-control" placeholder="" {{-- v-model="edit.colonia" --}}>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Delegación/Municipio: </label>
                            <div class="col-sm-7">
                                <input type="text" id="municipio_edit" class="form-control" placeholder="" {{-- v-model="edit.municipio" --}}>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Código Postal: </label>
                            <div class="col-sm-7">
                                <input type="text" id="cp_edit" class="form-control" placeholder="" maxlength="5" {{-- v-model="edit.cp" --}}>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Estado: </label>
                            <div class="col-sm-7">
                                {!! $estados_edit !!}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Giro Comercial : </label>
                            <div class="col-sm-7">
                                {{-- <input type="text" id="giro_comercial" class="form-control" placeholder="" v-model="edit.giro_comercial"> --}}
                                {!! $giro_comercial_edit !!}
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-3">Estatus: </label>
                            <div class="col-sm-7">
                                <select class="form-control" v-model="edit.estatus">
                                    <option value="0">Baja</option>
                                    <option value="1">Activo</option>
                                </select>
                            </div>
                        </div>



                    </form>

                </div>
                <div class="modal-footer">
                    <div class="btn-toolbar pull-right">
                        <button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                            <i class="fa fa-times-circle"></i> Cancelar
                        </button>
                        <button type="button" class="btn btn-info" v-on:click="update_register()" {{$update}}>
                        <i class="fa fa-save"></i> Actualizar 
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_proveedores_register" role="dialog" aria-hidden="true">
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
                    {{-- <button type="button" class="btn btn-primary" v-on:click.prevent="save_register()"><i class="fa fa-save"></i> Registrar </button>  --}}
                    {!! $button_insertar !!}
                </div>
            </div>

        </div>
    </div>
</div>