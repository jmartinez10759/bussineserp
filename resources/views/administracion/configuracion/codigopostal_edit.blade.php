<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro Código Postal </h3>
            </div>
            <div class="modal-body">
                    <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Código Postal:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="codigo_postal" class="form-control" placeholder="" ng-model="insert.codigo_postal">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Estado :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="estado" class="form-control" placeholder="" ng-model="insert.estado">
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Municipio :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="municipio" class="form-control" placeholder="" ng-model="insert.municipio">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Localidad :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="localidad" class="form-control" placeholder="" ng-model="insert.localidad">
                            </div>

                        </div>
                    </form>                
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="insert_register()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
</div>

<div class="" id="modal_edit_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Detalle Código Postal </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Código Postal:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="codigo_postal" class="form-control" placeholder="" ng-model="edit.codigo_postal">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Estado :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="estado" class="form-control" placeholder="" ng-model="edit.estado">
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Municipio :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="municipio" class="form-control" placeholder="" ng-model="edit.municipio">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Localidad :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="localidad" class="form-control" placeholder="" ng-model="edit.localidad">
                            </div>

                        </div>
                    </form>                
                
                
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="update_register()" {{$insertar}}><i class="fa fa-save"></i> Actualizar </button> 
                </div>
            </div>

        </div>
    </div>
</div>