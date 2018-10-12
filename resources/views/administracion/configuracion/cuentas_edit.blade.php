<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Registro de Cuentas</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">

                    <!--<div>
                        <font size="4" color="green"> DATOS DE CONTACTO </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" v-model="insert.contacto">
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

                    </div>-->

                    <div>
                        <font size="4" color="green"> DATOS DE CUENTA </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="nombre_comercial" class="form-control" placeholder="" v-model="insert.nombre_comercial">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Giro Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="giro_comercial" class="form-control" placeholder="" v-model="insert.giro_comercial">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Empresas: </label>
                        <div class="col-sm-7">
                            {!! $cmb_empresas !!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Clientes: </label>
                        <div class="col-sm-7">
                             <select class="form-control" disabled>
                                <option value="0">Seleccione Opcion</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Contactos: </label>
                        <div class="col-sm-7" id="div_contactos">
                            <select class="form-control" disabled>
                                <option value="0">Seleccione Opcion</option>
                            </select>
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
                <h3>Detalles de Cuentas</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
<!--

                    <div>
                        <font size="4" color="green"> DATOS DE CONTACTO </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" v-model="update.contacto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Departamento: </label>
                        <div class="col-sm-7">
                            <input type="text" id="departamento" class="form-control" placeholder="Ingrese departamento o cargo " v-model="update.departamento">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" v-model="update.telefono">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Correo: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="correo" class="form-control" placeholder="Ingrese un correo valido" v-model="update.correo">
                        </div>

                    </div>
-->

                    <div>
                        <font size="4" color="green"> DATOS DE CUENTA </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="nombre_comercial" class="form-control" placeholder="" v-model="update.nombre_comercial">
                        </div>

                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Giro Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="giro_comercial" class="form-control" placeholder="" v-model="update.giro_comercial">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estatus: </label>
                        <div class="col-sm-7">
                            <select class="form-control" v-model="update.estatus">
                                <option value="0">Baja</option>
                                <option value="1">Activo</option>
                            </select>
                        </div>
                    </div>



                </form>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-info" v-on:click="update()" {{$update}}>
                        <i class="fa fa-save"></i> Actualizar
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!--<div class="modal fade" id="modal_sucusales_register" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h3>Asignacion de Sucursales</h3>
            </div>

            <div class="modal-body panel-body">
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" v-on:click.prevent="insert_empresas()" {{$insertar}}>
                        <i class="fa fa-save"></i> Guardar Sucursales
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>-->