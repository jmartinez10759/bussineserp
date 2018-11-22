<div  id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro Categoria Productos </h3>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                   <form class="form-horizontal">
                        <div class="form-group">
                            <label  class="col-sm-3 control-label">Nombre:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" placeholder="Ingrese Nombre de la categoria" ng-model="insert.nombre" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Detalles:  </font> </label>
                            <div class="col-sm-7">
                               <input type="text" id="descripcion" class="form-control" placeholder="" ng-model="insert.detalles">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Estatus: </label>
                            <div class="col-sm-7">
                                <select class="form-control" ng-model="insert.estatus">
                                    <option value="0">Baja</option>
                                    <option value="1">Activo</option>
                                </select>
                            </div>
                        </div>
                    </form>                
                    
                </div>
            </div>
        </div>
                
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="insert_register()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>
    
</div>

<div  id="modal_edit_register" style="display:none;">
            <div class="modal-header">
                <h3> Detalles Categoria Productos </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                        <div class="form-group">
                            <label  class="col-sm-3 control-label">Nombre:</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control" placeholder="Ingrese Nombre de la categoria" ng-model="edit.nombre" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Detalles:  </font> </label>
                            <div class="col-sm-7">
                               <input type="text" id="descripcion" class="form-control" placeholder="" ng-model="edit.detalles">
                            </div> 
                        </div>
                        <div class="form-group">
                            <label for="estatus" class="col-sm-3 control-label">Estatus</label>
                                        <div class="col-sm-7">
                                             <select class="form-control"
                                             chosen
                                             width="'100%'" 
                                             ng-model="edit.estatus" 
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