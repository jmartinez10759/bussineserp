	<div id="modal_conceptos" style="display:none;">
		<h3>Agregar Conceptos</h3>
			<hr>
		<div class="modal-body">

			<form class="form-horizontal" >

				<div class="form-group">
					<label class="control-label col-sm-3" for="">Codigo</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" placeholder="" v-model="conceptos.codigo" id="codigo_concepto">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="">Cantidad</label>
					<div class="col-sm-9">
						<input type="text" id="cantidad_concepto" class="form-control" placeholder="" v-model="conceptos.cantidad" v-on:blur="total_concepto()">
					</div>
				</div>


				<div class="form-group">
					<label class="control-label col-sm-3" for="">Precio Unitario</label>
					<div class="col-sm-9">
						<input type="text" id="precio_concepto" class="form-control" placeholder="$" v-model="conceptos.precio" v-on:blur="total_concepto()">
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="">Descripción</label>
					<div class="col-sm-9">
						<textarea class="form-control" v-model="conceptos.descripcion" id="descripcion_concepto"></textarea>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-sm-3" for="">Total</label>
					<div class="col-sm-9">
						<input type="text"  class="form-control" placeholder="$" v-model="conceptos.total" disabled id="total_concepto">
					</div>
				</div>

		 </form>


		</div>
		<div class="modal-footer">
			<div class="pull-right">
				<button type="button" class="btn btn-success" v-on:click.prevent="insert_conceptos()" {{$insertar}} ><i class="fa fa-save"></i> Agregar</button>
			</div>
		</div>


	</div>

	<div id="modal_edit_facturas" style="display:none;">

		<h3>Detalles de la  Información</h3>
		<hr>
			<div class="modal-body" style="overflow-y:scroll; height:500px;">

				<form class="form-horizontal" >
					<input type="hidden" name="id_factura_edit" />
					<div class="form-group">

						<label class="control-label col-sm-1" for="">Razón Social</label>
						<div class="col-sm-5">
							<input type="text" name="razon_social_edit" class="form-control" placeholder="" disabled>
						</div>

						<label class="control-label col-sm-1" for="">RFC <font size="3" color="red">*</font></label>
						<div class="col-sm-2">
							<input type="text" name="rfc_receptor_edit" class="form-control" placeholder="" disabled>
						</div>

						<label class="control-label col-sm-1" for="">N° Factura <font size="3" color="red">*</font></label>
						<div class="col-sm-2">
							<input type="text" name="factura_edit" class="form-control" placeholder="" disabled>
						</div>

					</div>
					<div class="form-group">

						<label class="control-label col-sm-1" for="">SubTotal</label>
						<div class="col-sm-1">
							<input type="text" name="subtotal_edit" class="form-control" placeholder="$" disabled>
						</div>

						<label class="control-label col-sm-1" for="">Total Factura</label>
						<div class="col-sm-2">
							<input type="text" name="total_edit" class="form-control" placeholder="$" disabled>
						</div>

						<label class="control-label col-sm-1" for="">Fecha Factura</label>
						<div class="col-sm-2">
							<input type="text" class="form-control fechas" placeholder="" id="fecha_factura_edit" readonly disabled>
						</div>

						<label class="control-label col-sm-1" for="">Forma de Pago</label>
						<div class="col-sm-3">
									{!! $select_forma_pago_edit !!}
						</div>


					</div>

					<div class="form-group" >

						<label class="control-label col-sm-1" for="">Comisión Paypal</label>
						<div class="col-sm-1">
							<input type="text" id="comision_edit" class="form-control" placeholder="" v-on:blur="comision('edit')">
						</div>

						<label class="control-label col-sm-1" for="">Total Pagado </label>
						<div class="col-sm-2">
							<input type="text" id="total_pago_edit" class="form-control" placeholder="" disabled>
						</div>

						<label class="control-label col-sm-1" for="">Método de Pago</label>
						<div class="col-sm-3">
							{!! $select_metodo_pago_edit !!}
						</div>

						<label class="control-label col-sm-1" for="" id="txt_fecha_pago_edit">Fecha de Pago</label>
						<div class="col-sm-2" style="display:block;" id="div_fechas_pago_edit">
								<div class="col-sm-12">
									<input type="text" id="fecha_pago_edit" class="form-control fechas" placeholder="" readonly>
								</div>
						</div>

						<div class="input-group add-on col-sm-1" style="display:none;" id="div_parcialidades_edit">
			    		<input id="parcialidades_edit" value="1" type="text" class="form-control"  placeholder="" v-on:keyup="operacion_parcialidades_edit()">
			          <div class="input-group-btn">
			            <button type="button" class="btn btn-info" v-on:click.prevent="add_fechas_parcialidades_edit()" title="Agregar Fechas" ><i class="fa fa-calendar"></i></button>
			          </div>
			   		</div>

					</div>

					<div class="form-group">

						<label class="control-label col-sm-2" for="">Observaciones</label>
						<div class="col-sm-5">
									<textarea class="form-control" id="observaciones_edit" ></textarea>
						</div>

						<input type="hidden" id="archivo_edit" />
						<div class="col-sm-5">
							<div id="div_dropzone_file_edit" ></div>
						</div>

					</div>

					<hr>

					<div class="table-responsive">

						<table class="table table-hover" id="table_conceptos_edit">

								<thead style="background-color: rgb(51, 122, 183); color: rgb(255, 255, 255);">
										<tr>
										<th class="text-center">CODIGO</th>
										<th class="text-center">CANTIDAD</th>
										<th>DESCRIPCION</th>
										<th class="text-right">PRECIO UNITARIO</th>
										<th class="text-right">PRECIO TOTAL</th>
										<!-- <th></th> -->
									</tr>
								</thead>

								<tbody>
									<tr v-for="(conceptos, key) in datos">
										<td class="text-center">@{{conceptos.productos.clave_unidad}}</td>
										<td class="text-center">@{{conceptos.cantidad}}</td>
										<td>@{{conceptos.productos.nombre}}</td>
										<td class="text-right">@{{ conceptos.precio }}</td>
										<td class="text-right">@{{ conceptos.precio * conceptos.cantidad }}</td>
										<!-- <td class="text-center"><a href="#" onclick="eliminar('17353')"><i class="glyphicon glyphicon-trash"></i></a></td> -->
									</tr>

								</tbody>

								<tfoot>
									<tr>
										<td class="text-right" colspan="4">SUBTOTAL </td>
										<td class="text-right subtotal"  style="background-color:#eee"></td>
										<td></td>
									</tr>
									<tr>
										<td class="text-right" colspan="4">IVA (16)% </td>
										<td class="text-right iva"  style="background-color:#eee"></td>
										<td></td>
									</tr>
									<tr>
										<td class="text-right" colspan="4">TOTAL </td>
										<td class="text-right total"  style="background-color:#eee"></td>
										<td></td>
									</tr>

								</tfoot>

						</table>

					</div>

				</form>

			</div>

			<div class="modal-footer">
				<div class="pull-right">
					<button type="button" class="btn btn-primary" v-on:click.prevent="update_factura()" {{$update}}><i class="fa fa-save"></i> Actualizar</button>
				</div>
			</div>


		</div>

	<div id="modal_facturas" style="display:none;">
		<input type="hidden" id="id_factura"/>
		<h3>Registro de Información</h3>
		<hr>

		<div class="modal-body" style="overflow-y:scroll; height:500px;">
			<form class="form-horizontal" >

				<div class="form-group">

					<label class="control-label col-sm-1" for="">Razón Social</label>
					<div class="col-sm-5">
						<input type="text" name="razon_social" class="form-control" placeholder="" v-model="newKeep.razon_social">
					</div>

					<label class="control-label col-sm-1" for="">RFC <font size="3" color="red">*</font></label>
					<div class="col-sm-2">
						<input type="text" id="rfc_receptor" name="rfc_receptor" class="form-control" placeholder="" v-model="newKeep.rfc_receptor">
					</div>

					<label class="control-label col-sm-1" for="">N° Factura <font size="3" color="red">*</font></label>
					<div class="col-sm-2">
						<input type="text" name="factura" class="form-control" placeholder="" v-model="newKeep.factura">
					</div>

				</div>
				<div class="form-group">

					<label class="control-label col-sm-1" for="">SubTotal</label>
					<div class="col-sm-1">
						<input type="text" name="subtotal" class="form-control" placeholder="$" v-model="newKeep.subtotal">
					</div>

					<label class="control-label col-sm-1" for="">Total Factura</label>
					<div class="col-sm-2">
						<input type="text" name="total" class="form-control" placeholder="$" v-model="newKeep.total">
					</div>

					<label class="control-label col-sm-1" for="">Fecha Factura</label>
					<div class="col-sm-2">
						<input type="text" class="form-control fechas" placeholder="" id="fecha_factura" readonly>
					</div>

					<label class="control-label col-sm-1" for="">Forma de Pago</label>
					<div class="col-sm-3">
								{!! $select_forma_pago !!}
					</div>


				</div>

				<div class="form-group" >

					<label class="control-label col-sm-1" for="">Comisión Paypal</label>
					<div class="col-sm-1">
						<input type="text" id="comision" class="form-control" placeholder="" v-on:blur="comision()">
					</div>

					<label class="control-label col-sm-1" for="">Total Pagado </label>
					<div class="col-sm-2">
						<input type="text" id="total_pago" class="form-control" placeholder="" disabled>
					</div>

					<label class="control-label col-sm-1" for="">Método de Pago</label>
					<div class="col-sm-3">
						{!! $select_metodo_pago !!}
					</div>

					<label class="control-label col-sm-1" for="" id="txt_fecha_pago">Fecha de Pago</label>
					<div class="col-sm-2" style="display:block;" id="div_fechas_pago">
							<div class="col-sm-12">
								<input type="text" id="fecha_pago" class="form-control fechas" placeholder="" readonly>
							</div>
					</div>

					<div class="input-group add-on col-sm-1" style="display:none;" id="div_parcialidades">
		    		<input id="parcialidades" value="1" type="text" class="form-control"  placeholder="">
		          <div class="input-group-btn">
		            <button type="button" class="btn btn-info" v-on:click.prevent="add_fechas_parcialidades()" title="Agregar Fechas" ><i class="fa fa-calendar"></i></button>
		          </div>
		   		</div>


				</div>

				<div class="form-group">

					<label class="control-label col-sm-2" for="">Observaciones</label>
					<div class="col-sm-5">
								<textarea class="form-control" id="observaciones" v-model="newKeep.descripcion"></textarea>
					</div>
					<input type="hidden" id="archivo" />
					<div class="col-sm-5">
						<div id="div_dropzone_file" ></div>
					</div>

				</div>

				<div class="col-sm-offset-0" style="display:block;">
						<button type="button" class="btn btn-warning add" title="Agregar Producto"  href="#modal_conceptos" id="add_concepto"><i class="fa fa-plus-circle"></i> Agregar</button>
				</div>
				<hr>
				<div class="table-response" style="display:block;">

					<table class="table table-hover" id="table_conceptos">

							<thead style="background-color: rgb(51, 122, 183); color: rgb(255, 255, 255);">
								<tr>
										<th class="text-center">CODIGO</th>
										<th class="text-center">CANTIDAD</th>
										<th>DESCRIPCION</th>
										<th class="text-right">PRECIO UNITARIO</th>
										<th class="text-right">PRECIO TOTAL</th>
										<th></th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="(conceptos, key) in facturas.conceptos">
									<td class="text-center">@{{ conceptos.productos.clave_unidad}}</td>
									<td class="text-center">@{{ conceptos.cantidad}}</td>
									<td>@{{ conceptos.productos.nombre}}</td>
									<td class="text-center">@{{ conceptos.precio}}</td>
									<td class="text-center">@{{ conceptos.total }}</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td class="text-right" colspan="4" >SUBTOTAL </td>
									<td class="text-right" id="subtotal" style="background-color:#eee"> @{{resultados.subtotal}} </td>
								</tr>
								<tr>
									<td class="text-right" colspan="4">IVA (16)% </td>
									<td class="text-right" id="iva" style="background-color:#eee"> @{{resultados.iva}}</td>
								</tr>
								<tr>
									<td class="text-right" colspan="4">TOTAL </td>
									<td class="text-right" id="total" style="background-color:#eee">@{{ resultados.total }} </td>
								</tr>

							</tfoot>

					</table>

				</div>

			</form>
		</div>

		<div class="modal-footer">
				<div class="pull-right">
					<button type="button" class="btn btn-success" v-on:click.prevent="insert_factura()" {{ $insertar }}><i class="fa fa-save"></i> Registrar</button>
				</div>
		</div>


	</div>

	<div style="display:none;" id="content_excel">
		<h3>REPORTE MENSUAL DE VENTAS BURO LABORAL MÉXICO</h3>
		<hr>
			<div id="excel" style="overflow-y:scroll; height:450px;"></div>
		<br>
		<div class="pull-right">
			<button class="btn btn-primary" type="button" v-on:click.prevent="download_excel()"><i class="fa fa-cloud-download"></i> Descargar</button>
		</div>
	</div>

	<div style="display:none" id="add_fechas_parcialidades">
			<h3>Asignar Fechas de Pagos</h3>
			<hr>
			<div id="content_fechas"></div>

			<div class="modal-footer">
					<div class="pull-right">
						<button type="button" class="btn btn-success" v-on:click.prevent="fechas_parcialidades()" ><i class="fa fa-save"></i> Asignar</button>
					</div>
			</div>

	</div>

	<div style="display:none" id="add_fechas_parcialidades_edit">
			<h3>Asignar Fechas de Pagos</h3>
			<hr>
			<div id="content_fechas_edit"></div>

			<div class="modal-footer">
					<div class="pull-right">
						<button type="button" class="btn btn-success" v-on:click.prevent="fechas_parcialidades_edit()" ><i class="fa fa-save"></i> Asignar</button>
					</div>
			</div>

	</div>
