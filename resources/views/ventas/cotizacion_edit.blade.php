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
                            <div class="form-group row">
                              <label for="nombre_cliente" class="col-md-2 control-label">Selecciona el cliente:</label>
                              <div class="col-md-3">
                                  <!-- <input type="text" class="form-control input-sm ui-autocomplete-input" id="nombre_cliente" placeholder="Ingresa el nombre del cliente" required="" autocomplete="off">
                                  <input id="id_cliente" type="hidden">  -->
                                 <!--  <select name="cliente" id="sys_idCliente" class="form-control input-sm" required="required"></select>
 -->                             
                                    {!! $clientes !!}
                              </div>
                              
                              
                              <label for="contacto" class="col-md-1 control-label">Contacto:</label>
                                <div class="col-md-2">
                                    <div id="div_contacto"></div>
                                    <!-- <select class="form-control input-sm" id="contacto" name="contacto">
                                        <option value="">Selecciona</option>
                                    </select> -->
                                </div>
                                
                              
                                <div class="col-md-2">
                                    <input type="text" class="form-control input-sm" id="tel1" placeholder="" value="Teléfono" readonly="">
                                 </div>
                                 <div class="col-md-2">
                                    <input type="text" class="form-control input-sm" id="email_contact" placeholder="" value="Correo electrónico" readonly="">
                                 </div>
                            
                            </div>

                            <div class="form-group row">
                                <label for="empresa" class="col-md-2 control-label">RFC empresa:</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control input-sm" id="rfc_empresa" placeholder="" readonly="">
                                </div>
                                <label for="tel2" class="col-md-1 control-label">Nombre comercial:</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control input-sm" id="nombre_comercial" placeholder="" readonly="">
                                </div>
                                <label for="email" class="col-md-1 control-label">Teléfono:</label>
                                <div class="col-md-2">
                                    <input type="email" class="form-control input-sm" id="tel2" placeholder="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="condiciones" class="col-md-2 control-label">Forma de pago:</label>
                                <div class="col-md-3">

                                    {!! $formas_pagos !!}
                                </div>
                                <label for="validez" class="col-md-1 control-label">Método de pago:</label>
                                <div class="col-md-2">

                                    {!! $metodos_pagos !!}
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="condiciones" class="col-md-2 control-label">Descripción:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="observaciones" name="observaciones"></textarea>
                                </div>
                                
                                <label for="moneda" class="col-md-1 control-label">Moneda:</label>
                                <div class="col-md-3">
                                    {!! $monedas !!}
                                </div>
                                
                            </div>
                            
                            <div class="form-group row">
                                <div class="pull-right col-sm-2">
                                    <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                     <span class="glyphicon glyphicon-plus"></span> Agregar Conceptos
                                    </button> -->
                                    <button type="button" class="btn btn-info add" title="Agregar Producto"  href="#modal_conceptos" id="add_concepto"><i class="fa fa-plus-circle"></i> Agregar conceptos</button>
                                    <!-- <button type="submit" class="btn btn-default">
                                      <span class="glyphicon glyphicon-print"></span> Imprimir
                                    </button> -->
                                </div>
                            </div>

                            
                            <hr>    

                            <div class="table-responsive">

                                <table class="table">
                                    <tbody><tr style="background-color: #337ab7; color: #ffffff;">
                                        <th class="text-center">CÓDIGO</th>
                                        <th class="text-center">CANTIDAD</th>
                                        <th>DESCRIPCIÓN</th>
                                        <th class="text-right">PRECIO UNITARIO.</th>
                                        <th class="text-right">PRECIO TOTAL</th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <td class="text-center">00002</td>
                                        <td class="text-center">3</td>
                                        <td>Shampoo</td>
                                        <td class="text-right">4.50</td>
                                        <td class="text-right">13.50</td>
                                        <td class="text-center"><a href="#" onclick="eliminar('17353')"><i class="glyphicon glyphicon-trash"></i></a></td>
                                    </tr>       
                                    <tr>
                                        <td class="text-center">999910</td>
                                        <td class="text-center">1</td>
                                        <td>Test motherboard</td>
                                        <td class="text-right">150.00</td>
                                        <td class="text-right">150.00</td>
                                        <td class="text-center"><a href="#" onclick="eliminar('17352')"><i class="glyphicon glyphicon-trash"></i></a></td>
                                    </tr>       
                                    <tr>
                                        <td class="text-right" colspan="4" >SUBTOTAL </td>
                                        <td class="text-right" id="subtotal" style="background-color:#eee">  </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="4">IVA ({{$iva}})% </td>
                                        <td class="text-right" id="iva" style="background-color:#eee"> </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="4">TOTAL </td>
                                        <td class="text-right" id="total" style="background-color:#eee"></td>
                                    </tr>

                                </tbody></table>

                            </div>
                              <!-- <div class="form-group">
                                <label class="control-label col-sm-2" for="">Posicion</label>
                                <div class="col-sm-2">
                                  <input type="text" class="form-control" placeholder="" v-model="datos.skill_orden">
                                </div>
                            </div> -->
                        </form>
        </div>

        <div class="modal-footer">
            <div class="btn-toolbar pull-right">
                <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                <button type="button" class="btn btn-primary" v-on:click.prevent="insert_register()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button> 
            </div>
        </div>

</div>





<div id="modal_conceptos" style="display:none;">
        <h3>Agregar Conceptos</h3>
            <hr>
        <div class="modal-body">

            <form class="form-horizontal" >

                                            <div class="form-group">
                                <label for="condiciones" class="col-sm-3 control-label">Productos:</label>
                                <div class="col-sm-3">
               
                                    {!! $productos !!}
                                </div>
                                <label for="validez" class="col-sm-3 control-label">Planes:</label>
                                <div class="col-sm-3">

                                    {!! $metodos_pagos !!}
                                </div>

                            </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="">Cantidad</label>
                    <div class="col-sm-9">
                        <input type="text" id="cantidad_concepto" class="form-control" placeholder="" >
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-sm-3" for="">Precio Unitario</label>
                    <div class="col-sm-9">
                        <input type="text" id="precio_concepto" class="form-control" placeholder="$">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="">Descripción</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="descripcion"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="">Total</label>
                    <div class="col-sm-9">
                        <input type="text"  class="form-control" placeholder="$"  disabled id="total_concepto">
                    </div>
                </div>

         </form>


        </div>
        <div class="modal-footer">
            <div class="pull-right">
                <button type="button" class="btn btn-success" ><i class="fa fa-save"></i> Agregar</button>
            </div>
        </div>


    </div>
