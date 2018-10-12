<!-- <div class="modal fade" id="modal_add_register" role="dialog" aria-hidden="true"> -->
<div style="display:none;" id="modal_add_register" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>{{$titulo_modal}}</h3>
			</div>
			<div class="modal-body panel-body row-border">
				<!--Se crea el contenido de los datos que se solicitan-->
				<form class="form-horizontal">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_1}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="texto" style="text-transform: capitalize;" v-model="newKeep.texto">
							<input type="hidden" class="form-control" id="id_principal">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_2}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<select class="form-control" id="tipo" v-on:change="tipo_menu()" v-model="newKeep.tipo">
								<option value="SIMPLE">SIMPLE</option>
								<option value="PADRE">PADRE</option>
								<option value="HIJO">HIJO</option>
							</select>
						</div>
					</div>

					<div class="form-group" id="select_padre" v-if="newKeep.tipo == 'HIJO'">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_3}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
              <!-- aqui va el id_padre -->
              <select class="form-control" v-model="newKeep.id_padre">
								<option v-for="(menu_padre, key ) in datos.tipo_menu" :value="menu_padre.id">@{{menu_padre.texto}}</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_4}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="link" v-model="newKeep.link">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_5}} </label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="icon" v-model="newKeep.icon">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_7}} </label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" id="orden" v-model="newKeep.orden">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_6}} </label>
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
					<button type= "button" class="btn btn-danger" data-fancybox-close ><i class="fa fa-times-circle"></i> Cancelar</button>
					<button type= "button" class="btn btn-primary" v-on:click.prevent="insert()" {{$insertar}}><i class="fa fa-save"></i> Registrar</button>
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
				<h3>{{$titulo_modal_edit}}</h3>
			</div>

			<div class="modal-body panel-body">
				<!--Se crea el contenido de los datos que se solicitan-->
				<form action="" class="form-horizontal row-border panel panel-body">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_1}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" style="text-transform: capitalize;" v-model="fillKeep.texto">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_2}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<select class="form-control" v-on:change="tipo_menu()" v-model="fillKeep.tipo">
								<option value="SIMPLE">SIMPLE</option>
								<option value="PADRE">PADRE</option>
								<option value="HIJO">HIJO</option>
							</select>
						</div>
					</div>

					<div class="form-group" v-if="fillKeep.tipo == 'HIJO'">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_3}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
              <!-- aqui va el id_padre -->
              <select class="form-control" v-model="fillKeep.id_padre">
								<option v-for="(menu_padre, key ) in datos.tipo_menu" :value="menu_padre.id">@{{menu_padre.texto}}</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_4}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" v-model="fillKeep.link">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_5}} </label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" v-model="fillKeep.icon">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_7}} </label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" v-model="fillKeep.orden">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_6}} </label>
						</div>
						<div class="col-sm-6">
							<select class="form-control" v-model="fillKeep.estatus">
								<option value="1">ACTIVO</option>
								<option value="0">BAJA</option>
							</select>
						</div>
					</div>

				</form>

			</div>
			<div class="modal-footer">
				<div class="btn-toolbar pull-right">
					<button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Cancelar</button>
					<button type= "button" class="btn btn-info" v-on:click.prevent="update()" {{$update}}><i class="fa fa-save"></i> Actualizar</button>
				</div>
			</div>
		</div>
	</div>
</div>
