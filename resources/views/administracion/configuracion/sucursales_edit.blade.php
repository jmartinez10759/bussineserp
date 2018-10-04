<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro de Sucursales</h3>
            </div>
            <div class="modal-body">

                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-3">Codigo: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="" v-model="newKeep.codigo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Sucursal: </label>
                        <div class="col-sm-7">
                            <input type="text" id="departamento" class="form-control" placeholder="" v-model="newKeep.sucursal">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Dirección: </label>
                        <div class="col-sm-7">
                            <input type="text" id="departamento" class="form-control" placeholder="" v-model="newKeep.direccion">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" v-model="newKeep.telefono">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estatus: </label>
                        <div class="col-sm-7">
                            <select class="form-control" v-model="newKeep.estatus">
                                <option value="1">Activo</option>
                                <option value="0">Baja</option>
                            </select>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click.prevent="insert()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_register" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h3>Actualizacion Registro</h3>
            </div>

            <div class="modal-body">
                <!--Se crea el contenido de los datos que se solicitan-->
                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-3">Codigo: </label>
                        <div class="col-sm-7">
                            <input type="text" id="codigo" class="form-control" placeholder="" v-model="fillKeep.codigo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Sucursal: </label>
                        <div class="col-sm-7">
                            <input type="text" id="sucursal" class="form-control" placeholder="" v-model="fillKeep.sucursal">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Dirección: </label>
                        <div class="col-sm-7">
                            <input type="text" id="direccion" class="form-control" placeholder="" v-model="fillKeep.direccion">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" v-model="fillKeep.telefono">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estatus: </label>
                        <div class="col-sm-7">
                            <select class="form-control" v-model="fillKeep.estatus">
                                <option value="1">Activo</option>
                                <option value="0">Baja</option>
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
                    <button type="button" class="btn btn-info" v-on:click.prevent="update()" {{$update}}>
                        <i class="fa fa-save"></i> Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>