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
                        <div class="col-sm-8">
                            <input type="text" class="form-control has-feedback-left" ng-model="insert.name" style="text-transform: uppercase;" placeholder="Nombre Completo">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_2}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control has-feedback-left" ng-model="insert.email" placeholder="Ingresa correo">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_8}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control has-feedback-left" ng-model="insert.username" placeholder="Ingresa correo">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_3}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-8">
                            <input type="password" class="form-control has-feedback-left" ng-model="insert.password" placeholder="Ingrese contraseña">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_4}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-8">
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
                        <div class="col-sm-8">
                            <select class="form-control"
                                    chosen
                                    width="'100%'"
                                    multiple
                                    data-live-search="true"
                                    ng-model="insert.id_empresa"
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
                        <div class="col-sm-8">
                            <div id="div_sucursales">
                                <select class="form-control"
                                        chosen
                                        width="'100%'"
                                        ng-model="insert.id_sucursal"
                                        ng-options="value.id as value.descripcion for (key, value) in cmbGroup">
                                    <option value="">--Seleccione Opcion--</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_5}} </label>
                        </div>
                        <div class="col-sm-8">
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
                                        ng-options="value.id as value.sucursal for (key, value) in cmbGroupsEdit">
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

<div id="modal_permisos" style="display:none;">

    <div class="row">
        <div class="col-sm-12">
            <div class="col-sm-3">
                <label> Usuario: </label>
                <div id="content_users_permisos"></div>
            </div>
            <div class="col-sm-3">
                <label> Roles: </label>
                <div id="content_roles_permisos"></div>
            </div>
            <div class="col-sm-3">
                <label> Empresas: </label>
                <div id="content_empresas_permisos"></div>
            </div>
            <div class="col-sm-3">
                <label> Surcursales: </label>
                <div id="content_sucursales_permisos"></div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="pull-right">
            <form class="form-inline">
                <input class="form-control" type="text" placeholder="Buscar..." aria-label="Search" onkeyup="buscador_general(this,'#datatable_permisos')" />
            </form>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="container">
            <div id="content_menus_permisos"></div>
        </div>
    </div>
    <br>
    <div class="modal-footer">
        <div class="btn-toolbar pull-right">
            <!-- <button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-times-circle"></i> Cancelar
            </button> -->
            <!-- {{$insertar}} -->
            <button type="button" class="btn btn-primary" v-on:click.prevent="register_permisos()">
                <i class="fa fa-save"></i> Guardar
            </button>
        </div>
    </div>

</div>

<div class="" id="modal_asignar_acciones" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Asignar Acciones</h3>
            </div>
            <div class="modal-body">
                <div id="content_acciones"></div>
                <input type="hidden" id="inp_menus_permisos">
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click.prevent="register_acciones()" {{$insertar}}><i class="fa fa-save"></i> Guardar </button>
                </div>
            </div>

        </div>
    </div>
</div>