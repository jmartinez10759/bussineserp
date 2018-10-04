@extends('layouts.template.app')
@section('content')

@push('styles')
@endpush
  <div class="container-fluid" id="vue-ejecutivos" v-cloak>

    <div class="row">

      <div class='col-sm-3'>
          <div class="form-group">
              <label class="col-sm-5 control-label">Fecha Pago Inicial</label>
              <div class='input-group date' id='datetimepicker1'>
                  <input type='text' class="form-control fechas" id="fecha_inicio_pago" />
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                  </span>
              </div>
          </div>
      </div>

      <div class='col-sm-3'>
          <div class="form-group">
              <label class="col-sm-5 control-label">Fecha Pago Final</label>
              <div class='input-group date' id='datetimepicker1'>
                  <input type='text' class="form-control fechas" id="fecha_final_pago" />
                  <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                  </span>
              </div>
          </div>
      </div>

      <div class='col-sm-3'>
          <div class="form-group">
              <label class="col-sm-3 control-label">Ejecutivos</label>
              <div class="col-sm-9">
                {!! $select_ejecutivos !!}
                <!-- <div v-html="ejecutivos.select_ejecutivos"></div> -->
              </div>
          </div>
      </div>


      <div class="col-sm-3">
          <button type="button" class="btn btn-info" v-on:click.prevent="filtros()"><i class="fa fa-filter"> </i> Filtrar</button>
      </div>

    </div>

      <div class="table-responsive">
        <table class="table table-hover scroll" id="table_ejecutivo">
          <thead style="background-color: #337ab7; color: #ffffff;">
            <tr>
              <th class="text-left col-xs-3">Nombre Completo</th>
              <th class="text-left col-xs-1">Perfil</th>
              <th class="text-left col-xs-1">N°Factura</th>
              <th class="text-left col-xs-1">RFC</th>
              <th class="text-left col-xs-2">Razón Social</th>
              <th class="text-left col-xs-1">Fecha Pago </th>
              <th class="text-left col-xs-1">Comisión Total</th>
              <th class="text-left col-xs-1">Pago Total Bancos</th>
              <th class="text-left col-xs-1">Total Facturas</th>
<!--              <th class="text-left col-xs-1">Estatus</th>-->
              <th class="text-left col-xs-1"></th>
            </tr>
          </thead>
          <tbody>

            <tr style="cursor: pointer;" v-for="(ejecutivo,key) in ejecutivos.response ">
              <td class="text-center col-xs-3" v-on:click.prevent="edit_ejecutivo( ejecutivo.id_usuario )">@{{ ejecutivo.nombre_completo }} </td>
              <td class="text-center col-xs-1" v-on:click.prevent="edit_ejecutivo( ejecutivo.id_usuario )">@{{ (ejecutivo.perfil) }}</td>
              <td class="text-center col-xs-1" v-on:click.prevent="edit_ejecutivo( ejecutivo.id_usuario )">@{{ (ejecutivo.factura) }}</td>
              <td class="text-center col-xs-1" v-on:click.prevent="edit_ejecutivo( ejecutivo.id_usuario )">@{{ (ejecutivo.rfc_receptor) }}</td>
              <td class="text-center col-xs-3" v-on:click.prevent="edit_ejecutivo( ejecutivo.id_usuario )">@{{ (ejecutivo.razon_social) }}</td>
              <td class="text-center col-xs-1" v-on:click.prevent="edit_ejecutivo( ejecutivo.id_usuario )">@{{ (ejecutivo.fecha_pago) }}</td>
              <td class="text-center col-xs-1" v-on:click.prevent="edit_ejecutivo( ejecutivo.id_usuario )">@{{ comisiones(ejecutivo.comision_general) }}</td>
              <td class="text-center col-xs-1" v-on:click.prevent="edit_ejecutivo( ejecutivo.id_usuario )">@{{ comisiones(ejecutivo.pago_general) }}</td>
              <td class="text-center col-xs-1" v-on:click.prevent="edit_ejecutivo( ejecutivo.id_usuario )">@{{ comisiones(ejecutivo.total_general) }}</td>
<!--              <td class="text-center col-xs-1" v-on:click.prevent="edit_ejecutivo( ejecutivo.id_usuario )">@{{ (ejecutivo.estatus == 1 )? "Activo": "Baja"}}</td>-->
              <td class="text-center col-xs-1">
                <a class="btn btn-success" title="Carga de XML" v-on:click.prevent="load_files( ejecutivo.id_usuario )" {{$upload}}><i class="fa fa-cloud-upload"></i></a>
              </td>
            </tr>

          </tbody>
          <tfoot>
            <tr>
              <td class="text-center col-xs-5"></td>
              <td class="text-center col-xs-0"></td>
              <td class="text-center col-xs-0"></td>
              <td class="text-center col-xs-0"></td>
              <td class="text-center col-xs-4"></td>
              <td class="text-center col-xs-0"></td>
              <td class="text-center col-xs-0"></td>
              <td class="text-center col-xs-1" style="background-color:#eee">@{{ ejecutivos.comision_general}}</td>
              <td class="text-center col-xs-1" style="background-color:#eee">@{{ ejecutivos.pago_general}}</td>
              <td class="text-center col-xs-1" style="background-color:#eee">@{{ ejecutivos.total_general }}</td>
              <td class="text-center col-xs-0"></td>
            </tr>
          </tfoot>
        </table>


      </div>
      @include('facturacion.ejecutivos_edit')

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
  <script type="text/javascript" src="{{asset('js/facturacion/build_ejecutivos.js')}}" ></script>
@endpush
