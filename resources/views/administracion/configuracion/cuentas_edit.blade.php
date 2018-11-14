<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Registro de Cuentas</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">
                    <div>
                        <font size="4" color="green"> DATOS DE CUENTA </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="nombre_comercial" class="form-control" placeholder="" ng-model="insert.nombre_comercial">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Servicio: </label>
                        <div class="col-sm-7">
                            {!! $cmb_servicios!!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Empresas: </label>
                        <div class="col-sm-7">
                            {!! $cmb_empresas !!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Sucursales: </label>
                        <div class="col-sm-7" id="div_cmb_sucursales">
                             <select class="form-control" disabled>
                                <option value="0">Seleccione Opcion</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Clientes Asignados: </label>
                        <div class="col-sm-7" id="div_cmb_clientes_asignados">
                             <select class="form-control" disabled>
                                <option value="0">Seleccione Opcion</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Cliente Principal: </label>
                        <div class="col-sm-7" id="div_cmb_clientes">
                             <select class="form-control" disabled>
                                <option value="0">Seleccione Opcion</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Contacto Principal: </label>
                        <div class="col-sm-7" id="div_cmb_contactos">
                            <select class="form-control" disabled>
                                <option value="0">Seleccione Opcion</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estatus: </label>
                        <div class="col-sm-7">
                            <select class="form-control" ng-model="insert.estatus">
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
                    <button type="button" class="btn btn-primary" ng-click="insert_register()" {{ $insertar }}><i class="fa fa-save"></i> Registrar </button>
                </div>
            </div>

        </div>
    </div>
</div>


<div id="modal_edit_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h3>Detalles de Cuentas</h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">

                    <div>
                        <font size="4" color="green"> DATOS DE CUENTA </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="nombre_comercial" class="form-control" placeholder="" ng-model="edit.nombre_comercial">
                        </div>

                    </div>
                    
                    <div class="form-group">
                         <label class="control-label col-sm-3">Servicio: </label>
                        <div class="col-sm-7">
                            {!! $cmb_servicios_edit!!}
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label class="control-label col-sm-3">Empresas: </label>
                        <div class="col-sm-7">
                            {!! $cmb_empresas_edit !!}
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Sucursales: </label>
                        <div class="col-sm-7" id="div_cmb_sucursales_edit">
                             <select class="form-control" disabled>
                                <option value="0">Seleccione Opcion</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Clientes Asignados: </label>
                        <div class="col-sm-7" id="div_cmb_clientes_asignados_edit">
                             <select class="form-control" disabled>
                                <option value="0">Seleccione Opcion</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Cliente Principal: </label>
                        <div class="col-sm-7" id="div_cmb_clientes_edit">
                             <select class="form-control" disabled>
                                <option value="0">Seleccione Opcion</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Contacto Principal: </label>
                        <div class="col-sm-7" id="div_cmb_contactos_edit">
                            <select class="form-control" disabled>
                                <option value="0">Seleccione Opcion</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estatus: </label>
                        <div class="col-sm-7">
                            <select class="form-control" id="cmb_estatus_edit">
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
                    <button type="button" class="btn btn-info" ng-click="update_register()" {{$update}}>
                        <i class="fa fa-save"></i> Actualizar
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!--<div class="modal fade" id="modal_sucusales_register" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                </button>
                <h3>Asignacion de Sucursales</h3>
            </div>

            <div class="modal-body panel-body">
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" v-on:click.prevent="insert_empresas()" {{$insertar}}>
                        <i class="fa fa-save"></i> Guardar Sucursales
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>-->