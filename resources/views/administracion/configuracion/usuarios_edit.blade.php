<!-- <div class="modal fade" id="modal_add_register" role="dialog" aria-hidden="true"> -->
<div id="modal_add_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>{{$titulo_modal}}</h3>
            </div>

            <div class="modal-body panel-body">
                <!--Se crea el contenido de los datos que se solicitan-->
                <form action="" class="form-horizontal row-border panel panel-body">

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{ $campo_1 }}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control has-feedback-left" ng-model="insert.name" style="text-transform: uppercase;" placeholder="Nombre Completo">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_2}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control has-feedback-left" ng-model="insert.email" placeholder="Ingresa correo">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_8}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control has-feedback-left" ng-model="insert.username" placeholder="Ingresa correo">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_3}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control has-feedback-left" ng-model="insert.password" placeholder="Ingrese contraseña">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_4}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="insert.id_rol"
                                    ng-options="value.id as value.perfil for (key, value) in cmbRoles">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_6}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    multiple
                                    ng-model="insert.id_empresa"
                                    ng-change="findGroupOfCompany(insert.id_empresa)"
                                    ng-options="value.id as value.razon_social for (key, value) in cmbCompanies">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_7}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    multiple
                                    ng-model="insert.id_sucursal"
                                    ng-options="value.groups.id as value.groups.descripcion for (key, value) in cmbGroups">
                                <option value="">--Seleccione Opción--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_5}} </label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control"
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
                    <button type="button" class="btn btn-danger" data-fancybox-close><i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type= "button" class="btn btn-success" ng-click="insertRegister()" ng-if="permisos.INS">
                        <i class="fa fa-save"></i> Registrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_edit_register" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h3>{!! $titulo_modal_edit !!}</h3>
            </div>

            <div class="modal-body panel-body">
                <form action="" class="form-horizontal row-border panel panel-body">

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_1}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control has-feedback-left" ng-model="update.name" style="text-transform: uppercase;" placeholder="Nombre Completo">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_2}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">

                            <input type="text" class="form-control has-feedback-left" ng-model="update.email" placeholder="Ingresa correo" disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_8}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control has-feedback-left" ng-model="update.username" placeholder="Ingrese username">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_3}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input type="password" class="form-control has-feedback-left" ng-model="update.password" placeholder="Ingrese contraseña">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_4}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="update.id_rol"
                                    ng-options="value.id as value.perfil for (key, value) in cmbRoles">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_6}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    multiple
                                    ng-model="update.id_empresa"
                                    ng-change="findGroupOfCompany(update.id_empresa)"
                                    ng-options="value.id as value.razon_social for (key, value) in cmbCompanies">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_7}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <div id="div_edit_sucursales">
                                <select class="form-control"
                                        chosen
                                        width="'100%'"
                                        multiple
                                        ng-model="update.id_sucursal"
                                        ng-options="value.groups.id as value.groups.descripcion for (key, value) in cmbGroups">
                                    <option value="">--Seleccione Opcion--</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_5}} </label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control"
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type= "button" class="btn btn-primary" ng-click="updateRegister()" ng-if="permisos.UPD" >
                        <i class="fa fa-save"></i> Actualizar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="modal_permission_user" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h3>Asignar Permisos del Usuario </h3>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-3">
                            <label> Roles: </label>
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="permission.rolesId"
                                    ng-disabled="true"
                                    ng-options="value.id as value.perfil for (key, value) in permission.cmbRoles">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label> Empresas: </label>
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="permission.companyId"
                                    ng-change="findByUserGroupOfCompany(permission.companyId)"
                                    ng-options="value.id as value.razon_social for (key, value) in permission.cmbCompanies">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label> Surcursales: </label>
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    ng-model="permission.groupsId"
                                    ng-change="findPermissionMenuByUser(permission.groupsId)"
                                    ng-options="value.id as value.sucursal for (key, value) in permission.cmbGroups">
                                <option value="">--Seleccione Opcion--</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-body panel-body" style="overflow-y:scroll; height:450px;">

                <div class="row">
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default" ng-repeat="menus in permission.TblMenus">
                                <div class="panel-heading">
                                    <div>
                                        <a data-toggle="collapse" data-parent="#accordion" href="#@{{ menus.id }}" ng-bind="menus.texto"></a>
                                        <div class="material-switch pull-right">
                                            <input id="menusFather_@{{ menus.id }}" type="checkbox" ng-model="permission.dataChecked[menus.id]" ng-disabled="permission.disabledCheck"/>
                                            <label for="menusFather_@{{ menus.id }}" class="label-primary"></label>
                                        </div>

                                    </div>

                                </div>

                                <div id="@{{ menus.id }}" class="panel-collapse collapse">
                                    <div style="overflow-y:scroll; height:200px;">

                                        <div class="panel-body" ng-repeat="submenus in menus.submenus">
                                            <div class="col-sm-8" ng-bind="submenus.texto"></div>
                                            <div class="col-sm-2 pull-right">
                                                <button type="button" class="btn btn-primary btn-sm" ng-click="actionsMenuByUsers(submenus.id)" title="Asignar Acciones">
                                                    <i class="glyphicon glyphicon-wrench"></i>
                                                </button>
                                            </div>
                                            <div class="material-switch pull-right col-sm-2">
                                                <input id="submenu_@{{ submenus.id }}" type="checkbox" ng-model="permission.dataChecked[submenus.id]" ng-disabled="permission.disabledCheck"/>
                                                <label for="submenu_@{{ submenus.id }}" class="label-primary"></label>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type= "button" class="btn btn-success" ng-click="permissionUserRegister()" >
                        <i class="fa fa-save"></i> Asignar Permisos
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal_toAssign_action" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                    <h3>Asignar Acciones del Menu </h3>
            </div>
            <div class="modal-body" style="overflow-y:scroll; height:500px;">

                <div class="panel-body" ng-repeat="action in permission.TblAction">
                    <div class="col-sm-3" ng-bind="action.descripcion"></div>
                    <div class="material-switch pull-right col-sm-3">
                        <input id="action_@{{ action.id }}" type="checkbox" ng-model="actions.dataChecked[action.id]" />
                        <label for="action_@{{ action.id }}" class="label-info"></label>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type= "button" class="btn btn-success" ng-click="actionsUserRegister()" >
                        <i class="fa fa-save"></i> Guardar
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>