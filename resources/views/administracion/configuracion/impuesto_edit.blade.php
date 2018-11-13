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
                                <input type="text" id="nombre" class="form-control" placeholder="" v-model="insert.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="descripcion" class="form-control" placeholder="" v-model="insert.descripcion">
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Retencion:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="retencion" class="form-control" placeholder="" v-model="insert.retencion">
                            </div>

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label input-sm">Traslado : </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control"  id="traslado" v-model="insert.traslado">
                </div>

                                           
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 control-label input-sm">Local Federal: </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control"  id="localfederal" v-model="insert.localfederal">
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
                <h3> Detalle Impuesto </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                        

                        <div class="form-group">
                            <label class="control-label col-sm-3">Clave:  </label>
                            <div class="col-sm-7">
                                <input type="text" id="nombre" class="form-control" placeholder="" v-model="edit.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="descripcion" class="form-control" placeholder="" v-model="edit.descripcion">
                            </div>

                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Retencion:   </label>
                            <div class="col-sm-7">
                                <input type="text" id="retencion" class="form-control" placeholder="" v-model="edit.retencion">
                            </div>

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label input-sm">Traslado : </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control"  id="traslado" v-model="edit.traslado">
                </div>

                                           
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 control-label input-sm">Local Federal: </label>
                <div class="col-sm-7">
                    <input type="text" class="form-control"  id="localfederal" v-model="edit.localfederal">
                </div> 
                        </div>
                    </form> 
                
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click.prevent="update_register()"><i class="fa fa-save"></i> Actualizar </button> 
                </div>
            </div>

        </div>
    </div>
</div>