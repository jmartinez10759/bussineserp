@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue_permisos">
<div class="row collapse in">

		<div class="row">
			<!-- <div class="col-sm-1"></div> -->
			<div class="col-sm-12">

				<div class="col-sm-3">
					{!! $select_users !!}
				</div>
				<div class="col-sm-3" id="roles">
					{!! $select_roles !!}
				</div>
				<div class="col-sm-3" id="empresas">
					<select class="form-control" disabled id="cmb_empresas" onchange="change_empresas()">
						<option value="">Seleccione una opcion</option>
						<option value="0">Todas las Empresas</option>
					</select>
				</div>
				<div class="col-sm-3" id="sucursales">
					<select class="form-control" disabled id="cmb_sucursales" onchange="change_sucursales()">
						<option value="">Seleccione una opcion</option>
						<option value="0">Todas las Sucursales</option>
					</select>
				</div>

			</div>
		</div>
		<br><br>

</div>

{!! $data_table !!}

<div class="col-sm-1 col-sm-offset-10">
	<div class="btn-toolbar">
		<button type="button" class="btn btn-success" data-toggle="modal" data-target="" v-on:click.prevent="register_permisos()" {{$permisos['INS']}}><i class="fa fa-plus-circle"> </i> Guardar Permisos</button>
	</div>
</div>
<br><br><br><br><br>

<!-- se crea el modal donde contendra la parte de los permisos -->
<div class="modal fade" id="modal_asignar_acciones" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
				</button>
				<h3>{{$titulo_modal}}</h3>
			</div>

			<div class="modal-body panel-body">
					<div class="table-response">
								<input type="hidden" v-model="fillKeep.id_menu" >
								{!! $data_table_acciones !!}
					</div>
			</div>
			<div class="modal-footer">
				<div class="btn-toolbar pull-right">
					<button type= "button" class="btn btn-danger" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times-circle"></i> Cancelar</button>
					<button type= "button" class="btn btn-primary" v-on:click.prevent="register_acciones()" {{$permisos['INS']}}><i class="fa fa-save"></i> Registrar Acciones</button>
				</div>
			</div>
		</div>
	</div>
</div>





</div>
@stop
@push('scripts')
  <script type="text/javascript" src="{{asset('js/administrador/configuracion/build_permisos.js')}}" ></script>
@endpush
