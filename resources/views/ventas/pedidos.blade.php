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
                    {!! $cmb_estatus !!}
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

        <div class="table-responsive">
            <table class="table table-striped table-responsive highlight table-hover fixed_header" id="datatable">
                <thead>
                    <tr style="background-color: #337ab7; color: #ffffff;">
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Contacto</th>
                        <th>Cliente</th>
                        <th>Ejecutivo</th>
                        <th>Estado</th>
                        <th class="text-right">Subtotal</th>
                        <th class="text-right">Iva</th>
                        <th class="text-right">Total</th>
                        <th class="text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>2517</td>
                        <td >01/08/2018</td>
                        <td><a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="444 444@44.44">444</a></td>
                        <td>Obed Alvarado</td>
                        <td>Obed Alvarado</td>
                        <td><span class="label label-success">Pagada</span></td>
                        <td class="text-right">184.76</td>
                        <td class="text-right">184.76</td>
                        <td class="text-right">184.76</td>
                        <td class="text-right">
                            <div class="dropdown">
                                <button class="btn btn-info dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Acciones
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
                                    <li>
                                        <a title="Editar" style="cursor:pointer;">
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
                                        <a style="cursor:pointer;" title="Borrar" v-on:click.prevent="destroy_register()" >
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