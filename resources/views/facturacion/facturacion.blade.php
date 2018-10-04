@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
	<div class="container-fluid" id="vue-facturas" v-cloak >

				<div class="row">

					<div class='col-sm-4'>
		          <div class="form-group">
									<label class="col-sm-6 control-label">Fecha Pago Inicial</label>
		              <div class='input-group date' id='datetimepicker1'>
		                  <input type='text' class="form-control fechas" id="fecha_inicio_pago" />
		                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
		                  </span>
		              </div>
		          </div>
		      </div>

					<div class='col-sm-4'>
		          <div class="form-group">
									<label class="col-sm-6 control-label">Fecha Pago Final</label>
		              <div class='input-group date' id='datetimepicker1'>
		                  <input type='text' class="form-control fechas" id="fecha_final_pago" />
		                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
		                  </span>
		              </div>
		          </div>
		      </div>

					<div class="col-sm-4">
							<button type="button" class="btn btn-info" v-on:click.prevent="filtro_fechas()"><i class="fa fa-filter"> </i> Filtrar</button>
					</div>

				</div>

					<div class="table-responsive" id="tabla">
						<table class="table table-hover table-responsive table-striped" id="table_general_facturas">
							<thead style="background-color: #337ab7; color: #ffffff;">
								<tr>
									<th>N°Factura</th>
									<th>RFC</th>
									<th>Cliente</th>
									<!-- <th>Parcialidades</th> -->
									<th>Fecha Factura</th>
									<th>Fecha Pago</th>
									<th class="text-left">Comisión</th>
									<th class="text-left">Total Pago Bancos</th>
									<th class="text-left">Total Factura</th>
									<th>Estatus</th>
									<th>Comprobante</th>
									<th></th>
								</tr>
							</thead>
							<tbody >
									<tr style="cursor: pointer;" v-for="( facturas ,key) in cfdi " >
										  <td v-on:click.prevent="edit_factura( facturas.id_factura )">@{{ facturas.factura }} </td>
										  <td v-on:click.prevent="edit_factura( facturas.id_factura )">@{{ facturas.rfc_receptor}}</td>
										  <td v-on:click.prevent="edit_factura( facturas.id_factura )">@{{ facturas.razon_social}}</td>
										  <td v-on:click.prevent="edit_factura( facturas.id_factura )">@{{ facturas.fecha_factura}}</td>
										  <td v-on:click.prevent="edit_factura( facturas.id_factura )">@{{ facturas.fecha_pago }}</td>
										  <td v-on:click.prevent="edit_factura( facturas.id_factura )">@{{ facturas.comision_general}}</td>
											<td v-on:click.prevent="edit_factura( facturas.id_factura )">@{{ facturas.pago_general}}</td>
										  <td v-on:click.prevent="edit_factura( facturas.id_factura )">@{{ facturas.total_general}}</td>
										  <td class="text-center">
													<select class="form-control" :id="facturas.id_factura" v-on:change="select_estatus( facturas.id_factura )" v-model="facturas.id_estatus">
															<option v-for="(estatus, key) in dropdown" :value="estatus.id">@{{estatus.nombre}}</option>
													</select>
											</td>
											<td class="text-center">
													<a class="btn btn-success" title="Comprobante" v-on:click.prevent="visualizar( facturas.archivo )"><i class="fa fa-search"></i></a>
											</td>
											<td class="text-center">
													<button class="btn btn-danger" type="button" title="Borrar Registro" v-on:click.prevent="delete_factura( facturas.id_factura )" {{$eliminar}}>
															<i class="fa fa-trash" onclick="" aria-hidden="true" ></i>
													</button>
											</td>
									</tr>
							</tbody>

						<tfoot>
							<tr>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<!-- <td></td> -->
								<td style="background-color:#eee">@{{ cantidades.comision_general}}</td>
								<td style="background-color:#eee">@{{ cantidades.pago_general}}</td>
								<td style="background-color:#eee">@{{ cantidades.total_general }}</td>
							</tr>
						</tfoot>
					</table>
					</div>


					@include('facturacion.facturacion_edit')
					<div class="row">
						<div class="pull-right">

							<div class="btn-group">
								<button type="button" class="btn btn-warning" v-on:click.prevent="generar_pdf()" title="Generar Reporte" {{$reportes}}><i class="fa fa-file-pdf-o"> </i> PDF</button>
							</div>
							<div class="btn-group">
								<button type="button" class="btn btn-primary" v-on:click.prevent="generar_csv()" title="Generar CSV" {{$excel}}><i class="	fa fa-file-excel-o"> </i> CSV</button>
							</div>

						</div>
					</div>

		</div>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/facturacion/module_facturas.js')}}" ></script>
@endpush
