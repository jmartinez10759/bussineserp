<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro Monedas </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                   
                    <div class="form-group">
                        <label class="control-label col-sm-3">Moneda: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" v-model="insert.nombre">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Descripción: </label>
                        <div class="col-sm-7">
                            <textarea id="descripcion" class="form-control" v-model="insert.descripcion"></textarea>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Estatus: </label>
                        <div class="col-sm-7">
                           <select class="form-control" v-model="insert.estatus">
                               <option value="0">Baja</option>
                               <option value="1">Activo</option>
                           </select>
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