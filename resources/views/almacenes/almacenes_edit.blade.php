<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro Almacén </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="" ng-model="insert.nombre"  capitalize>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Entradas: </label>
                        <div class="col-sm-7">
                            <input type="text" id="departamento" class="form-control" placeholder="" ng-model="insert.entradas">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Salidas: </label>
                        <div class="col-sm-7">
                            <input type="text" id="direccion" class="form-control" placeholder="" ng-model="insert.salidas">
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
                    <button type="button" class="btn btn-primary" ng-click="insert_register()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
</div>

<div class="" id="modal_edit_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Detalle Almacén </h3>
            </div>
            <div class="modal-body" >
                <form class="form-horizontal">

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="" ng-model="update.nombre"  capitalize>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Entradas: </label>
                        <div class="col-sm-7">
                            <input type="text" id="departamento" class="form-control" placeholder="" ng-model="update.entradas">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Salidas: </label>
                        <div class="col-sm-7">
                            <input type="text" id="direccion" class="form-control" placeholder="" ng-model="update.salidas">
                        </div>
                    </div>

                    

                    <div class="form-group">
                    <label for="estatus" class="col-sm-3 control-label">Estatus: </label>
                                        <div class="col-sm-7">
                                            <select class="form-control select_chosen"
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
                    <button type="button" class="btn btn-primary" ng-click="update_register()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
</div>

<div class="" id="permisos" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Asigne Sucursales </h3>
            </div>
            <div class="modal-body">
                <input type="hidden" id="id_empresa">
                <input type="hidden" id="id_almacen">
                <input type="hidden" id="id_producto" >
                <div id="sucursal_empresa"></div>
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close>
                        <i class="fa fa-times-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-primary" ng-click="insert_permisos()" {{$insertar}}>
                        <i class="fa fa-save"></i> Registrar 
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
<input type="hidden" id="id_almacen" /> 
<div class="" id="modal_asing_producto" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Listado de Productos</h3>
            </div>
            <div class="modal-body">
                {!! $data_table_producto !!}
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="save_asign_producto()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
</div>