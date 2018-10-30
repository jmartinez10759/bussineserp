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
                            <label class="col-sm-3 control-label">{{$campo_1}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control has-feedback-left" v-model="newKeep.name" style="text-transform: uppercase;" placeholder="Nombre Completo">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_2}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <!-- <input type="text" class="form-control" id="email" v-model="newKeep.email"> -->
                            <input type="text" class="form-control has-feedback-left" v-model="newKeep.email" placeholder="Ingresa correo">
                            <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_3}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <!-- <input type="password" class="form-control" id="password" v-model="newKeep.password"> -->
                            <input type="password" class="form-control has-feedback-left" v-model="newKeep.password" placeholder="Ingrese contraseña">
                            <span class="fa fa-inbox form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_4}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            {!! $select_roles !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_6}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            {!! $select_empresas !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_7}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            <div id="div_sucursales">
                                <select class="form-control" disabled>
                                    <option>Selecciona una Opcion</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_5}} </label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control" name="" id="estatus" v-model="newKeep.estatus">
                                <option value="1">ACTIVO</option>
                                <option value="0">BAJA</option>
                            </select>
                        </div>
                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close><i class="fa fa-times-circle"></i> Cancelar</button>
                    {!! $button_insertar !!}
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

                            <input type="text" class="form-control has-feedback-left" v-model="fillKeep.name" style="text-transform: uppercase;" placeholder="Nombre Completo">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_2}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">

                            <input type="text" class="form-control has-feedback-left" v-model="fillKeep.email" placeholder="Ingresa correo" disabled>
                            <span class="fa fa-envelope form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_3}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">

                            <input type="password" class="form-control has-feedback-left" v-model="fillKeep.password" placeholder="Ingrese contraseña">
                            <span class="fa fa-inbox form-control-feedback left" aria-hidden="true"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_4}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            {!! $select_roles_edit !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_6}}
                                <font color="red" size="3">*</font>
                            </label>
                        </div>
                        <div class="col-sm-6">
                            {!! $select_empresas_edit !!}
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
                                <select class="form-control" name="" id="cmb_sucursal_edit" disabled="disabled">
                                    <option value="0">Todas las Sucursales</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="control-label">
                            <label class="col-sm-3 control-label">{{$campo_5}} </label>
                        </div>
                        <div class="col-sm-6">
                            <select class="form-control" name="" v-model="fillKeep.estatus">
                                <option value="1">ACTIVO</option>
                                <option value="0">BAJA</option>
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
                    {!! $button_update !!}
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