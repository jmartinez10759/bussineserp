<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro Impuesto </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Clave:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre" class="form-control" placeholder="" ng-model="insert.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:   </label>
                            <div class="col-sm-7">
                                <textarea id="descripcion" class="form-control" placeholder="" ng-model="insert.descripcion"></textarea>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Retencion:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="retencion" class="form-control" placeholder="" ng-model="insert.retencion">
                            </div>

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label input-sm">Traslado : </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control"  id="traslado" ng-model="insert.traslado">
                </div>

                                           
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 control-label input-sm">Local Federal: </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control"  id="localfederal" ng-model="insert.localfederal">
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


<div class="" id="modal_edit_register"  style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Detalle Impuesto </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Clave:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre" class="form-control" placeholder="" ng-model="update.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:   </label>
                            <div class="col-sm-7">
                                <textarea id="descripcion" class="form-control" placeholder="" ng-model="update.descripcion">
                                    </textarea>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Retencion:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="retencion" class="form-control" placeholder="" ng-model="update.retencion">
                            </div>

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label input-sm">Traslado : </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control"  id="traslado" ng-model="update.traslado">
                </div>

                                           
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 control-label input-sm">Local Federal: </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control"  id="localfederal" ng-model="update.localfederal">
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