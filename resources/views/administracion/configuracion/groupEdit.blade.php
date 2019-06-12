<div class="modal fade" id="modal_add_register" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro de Datos</h3>
            </div>
            <div class="modal-body">

                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Codigo: </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" placeholder="" ng-model="insert.codigo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Sucursal: </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" placeholder="" ng-model="insert.sucursal">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Dirección: </label>
                        <div class="col-sm-7">
                            <textarea class="form-control" placeholder="" ng-model="insert.direccion"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" placeholder="Lada + número" ng-model="insert.telefono">
                        </div>

                    </div>

                    <div class="form-group" ng-if="userLogged == 1">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Empresas:     </label>
                        </div>
                        <div class="col-sm-7">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="insert.companyId"
                                    ng-options="value.id as value.razon_social for (key, value) in rootCmbCompanies">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Estatus: </label>
                        </div>
                        <div class="col-sm-7">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="insert.estatus"
                                    ng-options="value.id as value.descripcion for (key, value) in cmbEstatusRoot">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type= "button" class="btn btn-success" ng-click="insertRegister()" ng-if="permisos.INS">
                        <i class="fa fa-save"></i> Registrar
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="modal_edit_register" class="modal fade" >

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h3>Editar Registro</h3>
            </div>

            <div class="modal-body">

                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="control-label col-sm-3">Codigo: </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" placeholder="" ng-model="update.codigo">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Sucursal: </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" placeholder="" ng-model="update.sucursal">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Dirección: </label>
                        <div class="col-sm-7">
                            <textarea class="form-control" placeholder="" ng-model="update.direccion"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control" placeholder="Lada + número" ng-model="update.telefono">
                        </div>

                    </div>

                    <div class="form-group" ng-if="userLogged == 1">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Empresas</label>
                        </div>
                        <div class="col-sm-7">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="update.companyId"
                                    ng-options="value.id as value.razon_social for (key, value) in rootCmbCompanies">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Empresas: </label>
                        </div>
                        <div class="col-sm-7">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="update.estatus"
                                    ng-options="value.id as value.descripcion for (key, value) in cmbEstatusRoot">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">
                        <i class="fa fa-times-circle"></i> Cerrar
                    </button>
                    <button type= "button" class="btn btn-primary" ng-click="updateRegister()" ng-if="permisos.UPD" >
                        <i class="fa fa-save"></i> Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>