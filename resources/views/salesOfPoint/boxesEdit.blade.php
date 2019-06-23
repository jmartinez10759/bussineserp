
<div class="modal fade" id="modal_add_register" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3>Registro de Datos</h3>
            </div>
            <div class="modal-body panel-body">

                <form class="form-horizontal row-border panel panel-body">

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Nombre <font color="red" size="3">*</font></label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" ng-model="insert.name" capitalize>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Descripcion <font color="red" size="3">*</font></label>
                        </div>
                        <div class="col-sm-6">
                            <textarea class="form-control" ng-model="insert.description" capitalize></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Asignar </label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="insert.userId"
                                    ng-options="value.id as (value.name+' '+value.first_surname+' '+value.second_surname) for (key, value) in cmbUsers">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" ng-if="userLogged == 1">
                        <label class="col-sm-3 control-label">Empresas</label>
                        <div class="col-sm-6">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="insert.companyId"
                                    ng-change="getGroupByCompany(insert.companyId)"
                                    ng-options="value.id as value.razon_social for (key, value) in rootCmbCompanies">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" ng-if="userLogged == 1">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Sucursales</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="insert.groupId"
                                    multiple
                                    ng-options="value.groups.id as value.groups.descripcion for (key, value) in rootCmbGroups">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Estatus</label>
                        </div>
                        <div class="col-sm-6">
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
                    <button-register method="insertRegister()" permission="permisos" spinning="spinning"></button-register>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal_edit_register" class="modal fade" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Registros</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal row-border panel panel-body">

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Nombre <font color="red" size="3">*</font></label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" ng-model="update.name" capitalize>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Descripcion <font color="red" size="3">*</font></label>
                        </div>
                        <div class="col-sm-6">
                            <textarea class="form-control" ng-model="update.description" capitalize></textarea>
                        </div>
                    </div>

                    <div class="form-group" ng-if="userLogged == 1">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Empresas</label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    multiple
                                    ng-model="insert.companyId"
                                    ng-options="value.id as value.razon_social for (key, value) in rootCmbCompanies">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>

                        <div class="control-label">
                            <label class="col-sm-3 control-label">Sucursales</label>
                        </div>
                        <div class="col-sm-4">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="insert.groupId"
                                    multiple
                                    ng-options="value.groups.id as value.groups.descripcion for (key, value) in rootCmbGroups">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">Estatus</label>
                        </div>
                        <div class="col-sm-6">
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
                    <button-update method="updateRegister()" permission="permisos" spinning="spinning"></button-update>
                </div>
            </div>

        </div>
    </div>
</div>
