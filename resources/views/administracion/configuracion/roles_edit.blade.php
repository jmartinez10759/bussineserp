<div class="modal fade" id="modal_edit_register" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
				</button>
				<h3>{!! $titulo_modal_edit !!}</h3>
			</div>

			<div class="modal-body panel-body">
				<!--Se crea el contenido de los datos que se solicitan-->
				<form action="" class="form-horizontal row-border panel panel-body">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{!! $campo_1 !!} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" v-model="fillKeep.perfil" style="text-transform: capitalize;">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{!!$campo_2!!} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" v-model="fillKeep.clave_corta" style="text-transform: capitalize;">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{!!$campo_3!!}</label>
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
					<button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
            <i class="fa fa-times-circle"></i> Cancelar
					</button>
					<button type= "button" class="btn btn-info" v-on:click.prevent="update()" {{$update}}>
            <i class="fa fa-save"></i> Actualizar
          </button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal_add_register" style="display:none;">
	<div class="modal-dialog">
		<div class="modal-content">
			<h3>{!! $titulo_modal !!}</h3>
			<hr>
			<div class="modal-body panel-body">
				<!--Se crea el contenido de los datos que se solicitan-->
				<form action="" class="form-horizontal row-border panel panel-body">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{!! $campo_1 !!} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" v-model="newKeep.perfil" style="text-transform: capitalize;">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{!!$campo_2!!} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" v-model="newKeep.clave_corta" style="text-transform: capitalize;">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{!!$campo_3!!}</label>
						</div>
						<div class="col-sm-6">
							<select class="form-control" v-model="newKeep.estatus">
								<option value="1">ACTIVO</option>
								<option value="0">BAJA</option>
							</select>
						</div>
					</div>

				</form>

			</div>
			<div class="modal-footer">
				<div class="btn-toolbar pull-right">
					<button type= "button" class="btn btn-danger" data-fancybox-close>
						<i class="fa fa-times-circle"></i> Cancelar
					</button>
					<button type= "button" class="btn btn-primary" v-on:click.prevent="insert()" {{$insertar}}>
						<i class="fa fa-save"></i> Registrar
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
