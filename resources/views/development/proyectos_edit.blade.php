<div id="modal_add_register" style="display:none;" class="">
        <h3>Registro</h3>
        <hr><div class="modal-dialog modal-lg">
            <div class="modal-body" style="overflow-y:scroll;">
			<form class="form-horizontal">
                    <div>
                        <font size="4" color="green"> DATOS DE CUENTA </font>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-3">Título: </label>
                        <div class="col-sm-7">
                            <input type="text" id="nombre_titulo_proyecto" class="form-control" placeholder="" ng-model="insert.nombre_titulo_proyecto">
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3">Descripción: </label>
                        <div class="col-sm-7">
						<textarea class="form-control" id="descripcion_proyecto" name="observaciones" ng-model="insert.descripcion_proyecto" rows="4"></textarea>
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3">Fecha limite: </label>
                        <div class="col-sm-7">
                            <input type="text" id="fecha_cierre" class="form-control fecha" ng-model="insert.fecha_cierre" placeholder="">
                        </div>
					</div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-3">Cliente: </label>
                        <div class="col-sm-7">
						<select class="form-control input-sm"
                    width="'100%'"
					chosen
                    ng-model="insert.id_clientes" 
                    ng-options="value.id as value.razon_social for (key, value) in datos.clientes">
                        <option value="">--Seleccione Opcion--</option>
                    </select>
                        </div>
                    </div>
                    

                    <div class="form-group">
                        <label class="control-label col-sm-3">Estatus: </label>
                        <div class="col-sm-7">
						<select class="form-control input-sm"
                    width="'100%'"
					chosen
					disabled="" 
                    ng-model="insert.id_estatus" 
                    ng-options="value.id as value.nombre for (key, value) in datos.estatus">
                        <option value="">--Seleccione Opcion--</option>
                    </select>
                        </div>
					</div>
					
					<div class="form-group">
                        <label class="control-label col-sm-3">Archivos: </label>
                        <div class="col-sm-7">
						<input type="file" name="pdf" title="ADJUNTAR PDF" multiple>
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

<div id="modal_add_tarea" style="display:none;" class="col-sm-12">
        <h3>Registro</h3>
        <hr>
            <div class="modal-body" style="overflow-y:scroll; height:550px;">
            <div class="panel panel-primary">
			<div class="panel-heading">
				<div class="btn-group pull-right">
					<div class="pull-right">
						<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modal_add_clientes" title="Agregar usuario"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Agregar</button>
					</div>
				</div>
				<h4><i class='glyphicon glyphicon-user'></i> Proyectos</h4>
			</div>
			<div class="panel-body">
					<div class='outer_div'></div><!-- Carga los datos ajax -->
					<div class="table-responsive">
						<table class="table table-hover">
							<tbody><tr style="background-color: #337ab7; color: #ffffff;">
								<th>ID</th>
								<th>TÍTULO</th>
								<th>DESCRIPCIÓN</th>
								<th>FECHA</th>
								<th>ASIGNADO A</th>
								<!-- 								<th class="text-right">Acciones</th> -->

							</tr>
							<tr>
								<td data-toggle="modal" data-target="#modal-detail-factura">2517</td>
								<td data-toggle="modal" data-target="#modal-detail-factura">01/08/2018</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<i class='glyphicon glyphicon-phone'></i> 444<br><i class='glyphicon glyphicon-envelope'></i>  444@44.44">SE AGREGO...</a></td>
								<td>01/08/2018</td>
								<td><span class="label label-success">ALBERTO</span></td>					
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4792" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4792');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2517')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>

						</tbody></table>
						<hr>

							<div class="form-group">
						    	<label for="exampleInputEmail1"></label>
						    	<b>DESCRIPCIÓN:</b> <button type="button" class="btn btn-info">AGREGAR</button>
						    </div>
						    <div class="form-group">
						     	<textarea class="form-control" rows="3"></textarea>
						    </div>

						   	<div class="form-group">
						    	<label for="exampleInputEmail1"></label>
						    	<b>HISTORIAL COMENTARIOS:</b> 
						    </div>
						    <div class="form-group">
						     	<textarea class="form-control" rows="10"></textarea>
						    </div>

						    <div class="form-group">
						    	<div class="pull-right">
						    		<input type="file" name="pdf" title="ADJUNTAR PDF">
						    	</div>
						    </div>
                                    
					</div>
				</div>
			</div>
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="insert_register()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>
    
</div>

<div class="" id="modal_edit_register" style="display:none;">
            <div class="modal-header">
                <h3> Detalles </h3>
            </div>
            <div class="modal-body">
                
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" ng-click="insert_register()"><i class="fa fa-save"></i> Actualizar </button> 
                </div>
            </div>
    
</div>