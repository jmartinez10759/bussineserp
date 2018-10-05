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
                                  <input type="text" class="form-control input-sm ui-autocomplete-input" id="nombre_cliente" placeholder="Ingresa el nombre del cliente" required="" autocomplete="off">
                                  <input id="id_cliente" type="hidden"> 
                             </div>
                              
                              
                              <label for="atencion" class="col-md-1 control-label">Atención:</label>
                                <div class="col-md-2">
                                    <select class="form-control input-sm" id="atencion" name="atencion">
                                        <option value="">Selecciona</option>
                                    </select>
                                </div>
                                
                              
                                <div class="col-md-2">
                                    <input type="text" class="form-control input-sm" id="tel1" placeholder="" value="Teléfono" readonly="">
                                 </div>
                                 <div class="col-md-2">
                                    <input type="text" class="form-control input-sm" id="email_contact" placeholder="" value="Correo electrónico" readonly="">
                                 </div>
                            
                            </div>

                            <div class="form-group row">
                                <label for="empresa" class="col-md-2 control-label">Empresa:</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control input-sm" id="empresa" placeholder="" readonly="">
                                </div>
                                <label for="tel2" class="col-md-1 control-label">Teléfono:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control input-sm" id="tel2" placeholder="" readonly="">
                                </div>
                                <label for="email" class="col-md-1 control-label">Email:</label>
                                <div class="col-md-3">
                                    <input type="email" class="form-control input-sm" id="email" placeholder="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="condiciones" class="col-md-2 control-label">Condiciones de pago:</label>
                                <div class="col-md-3">
                                    <select class="form-control input-sm" id="condiciones" required="">
                                        <option value="">Selecciona condiciones de pago</option>
                                        <option value="Contado" selected="">Contado</option>
                                        <option value="Crédito 30 días">Crédito 30 días</option>
                                        <option value="Crédito 45 días">Crédito 45 días</option>
                                        <option value="Crédito 60 días">Crédito 60 días</option>
                                        <option value="Crédito 90 días">Crédito 90 días</option>
                                    </select>
                                </div>
                                <label for="validez" class="col-md-1 control-label">Validez:</label>
                                <div class="col-md-2">
                                    <select class="form-control input-sm" id="validez" required="">
                                        <option value="">Selecciona validez de oferta</option>
                                        <option value="5 días">5 días</option>
                                        <option value="10 días">10 días</option>
                                        <option value="15 días" selected="">15 días</option>
                                        <option value="30 días">30 días</option>
                                        <option value="60 días">60 días</option>
                                    </select>
                                </div>
                                <label for="entrega" class="col-md-1 control-label">Tiempo:</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control input-sm" id="entrega" placeholder="Tiempo de entrega" value="Inmediato">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="condiciones" class="col-md-2 control-label">Descripción:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="observaciones" ></textarea>
                                </div>
                                
                                <label for="moneda" class="col-md-1 control-label">Moneda:</label>
                                <div class="col-md-3">
                                    <select name="moneda" id="moneda" class="form-control input-sm" onchange="update_cotizacion(7,this.value);">
                                        <option value="1">Dolares</option>
                                            <option value="3">Guaranies</option>
                                            <option value="5">Bolivar Soberano</option>
                                            <option value="13">Colon CR</option>
                                            <option value="14">Quetzal</option>
                                            <option value="17">Pesos Mexicanos</option>
                                            <option value="18">Pesos Chilenos</option>
                                            <option value="19">Nuevos Soles</option>
                                            <option value="21">Peso colombiano</option>
                                            <option value="22">Pesos Argentinos</option>
                                            <option value="23">Bolivianos</option>
                                            <option value="24">Peso Chileno</option>
                                            <option value="25">ttvrthf</option>
                                            <option value="26">rcfdy</option>
                                            <option value="27">JZFpxz26</option>
                                            <option value="28">Jame</option>
                                            <option value="29">Pesos Dominicanos</option>
                                            <option value="30">aaaa</option>
                                            <option value="31">Dolar</option>
                                            <option value="32">Peso Chileno</option>
                                            <option value="33">Lempira</option>
                                            <option value="34">PESOS</option>
                                            <option value="35">Quetzal</option>
                                            <option value="36">Soles</option>
                                            <option value="37">Metical</option>
                                            <option value="38">antonio</option>
                                            <option value="39">Sol</option>
                                            <option value="40">Sol</option>
                                            <option value="41">Bitcoin</option>
                                    </select>
                                </div>
                                
                            </div>
                            
                            <div class="form-group row">
                                <div class="pull-right col-sm-3">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                     <span class="glyphicon glyphicon-plus"></span> Agregar productos
                                    </button>
                                    <button type="submit" class="btn btn-default">
                                      <span class="glyphicon glyphicon-print"></span> Imprimir
                                    </button>
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
                                        <td class="text-right" colspan="4">IVA (16)% </td>
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