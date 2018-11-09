@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-cotizacion">
    				<div class="panel-body">
				<form class="form-horizontal" role="form" id="datos_cotizacion">
        			<input type="hidden" id="Iva" value="{{$iva}}">
						<div class="form-group row">
								 <label for="daterange" class="col-md-1 control-label input-sm">Fecha Inicio </label>
				                <div class="col-md-3">
				                    <input type="text" class="form-control fecha" readonly="" id="fecha_inicial">
				                </div>

				                <label for="daterange" class="col-md-1 control-label input-sm">Fecha Final </label>
				                <div class="col-md-3">
				                    <input type="text" class="form-control fecha" readonly="" id="fecha_final">
				                </div>
								
								<div class="col-md-2">
									<select class="form-control" id="id_vendedor" onchange="load(1);" {{$permisos}} >
										<option value="">Vendedor</option>
										<option value="1">Joaquin Alvarado</option>
										<option value="2">Obed Gomez Alvarado</option>

									</select>
								</div>
								<div class="col-md-2">
									<select class="form-control" id="estado" {{$permisos}}>
										<option value="">Estado</option>
										<option value="0">Pendiente</option>
										<option value="1">Aceptada</option>
										<option value="2"> Rechazada</option>
									</select>
								</div>
								<!-- <label for="q" class="col-md-1 control-label input-sm">Buscar:</label>
								<div class="col-md-3">
									<div class="input-group">
										<input type="text" class="form-control" id="q" placeholder="Atención ó Empresa" onkeyup="load(1);">
										<span class="btn btn-default input-group-addon" onclick="load(1);"><i class="glyphicon glyphicon-search"></i></span>
									</div>	
								</div> -->		
										
								</div>

					</form>
					
					<div class="table-responsive" v-cloak>
						<table class="table table-striped table-response highlight table-hover fixed_header" id="datatable">
							<thead>
								<tr style="background-color: #337ab7; color: #ffffff;">
									<th>#</th>
									<th>Fecha</th>
									<th>Contacto</th>
									<th>Cliente</th>
									<th>Vendedor</th>
									<th>Estatus</th>
									<th class="text-right">Subtotal</th>
									<th class="text-right">Iva</th>
									<th class="text-right">Total</th>
									<th class="text-right">Acciones</th>
									<!-- 								<th class="text-right">Acciones</th> -->

							</tr>
							</thead>
							<tbody>
							<tr v-for="cot in cotizacion">
								<td>000@{{ cot.id_cotizacion }}
									<!--<input type="text" v-model="cot.id_cotizacion" id="id_cot"></td>-->
								<td>@{{ cot.created_at }}</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="">@{{ cot.nombre_completo }}</a></td>
								<td>@{{ cot.nombre_comercial }}</td>
								<td>@{{ cot.vendedor }}</td>
								<td>
									<span class="label label-warning" v-if="cot.id_estatus == 6">@{{(cot.id_estatus != 0 )? cot.nombre: ""}}</span>
									<span class="label label-danger" v-if="cot.id_estatus == 4">@{{(cot.id_estatus != 0 )? cot.nombre: ""}}</span>
									<span class="label label-success" v-if="cot.id_estatus == 5">@{{(cot.id_estatus != 0 )? cot.nombre: ""}}</span>
								</td>
								<!-- <td>{!! $estatus_inicio !!}</td> -->
								<td class="text-right">	$ @{{(cot.subtotal)?cot.subtotal.toLocaleString(): 0.00}}</td>
								<td class="text-right"> $ @{{(cot.iva)?cot.iva.toLocaleString(): 0.00}}</td>
								<td class="text-right"> $ @{{(cot.total_conc)?cot.total_conc.toLocaleString(): 0.00}}</td>
								<td class="text-right"> 
									<div class="dropdown">
										<button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Acciones
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
											<li><a style="cursor: pointer;" title="Editar cotización" v-on:click.prevent="edit_register(cot);"><i class="glyphicon glyphicon-edit"></i> Editar</a></li>
											<li><a href="#" title="Imprimir cotización" v-on:click.prevent="pdf_print(cot)"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
											<li><a href="#" title="Enviar cotización" v-on:click.prevent="pdf_email(cot)"><i class="glyphicon glyphicon-envelope"></i> Enviar Email</a></li>
											<li><a href="#" title="Borrar cotización" v-on:click.prevent="destroy_cotizacion(cot)"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
										</ul>
									</div>
								</td>					
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4792" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4792');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2517')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>

							<!--<tr>
								<td colspan="12"><span class="pull-right"><ul class="pagination pagination-large"><li class="disabled"><span><a>‹ Ant.</a></span></li><li class="active"><a>1</a></li><li><a href="javascript:void(0);" onclick="load(2)">2</a></li><li><a href="javascript:void(0);" onclick="load(3)">3</a></li><li><a href="javascript:void(0);" onclick="load(4)">4</a></li><li><a href="javascript:void(0);" onclick="load(5)">5</a></li><li><a>...</a></li><li><a href="javascript:void(0);" onclick="load(225)">225</a></li><li><span><a href="javascript:void(0);" onclick="load(2)">Sig. ›</a></span></li></ul></span></td>
							</tr>-->
						</tbody></table>
					</div>
				</div>



    @include('ventas.cotizacion_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/ventas/build_cotizacion.js')}}"></script>
<script>
/*	$(document).ready(function(){
  $.ajax({
    type: 'POST',
    url: '/crm/ventas/empresas',
    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	}
  })
  .done(function(listas_rep){
  	//console.log(listas_rep);return;
  	var listar ="<option value='0'>Selecionar una opción</option>";
  	for (var i = 0; i < listas_rep.result.length; i++) {
  		listar+="<option value='"+listas_rep.result[i].id+"'>"+listas_rep.result[i].razon_social+"</option>";
  	}
    $('#sys_idCliente').html(listar)
  })
  .fail(function(){
    toastr.error('Hubo un errror al cargar los datos')
  })

  $('#sys_idCliente').on('change', function(){
    var id = $('#sys_idCliente').val()
    console.log(id);
    $.ajax({
      type: 'POST',
      url: '/crm/ventas/contacto',
      data: {'id': id},
      headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   	}
    })
    .done(function(listas_rep){
      $('#contacto').html(listas_rep)
    })
    .fail(function(){
      toastr.error('Hubo un errror al cargar datos contactos')
    })
  })

})*/


function display_contactos(){
	var id_clientes = jQuery('#cmb_clientes').val();
	var url = domain('ventas/contacto');
	var fields = {id : id_clientes};
	var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          	var select_contactos = response.data.result;
          	//console.log(response.data.result.correo);
          	jQuery('#div_contacto').html(select_contactos.combo_contactos);

			$('#div_contacto').on('change', function() {
			  	jQuery('#tel1').val('');
              	jQuery('#email_contact').val('');
			});
            jQuery('#rfc_empresa').val(response.data.result.correo.rfc_receptor);
            jQuery('#nombre_comercial').val(response.data.result.correo.nombre_comercial);
            jQuery('#tel2').val(response.data.result.correo.telefono);
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });

}

function parser_data(){
	var id_contacto = jQuery('#cmb_contactos').val();
	var url = domain('ventas/contactos');
	var fields = {id : id_contacto};
	var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
              	jQuery('#tel1').val(response.data.result.telefono);
              	jQuery('#email_contact').val(response.data.result.correo);
          		$('#cmb_clientes').on('change', function() {
				  	jQuery('#tel1').val('');
	              	jQuery('#email_contact').val('');
				});
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
}

function display_productos(){
    jQuery('#cmb_planes').val(0);
	var id_producto = jQuery('#cmb_productos').val();
	//var url = domain('ventas/productos');
	var url = domain('productos/edit');
	var fields = {id : id_producto};
	var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          	var select_productos = response.data.result;
            jQuery('#precio_concepto').val(response.data.result.total);
            jQuery('#descripcion').val(response.data.result.descripcion);
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });

}

function display_planes(){
    jQuery('#cmb_productos').val(0);
	var id_planes = jQuery('#cmb_planes').val();
	//var url = domain('ventas/planes');
	var url = domain('planes/edit');
	var fields = {id : id_planes};
	var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          	//var select_productos = response.data.result;
            jQuery('#precio_concepto').val(response.data.result.total);
            jQuery('#descripcion').val(response.data.result.descripcion);
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });

}

/*Funcion para actualizar eststus*/
function display_estatus_select(){
	var id_estatus = jQuery('#cmb_estatus_inicio').val();
	var id_cot = jQuery('#id_cot').val();

	//var url = domain('ventas/planes');
	var url = domain('cotizaciones/update');
	var fields = {id : id_estatus};
	var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          	//var select_productos = response.data.result;
            jQuery('#precio_concepto').val(response.data.result.total);
            jQuery('#descripcion').val(response.data.result.descripcion);
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });

}

/*Funciones para editar*/
function display_contactos_edit(id_clientes){
	var id_clientes = jQuery('#cmb_clientes_edit').val();
	var url = domain('ventas/contacto/edicion');
	var fields = {id : id_clientes};
	var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          	var select_contactos = response.data.result;
          	//console.log(response.data.result.correo);
          	jQuery('#div_contacto_edit').html(select_contactos.combo_contactos);

			$('#div_contacto').on('change', function() {
			  	jQuery('#tel1_edit').val('');
              	jQuery('#email_contact_edit').val('');
			});
            jQuery('#rfc_empresa_edit').val(response.data.result.correo.rfc_receptor);
            jQuery('#nombre_comercial_edit').val(response.data.result.correo.nombre_comercial);
            jQuery('#tel2_edit').val(response.data.result.correo.telefono);
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });

}

function parser_data_edit(id_cont){
	var id_c = id_cont;
	var id_contacto = jQuery('#cmb_contactos_edit').val();
	var id_c_general = (id_contacto && id_c != '') ? id_contacto:id_c;
	var url = domain('ventas/contactos');
	var fields = {id : id_c_general};
	var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          		jQuery('#cmb_contactos_edit').val(response.data.result.id);
              	jQuery('#tel1_edit').val(response.data.result.telefono);
              	jQuery('#email_contact_edit').val(response.data.result.correo);
          		$('#cmb_clientes_edit').on('change', function() {
				  	jQuery('#tel1_edit').val('');
	              	jQuery('#email_contact_edit').val('');
				});
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });
}

function display_productos_edit(){
    jQuery('#cmb_planes_edit').val(0);
	var id_producto = jQuery('#cmb_productos_edit').val();
	//var url = domain('ventas/productos');
	var url = domain('productos/edit');
	var fields = {id : id_producto};
	var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          	var select_productos = response.data.result;
            jQuery('#precio_concepto_edit').val(response.data.result.total);
            jQuery('#descripcion_edit').val(response.data.result.descripcion);
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });

}

function display_planes_edit(){
    jQuery('#cmb_productos_edit').val(0);
	var id_planes = jQuery('#cmb_planes_edit').val();
	//var url = domain('ventas/planes');
	var url = domain('planes/edit');
	var fields = {id : id_planes};
	var promise = MasterController.method_master(url,fields,"get");
          promise.then( response => {
          	//var select_productos = response.data.result;
            jQuery('#precio_concepto_edit').val(response.data.result.total);
            jQuery('#descripcion_edit').val(response.data.result.descripcion);
          }).catch( error => {
              if( error.response.status == 419 ){
                    toastr.error( session_expired ); 
                    redirect(domain("/"));
                    return;
                }
              toastr.error( error.response.data.message , expired );
          });

}

/*end edit*/

function calcular_suma(){
	var cantidad = jQuery('#cantidad_concepto').val();
	if(cantidad == '') cantidad = 0;

	var precio_unitario = jQuery('#precio_concepto').val();
	if (precio_unitario == '') {
		precio_unitario = 0;
	} else {
			jQuery('#cmb_productos').on('change', function() {
				jQuery('#cantidad_concepto').val('');
              	jQuery('#total_concepto').val('');
			});	
			jQuery('#cmb_planes').on('change', function() {
				jQuery('#cantidad_concepto').val('');
              	jQuery('#total_concepto').val('');
			});	
	}

	var total = parseInt(cantidad) * parseFloat(precio_unitario);
	jQuery('#total_concepto').val(total.toFixed(2));

}

function calcular_suma_edit(){
	var cantidad = jQuery('#cantidad_concepto_edit').val();
	if(cantidad == '') cantidad = 0;

	var precio_unitario = jQuery('#precio_concepto_edit').val();
	if (precio_unitario == '') {
		precio_unitario = 0;
	} else {
			jQuery('#cmb_productos_edit').on('change', function() {
				jQuery('#cantidad_concepto_edit').val('');
              	jQuery('#total_concepto_edit').val('');
			});	
			jQuery('#cmb_planes_edit').on('change', function() {
				jQuery('#cantidad_concepto_edit').val('');
              	jQuery('#total_concepto_edit').val('');
			});	
	}

	var total = parseInt(cantidad) * parseFloat(precio_unitario);
	jQuery('#total_concepto_edit').val(total.toFixed(2));

}

function fancy_click()
  {

    $.fancybox.open({
    src  : '#modal_edit_register',
    type : 'inline',
    opts : {
      onComplete : function() {
        console.info('done!');
      }
    }
  });
  }
</script>
@endpush