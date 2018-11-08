<!-- <div class="" id="modal_add_registers" style="display:none;">
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
                            
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Giro Comercial: </label>
                        <div class="col-sm-7">
                            
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
 -->
<!-- esta es la vista que se utilizara para el agregado de empresas -->
<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Registro de Empresas </h3>
            </div>
            <div class="modal-body">

                <section class="content">
                    <div class="row">
                        <div class="col-md-3">
                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <div id="load_img">
                                        <img class=" img-responsive" src="" alt="Bussines profile picture">
                                    </div>

                                    <div class="col-sm-12">
                                    </div>
                                    <input type="text" class="form-control" id="logo" v-model="insert.logo">
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <form class="form-horizontal">

                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">

                                        <li class="active">
                                            <a href="#detalles" data-toggle="tab" aria-expanded="false">
                                                Detalles de Facturación
                                            </a>
                                        </li>

                                        <li class="">
                                            <a href="#contactos" data-toggle="tab" aria-expanded="false">
                                                Detalles del Contacto
                                            </a>
                                        </li>


                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane" id="contactos">
                                            <div class="form-group ">
                                                <label for="product_code" class="col-sm-2 control-label">Nombre:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="contacto" class="form-control" placeholder="Ingrese Nombre de contacto" v-model="newKeep.contacto">
                                                </div>
                                                <label for="model" class="col-sm-2 control-label">Departamento:</label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="departamento" class="form-control" placeholder="Ingrese departamento o cargo " v-model="newKeep.departamento">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="producto" class="col-sm-2 control-label">Teléfono:</label>

                                                <div class="col-sm-4">
                                                    <input type="text" id="telefono" class="form-control" placeholder="Lada + número" v-model="newKeep.telefono" maxlength="15">
                                                </div>
                                                <label for="modelo" class="col-sm-2 control-label">Correo:<font size="3" color="red">* </font></label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="correo" class="form-control" placeholder="Ingrese un correo valido" v-model="newKeep.correo">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-6">
                                                    <div id="div_dropzone_file_empresa"></div> 
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane active" id="detalles">
                                            <div class="form-group ">
                                                <label for="product_code" class="col-sm-2 control-label">Nombre Comercial: </label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="nombre_comercial" class="form-control" placeholder="" v-model="newKeep.nombre_comercial">
                                                </div>
                                                <label for="model" class="col-sm-2 control-label">Razón Social: <font size="3" color="red">* </font></label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="razon_social" class="form-control" placeholder="" v-model="newKeep.razon_social">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="producto" class="col-sm-2 control-label">RFC: <font size="3" color="red">* </font> </label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="rfc_emisor" class="form-control" placeholder="" v-model="newKeep.rfc_emisor">
                                                </div>
                                                <label for="modelo" class="col-sm-2 control-label">Calle y Número: </label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="calle" class="form-control" placeholder="" v-model="newKeep.calle">
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label for="note" class="col-sm-2 control-label">Descripción</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" id="descripcion"></textarea>
                                                </div>
                                            </div> -->
                                            <div class="form-group">
                                                <label for="unidad_medida" class="col-sm-2 control-label">Colonia: </label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="colonia" class="form-control" placeholder="" v-model="newKeep.colonia">
                                                </div>

                                                <label for="categoria" class="col-sm-2 control-label">Delegación/ Municipio: </label>
                                                <div class="col-sm-4">
                                                    <input type="text" id="municipio" class="form-control" placeholder="" v-model="newKeep.municipio">
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                
                                                <label for="iva" class="col-sm-2 control-label">Pais: </label>
                                                <div class="col-sm-4">
                                                    {!! $paises !!}
                                                </div>
                                                
                                                <label for="iva" class="col-sm-2 control-label">Estado: </label>
                                                <div class="col-sm-4">
                                                    <div id="div_cmb_estados">
                                                        <select class="form-control" disabled="">
                                                            <option>Selecione Opcion</option>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                
                                                <label for="subtotal" class="col-sm-2 control-label">Código Postal: </label>
                                                <div class="col-sm-4">
                                                    <div id="div_cmb_codigos">
                                                        <select class="form-control" disabled="">
                                                            <option>Selecione Opcion</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <label for="iva" class="col-sm-2 control-label">Regimen Fiscal: </label>
                                                <div class="col-sm-4">
                                                    {!! $regimen_fiscal !!}
                                                </div>


                                            </div>

                                            <div class="form-group">
                                                <label for="subtotal" class="col-sm-2 control-label">Servicios: </label>
                                                <div class="col-sm-4">
                                                    {!! $giro_comercial !!}
                                                </div>

                                                <label for="estatus" class="col-sm-2 control-label">Estatus</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control" v-model="newKeep.estatus">
                                                        <option value="0">Baja</option>
                                                        <option value="1">Activo</option>
                                                    </select>
                                                </div>


                                            </div>

                                        </div>
                                        <!-- /.tab-pane -->



                                    </div>
                                    <!-- /.tab-content -->
                                </div>
                                <!-- /.nav-tabs-custom -->
                            </form>

                        </div>
                        <!-- /.col -->
                    </div>

                </section>

            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click.prevent="insert_register()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button>
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
