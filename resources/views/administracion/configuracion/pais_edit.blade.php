<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro Paises </h3>
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
                            <label class="control-label col-sm-3">Descripción:  </font> </label>
                            <div class="col-sm-7">
                                <textarea id="descripcion" class="form-control" placeholder="" ng-model="insert.descripcion"> </textarea>
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Formato Código Postal :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="formato_codigo_postal" class="form-control" placeholder="" ng-model="insert.formato_codigo_postal">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Formato Registro :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="formato_registro" class="form-control" placeholder="" ng-model="insert.formato_registro">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Validacion Registro :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="validacion_registro" class="form-control" placeholder="" ng-model="insert.validacion_registro">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Agrupaciones :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="agrupaciones" class="form-control" placeholder="" ng-model="insert.agrupaciones">
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
                <h3> Detalle Paises </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Clave:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre" class="form-control" placeholder="" ng-model="edit.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:  </font> </label>
                            <div class="col-sm-7">
                                <textarea id="descripcion" class="form-control" placeholder="" ng-model="edit.descripcion">
                                    </textarea>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Formato Código Postal :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="formato_codigo_postal" class="form-control" placeholder="" ng-model="edit.formato_codigo_postal">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Formato Registro :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="formato_registro" class="form-control" placeholder="" ng-model="edit.formato_registro">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Validacion Registro :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="validacion_registro" class="form-control" placeholder="" ng-model="edit.validacion_registro">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Agrupaciones :  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="agrupaciones" class="form-control" placeholder="" ng-model="edit.agrupaciones">
                            </div>

                        </div>
                        
                    </form>                
                
            </div>
                
                
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