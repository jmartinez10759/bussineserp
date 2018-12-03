<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro Uso de CFDI </h3>
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
                            <label class="control-label col-sm-3">Fisica:  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="fisica" class="form-control" placeholder="" ng-model="insert.fisica">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Moral:  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="moral" class="form-control" placeholder="" ng-model="insert.moral">
                            </div>

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label input-sm">Fecha Inicio </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control fecha"  id="fecha_inicial" ng-model="insert.fecha_inicio_vigencia">
                </div>

                                           
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 control-label input-sm">Fecha Final </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control fecha"  id="fecha_final" ng-model="insert.fecha_final_vigencia">
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Detalle Uso de CFDI </h3>
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
                            <label class="control-label col-sm-3">Descripción:  </font> </label>
                            <div class="col-sm-7">
                                <textarea id="descripcion" class="form-control" placeholder="" ng-model="update.descripcion"> </textarea>
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Fisica:  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="fisica" class="form-control" placeholder="" ng-model="update.fisica">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Moral:  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="moral" class="form-control" placeholder="" ng-model="update.moral">
                            </div>

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label input-sm">Fecha Inicio </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control fecha"  id="fecha_inicial" ng-model="update.fecha_inicio_vigencia">
                </div>

                                           
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 control-label input-sm">Fecha Final </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control fecha"  id="fecha_final" ng-model="update.fecha_final_vigencia">
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