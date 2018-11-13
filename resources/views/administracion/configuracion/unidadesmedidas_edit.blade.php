<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro Unidad Medida </h3>
            </div>
            <div class="modal-body">
                        <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Clave:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="clave" class="form-control" placeholder="" v-model="insert.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Nombre:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre" class="form-control" placeholder="" v-model="insert.nombre">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="descripcion" class="form-control" placeholder="" v-model="insert.descripcion">
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
                    <button type="button" class="btn btn-primary" v-on:click.prevent="insert_register()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_register" role="dialog" aria-hidden="true" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Detalle Unidad Medida </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Clave:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="clave" class="form-control" placeholder="" v-model="edit.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Nombre:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre" class="form-control" placeholder="" v-model="edit.nombre">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="descripcion" class="form-control" placeholder="" v-model="edit.descripcion">
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click.prevent="update_register()"><i class="fa fa-save"></i> Actualizar </button> 
                </div>
            </div>

        </div>
    </div>
</div>