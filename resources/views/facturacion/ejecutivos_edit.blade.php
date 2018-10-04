<div id="modal_upload" style="display:none;">

    <h3>Carga de Archivos XML</h3>
    <hr>
      <div class="modal-body">
        <input type="hidden" id="id_usuario" value="">

        <form class="form-horizontal" >
            <div id="div_dropzone_file"></div>
       </form>

      </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-success" v-on:click.prevent="send_masiva('facturacion/ejecutivos')" ><i class="fa fa-save"></i> Aceptar</button>
    </div>

</div>

<div id="modal_facturas_by_cliente" style="display:none;">
  <h3>@{{facturas.rfc_receptor}} - @{{facturas.razon_social}}</h3>
  <hr>
    <div class="modal-body" style="overflow-y:scroll; height:500px;">

      <form class="form-inline col-sm-offset-9">
        <input class="form-control" type="text" placeholder="Buscar" aria-label="Search" onkeyup="buscador_general(this,'#table_facturas_clientes')">
      </form>
      <br>

      <div class="table-responsive">

        <table class="table table-hover table-responsive" id="table_facturas_clientes">
          <thead style="background-color: #337ab7; color: #ffffff;">
            <tr>
              <th class="text-center">N°Factura</th>
              <th class="text-center">RFC</th>
              <th class="text-center">Razón Social</th>
              <th class="text-center">Fecha Factura</th>
              <th class="text-center">Estatus</th>
              <th class="text-center"></th>
            </tr>
          </thead>

          <tbody>

              <tr style="cursor: pointer;" v-for="(facturas,key) in facturas.facturas ">
                  <td class="text-left">@{{facturas.serie}}-@{{facturas.folio}}</td>
                  <td class="text-left">@{{facturas.clientes[0].rfc_receptor}}</td>
                  <td class="text-left">@{{facturas.clientes[0].razon_social}}</td>
                  <td class="text-left">@{{facturas.fecha_factura}}</td>
                  <td class="text-left">@{{facturas.estatus.nombre}}</td>
                  <td class="text-left"></td>
              </tr>

          </tbody>

          <tfoot>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <!-- <td style="background-color:#eee">@{{ cantidades.comision_general}}</td>
                <td style="background-color:#eee">@{{ cantidades.pago_general}}</td>
                <td style="background-color:#eee">@{{ cantidades.total_general }}</td> -->
              </tr>
          </tfoot>

        </table>

      </div>


    </div>

  <div class="modal-footer">
    <!-- <button type="button" class="btn btn-success" v-on:click.prevent="insert_conceptos()" ><i class="fa fa-save"></i> Agregar</button> -->
  </div>

</div>

<div id="modal_clientes" style="display:none;">
  <h3>Detalles Ejecutivo</h3>
  <hr>
    <div class="modal-body" style="overflow-y:scroll; height:480px;">

      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#clientes" data-toggle="tab">Total Clientes</a></li>
          <li><a href="#facturas" data-toggle="tab">Total Facturas</a></li>
          <!-- <li class="active"><a href="#settings" data-toggle="tab">Edicion</a></li> -->
        </ul>
        <div class="tab-content">

          <div class="active tab-pane" id="clientes">

              <form class="form-inline col-sm-offset-8">
                <input class="form-control" type="text" placeholder="Buscar" aria-label="Search" onkeyup="buscador_general(this,'#table_clientes')">
              </form>
              <br>
              <div class="table-responsive">
                <table class="table table-hover table-responsive" id="table_clientes">
                  <thead style="background-color: #337ab7; color: #ffffff;">
                    <tr>
                      <th class="text-center">RFC</th>
                      <th class="text-center">Razón Social</th>
                      <th class="text-center">Total Facturas</th>
                      <th class="text-center"></th>
                    </tr>
                  </thead>
                  <tbody>

                      <tr style="cursor: pointer;" v-for="(clientes,key) in clientes.total_clientes ">
                          <td class="text-left" v-on:click.prevent="details_clientes(clientes.id)" title="Visualizar facturas del cliente">@{{clientes.rfc_receptor}}</td>
                          <td class="text-left" v-on:click.prevent="details_clientes(clientes.id)" title="Visualizar facturas del cliente">@{{clientes.razon_social}}</td>
                          <td class="text-center" v-on:click.prevent="details_clientes(clientes.id)" title="Visualizar facturas del cliente">@{{clientes.facturas.length}}</td>
                          <td class="text-left"></td>
                      </tr>

                  </tbody>
                  <tfoot>
                      <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <!-- <td style="background-color:#eee">@{{ cantidades.comision_general}}</td>
                        <td style="background-color:#eee">@{{ cantidades.pago_general}}</td>
                        <td style="background-color:#eee">@{{ cantidades.total_general }}</td> -->
                      </tr>
                  </tfoot>
                </table>

              </div>

          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="facturas">

            <form class="form-inline col-sm-offset-9">
              <input class="form-control" type="text" placeholder="Buscar" aria-label="Search" onkeyup="buscador_general(this,'#table_facturas_totales')">
            </form>
            <br>
            <div class="table-responsive">

              <table class="table table-hover table-responsive" id="table_facturas_totales">
                <thead style="background-color: #337ab7; color: #ffffff;">
                  <tr>
                    <th class="text-center">N°Factura</th>
                    <th class="text-center">RFC</th>
                    <th class="text-center">Razón Social</th>
                    <th class="text-center">Fecha Factura</th>
                    <th class="text-center">Total Factura</th>
                    <th class="text-center">Estatus</th>
                    <th class="text-center">Comprobante</th>
                    <th class="text-center"></th>
                  </tr>
                </thead>
                <tbody>
                    <tr style="cursor: pointer;" v-for="(facturas,key) in clientes.total_facturas ">
                        <td class="text-left" v-on:click.prevent="edit_factura( facturas.id )">@{{facturas.serie}}-@{{facturas.folio}}</td>
                        <td class="text-left" v-on:click.prevent="edit_factura( facturas.id )">@{{facturas.clientes[0].rfc_receptor}}</td>
                        <td class="text-left" v-on:click.prevent="edit_factura( facturas.id )">@{{facturas.clientes[0].razon_social}}</td>
                        <td class="text-left" v-on:click.prevent="edit_factura( facturas.id )">@{{facturas.fecha_factura}}</td>
                        <td class="text-left" v-on:click.prevent="edit_factura( facturas.id )">@{{ facturas.total }}</td>
                        <td class="text-left">
                          <!-- @{{facturas.estatus.nombre}} -->
                          <select class="form-control" :id="facturas.id" v-on:change="select_estatus( facturas.id )" v-model="facturas.id_estatus">
															<option v-for="(estatus, key) in clientes.select_estatus" :value="estatus.id">@{{estatus.nombre}}</option>
													</select>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-warning" title="Visualizar Comprobante" v-on:click.prevent="visualizar( facturas.archivo )"><i class="fa fa-search"></i></a>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger" type="button" title="Borrar Registro" v-on:click.prevent="delete_factura(facturas.id)" {{$eliminar}}>
                                <i class="fa fa-trash"aria-hidden="true" ></i>
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
                      <!-- <td style="background-color:#eee">@{{ cantidades.comision_general}}</td>
                      <td style="background-color:#eee">@{{ cantidades.pago_general}}</td>
                      <td style="background-color:#eee">@{{ cantidades.total_general }}</td> -->
                    </tr>
                </tfoot>
              </table>

            </div>


          </div>
          <!-- /.tab-pane -->
          <!-- <div class="tab-pane" id="settings"></div> -->
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
  <hr>
  <div class="modal-footer">
    <!-- <button type="button" class="btn btn-success" v-on:click.prevent="insert_conceptos()" ><i class="fa fa-save"></i> Agregar</button> -->
  </div>

</div>

<div style="display:none;" id="content_excel">
  <h3>REPORTE DE VENTAS BURO LABORAL MÉXICO</h3>
  <hr>
    <div class="table-response">
      <div id="excel" style="overflow-y:scroll; height:450px; overflow-x:auto"></div>
    </div>
  <br>
  <div class="pull-right">
    <button class="btn btn-primary" type="button" v-on:click.prevent="download_excel()"><i class="fa fa-cloud-download"></i> Descargar</button>
  </div>
</div>
