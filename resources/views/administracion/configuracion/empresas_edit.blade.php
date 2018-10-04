<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Registro de Empresas</h3>
            </div>
            <div class="modal-body" style="overflow-y: scroll; height: 500px;">
                <form class="form-horizontal">

                    <div>
                        <font size="4" color="green"> DATOS DE CONTACTO </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" v-model="newKeep.contacto">
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-sm-3">Departamento: </label>
                        <div class="col-sm-7">
                            <input type="text" id="departamento" class="form-control" placeholder="Ingrese departamento o cargo " v-model="newKeep.departamento">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" v-model="newKeep.telefono">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Correo: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="correo" class="form-control" placeholder="Ingrese un correo valido" v-model="newKeep.correo">
                        </div>

                    </div>

                    <div>
                        <font size="4" color="green"> DATOS DE FACTURACIÓN </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="nombre_comercial" class="form-control" placeholder="" v-model="newKeep.nombre_comercial">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Razón social: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="razon_social" class="form-control" placeholder="" v-model="newKeep.razon_social">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">RFC: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="rfc_emisor" class="form-control" placeholder="" v-model="newKeep.rfc_emisor">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Calle y Número: </label>
                        <div class="col-sm-7">
                            <input type="text" id="calle" class="form-control" placeholder="" v-model="newKeep.calle">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Colonia: </label>
                        <div class="col-sm-7">
                            <input type="text" id="colonia" class="form-control" placeholder="" v-model="newKeep.colonia">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Delegación/Municipio: </label>
                        <div class="col-sm-7">
                            <input type="text" id="municipio" class="form-control" placeholder="" v-model="newKeep.municipio">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Código Postal: </label>
                        <div class="col-sm-7">
                            <input type="text" id="cp" class="form-control" placeholder="" maxlength="5" v-model="newKeep.cp">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estado: </label>
                        <div class="col-sm-7">
                            {!! $estados !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Giro Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="giro_comercial" class="form-control" placeholder="" v-model="newKeep.giro_comercial">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Estatus: </label>
                        <div class="col-sm-7">
                            <select class="form-control" v-model="newKeep.estatus">
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
                    <button type="button" class="btn btn-primary" v-on:click="insert()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button>
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
                <h3>Detalles de Empresas</h3>
            </div>
            <div class="modal-body" style="overflow-y: scroll; height: 500px;">
                <form class="form-horizontal">

                    <div>
                        <font size="4" color="green"> DATOS DE CONTACTO </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre: </label>
                        <div class="col-sm-7">
                            <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" v-model="fillKeep.contacto">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Departamento: </label>
                        <div class="col-sm-7">
                            <input type="text" id="departamento" class="form-control" placeholder="Ingrese departamento o cargo " v-model="fillKeep.departamento">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Teléfono: </label>
                        <div class="col-sm-7">
                            <input type="text" id="telefono" class="form-control" placeholder="Lada + número" v-model="fillKeep.telefono">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Correo: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="correo" class="form-control" placeholder="Ingrese un correo valido" v-model="fillKeep.correo">
                        </div>

                    </div>

                    <div>
                        <font size="4" color="green"> DATOS DE FACTURACIÓN </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Nombre Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="nombre_comercial" class="form-control" placeholder="" v-model="fillKeep.nombre_comercial">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Razón social: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="razon_social" class="form-control" placeholder="" v-model="fillKeep.razon_social">
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">RFC: <font size="3" color="red">* </font> </label>
                        <div class="col-sm-7">
                            <input type="text" id="rfc_receptor" class="form-control" placeholder="" v-model="fillKeep.rfc_emisor">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Calle y Número: </label>
                        <div class="col-sm-7">
                            <input type="text" id="calle" class="form-control" placeholder="" v-model="fillKeep.calle">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Colonia: </label>
                        <div class="col-sm-7">
                            <input type="text" id="colonia" class="form-control" placeholder="" v-model="fillKeep.colonia">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Delegación/Municipio: </label>
                        <div class="col-sm-7">
                            <input type="text" id="municipio" class="form-control" placeholder="" v-model="fillKeep.municipio">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-3">Código Postal: </label>
                        <div class="col-sm-7">
                            <input type="text" id="cp" class="form-control" placeholder="" maxlength="5" v-model="fillKeep.cp">
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estado: </label>
                        <div class="col-sm-7">
                            {!! $estados_edit !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Giro Comercial: </label>
                        <div class="col-sm-7">
                            <input type="text" id="giro_comercial" class="form-control" placeholder="" v-model="fillKeep.giro_comercial">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Estatus: </label>
                        <div class="col-sm-7">
                            <select class="form-control" v-model="fillKeep.estatus">
                                <option value="0">Baja</option>
                                <option value="1">Activo</option>
                            </select>
                        </div>
                    </div>



                </form>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-times-circle"></i> Cancelar
					</button>
                    <button type="button" class="btn btn-info" v-on:click="update()" {{$update}}>
                    <i class="fa fa-save"></i> Actualizar 
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal_sucusales_register" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
				</button>
				<h3>Asignacion de Sucursales</h3>
			</div>

			<div class="modal-body panel-body">
					{!! $data_table_sucursales !!}
			</div>
			<div class="modal-footer">
				<div class="btn-toolbar pull-right">
					<button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
            <i class="fa fa-times-circle"></i> Cancelar
					</button>
					<button type= "button" class="btn btn-success" v-on:click.prevent="insert_sucursales()" {{$insertar}}>
            <i class="fa fa-save"></i> Guardar Sucursales
          </button>
				</div>
			</div>
		</div>
	</div>
</div>
