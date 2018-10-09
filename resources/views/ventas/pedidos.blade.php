@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-pedidos">

        	<div class="panel-body">
				<form class="form-horizontal">

                    <div class="form-group row">
                        <label for="daterange" class="col-md-1 control-label input-sm">Fecha Pedido</label>
                        <div class="col-md-3">
                            <input type="text" name="daterange" id="daterange" class="form-control" readonly="">
                        </div>


                        <div class="col-md-2">
                            <select class="form-control" id="estado" onchange="load(1);">
                                    <option value="">Estado</option>
                                    <option value="0">Pendiente</option>
                                    <option value="1">Aceptada</option>
                                    <option value="2"> Rechazada</option>
                                </select>
                        </div>
                        
                        <div class="col-md-2">
                            <select class="form-control" id="id_vendedor" onchange="" {{$permisos}}>
                                <option value="">Vendedor</option>
                                <option value="1">Joaquin Alvarado</option>
                                <option value="2">Obed Gomez Alvarado</option>
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
                    
					<div id="resultados"></div><!-- Carga los datos ajax -->
					<div class='outer_div'></div><!-- Carga los datos ajax -->
					<div class="table-responsive">
						<table class="table table-striped table-response highlight table-hover fixed_header" id="datatable">
							<thead>
								<tr style="background-color: #337ab7; color: #ffffff;">
									<th>#</th>
									<th>Fecha</th>
									<th>Contacto</th>
									<th>Cliente</th>
									<th>Vendedor</th>
									<th>Estado</th>
									<th class="text-right">Neto</th>
									<th class="text-right">Iva</th>
									<th class="text-right">Total</th>
									<th class="text-right">Acciones</th>
									<!-- 								<th class="text-right">Acciones</th> -->

							</tr>
							</thead>
							<tbody>

							<tr>
								<td data-toggle="modal" data-target="#modal-detail-factura">2517</td>
								<td data-toggle="modal" data-target="#modal-detail-factura">01/08/2018</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="444 444@44.44">444</a></td>
								<td>Obed Alvarado</td>
								<td>Obed Alvarado</td>
								<td><span class="label label-success">Pagada</span></td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right"> 
									<div class="dropdown">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Acciones
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
											<li><a href="editar_cotizacion.php?id=253" title="Editar cotización"><i class="glyphicon glyphicon-edit"></i> Editar</a></li>
											<li><a href="#" title="Imprimir cotización" onclick="descargar('312');"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
											<li><a href="#" title="Enviar cotización" data-toggle="modal" data-target="#myModal" data-number="312" data-email="support@911alarmas.com"><i class="glyphicon glyphicon-envelope"></i> Enviar Email</a></li>
											<li><a href="#" title="Borrar cotización" onclick="eliminar('253')"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
										</ul>
									</div>
								</td>					
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4792" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4792');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2517')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>
							<tr>
								<td data-toggle="modal" data-target="#modal-detail-factura">2516</td>
								<td data-toggle="modal" data-target="#modal-detail-factura">01/08/2018</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<i class='glyphicon glyphicon-phone'></i> 123<br><i class='glyphicon glyphicon-envelope'></i>  123@123">12345</a></td>
								<td>Obed Alvarado</td>
								<td>Obed Alvarado</td>
								<td><span class="label label-success">Pagada</span></td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right"> 
									<div class="dropdown">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Acciones
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
											<li><a href="editar_cotizacion.php?id=253" title="Editar cotización"><i class="glyphicon glyphicon-edit"></i> Editar</a></li>
											<li><a href="#" title="Imprimir cotización" onclick="descargar('312');"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
											<li><a href="#" title="Enviar cotización" data-toggle="modal" data-target="#myModal" data-number="312" data-email="support@911alarmas.com"><i class="glyphicon glyphicon-envelope"></i> Enviar Email</a></li>
											<li><a href="#" title="Borrar cotización" onclick="eliminar('253')"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
										</ul>
									</div>
								</td>				
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4791" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4791');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2516')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>

							<tr>
								<td data-toggle="modal" data-target="#modal-detail-factura">2516</td>
								<td data-toggle="modal" data-target="#modal-detail-factura">01/08/2018</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<i class='glyphicon glyphicon-phone'></i> 123<br><i class='glyphicon glyphicon-envelope'></i>  123@123">12345</a></td>
								<td>Obed Alvarado</td>
								<td>Obed Alvarado</td>
								<td><span class="label label-success">Pagada</span></td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right"> 
									<div class="dropdown">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Acciones
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
											<li><a href="editar_cotizacion.php?id=253" title="Editar cotización"><i class="glyphicon glyphicon-edit"></i> Editar</a></li>
											<li><a href="#" title="Imprimir cotización" onclick="descargar('312');"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
											<li><a href="#" title="Enviar cotización" data-toggle="modal" data-target="#myModal" data-number="312" data-email="support@911alarmas.com"><i class="glyphicon glyphicon-envelope"></i> Enviar Email</a></li>
											<li><a href="#" title="Borrar cotización" onclick="eliminar('253')"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
										</ul>
									</div>
								</td>				
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4791" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4791');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2516')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>

							<tr>
								<td data-toggle="modal" data-target="#modal-detail-factura">2516</td>
								<td data-toggle="modal" data-target="#modal-detail-factura">01/08/2018</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<i class='glyphicon glyphicon-phone'></i> 123<br><i class='glyphicon glyphicon-envelope'></i>  123@123">12345</a></td>
								<td>Obed Alvarado</td>
								<td>Obed Alvarado</td>
								<td><span class="label label-success">Pagada</span></td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right"> 
									<div class="dropdown">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Acciones
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
											<li><a href="editar_cotizacion.php?id=253" title="Editar cotización"><i class="glyphicon glyphicon-edit"></i> Editar</a></li>
											<li><a href="#" title="Imprimir cotización" onclick="descargar('312');"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
											<li><a href="#" title="Enviar cotización" data-toggle="modal" data-target="#myModal" data-number="312" data-email="support@911alarmas.com"><i class="glyphicon glyphicon-envelope"></i> Enviar Email</a></li>
											<li><a href="#" title="Borrar cotización" onclick="eliminar('253')"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
										</ul>
									</div>
								</td>				
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4791" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4791');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2516')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>

							<tr>
								<td data-toggle="modal" data-target="#modal-detail-factura">2516</td>
								<td data-toggle="modal" data-target="#modal-detail-factura">01/08/2018</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<i class='glyphicon glyphicon-phone'></i> 123<br><i class='glyphicon glyphicon-envelope'></i>  123@123">12345</a></td>
								<td>Obed Alvarado</td>
								<td>Obed Alvarado</td>
								<td><span class="label label-success">Pagada</span></td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right"> 
									<div class="dropdown">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Acciones
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
											<li><a href="editar_cotizacion.php?id=253" title="Editar cotización"><i class="glyphicon glyphicon-edit"></i> Editar</a></li>
											<li><a href="#" title="Imprimir cotización" onclick="descargar('312');"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
											<li><a href="#" title="Enviar cotización" data-toggle="modal" data-target="#myModal" data-number="312" data-email="support@911alarmas.com"><i class="glyphicon glyphicon-envelope"></i> Enviar Email</a></li>
											<li><a href="#" title="Borrar cotización" onclick="eliminar('253')"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
										</ul>
									</div>
								</td>				
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4791" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4791');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2516')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>

							<tr>
								<td data-toggle="modal" data-target="#modal-detail-factura">2516</td>
								<td data-toggle="modal" data-target="#modal-detail-factura">01/08/2018</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<i class='glyphicon glyphicon-phone'></i> 123<br><i class='glyphicon glyphicon-envelope'></i>  123@123">12345</a></td>
								<td>Obed Alvarado</td>
								<td>Obed Alvarado</td>
								<td><span class="label label-success">Pagada</span></td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right"> 
									<div class="dropdown">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Acciones
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
											<li><a href="editar_cotizacion.php?id=253" title="Editar cotización"><i class="glyphicon glyphicon-edit"></i> Editar</a></li>
											<li><a href="#" title="Imprimir cotización" onclick="descargar('312');"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
											<li><a href="#" title="Enviar cotización" data-toggle="modal" data-target="#myModal" data-number="312" data-email="support@911alarmas.com"><i class="glyphicon glyphicon-envelope"></i> Enviar Email</a></li>
											<li><a href="#" title="Borrar cotización" onclick="eliminar('253')"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
										</ul>
									</div>
								</td>				
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4791" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4791');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2516')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>

							<tr>
								<td data-toggle="modal" data-target="#modal-detail-factura">2516</td>
								<td data-toggle="modal" data-target="#modal-detail-factura">01/08/2018</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<i class='glyphicon glyphicon-phone'></i> 123<br><i class='glyphicon glyphicon-envelope'></i>  123@123">12345</a></td>
								<td>Obed Alvarado</td>
								<td>Obed Alvarado</td>
								<td><span class="label label-success">Pagada</span></td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right"> 
									<div class="dropdown">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Acciones
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
											<li><a href="editar_cotizacion.php?id=253" title="Editar cotización"><i class="glyphicon glyphicon-edit"></i> Editar</a></li>
											<li><a href="#" title="Imprimir cotización" onclick="descargar('312');"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
											<li><a href="#" title="Enviar cotización" data-toggle="modal" data-target="#myModal" data-number="312" data-email="support@911alarmas.com"><i class="glyphicon glyphicon-envelope"></i> Enviar Email</a></li>
											<li><a href="#" title="Borrar cotización" onclick="eliminar('253')"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
										</ul>
									</div>
								</td>				
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4791" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4791');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2516')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>




							<tr>
								<td>2509</td>
								<td>31/07/2018</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<i class='glyphicon glyphicon-phone'></i> 0990998372<br><i class='glyphicon glyphicon-envelope'></i>  daniel.cajas@hotmail.com">Daniel Cajas</a></td>
								<td>Obed Alvarado</td>
								<td>Obed Alvarado</td>
								<td><span class="label label-success">Pagada</span></td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right"> 
									<div class="dropdown">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Acciones
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
											<li><a href="editar_cotizacion.php?id=253" title="Editar cotización"><i class="glyphicon glyphicon-edit"></i> Editar</a></li>
											<li><a href="#" title="Imprimir cotización" onclick="descargar('312');"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
											<li><a href="#" title="Enviar cotización" data-toggle="modal" data-target="#myModal" data-number="312" data-email="support@911alarmas.com"><i class="glyphicon glyphicon-envelope"></i> Enviar Email</a></li>
											<li><a href="#" title="Borrar cotización" onclick="eliminar('253')"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
										</ul>
									</div>
								</td>					
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4781" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4781');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2509')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>
							<tr>
								<td>2508</td>
								<td>30/07/2018</td>
								<td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<i class='glyphicon glyphicon-phone'></i> 5555555<br><i class='glyphicon glyphicon-envelope'></i>  ejemplo@gmail.com">ROBERTO SERPA LANDAVERRY</a></td>
								<td>Obed Alvarado</td>
								<td>Obed Alvarado</td>
								<td><span class="label label-success">Pagada</span></td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right">184.76</td>
								<td class="text-right"> 
									<div class="dropdown">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Acciones
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
											<li><a style="cursor: pointer;" onclick="alert(1);" title="Editar cotización"><i class="glyphicon glyphicon-edit"></i> Editar</a></li>
											<li><a href="#" title="Imprimir cotización" onclick="descargar('312');"><i class="glyphicon glyphicon-print"></i> Imprimir</a></li>
											<li><a href="#" title="Enviar cotización" data-toggle="modal" data-target="#myModal" data-number="312" data-email="support@911alarmas.com"><i class="glyphicon glyphicon-envelope"></i> Enviar Email</a></li>
											<li><a href="#" title="Borrar cotización" onclick="eliminar('253')"><i class="glyphicon glyphicon-trash"></i> Eliminar</a></li>
										</ul>
									</div>
								</td>				
<!-- 								<td class="text-right">
									<a href="editar_factura.php?id_factura=4780" class="btn btn-default" title="Editar factura"><i class="glyphicon glyphicon-edit"></i></a> 
									<a href="#" class="btn btn-default" title="Descargar factura" onclick="imprimir_factura('4780');"><i class="glyphicon glyphicon-download"></i></a> 
									<a href="#" class="btn btn-default" title="Borrar factura" onclick="eliminar('2508')"><i class="glyphicon glyphicon-trash"></i> </a>
								</td> -->

							</tr>
							<!--<tr>
								<td colspan="12"><span class="pull-right"><ul class="pagination pagination-large"><li class="disabled"><span><a>‹ Ant.</a></span></li><li class="active"><a>1</a></li><li><a href="javascript:void(0);" onclick="load(2)">2</a></li><li><a href="javascript:void(0);" onclick="load(3)">3</a></li><li><a href="javascript:void(0);" onclick="load(4)">4</a></li><li><a href="javascript:void(0);" onclick="load(5)">5</a></li><li><a>...</a></li><li><a href="javascript:void(0);" onclick="load(225)">225</a></li><li><span><a href="javascript:void(0);" onclick="load(2)">Sig. ›</a></span></li></ul></span></td>
							</tr>-->
						</tbody></table>
					</div>
                </div>
                
    {!! $data_table !!}
    @include('ventas.pedidos_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/ventas/build_pedidos.js')}}"></script>
@endpush