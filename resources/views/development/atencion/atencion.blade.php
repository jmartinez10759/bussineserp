@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush

<seccion id="vue-atencion">

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









	@include('development.atencion.atencion_edit')

  <!-- <div class="row">
    <div class="pull-right">

      <div class="btn-group">
        <button type="button" class="btn btn-warning" v-on:click.prevent="generar_pdf()" title="Generar Reporte" {{$reportes}}><i class="fa fa-file-pdf-o"> </i> PDF</button>
      </div>
      <div class="btn-group">
        <button type="button" class="btn btn-primary" v-on:click.prevent="generar_csv()" title="Generar CSV" {{$excel}}><i class="	fa fa-file-excel-o"> </i> CSV</button>
      </div>

    </div>
  </div> -->

</seccion>

@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/development/atencion/build_atencion.js')}}" ></script>
@endpush
