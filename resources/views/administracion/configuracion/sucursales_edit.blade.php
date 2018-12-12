<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro de Sucursales</h3>
            </div>
            <div class="modal-body">

                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-3">Codigo: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="" ng-model="insert.codigo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Sucursal: </label>
                        <div class="col-sm-7">
                            <input type="text" id="departamento" class="form-control" placeholder="" ng-model="insert.sucursal">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Dirección: </label>
                        <div class="col-sm-7">
                            <textarea id="direccion" class="form-control" placeholder="" ng-model="insert.direccion"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" ng-model="insert.telefono">
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
                                                 <option value="" disabled selected >--Seleccione Opcion--</option>     
                                            </select>
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

<div class="" id="modal_edit_register" style="overflow-y:scroll; height:500px;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h3>Actualizacion Registro</h3>
            </div>

            <div class="modal-body">
                <!--Se crea el contenido de los datos que se solicitan-->
                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-3">Codigo: </label>
                        <div class="col-sm-7">
                            <input type="text" id="codigo" class="form-control" placeholder="" ng-model="update.codigo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Sucursal: </label>
                        <div class="col-sm-7">
                            <input type="text" id="sucursal" class="form-control" placeholder="" ng-model="update.sucursal">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Dirección: </label>
                        <div class="col-sm-7">
                            <textarea id="direccion" class="form-control" placeholder="" ng-model="update.direccion"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" ng-model="update.telefono">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="estatus" class="col-sm-3 control-label">Estatus: </label>
                            <div class="col-sm-7">
                                <select class="form-control"
                                 chosen
                                 width="'100%'" 
                                 ng-model="update.estatus" 
                                 ng-options="value.id as value.descripcion for (key, value) in cmb_estatus">
                                 <option value="" disabled selected >--Seleccione Opcion--</option>    
                                </select>
                            </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="update_register()" {{$update}}>
                        <i class="fa fa-save"></i> Actualizar 
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>