<!-- seccion de correos  -->

<div class="modal fade" id="modal_add_correo" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width:90%; height:100%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
				</button>
				<h3>{{$titulo_modal}}</h3>
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
				              <div class="form-group">
				                <input type="text"class="form-control" placeholder="Para:" v-model="newKeep.emisor" id="emisor">
				              </div>
				              <div class="form-group">
				                <input type="text" class="form-control" placeholder="Asunto:" v-model="newKeep.asunto" id="asunto">
				              </div>
				              <div class="form-group">
			                   <textarea id="compose-textarea" class="form-control" style="height: 300px">
			                    </textarea>
				              </div>
				              <!-- <div class="form-group">
				                <div class="btn btn-default btn-file">
				                  <i class="fa fa-paperclip"></i> Attachment
				                  <input type="file" name="attachment">
				                </div>
				                <p class="help-block">Max. 32MB</p>
				              </div> -->
				            </div>
				            <!-- /.box-body -->
				            <div class="box-footer">
				              <div class="pull-right">
				                <button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Cancelar</button>
				                <button type="button" class="btn btn-primary" v-on:click.prevent="send_correo()"><i class="fa fa-envelope-o"></i> Enviar</button>
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
				<!-- <div class="btn-toolbar pull-right">
					<button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Cancelar</button>
					<button type= "button" class="btn btn-primary" v-on:click.prevent="insert()" ><i class="fa fa-save"></i> Registrar</button>
				</div> -->
			</div>
		</div>
	</div>
</div>

<!-- seccion de notas -->
<div class="modal fade" id="modal_add_notas" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg" style="width:50%; height:100%">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
				</button>
				<h3>{{$titulo_modal_notas}}</h3>
			</div>

			<div class="modal-body panel-body">
				<!--Se crea el contenido de los datos que se solicitan-->
				 <form action="" class="form-horizontal row-border panel panel-body">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_1}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="titulo" style="text-transform: capitalize;" v-model="newKeep.titulo">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_2}} <font color="red" size="3"></font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="asunto" style="text-transform: capitalize;" v-model="newKeep.asunto">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_3}} <font color="red" size="3">*</font></label>
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
					<button type= "button" class="btn btn-primary" v-on:click.prevent="insert_notas()" ><i class="fa fa-save"></i> Registrar</button>
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
				<h3>{{$titulo_modal_citas}}</h3>
			</div>

			<div class="modal-body panel-body">
				<!--Se crea el contenido de los datos que se solicitan-->
				 <form action="" class="form-horizontal row-border panel panel-body">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_4}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="nombre" style="text-transform: uppercase;" v-model="newKeep.nombre">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_5}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="correo" v-model="newKeep.correo">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_6}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							{!! $select_estados !!}
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_7}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="fecha">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_8}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6 bootstrap-timepicker">
							<input type="text" class="form-control timepicker" id="horario">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_9}} <font color="red" size="3">*</font></label>
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
					<button type= "button" class="btn btn-primary" v-on:click.prevent="insert_cita()" ><i class="fa fa-save"></i> Registrar</button>
				</div>
			</div>
		</div>
	</div>
</div>
