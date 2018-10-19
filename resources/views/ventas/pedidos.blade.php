@extends('layouts.template.app')
@section('content')
@push('styles')
@endpush
<div id="vue-pedidos" v-cloak>

    <div class="panel-body">
        <form class="form-horizontal">

            <div class="form-group row">
                <label for="daterange" class="col-md-1 control-label input-sm">Fecha Inicio </label>
                <div class="col-md-3">
                    <input type="text" class="form-control fecha" readonly="" id="fecha_inicial">
                </div>

                <label for="daterange" class="col-md-1 control-label input-sm">Fecha Final </label>
                <div class="col-md-3">
                    <input type="text" class="form-control fecha" readonly="" id="fecha_final">
                </div>

                <!-- <div class="col-md-2">
                    {!! $cmb_estatus !!}
                </div> -->
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

        <div class="table-responsive">
            <table class="table table-striped table-responsive highlight table-hover fixed_header" id="datatable">
                <thead>
                    <tr style="background-color: #337ab7; color: #ffffff;">
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Contacto</th>
                        <th>Cliente</th>
                        <!-- <th>Ejecutivo</th> -->
                        <th>Estatus</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-right">Iva</th>
                        <th class="text-right">Total</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <tr v-for="data in datos">
                        <td>000@{{data.id}}</td>
                        <td>@{{data.created_at}}</td>
                        <td>@{{(data.id_contacto != 0)? data.contactos.nombre_completo:"" }}</td>
                        <td>@{{(data.id_cliente != 0)?data.clientes.nombre_comercial:"" }}</td>
                        <!-- <td>@{{data.usuarios[0].name}}</td> -->
                        <td>
                            <span class="label label-warning" v-if="data.id_estatus == 6">@{{(data.id_estatus != 0 )? data.estatus.nombre: ""}}</span>
                            <span class="label label-danger" v-if="data.id_estatus == 4">@{{(data.id_estatus != 0 )? data.estatus.nombre: ""}}</span>
                            <span class="label label-success" v-if="data.id_estatus == 5">@{{(data.id_estatus != 0 )? data.estatus.nombre: ""}}</span>
                        </td>
                        <td class="text-right">$ @{{(data.subtotal)?data.subtotal.toLocaleString(): 0.00}}</td>
                        <td class="text-right">$ @{{(data.iva)?data.iva.toLocaleString(): 0.00}}</td>
                        <td class="text-right">$ @{{(data.total)? data.total.toLocaleString(): 0.00 }}</td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Acciones
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                    <li>
                                        <a title="Editar" style="cursor:pointer;" v-on:click.prevent="edit_register(data.id)">
                                            <i class="glyphicon glyphicon-edit"></i> Editar
                                        </a>
                                    </li>
                                    <li {{$reportes}}>
                                        <a href="#" title="Imprimir cotización" v-on:click.prevent="descargar();">
                                            <i class="glyphicon glyphicon-print"></i> Imprimir
                                        </a>
                                    </li>
                                    <li {{$email}}>
                                        <a title="Enviar Correo">
                                            <i class="glyphicon glyphicon-envelope"></i> Enviar Email
                                        </a>
                                    </li>
                                    <li {{$eliminar}}>
                                        <a style="cursor:pointer;" title="Borrar" v-on:click.prevent="destroy_register(data.id)" >
                                            <i class="glyphicon glyphicon-trash"></i> Eliminar
                                        </a>
                                    </li>
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
                </tbody>
            </table>
        </div>
    </div>

    @include('ventas.pedidos_edit')
</div>
@stop
@push('scripts')
<script type="text/javascript" src="{{asset('js/ventas/build_pedidos.js')}}"></script>
@endpush