<div class="modal fade" id="modal_add_register" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>{!! $titulo_modal !!}</h3>
			</div>
			<div class="modal-body panel-body">

				<form class="form-horizontal row-border panel panel-body">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{!! $campo_1 !!} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="insert.perfil" capitalize>
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{!!$campo_2!!} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="insert.clave_corta" capitalize>
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
							<label class="col-sm-3 control-label">{!!$campo_3!!}</label>
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
					<button type="button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true">
						<i class="fa fa-times-circle"></i> Cancelar
					</button>
					<button type= "button" class="btn btn-success" ng-click="insertRegister()" ng-if="permisos.INS">
						<i class="fa fa-save"></i> Registrar
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="modal_edit_register" class="modal fade" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Editar Registros</h4>
            </div>
            <div class="modal-body">

				<form class="form-horizontal row-border panel panel-body">

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{!! $campo_1 !!} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="update.perfil" capitalize>
						</div>
					</div>

					<div class="form-group">
						<div class="control-label">
							<label class="col-sm-3 control-label">{!!$campo_2!!} <font color="red" size="3">*</font></label>
						</div>
						<div class="col-sm-6">
							<input type="text" class="form-control" ng-model="update.clave_corta" capitalize>
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
							<label class="col-sm-3 control-label">{!!$campo_3!!}</label>
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
					<button type="button" class="btn btn-danger" data-dismiss="modal">
						<i class="fa fa-times-circle"></i> Cerrar
					</button>
					<button type= "button" class="btn btn-primary" ng-click="updateRegister()" ng-if="permisos.UPD" >
						<i class="fa fa-save"></i> Actualizar
					</button>
				</div>
            </div>

        </div>
    </div>
</div>
