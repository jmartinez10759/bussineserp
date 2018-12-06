<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro Monedas </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                   
                    <div class="form-group">
                        <label class="control-label col-sm-3">Moneda: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Moneda" ng-model="insert.nombre">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Descripción: </label>
                        <div class="col-sm-7">
                            <textarea id="descripcion" class="form-control" ng-model="insert.descripcion"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                         <label for="estatus" class="col-sm-3 control-label">Estatus: </label>
                                        <div class="col-sm-7">
                                            <select class="form-control select_chosen"
                                                 chosen
                                                 width="'100%'" 
                                                 ng-model="insert.estatus" 
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
<div id="modal_edit_register" style="display:none;">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Detalle Monedas </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                   
                    <div class="form-group">
                        <label class="control-label col-sm-3">Moneda: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Moneda" ng-model="update.nombre">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Descripción: </label>
                        <div class="col-sm-7">
                            <textarea id="descripcion" class="form-control" ng-model="update.descripcion"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                         <label for="estatus" class="col-sm-3 control-label">Estatus: </label>
                                        <div class="col-sm-7">
                                            <select class="form-control select_chosen"
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
                    <button type="button" class="btn btn-primary" ng-click="update_register()" {{$update}}><i class="fa fa-save"></i> Actualizar </button> 
                </div>
            </div>

        </div>
    </div>
</div>