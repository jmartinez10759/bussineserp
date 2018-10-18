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
        <input type="hidden" id="id_concep_producto">
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

                                <label for="validez" class="col-md-1 control-label">Estatus:</label>
                                <div class="col-md-3">

                                    {!! $estatus !!}
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
                        
                            <input type="hidden" v-model="totales.subtotal" id="sub">
                            <input type="hidden" v-model="totales.iva" id="iv">
                            <input type="hidden" v-model="totales.Total" id="tol">
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
                                    <tr v-for="data in datos">
                                        <td class="text-center">@{{ data.codigo }}</td>
                                        <td class="text-center">@{{ data.cantidad }}</td>
                                        <td>@{{ data.descripcion }}</td>
                                        <td class="text-right">@{{ data.precio }}</td>
                                        <td class="text-right">@{{ data.total }}</td>
                                        <td class="text-center"><a href="#" v-on:click.prevent="destroy_register(data)"><i class="glyphicon glyphicon-trash"></i></a></td>
                                    </tr>            
                                    <tr>
                                        <td class="text-right" colspan="4" >SUBTOTAL </td>
                                        <td class="text-right" style="background-color:#eee"> @{{ totales.subtotal }} </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="4">IVA ({{$iva}})% </td>
                                        <td class="text-right" style="background-color:#eee"> @{{ totales.iva }} </td>
                                    </tr>
                                    <tr>
                                        <td class="text-right" colspan="4">TOTAL </td>
                                        <td class="text-right" style="background-color:#eee"> @{{ totales.Total }} </td>
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

                        {!! $planes !!}
                    </div>

                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="">Cantidad</label>
                    <div class="col-sm-9">
                        <input type="number" id="cantidad_concepto" class="form-control" placeholder="" onkeyup="calcular_suma()">
                    </div>
                </div>


                <div class="form-group">
                    <label class="control-label col-sm-3" for="">Precio Unitario</label>
                    <div class="col-sm-9">
                        <input type="text" id="precio_concepto" class="form-control" disabled placeholder="$" onkeyup="calcular_suma()" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3" for="">Descripción</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" id="descripcion" rows="5"></textarea>
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
                <button type="button" class="btn btn-danger" data-fancybox-close> <i class="fa fa-times-circle"></i> Cancelar</button>
                        
                <button type="button" class="btn btn-success" v-on:click.prevent="insert_register()"><i class="fa fa-save"></i> Agregar</button>
            </div>
        </div>


    </div>

<div id="modal_edit_register" style="display:none;" class="col-sm-12">
        <input type="hidden" id="id_factura_edit"/>
        <input type="hidden" id="id_concep_producto_edit">
        <h3>Editar Información</h3>
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
                                    <select name="cmb_clientes" id="cmb_clientess" onchange="div_contacto_edit()" data-campo="cmb_clientes" title="" data-live-search="true" class="chosen-select form-control" tabindex="-98"><option value="0" selected="selected">Seleccione Opción</option> <option value="138">SOCIEDAD DE BENEFICENCIA ESPA BES420901CY3 </option><option value="111">SYSBUSSINESS1 SA DE CV MAQJ901001BU9 </option><option value="41">ACH FOODS DE MEXICO S DE RL DE CV ACA040206338 </option><option value="40">CENTRO CELULAR S.A. DE C.V. CCE940804T7A </option><option value="39">Aura Servicios de Personal, S. de R.L. de C.V. ASP161025IG4 </option><option value="38">RUBA SERVICIOS, S. A. DE C. V. RSE011018FU6 </option><option value="37">PERSONAL ESPECIALIZADO EN CONSULTORIA Y PROTECCION SA DE CV PEC1510137C3 </option><option value="36">FEMSA SERVICIOS SA DE CV FSE920910CC6 </option><option value="35">ADMINISTRADORA DE PERSONAL WK SA DE CV CTF120816KW9 </option><option value="34">AFORE SURA, S.A DE C.V. ASU961217L85 </option><option value="33">PROV Y SERV S.A DE C.V. PSE130711IR6 </option><option value="32">CORPORATIVO COPAMEX SA DE CV CCO930402ND4 </option><option value="31">FABRICACIONES Y SERVICIOS DE M FSM960315HU0 </option><option value="30">ARRENDAMIENTOS GRACIDA S DE RL DE CV AGR101208QH0 </option><option value="29">ETICA LEGAL RECURSOS HUMANOS SC ELR180514HA9 </option><option value="28">SERGIO RAMIREZ PONCE RAPS8211173H6 </option><option value="27">ADMINISTRADORA DE COMERCIOS Y FRANQUICIAS S.A. DE C.V. ACF030228SAA </option><option value="26">SERVICIOS FARMACEUTICOS EJECUTIVOS S.A. DE C.V. SFE000609179 </option><option value="25">MIRIAM MARIN ALBERTO MAAM730524ES0 </option><option value="24">INTEGRACIONES LABORALES ER SA DE CV ILE180426D56 </option><option value="23">RADEC SA DE CV RAD8909307U0 </option><option value="22">AFVA CONSULTORES EN RECURSOS HUMANOS S.C. ACR080521EC1 </option><option value="21">PROMOSER GC, S.C. PGC140910B34 </option><option value="20">CERTEZA SOLUCION HUMANA S.A DE C.V. CSH1308025H2 </option><option value="19">ALTA DIRECCION DE NEGOCIOS ADITSYSTEMS SA DE CV ADN1608115J3 </option><option value="18">CPIM GROUP SPECIALIZED SERVICES S DE RL DE CV CGS151118V60 </option><option value="17">OPERACION PROFESIONAL DE SERVICIOS MULTIFUNCIONALES S.A DE C.V OPS100622A29 </option><option value="16">ESTRATEGICAMENTE SYNERGO, S.A DE C.V. ESY1411059G1 </option><option value="15">BINNIZA RH S.A DE C.V. BRH120131763 </option><option value="14">CODIGO ALIMENTARIO S.A. DE C.V. CAL0804077FA </option><option value="13">OLIVER AVALOS GARCIA AAGO820524943 </option><option value="12">ENFOQUE SELECTIVO EN CAPITAL HUMANO S.A. DE C.V. ESC161003NC8 </option><option value="11">ISIDRO NICOLAS MARTINEZ CAMPOS MACI610311HQ1 </option><option value="10">PIR SERVICIOS CORPORATIVOS DE PREVENCION S.A DE C.V. PSC0309227N2 </option><option value="9">LEONI WIRING SYSTEMS DE DURANGO SA DE CV LWS070330H96 </option><option value="8">EQUIPO A TU LADO, SA DE CV ETL170621EA9 </option><option value="7">PAZMINO, S.C PAZ090727MD0 </option><option value="6">COBALTO CR, S.A. DE C.V. CCR0804158G4 </option><option value="5">LEASEPLAN MEXICO SA DE CV LME080530BP0 </option><option value="4">APLIMOVS SA DE CV APL131011MZ3 </option><option value="3">ARPADA S.A. DE C.V. ARP111115RM1 </option><option value="2">EL HOMBRE Y EL COSMOS S.C DE R.L. DE C.V. HCO150810T81 </option><option value="1">POLIMEROS MEXICANOS S.A. DE C.V. PME970826H15 </option></select>
                              </div>
                              
                              
                              <label for="contacto" class="col-md-1 control-label">Contacto:</label>
                                <div class="col-md-2">
                                    <div id="div_contacto_edit"></div>
                                    <!-- <select class="form-control input-sm" id="contacto" name="contacto">
                                        <option value="">Selecciona</option>
                                    </select> -->
                                </div>
                                
                              
                                <div class="col-md-2">
                                    <input type="text" class="form-control input-sm" id="tel1_edit" placeholder="" value="Teléfono" readonly="">
                                 </div>
                                 <div class="col-md-2">
                                    <input type="text" class="form-control input-sm" id="email_contact_edit" placeholder="" value="Correo electrónico" readonly="">
                                 </div>
                            
                            </div>

                            <div class="form-group row">
                                <label for="empresa" class="col-md-2 control-label">RFC empresa:</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control input-sm" id="rfc_empresa_edit" placeholder="" readonly="">
                                </div>
                                <label for="tel2" class="col-md-1 control-label">Nombre comercial:</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control input-sm" id="nombre_comercial_edit" placeholder="" readonly="">
                                </div>
                                <label for="email" class="col-md-1 control-label">Teléfono:</label>
                                <div class="col-md-2">
                                    <input type="email" class="form-control input-sm" id="tel2_edit" placeholder="" readonly="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="condiciones" class="col-md-2 control-label">Forma de pago:</label>
                                <div class="col-md-3">

                                    <!-- {!! $formas_pagos !!} -->
                                </div>
                                <label for="validez" class="col-md-1 control-label">Método de pago:</label>
                                <div class="col-md-2">

                                    <!-- {!! $metodos_pagos !!} -->
                                </div>

                                <label for="validez" class="col-md-1 control-label">Estatus:</label>
                                <div class="col-md-3">

                                    <!-- {!! $estatus !!} -->
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="condiciones" class="col-md-2 control-label">Descripción:</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" id="observaciones_edit" name="observaciones"></textarea>
                                </div>
                                
                                <label for="moneda" class="col-md-1 control-label">Moneda:</label>
                                <div class="col-md-3">
                                    <!-- {!! $monedas !!} -->
                                </div>
                                
                            </div>
                            
                            <div class="form-group row">
                                <div class="pull-right col-sm-2">
                                    <!-- <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">
                                     <span class="glyphicon glyphicon-plus"></span> Agregar Conceptos
                                    </button> -->
                                    <button type="button" class="btn btn-info add" title="Agregar Producto"  href="#modal_conceptos" id="add_concepto_edit"><i class="fa fa-plus-circle"></i> Agregar conceptos</button>
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
                                    <tr v-for="data in datos">
                                        <td class="text-center">@{{ data.codigo }}</td>
                                        <td class="text-center">@{{ data.cantidad }}</td>
                                        <td>@{{ data.descripcion }}</td>
                                        <td class="text-right">@{{ data.precio }}</td>
                                        <td class="text-right">@{{ data.total }}</td>
                                        <td class="text-center"><a href="#" v-on:click.prevent="destroy_register(data)"><i class="glyphicon glyphicon-trash"></i></a></td>
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
                <button type="button" class="btn btn-primary" v-on:click.prevent="insert_registere()" {{$insertar}}><i class="fa fa-save"></i> Registrar </button> 
            </div>
        </div>

</div>