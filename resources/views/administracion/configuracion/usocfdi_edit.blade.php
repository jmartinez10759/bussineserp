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
                                <input type="text" id="nombre" class="form-control" placeholder="" v-model="insert.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="descripcion" class="form-control" placeholder="" v-model="insert.descripcion">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Fisica:  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="fisica" class="form-control" placeholder="" v-model="insert.fisica">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Moral:  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="moral" class="form-control" placeholder="" v-model="insert.moral">
                            </div>

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label input-sm">Fecha Inicio </label>
                <div class="col-sm-7">
                    <input type="date" class="form-control fecha"  id="fecha_inicial" v-model="insert.fecha_inicio_vigencia">
                </div>

                                           
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 control-label input-sm">Fecha Final </label>
                <div class="col-sm-7">
                    <input type="date" class="form-control fecha"  id="fecha_final" v-model="insert.fecha_final_vigencia">
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
                                <input type="text" id="nombre" class="form-control" placeholder="" v-model="edit.clave">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Descripción:  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="descripcion" class="form-control" placeholder="" v-model="edit.descripcion">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Fisica:  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="fisica" class="form-control" placeholder="" v-model="edit.fisica">
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">Moral:  </font> </label>
                            <div class="col-sm-7">
                                <input type="text" id="moral" class="form-control" placeholder="" v-model="edit.moral">
                            </div>

                        </div>
                        <div class="form-group">
                        <label  class="col-sm-3 control-label input-sm">Fecha Inicio </label>
                <div class="col-sm-7">
                    <input type="date" class="form-control fecha"  id="fecha_inicial" v-model="edit.fecha_inicio_vigencia">
                </div>

                                           
                        </div>
                        <div class="form-group">
                            <label  class="col-sm-3 control-label input-sm">Fecha Final </label>
                <div class="col-sm-7">
                    <input type="date" class="form-control fecha"  id="fecha_final" v-model="edit.fecha_final_vigencia">
                </div> 
                        </div>                    


                    </form>                 
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click.prevent="update_register()"><i class="fa fa-save"></i> Actualizar </button> 
                </div>
            </div>

        </div>
    </div>
</div>