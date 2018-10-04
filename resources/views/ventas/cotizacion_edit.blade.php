<!--<div class="" id="modal_add_register" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3> Titulo modales </h3>
            </div>
            <div class="modal-body">
                
                
            </div>
            <div class="modal-footer">
                <div class="btn-toolbar pull-right">
                    <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                    <button type="button" class="btn btn-primary" v-on:click.prevent="insert_register()"><i class="fa fa-save"></i> Registrar </button> 
                </div>
            </div>

        </div>
    </div>
</div>-->

<div id="modal_add_register" style="display:none;" class="col-sm-12">
        <input type="hidden" id="id_factura"/>
        <h3>Registro de Información</h3>
        <hr>

        <div class="modal-body" style="overflow-y:scroll; height:500px;">
            <form class="form-horizontal" >

                <div class="form-group">

                    <label class="control-label col-sm-1" for="">Razón Social</label>
                    <div class="col-sm-5">
                        <input type="text" name="razon_social" class="form-control" placeholder="" >
                    </div>

                    <label class="control-label col-sm-1" for="">RFC <font size="3" color="red">*</font></label>
                    <div class="col-sm-2">
                        <input type="text" id="rfc_receptor" name="rfc_receptor" class="form-control" placeholder="" >
                    </div>

                    <label class="control-label col-sm-1" for="">N° Factura <font size="3" color="red">*</font></label>
                    <div class="col-sm-2">
                        <input type="text" name="factura" class="form-control" placeholder="" >
                    </div>

                </div>
                <div class="form-group">

                    <label class="control-label col-sm-1" for="">SubTotal</label>
                    <div class="col-sm-1">
                        <input type="text" name="subtotal" class="form-control" placeholder="$" >
                    </div>

                    <label class="control-label col-sm-1" for="">Total Factura</label>
                    <div class="col-sm-2">
                        <input type="text" name="total" class="form-control" placeholder="$" >
                    </div>

                    <label class="control-label col-sm-1" for="">Fecha Factura</label>
                    <div class="col-sm-2">
                        <input type="text" class="form-control fechas" placeholder="" id="fecha_factura" readonly>
                    </div>

                    <label class="control-label col-sm-1" for="">Forma de Pago</label>
                    <div class="col-sm-3">
                                
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
                                <textarea class="form-control" id="observaciones" ></textarea>
                    </div>
                    <input type="hidden" id="archivo" />
                    <div class="col-sm-5">
                        <div id="div_dropzone_file" ></div>
                    </div>

                </div>

                <div class="col-sm-offset-0" style="display:block;">
                        <button type="button" class="btn btn-warning add" title="Agregar Producto"  href="#modal_conceptos" id="add_concepto"><i class="fa fa-plus-circle"></i> Agregar Concept</button>
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
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="text-right" colspan="4" >SUBTOTAL </td>
                                    <td class="text-right" id="subtotal" style="background-color:#eee">  </td>
                                </tr>
                                <tr>
                                    <td class="text-right" colspan="4">IVA (16)% </td>
                                    <td class="text-right" id="iva" style="background-color:#eee"> </td>
                                </tr>
                                <tr>
                                    <td class="text-right" colspan="4">TOTAL </td>
                                    <td class="text-right" id="total" style="background-color:#eee"></td>
                                </tr>

                            </tfoot>

                    </table>
                </div>

            </form>
        </div>

        <div class="modal-footer">
            <div class="btn-toolbar pull-right">
                <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" v-on:click.prevent="insert_register()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button> 
            </div>
        </div>

</div>