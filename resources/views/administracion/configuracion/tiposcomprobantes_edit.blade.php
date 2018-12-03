<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro de Tipos de Comprobantes </h3>
            </div>
            <div class="modal-body">
                    <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Nombre de Comprobante:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre" class="form-control" placeholder="" ng-model="insert.nombre">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción: </label>
                            <div class="col-sm-7">
                                <textarea id="descripcion" class="form-control" placeholder="" ng-model="insert.descripcion"> </textarea>
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
<div class="" id="modal_edit_register" style="display:none;">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Detalle de Tipos de Comprobantes </h3>
            </div>
            <div class="modal-body">
                    <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Nombre de Comprobante:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre" class="form-control" placeholder="" ng-model="update.nombre">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción: </label>
                            <div class="col-sm-7">
                                <textarea id="descripcion" class="form-control" placeholder="" ng-model="update.descripcion"></textarea>
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
                        </button>
                        <button type="button" class="btn btn-info" ng-click="update_register()" {{$update}}>
                        <i class="fa fa-save"></i> Actualizar 
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

   {{--  <div class="modal fade" id="modal_tiposComprobantes_register" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h3>Asignacion de Tipos de Comprobantes</h3>
                </div>

                <div class="modal-body panel-body">
                        {!! $data_table!!}
                </div>  
                </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    
                    {!! $button_insertar !!}
                </div>
            </div>

        </div>
    </div>
</div> --}}