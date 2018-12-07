
<!-- seccion de notas -->
<div class="modal fade" id="modal_add_notas" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width:50%; height:100%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
				</button>
				<h3>Agregar Notas</h3>
			</div>

			<div class="modal-body panel-body">
				<!--Se crea el contenido de los datos que se solicitan-->
				 <form action="" class="form-horizontal row-border panel panel-body">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">Titulo <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="titulo" style="text-transform: capitalize;" v-model="newKeep.titulo">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">Asunto <font color="red" size="3"></font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="asunto" style="text-transform: capitalize;" v-model="newKeep.asunto">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">Notas <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<textarea class="form-control" v-model="newKeep.nota"></textarea>
						</div>
					</div>

				</form>
			</div>
			<div class="modal-footer">
				<div class="btn-toolbar pull-right">
					<button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Cancelar</button>
					<button type= "button" class="btn btn-primary" v-on:click.prevent="insert_notas()" {{$insertar}}><i class="fa fa-save"></i> Registrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- secciond de citas -->
<div class="modal fade" id="modal_add_citas" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width:60%; height:100%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
				</button>
				<h3>Agendar Citas</h3>
			</div>

			<div class="modal-body panel-body">
				<!--Se crea el contenido de los datos que se solicitan-->
				 <form action="" class="form-horizontal row-border panel panel-body">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">Nombre <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="nombre" style="text-transform: uppercase;" v-model="newKeep.nombre">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">Correo <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="correo" v-model="newKeep.correo">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">Estado <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">Fecha <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="fecha">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">Horario <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6 bootstrap-timepicker">
							<input type="text" class="form-control timepicker" id="horario">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">Notas <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<textarea class="form-control" id="cita" v-model="newKeep.cita"></textarea>
						</div>
					</div>

					<!-- <div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_2}} </label>
						</div>
						<div class="col-sm-6">
							<select class="form-control" name="" id="estatus" v-model="newKeep.estatus">
								<option value="1">ACTIVO</option>
								<option value="0">BAJA</option>
							</select>
						</div>
					</div> -->

				</form>
			</div>
			<div class="modal-footer">
				<div class="btn-toolbar pull-right">
					<button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Cancelar</button>
					<button type= "button" class="btn btn-primary" v-on:click.prevent="insert_cita()" {{$insertar}}><i class="fa fa-save"></i> Registrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- secciond de detalles -->
<div class="modal fade" id="modal_add_detalless" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width:80%; height:100%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
				</button>
				<center><h3>Detalles del Correo Recibido</h3></center>
			</div>

			<div class="modal-body panel-body">

        <center>
          <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable">
              <tr>
                  <td align="" valign="top" id="bodyCell">
                      <!-- BEGIN TEMPLATE // -->
                      <table border="0" cellpadding="0" cellspacing="0" id="templateContainer">

                          <tr>
                              <td align="" valign="top">
                                  <!-- BEGIN BODY // -->
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="templateBody">
                                        <tr>
                                            <td valign="top" class="bodyContent" mc:edit="body_content">
                                                <!-- <h1>Contacto registrado en Overhaulin.mx</h1> -->
                                          <p>Recibido: <strong>@{{ datos.created_at }}</strong></p>
                                            <ul>
                                              <li>Nombre: <strong>@{{datos.name}}</strong></li>
                                              <li>Apellidos: <strong>@{{datos.surname}}</strong></li>
                                              <li>Empresa: @{{datos.company_name}}</li>
                                              <li>Cargo: @{{datos.position_name}}</li>
                                              <p>Direcci&oacute;n @{{datos.street}}</p>
                                              <hr />
                                              <li>Pais: @{{datos.country_id}}</li>
                                              <li>Calle: @{{datos}}</li>
                                              <li>N&uacute;mero externo: @{{datos.external_number}}</li>
                                              <li>N&uacute;mero interno: @{{datos.internal_number}}</li>
                                              <li>Colonia: @{{datos.neighborhood}}</li>
                                              <li>Estado: @{{datos.state_name}}</li>
                                              <li>Ciudad: @{{datos}}</li>
                                              <li>C&oacute;digo Postal: @{{datos.postal_code}}</li>
                                              <li>Tel&eacute;fono fijo: @{{datos.phone_number}}</li>
                                              <li>Tel&eacute;fono celular: @{{datos}}</li>
                                              <li>E-Mail: @{{datos.email}}</li>
                                              <hr />
                                              <li>Marca: @{{datos.marca}} </li>
                                              <li>Modelo: @{{datos.modelo}} </li>
                                              <li>Año: @{{datos}} </li>

                                            </ul>
                                            <ul>
                                                <li> E-Mail: @{{datos.correo}}</li>
                                                <li> Asunto: @{{datos.asunto}}</li>
                                                <li></li>
                                            </ul>
                                            <h3>Mensaje:</h3>
                                            <div style="padding:10px;background-color:white;border-radius:4px;">
                                                <p v-html="datos.descripcion"></p>
                                            </div>

                                            </td>
                                        </tr>
                                    </table>
                                    <!-- // END BODY -->
                                </td>
                            </tr>
                        </table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </table>
        </center>

			</div>

      <div class="modal-footer">
				<div class="btn-toolbar pull-right">
					<button type= "button" class="btn btn-info" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Aceptar</button>
				</div>
			</div>
		</div>

	</div>
</div>
<!-- seccion de detalles del correo -->
<div class="modal fade" id="modal_add_detalles" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:90%; height:50%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
        </button>
        <strong style="font-size:180%">@{{datos.asunto}} </strong><span class="label label-primary"> {{$titulo}}</span>
      </div>

      <div class="modal-body panel-body">
            <!-- Main content -->
            <section class="content">
              <div class="row">

                <div class="col-md-12">
                  <div class="box box-primary" style="height:90%">
                    <!-- <div class="box-header with-border"></div> -->
                    <!-- /.box-header -->
                    <div class="box-body">
                      <div class="recibidos">

                          <div class="form-group">
                            <strong style="font-size:110%" v-if="datos.nombre">@{{datos.nombre}}</strong>
                            <strong style="font-size:110%" v-else>Nombre enviado</strong>
                            <p style="font-size:90%">< @{{datos.correo}} ></p>
                          </div>
                          <div class="form-group">
                            <strong style="font-size:70%" v-for="(users,key) in datos.usuarios"> @{{users.name}} @{{users.first_surname}} @{{users.second_surname}}</strong>
                            <p style="font-size:70%" v-for="(users,key) in datos.usuarios">< @{{users.email}} ></p>
                            <!-- <strong style="font-size:110%">Nombre Recibido</strong> -->
                          </div>
                          <div class="form-group">
                              <div class="panel panel-default">
                                <div class="panel-heading">Descripcion Mensaje</div>
                                <div class="panel-body" v-html="datos.descripcion"></div>
                              </div>
                          </div>

                      </div>

                      <div class="form-group mensaje" style="display:none;">
                          @include('administracion.correos.redaccion')
                      </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer ">
                      <div class="pull-right">
                        <button type="button" class="btn btn-danger recibidos" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Cancelar</button>
                        <button type="button" class="btn btn-primary recibidos" v-on:click.prevent="mostrar()"><i class="fa fa-mail-reply"></i> Responder</button>
                      </div>
                      <!-- <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button> -->
                    </div>
                    <!-- /.box-footer -->
                  </div>
                  <!-- /. box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </section>
            <!-- /.content -->
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
