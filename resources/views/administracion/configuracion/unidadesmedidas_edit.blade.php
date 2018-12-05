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
                                <input type="text" id="clave" class="form-control" placeholder="" ng-model="insert.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Nombre:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre" class="form-control" placeholder="" ng-model="insert.nombre">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="descripcion" class="form-control" placeholder="" ng-model="insert.descripcion">
                            </div>

                        </div>

                        
                        <div class="form-group">
                            <label for="estatus" class="col-sm-3 control-label">Estatus: </label>
                            <div class="col-sm-7">
                                <select class="form-control"
                                 chosen
                                 width="'100%'" 
                                 ng-model="update.estatus" 
                                 ng-options="value.id as value.descripcion for (key, value) in cmb_estatus">
                                 <option value="">--Seleccione Opcion--</option>   
                                </select>
                            </div>
                        </div>
                    </form>        
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="insert_register()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
</div>

<div class="" id="modal_edit_register" style="display:none;">
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
                                <input type="text" id="clave" class="form-control" placeholder="" ng-model="update.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Nombre:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre" class="form-control" placeholder="" ng-model="update.nombre">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="descripcion" class="form-control" placeholder="" ng-model="update.descripcion">
                            </div>

                        </div>

                        
                        <div class="form-group">
                            <label for="estatus" class="col-sm-3 control-label">Estatus: </label>
                            <div class="col-sm-7">
                                <select class="form-control"
                                 chosen
                                 width="'100%'" 
                                 ng-model="update.estatus" 
                                 ng-options="value.id as value.descripcion for (key, value) in cmb_estatus">
                                 <option value="">--Seleccione Opcion--</option>   
                                </select>
                            </div>
                        </div>
                    </form>                  
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="update_register()"><i class="fa fa-save"></i> Actualizar </button> 
                </div>
            </div>

        </div>
    </div>
</div>