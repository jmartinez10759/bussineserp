<div class="modal fade" id="modal_add_register" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3>{{$titulo_modal}}</h3>
			</div>
			<div class="modal-body panel-body row-border">
				<form class="form-horizontal">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_1}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="insert.texto">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_2}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<select class="form-control"
									chosen
									width="'100%'"
									ng-model="insert.tipo"
									ng-options="value.id as value.descripcion for (key, value) in cmbTypeMenu">
								<option value="">--Seleccione Opcion--</option>
							</select>
						</div>
					</div>

					<div class="form-group" ng-if="insert.tipo == 'HIJO'">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_3}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<select class="form-control"
									chosen
									width="'100%'"
									ng-model="insert.id_padre"
									ng-options="value.id as value.texto for (key, value) in cmbTypeMenus">
								<option value="">--Seleccione Opcion--</option>
							</select>
						</div>
					</div>

					<div class="form-group" ng-hide="insert.tipo == 'PADRE'">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_4}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="insert.link">
						</div>
					</div>

					<div class="form-group" ng-hide="insert.tipo == 'HIJO'">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_5}} </label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="insert.icon">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_7}} </label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="insert.orden">
						</div>
					</div>

					<div class="form-group" ng-if="userLogged == 1">
						<div class="control-label">
							<label class="col-sm-3 control-label">Empresas</label>
						</div>
						<div class="col-sm-6">
							<select class="form-control"
									chosen
									width="'100%'"
									multiple
									ng-model="insert.companyId"
									ng-options="value.id as value.razon_social for (key, value) in rootCmbCompanies">
								<option value="">--Seleccione Opcion--</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_6}} </label>
						</div>
						<div class="col-sm-6">
							<select class="form-control"
									chosen
									width="'100%'"
									ng-model="insert.estatus"
									ng-options="value.id as value.descripcion for (key, value) in cmbEstatusRoot">
								<option value="">--Seleccione Opcion--</option>
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
					<button type= "button" class="btn btn-success" ng-click="insertRegister()" ng-if="permisos.INS" ng-disabled="spinning">
						<span ng-show="spinning"><i class="glyphicon glyphicon-refresh spinning"></i></span>
						<span ng-hide="spinning"><i class="fa fa-save"></i> </span>Registrar
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
				<h3>{{$titulo_modal_edit}}</h3>
			</div>

			<div class="modal-body panel-body">
				<form action="" class="form-horizontal row-border panel panel-body">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_1}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="update.texto">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_2}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<select class="form-control"
									chosen
									width="'100%'"
									ng-model="update.tipo"
									ng-options="value.id as value.descripcion for (key, value) in cmbTypeMenu">
								<option value="">--Seleccione Opcion--</option>
							</select>
						</div>
					</div>

					<div class="form-group" ng-if="update.tipo == 'HIJO'">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_3}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<select class="form-control"
									chosen
									width="'100%'"
									ng-model="update.id_padre"
									ng-options="value.id as value.texto for (key, value) in cmbTypeMenus">
								<option value="">--Seleccione Opcion--</option>
							</select>

						</div>
					</div>

					<div class="form-group" ng-hide="update.tipo == 'PADRE'">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_4}} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="update.link">
						</div>
					</div>

					<div class="form-group" ng-hide="update.tipo == 'HIJO'">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_5}} </label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="update.icon">
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_7}} </label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="update.orden">
						</div>
					</div>

					<div class="form-group" ng-if="userLogged == 1">
						<div class="control-label">
							<label class="col-sm-3 control-label">Empresas</label>
						</div>
						<div class="col-sm-6">
							<select class="form-control"
									chosen
									width="'100%'"
									multiple
									ng-model="update.companyId"
									ng-options="value.id as value.razon_social for (key, value) in rootCmbCompanies">
								<option value="">--Seleccione Opcion--</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{{$campo_6}} </label>
						</div>
						<div class="col-sm-6">
							<select class="form-control"
									chosen
									width="'100%'"
									ng-model="update.estatus"
									ng-options="value.id as value.descripcion for (key, value) in cmbEstatusRoot">
								<option value="">--Seleccione Opcion--</option>
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
					<button type="button" class="btn btn-primary" ng-click="updateRegister()" ng-if="permisos.UPD" ng-disabled="spinning">
						<span ng-show="spinning"><i class="glyphicon glyphicon-refresh spinning"></i></span>
						<span ng-hide="spinning"><i class="fa fa-save"></i> </span>Actualizar
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
